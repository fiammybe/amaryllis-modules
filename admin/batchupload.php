<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/batchupload.php
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
 
ini_set('max_execution_time', 0);

ini_set('memory_limit', '256M');

include_once 'admin_header.php';

if(!defined("ALBUM_BATCH_ROOT")) define("ALBUM_BATCH_ROOT", ICMS_UPLOAD_PATH . '/' . ALBUM_DIRNAME . '/batch/' );
if(!defined("ALBUM_IMAGES_UPLOAD")) define("ALBUM_IMAGES_UPLOAD", ICMS_UPLOAD_PATH . '/' . ALBUM_DIRNAME . '/images/');

$valid_op = array ('batchupload', 'addimages', 'addzip', 'zipupload', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$album_album_handler = icms_getModuleHandler('album', ALBUM_DIRNAME, 'album');
$album_images_handler = icms_getModuleHandler('images', ALBUM_DIRNAME, 'album');

$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;
$clean_images_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'zipupload':
			icms_cp_header();
			icms::$module->displayAdminmenu(4, _MI_ALBUM_MENU_BATCHUPLOAD);
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
					$i = 0;
					foreach ($files as $file) {
						$i++;
						$img_title = array_shift(explode(".", $file));
						$imagesObject = $album_images_handler->create(TRUE);
						$imagesObject->setVar("a_id", $_POST['a_id']);
						$imagesObject->setVar("img_title", $img_title);
						$imagesObject->setVar("img_published_date", time() - 100);
						$imagesObject->setVar("img_description", $img_title . " - " . $_POST['img_dsc']);
						$imagesObject->setVar("img_url", $file);
						if($_POST['img_tags']) $imagesObject->setVar("img_tags", $_POST['img_tags']);
						$imagesObject->setVar("img_active", $_POST['img_active']);
						$imagesObject->setVar("img_approve", TRUE);
						$imagesObject->setVar("weight", $i);
						$imagesObject->setVar("img_publisher", icms::$user->getVar("uid", "e"));
						if($_POST['img_copyright']) $imagesObject->setVar("img_copyright", $_POST['img_copyright']);
						if($_POST['url_img_urllink']) {
							$urllink_handler = icms::handler("icms_data_urllink");
							$sql = "SHOW TABLE STATUS WHERE name='" . icms::$xoopsDB->prefix('icms_data_urllink') . "'";
							$result = icms::$xoopsDB->queryF($sql);
							$row = icms::$xoopsDB->fetchBoth($result);
							$url_id = $row['Auto_increment'];
							$imagesObject->setVar("img_urllink", $url_id);
							$urlObj = $urllink_handler->create(TRUE);
							$urlObj->setVar("mid", (int)$_POST['mid_img_urllink']);
							$urlObj->setVar("caption", $_POST['caption_img_urllink']);
							$urlObj->setVar("description", $_POST['desc_img_urllink']);
							$urlObj->setVar("url", $_POST['url_img_urllink']);
							$urlObj->setVar("target", $_POST['target_img_urllink']);
							$urllink_handler->insert($urlObj, TRUE);
							$imagesObject->setVar("img_urllink", $urlObj->id());
						}
						icms_core_Filesystem::copyRecursive(ALBUM_BATCH_ROOT . $new_name . '/' . $file, ALBUM_IMAGES_UPLOAD . $file);
						icms_core_Filesystem::deleteFile(ALBUM_BATCH_ROOT . $new_name . '/' . $file);
						
						$album_images_handler->insert($imagesObject, TRUE);
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
			icms_cp_header();
			icms::$module->displayAdminmenu(4, _MI_ALBUM_MENU_BATCHUPLOAD);
			if($_POST['a_id'] <= 0) redirect_header(icms_getPreviousPage(), 4, _AM_ALBUM_BATCHUPLOAD_NOALBUM);
			$files = $_POST['img_ids'];
			$i = 0;
			if(is_array($files)) {
				foreach ($files as $file => $value) {
					$i++;
					$img_title = array_shift(explode(".", $value));
					$imagesObject = $album_images_handler->create(TRUE);
					$imagesObject->setVar("a_id", $_POST['a_id']);
					$imagesObject->setVar("img_title", $img_title);
					$imagesObject->setVar("img_published_date", time() - 100);
					$imagesObject->setVar("img_description", $img_title . " - " . $_POST['img_dsc']);
					$imagesObject->setVar("img_url", $value);
					if($_POST['img_tags']) $imagesObject->setVar("img_tags", $_POST['img_tags']);
					$imagesObject->setVar("img_active", $_POST['img_active']);
					$imagesObject->setVar("img_approve", TRUE);
					$imagesObject->setVar("weight", $i);
					$imagesObject->setVar("img_publisher", icms::$user->getVar("uid", "e"));
					if($_POST['img_copyright']) $imagesObject->setVar("img_copyright", $_POST['img_copyright']);
					if($_POST['url_img_urllink']) {
						$urllink_handler = icms::handler("icms_data_urllink");
						$sql = "SHOW TABLE STATUS WHERE name='" . icms::$xoopsDB->prefix('icms_data_urllink') . "'";
						$result = icms::$xoopsDB->queryF($sql);
						$row = icms::$xoopsDB->fetchBoth($result);
						$url_id = $row['Auto_increment'];
						$imagesObject->setVar("img_urllink", $url_id);
						$urlObj = $urllink_handler->create(TRUE);
						$urlObj->setVar("mid", (int)$_POST['mid_img_urllink']);
						$urlObj->setVar("caption", $_POST['caption_img_urllink']);
						$urlObj->setVar("description", $_POST['desc_img_urllink']);
						$urlObj->setVar("url", $_POST['url_img_urllink']);
						$urlObj->setVar("target", $_POST['target_img_urllink']);
						$urllink_handler->insert($urlObj, TRUE);
						$imagesObject->setVar("img_urllink", $urlObj->id());
						
					}
					icms_core_Filesystem::copyRecursive(ALBUM_BATCH_ROOT . $value, ALBUM_IMAGES_UPLOAD . $value);
					icms_core_Filesystem::deleteFile(ALBUM_BATCH_ROOT . $value);
					
					$album_images_handler->insert($imagesObject, TRUE);
					echo "<code> File " . $value . " successfully moved.</code><br />";
				}
			} else {
				$img_title = array_shift(explode(".", $value));
				$imagesObject = $album_images_handler->create(TRUE);
				$imagesObject->setVar("a_id", $_POST['a_id']);
				$imagesObject->setVar("img_title", $img_title);
				$imagesObject->setVar("img_published_date", time() - 100);
				$imagesObject->setVar("img_description", $img_title . " - " . $_POST['img_dsc']);
				$imagesObject->setVar("img_url", $value);
				if($_POST['img_tags']) $imagesObject->setVar("img_tags", $_POST['img_tags']);
				$imagesObject->setVar("img_active", $_POST['img_active']);
				$imagesObject->setVar("img_approve", TRUE);
				$imagesObject->setVar("weight", $i);
				$imagesObject->setVar("img_publisher", icms::$user->getVar("uid", "e"));
				if($_POST['img_copyright']) $imagesObject->setVar("img_copyright", $_POST['img_copyright']);
				if($_POST['url_img_urllink']) {
					$urllink_handler = icms::handler("icms_data_urllink");
					$sql = "SHOW TABLE STATUS WHERE name='" . icms::$xoopsDB->prefix('icms_data_urllink') . "'";
					$result = icms::$xoopsDB->queryF($sql);
					$row = icms::$xoopsDB->fetchBoth($result);
					$url_id = $row['Auto_increment'];
					$urlObj = $urllink_handler->create(TRUE);
					$urlObj->setVar("mid", (int)$_POST['mid_img_urllink']);
					$urlObj->setVar("caption", $_POST['caption_img_urllink']);
					$urlObj->setVar("description", $_POST['desc_img_urllink']);
					$urlObj->setVar("url", $_POST['url_img_urllink']);
					$urlObj->setVar("target", $_POST['target_img_urllink']);
					$urllink_handler->insert($urlObj, TRUE);
					$imagesObject->setVar("img_urllink", $urlObj->id());
				}
				icms_core_Filesystem::copyRecursive(ALBUM_BATCH_ROOT . $value, ALBUM_IMAGES_UPLOAD . $value);
				icms_core_Filesystem::deleteFile(ALBUM_BATCH_ROOT . $value);
				
				$album_images_handler->insert($imagesObject, TRUE);
				echo "<code> File " . $value . " successfully moved.</code><br /><br />";
			}
			echo '<br /><br /><a class="formButton" href="' . ALBUM_ADMIN_URL . 'batchupload.php">' . _BACK . '</a>';

			break;
		case 'addimages':
		case 'addzip':
		default:
			icms_cp_header();
			icms::$module->displayAdminmenu(4, _MI_ALBUM_MENU_BATCHUPLOAD);
			
			echo "<h2 style='color: #336699;'>" . _AM_ALBUM_BATCHUPLOAD_SELECT_SOURCE . "</h2>";
			
			$opform = new icms_form_Simple('', 'opform', 'batchupload.php', "get");
			$op_select = new icms_form_elements_Select("", 'op', $clean_op);
			$op_select->setExtra('onchange="document.forms.opform.submit()"');
			$op_select->addOption('addimages', _AM_ALBUM_BATCHUPLOAD_IMAGES);
			$op_select->addOption('addzip', _AM_ALBUM_BATCHUPLOAD_ZIPUPL);
			$opform->addElement($op_select);
			$opform->display();
			
			echo "<br />";
			
			$submit_op = ($clean_op == 'addzip') ? "batchupload.php?op=zipupload" : "batchupload.php?op=batchupload";
			
			$case = ($clean_op == 'addzip') ? _AM_ALBUM_BATCHUPLOAD_ZIPUPL : _AM_ALBUM_BATCHUPLOAD_IMAGES;
			
			$form = new icms_form_Theme(_AM_ALBUM_BATCHUPLOAD_ADD . " - " . $case, "op", $submit_op, "post", TRUE);
			
			$selalbum = new icms_form_elements_Select(_CO_ALBUM_IMAGES_A_ID, "a_id");
			$selalbum->addOptionArray($album_album_handler->getAlbumListForPid());
			$selalbum->setRequired();
			$form->addElement($selalbum);
			
			if($clean_op == 'addimages' || $clean_op ==  '') {
				$selimages = new icms_form_elements_Checkbox(_AM_ALBUM_BATCHUPLOAD_SEL_IMAGES, "img_ids");
				$selimages->addOptionArray($album_images_handler->getImagesFromBatch());
				$selimages->setRequired();
				$form->addElement($selimages);
			} elseif ($clean_op == 'addzip') {
				$uploader = new icms_form_elements_File(_AM_ALBUM_BATCHUPLOAD_UPLOAD_ZIP, "img_zip", 20000000);
				$uploader->setRequired();
				$form->addElement($uploader);
				$form->setExtra('enctype="multipart/form-data"');
			}
			
			$form->addElement(new icms_form_elements_Textarea(_AM_ALBUM_BATCHUPLOAD_IMG_DSC, "img_dsc", "", 7, 50));
			
			$form->addElement(new icms_form_elements_Radioyn(_CO_ALBUM_IMAGES_IMG_ACTIVE, "img_active", 1));
			
			if($albumConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
				$seltags = new icms_form_elements_Select(_CO_ALBUM_IMAGES_IMG_TAGS, "img_tags", 0, 10, TRUE);
				$seltags->addOptionArray($album_images_handler->getImagesTags());
				$form->addElement($seltags);
			}
			$form->addElement(new icms_form_elements_Text(_CO_ALBUM_IMAGES_IMG_COPYRIGHT, "img_copyright", 50, 255, $albumConfig['img_default_copyright'] ));
			
			$tray = new icms_form_elements_Tray(_CO_ALBUM_IMAGES_IMG_URLLINK, "<br />", "img_urllink");
			$mid = new icms_form_elements_Hidden("mid_img_urllink", icms::$module->getVar("mid"));
			$cap = new icms_form_elements_Text(_AM_ALBUM_BATCHUPLOAD_URL_CAP, "caption_img_urllink", 50, 255);
			$dsc = new icms_form_elements_Text(_AM_ALBUM_BATCHUPLOAD_URL_DSC, "desc_img_urllink", 50, 255);
			$url = new icms_form_elements_Text(_AM_ALBUM_BATCHUPLOAD_URL_URL, "url_img_urllink", 50, 255);
			$tar = new icms_form_elements_Radio(_AM_ALBUM_BATCHUPLOAD_URL_TARGET, "target_img_urllink", "_blank");
			$tar->addOption("_blank", "_blank");
			$tar->addOption("_self", "_self");
			$tray->addElement($cap);
			$tray->addElement($dsc);
			$tray->addElement($url);
			$tray->addElement($tar);
			$tray->addElement($mid);
			$form->addElement($tray);
			
			$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
			$form->display();			
			break;
	}
	include_once 'admin_footer.php';
}