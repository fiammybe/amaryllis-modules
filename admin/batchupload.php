<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/album.php
 *
 * List, add, edit and delete album objects
 *
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
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

$valid_op = array ('batchupload', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$album_album_handler = icms_getModuleHandler('album', ALBUM_DIRNAME, 'album');
$album_images_handler = icms_getModuleHandler('images', ALBUM_DIRNAME, 'album');

$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;
$clean_images_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'batchupload':
			icms_cp_header();
			icms::$module->displayAdminmenu(3, _MI_ALBUM_MENU_BATCHUPLOAD);
			if($_POST['a_id'] <= 0) redirect_header(ALBUM_ADMIN_URL . "batchupload.php", 4, _AM_ALBUM_BATCHUPLOAD_NOALBUM);
			$files = $_POST['img_ids'];
			$i = 0;
			foreach ($files as $file => $value) {
				$i++;
				$img_title = array_shift(explode(".", $value));
				$imagesObject = $album_images_handler->create(TRUE);
				$imagesObject->setVar("a_id", $_POST['a_id']);
				$imagesObject->setVar("img_title", $img_title);
				$imagesObject->setVar("img_published_date", time() - 100);
				$imagesObject->setVar("img_description", $img_title . " - " . $_POST['img_dsc']);
				$imagesObject->setVar("img_url", $value);
				if($albumConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) $imagesObject->setVar("img_tags", $_POST['img_tags']);
				$imagesObject->setVar("img_active", $_POST['img_active']);
				$imagesObject->setVar("img_approve", TRUE);
				$imagesObject->setVar("weight", $i);
				$imagesObject->setVar("img_publisher", icms::$user->getVar("uid", "e"));
				//if($albumConfig['need_image_links'] == 1) $imagesObject->setVar("img_urllink", $_POST['img_urllink']);
				
				icms_core_Filesystem::copyRecursive(ALBUM_BATCH_ROOT . $value, ALBUM_IMAGES_UPLOAD . $value);
				icms_core_Filesystem::deleteFile(ALBUM_BATCH_ROOT . $value);
				
				$album_images_handler->insert($imagesObject, TRUE);
				echo "<code> File " . $value . " successfully moved.</code><br />";
			}
			
			break;
		
		default:
			icms_cp_header();
			icms::$module->displayAdminmenu(3, _MI_ALBUM_MENU_BATCHUPLOAD);
			
			$form = new icms_form_Theme(_AM_ALBUM_BATCHUPLOAD_ADD, "op", "batchupload.php?op=batchupload", "post", TRUE);
			
			$selalbum = new icms_form_elements_Select(_CO_ALBUM_IMAGES_A_ID, "a_id");
			$selalbum->addOptionArray($album_album_handler->getAlbumListForPid());
			$selalbum->setRequired();
			$form->addElement($selalbum);
			
			$selimages = new icms_form_elements_Checkbox(_AM_ALBUM_BATCHUPLOAD_SEL_IMAGES, "img_ids");
			$selimages->addOptionArray($album_images_handler->getImagesFromBatch());
			$form->addElement($selimages);
			
			$form->addElement(new icms_form_elements_Textarea(_AM_ALBUM_BATCHUPLOAD_IMG_DSC, "img_dsc", "", 7, 50));
			
			$form->addElement(new icms_form_elements_Radioyn(_CO_ALBUM_IMAGES_IMG_ACTIVE, "img_active", 1));
			
			if($albumConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
				$seltags = new icms_form_elements_Select(_CO_ALBUM_IMAGES_IMG_TAGS, "img_tags", 0, 10, TRUE);
				$seltags->addOptionArray($album_images_handler->getImagesTags());
				$form->addElement($seltags);
			}
			/**
			if($albumConfig['need_image_links'] == 1) {
				$addUrllink = new icms_ipf_form_elements_Urllink($album_images_handler->create(TRUE), "img_urllink");
				$form->addElement($addUrllink);
			}
			*/
			$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, "submit"));
			$form->display();
			
			break;
	}
	include_once 'admin_footer.php';
}