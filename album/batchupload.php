<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /batchupload.php
 *
 * batchupload to add images from batch folder (uploaded via ftp) or to upload a new set via zip file
 *
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Album
 * @since		1.20
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

defined ("ICMS_ROOT_PATH") or die();

ini_set('max_execution_time', 0);

ini_set('memory_limit', '256M');

function addUrlLink() {
	global $urllink_handler;
	$urlObj = $urllink_handler->create(TRUE);
	$urlObj->setVar("mid", (int)$_POST['mid_img_urllink']);
	$urlObj->setVar("caption", $_POST['caption_img_urllink']);
	$urlObj->setVar("description", $_POST['desc_img_urllink']);
	$urlObj->setVar("url", $_POST['url_img_urllink']);
	$urlObj->setVar("target", $_POST['target_img_urllink']);
	$urllink_handler->insert($urlObj, TRUE);
	return $urlObj->id();
}

function addImage($new_name, $a_id, $img_title, $dsc, $time, $file, $tags, $active, $weight, $uid, $urllink, $copyright, $copy_pos, $copy_color, $copy_font, $copy_fsize) {
	global $images_handler;
	$imgObj = $images_handler->create(TRUE);
	$imgObj->setVar("a_id", $a_id);
	$imgObj->setVar("img_title", $img_title);
	$imgObj->setVar("img_published_date", $time);
	$imgObj->setVar("img_updated_date", 0);
	$imgObj->setVar("img_description", $img_title . " - " . $dsc);
	$imgObj->setVar("img_url", $file);
	if($tags) $imgObj->setVar("img_tags", $tags);
	$imgObj->setVar("img_active", $active);
	$imgObj->setVar("img_approve", TRUE);
	$imgObj->setVar("weight", $weight);
	$imgObj->setVar("img_publisher", $uid);
	$imgObj->setVar("img_urllink", $urllink);
	if($copyright) {
		$imgObj->setVar("img_copyright", $copyright);
		$imgObj->setVar("img_copy_pos", $copy_pos);
		$imgObj->setVar("img_copy_color", $copy_color);
		$imgObj->setVar("img_copy_font", $copy_font);
		$imgObj->setVar("img_copy_fontsize", $copy_fsize);
	}
	if($new_name) {
		icms_core_Filesystem::copyRecursive(ALBUM_BATCH_ROOT . $new_name . '/' . $file, ALBUM_IMAGES_UPLOAD . $file);
		icms_core_Filesystem::deleteFile(ALBUM_BATCH_ROOT . $new_name . '/' . $file);
	} else {
		icms_core_Filesystem::copyRecursive(ALBUM_BATCH_ROOT . $file, ALBUM_IMAGES_UPLOAD . $file);
		icms_core_Filesystem::deleteFile(ALBUM_BATCH_ROOT . $file);
	}

	$images_handler->insert($imgObj, TRUE);
}

$icmsTpl->assign("album_forms", TRUE);

if(!defined("ALBUM_BATCH_ROOT")) define("ALBUM_BATCH_ROOT", ICMS_UPLOAD_PATH . '/' . ALBUM_DIRNAME . '/batch/' );
if(!defined("ALBUM_IMAGES_UPLOAD")) define("ALBUM_IMAGES_UPLOAD", ICMS_UPLOAD_PATH . '/' . ALBUM_DIRNAME . '/images/');

$valid_op = array ('batchupload', 'addimages', 'addzip', 'zipupload');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : 'addzip';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');
if($clean_op == 'addimages' && !$album_isAdmin) redirect_header(icms_getPreviousPage(), 3, _NOPERM);

if($clean_album == FALSE && !$album_isAdmin) redirect_header(icms_getPreviousPage(), 3, _NOPERM);

$albumObj = $album_handler->getAlbumBySeo($clean_album);
$clean_album_id = ($albumObj) ? $albumObj->id() : 0;
if(!$album_isAdmin) {
	if((!is_object($albumObj) && !$albumObj->accessGranted("album_uplperm"))) redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}
if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'zipupload':
			if($_POST['a_id'] <= 0) redirect_header(icms_getPreviousPage(), 4, _AM_ALBUM_BATCHUPLOAD_NOALBUM);
			$uploader = new icms_file_MediaUploadHandler(ALBUM_BATCH_ROOT, array("application/zip"), 20000000);
			$uploader->setPrefix('', FALSE);
			if($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				if ($uploader->upload(0777)) {
					$new_name = array_shift(explode(".", $uploader->getSavedFileName()));
					mkdir(ALBUM_UPLOAD_ROOT . $new_name, 0777, TRUE);
					$zip = new ZipArchive;
					if ($zip->open(ALBUM_BATCH_ROOT . $uploader->getSavedFileName()) === TRUE) {
		    			$zip->extractTo(ALBUM_BATCH_ROOT . $new_name . '/');
						$zip->close();
					    echo '<code>Zip File successfully extracted to ' . ALBUM_BATCH_ROOT . $new_name . "</code><br />";
					} else {
						echo '<code>An error occured while extracting the archive.</code><br />';
					}
					$files = icms_core_Filesystem::getFileList(ALBUM_BATCH_ROOT . $new_name . '/', '', array('gif', 'jpg', 'png'));
					$weight = 0;
					foreach ($files as $file) {
						$weight++;
						$img_title = array_shift(explode(".", $file));
						$urllink_handler = icms::handler("icms_data_urllink");
						if(isset($_POST['url_img_urllink']) && !empty($_POST['url_img_urllink'])) {
							$urllink = addUrlLink();
						} else {
							$urllink = 0;
						}
						$tags = (isset($_POST['img_tags']) && $_POST['img_tags'] != "") ? $_POST['img_tags'] : '';
						$copyright = isset($_POST['img_copyright']) && !empty($_POST['img_copyright']) ? $_POST['img_copyright'] : FALSE;
						$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
						addImage($new_name, $_POST['a_id'], $img_title, $_POST['img_dsc'], time(), $file, $tags, $_POST['img_active'], $weight, $uid, $urllink,
									$copyright, $_POST['copy_pos'], $_POST['copy_color'], $_POST['copy_font'], $_POST['copy_font_size']);
						echo "<code> File " . $file . " successfully moved.</code><br />";
					}
				}
				icms_core_Filesystem::deleteRecursive(ALBUM_BATCH_ROOT . $new_name . '/');
				echo "<code> Folder " . $new_name . " successfully removed.</code><br />";
				icms_core_Filesystem::deleteFile(ALBUM_BATCH_ROOT . $uploader->getSavedFileName());
				echo "<code> Folder " . $new_name . " successfully removed.</code><br />";
			}
			break;
		case 'batchupload':
			if($_POST['a_id'] <= 0) redirect_header(icms_getPreviousPage(), 4, _AM_ALBUM_BATCHUPLOAD_NOALBUM);
			$files = $_POST['img_ids'];
			$weight = 0;
			if(is_array($files)) {
				foreach ($files as $file => $value) {
					$weight++;
					$img_title = array_shift(explode(".", $value));
					$urllink_handler = icms::handler("icms_data_urllink");
					if(isset($_POST['url_img_urllink']) && !empty($_POST['url_img_urllink'])) {
						$urllink = addUrlLink();
					} else {
						$urllink = 0;
					}
					$copyright = isset($_POST['img_copyright']) && !empty($_POST['img_copyright']) ? $_POST['img_copyright'] : FALSE;
					$tags = (isset($_POST['img_tags']) && $_POST['img_tags'] != "") ? $_POST['img_tags'] : '';
					$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
					addImage(FALSE, $_POST['a_id'], $img_title,$_POST['img_dsc'], time(), $value, $tags, $_POST['img_active'], $weight, $uid, $urllink,
								$copyright, $_POST['copy_pos'], $_POST['copy_color'], $_POST['copy_font'], $_POST['copy_font_size']);
					echo "<code> File " . $value . " successfully moved.</code><br />";
				}
			}
			echo '<br /><br /><a class="formButton" href="' . ALBUM_ADMIN_URL . 'batchupload.php">' . _BACK . '</a>';
			break;
		case 'addimages':
		case 'addzip':
			if($album_isAdmin) {
				echo "<h2 style='color: #336699;'>" . _MD_ALBUM_BATCHUPLOAD_SELECT_SOURCE . "</h2>";
				$opform = new icms_form_Simple('', 'opform', ALBUM_REAL_URL.$album_page.'?view=batchupload', "get");
				$op_select = new icms_form_elements_Select("", 'op', $clean_op);
				$op_select->setExtra('onchange="document.forms.opform.submit()"');
				$op_select->addOption('addimages', _MD_ALBUM_BATCHUPLOAD_IMAGES);
				$op_select->addOption('addzip', _MD_ALBUM_BATCHUPLOAD_ZIPUPL);
				$opform->addElement($op_select);
				$opform->display();
				echo "<br />";
			}
			if($album_isAdmin) {
				$submit_op = ($clean_op == 'addzip') ? ALBUM_REAL_URL.$album_page.'?view=batchupload&op=zipupload' : ALBUM_REAL_URL.$album_page.'?view=batchupload&op=batchupload';
			} else {
				$submit_op = ALBUM_REAL_URL.$album_page.'?view=batchupload&op=zipupload&album=' . $clean_album;
			}

			$case = ($clean_op == 'addzip') ? _MD_ALBUM_BATCHUPLOAD_ZIPUPL : _MD_ALBUM_BATCHUPLOAD_IMAGES;

			$form = new icms_form_Theme(_MD_ALBUM_BATCHUPLOAD_ADD . " - " . $case, "op", $submit_op, "post", TRUE);

			$selalbum = new icms_form_elements_Select(_CO_ALBUM_IMAGES_A_ID, "a_id", $clean_album_id);
			$selalbum->addOptionArray($album_handler->getAlbumListForPid());
			$selalbum->setRequired();
			if(!$album_isAdmin) $selalbum->setHidden();
			$form->addElement($selalbum);

			if($clean_op == 'addimages' || $clean_op ==  '') {
				$selimages = new icms_form_elements_Checkbox(_MD_ALBUM_BATCHUPLOAD_SEL_IMAGES, "img_ids");
				$selimages->addOptionArray($images_handler->getImagesFromBatch());
				$selimages->setRequired();
				$form->addElement($selimages);
			} elseif ($clean_op == 'addzip') {
				$uploader = new icms_form_elements_File(_MD_ALBUM_BATCHUPLOAD_UPLOAD_ZIP, "img_zip", 20000000);
				$uploader->setRequired();
				$form->addElement($uploader);
				$form->setExtra('enctype="multipart/form-data"');
			}

			$form->addElement(new icms_form_elements_Textarea(_MD_ALBUM_BATCHUPLOAD_IMG_DSC, "img_dsc", "", 7, 50));

			$form->addElement(new icms_form_elements_Radioyn(_CO_ALBUM_IMAGES_IMG_ACTIVE, "img_active", 1));

			if($album_handler->_index_module_status) {
				$tags = new icms_form_elements_Text(_CO_ALBUM_IMAGES_IMG_TAGS, "img_tags", 75, 255);
				$form->addElement($tags);
			}

			if($albumConfig['img_allow_uploader_copyright'] == 1) {
				$form->addElement(new icms_form_elements_Text(_CO_ALBUM_IMAGES_IMG_COPYRIGHT, "img_copyright", 50, 255, $albumConfig['img_default_copyright'] ));

				$copypos = new icms_form_elements_Select(_CO_ALBUM_IMAGES_IMG_COPY_POS, "copy_pos");
				$copypos->addOptionArray($images_handler->getWatermarkPositions());
				$form->addElement($copypos);

				$copycolor = new icms_form_elements_Select(_CO_ALBUM_IMAGES_IMG_COPY_COLOR, "copy_color");
				$copycolor->addOptionArray($images_handler->getWatermarkColors());
				$form->addElement($copycolor);

				$copyfont = new icms_form_elements_Select(_CO_ALBUM_IMAGES_IMG_COPY_FONT, "copy_font");
				$copyfont->addOptionArray($images_handler->getWatermarkFont());
				$form->addElement($copyfont);

				$copyfontsize = new icms_form_elements_Select(_CO_ALBUM_IMAGES_IMG_COPY_FONTSIZE, "copy_font_size");
				$copyfontsize->addOptionArray($images_handler->getWatermarkFontSize());
				$form->addElement($copyfontsize);
			}
			if($albumConfig['need_image_links'] == 1) {
				$tray = new icms_form_elements_Tray(_CO_ALBUM_IMAGES_IMG_URLLINK, "<br />", "img_urllink");
				$mid = new icms_form_elements_Hidden("mid_img_urllink", icms::$module->getVar("mid"));
				$cap = new icms_form_elements_Text(_MD_ALBUM_BATCHUPLOAD_URL_CAP, "caption_img_urllink", 50, 255);
				$dsc = new icms_form_elements_Text(_MD_ALBUM_BATCHUPLOAD_URL_DSC, "desc_img_urllink", 50, 255);
				$url = new icms_form_elements_Text(_MD_ALBUM_BATCHUPLOAD_URL_URL, "url_img_urllink", 50, 255);
				$tar = new icms_form_elements_Radio(_MD_ALBUM_BATCHUPLOAD_URL_TARGET, "target_img_urllink", "_blank");
				$tar->addOption("_blank", "_blank");
				$tar->addOption("_self", "_self");
				$tray->addElement($cap);
				$tray->addElement($dsc);
				$tray->addElement($url);
				$tray->addElement($tar);
				$tray->addElement($mid);
				$form->addElement($tray);
			}
			$form->addElement(new icms_form_elements_Hiddentoken());
			$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
			$form->display();
			break;
	}
}