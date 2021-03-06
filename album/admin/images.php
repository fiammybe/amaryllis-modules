<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/images.php
 *
 * List, add, edit and delete images objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

function editimages($images_id = 0) {
	global $images_handler, $icmsModule, $icmsAdminTpl;

	$imagesObj = $images_handler->get($images_id);
	$img_uid = icms::$user->getVar("uid");
	if (!$imagesObj->isNew()){
		$imagesObj->hideFieldFromForm(array("img_approve", "img_copyright", "img_copy_pos", "img_copy_font", "img_copy_fontsize", "img_copy_color"));
		$imagesObj->setVar( 'img_updated_date', (time() - 100) );
		icms::$module->displayAdminmenu( 2, _MI_ALBUM_MENU_IMAGES . " > " . _MI_ALBUM_IMAGES_EDIT . " &raquo;" . $imagesObj->title()."&laquo;");
		$sform = $imagesObj->getForm(_AM_ALBUM_IMAGES_EDIT." &raquo;".$imagesObj->title()."&laquo;", "addimages");
		$sform->assign($icmsAdminTpl);
	} else {
		$imagesObj->hideFieldFromForm(array("img_approve"));
		$imagesObj->setVar('img_publisher', $img_uid);
		$imagesObj->setVar( 'img_published_date', (time() - 100) );
		icms::$module->displayAdminmenu( 2, _MI_ALBUM_MENU_IMAGES . " > " . _MI_ALBUM_IMAGES_UPLOADNEW);
		$sform = $imagesObj->getForm(_MI_ALBUM_IMAGES_UPLOADNEW, "addimages");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:album_admin.html");
}

include_once "admin_header.php";

$album_album_handler = icms_getModuleHandler("album", ALBUM_DIRNAME, "album");
$count = $album_album_handler->getCount(NULL);
if($count <= 0) redirect_header(ALBUM_ADMIN_URL . 'album.php', 3, _AM_NO_ALBUM_FOUND);

$clean_img_id = $clean_a_id = $clean_op = $valid_op = '';
$valid_op = array ('mod', 'changedField', 'addimages', 'del','view','changeApprove','visible','changeFields','');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$images_handler = new mod_album_ImagesHandler(icms::$xoopsDB);
$clean_img_id = isset($_GET["img_id"]) ? filter_input(INPUT_GET, "img_id", FILTER_SANITIZE_NUMBER_INT) : 0 ;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editimages($clean_img_id);
			break;

		case "addimages":
			$controller = new icms_ipf_Controller($images_handler);
			$controller->storeFromDefaultForm(_AM_ALBUM_IMAGES_CREATED, _AM_ALBUM_IMAGES_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($images_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$imagesObj = $images_handler->get($clean_img_id);
			icms_cp_header();
			$imagesObj->displaySingleObject();
			break;

		case "visible":
			$visibility = $images_handler->changeField($clean_img_id,"img_active");
			$ret = 'images.php';
			if ($visibility == 0) {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_IMAGE_OFFLINE );
			} else {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_IMAGE_ONLINE );
			}
			break;

		case 'changeApprove':
			$approve = $images_handler->changeField($clean_img_id, "img_approve");
			if($approve == 1) {
				$imagesObj = $images_handler->get(($clean_img_id));
				$imagesObj->sendMessageApproved();
			}
			$red_message = ($approve == 0) ? _AM_ALBUM_APPROVE_FALSE : _AM_ALBUM_APPROVE_TRUE;
			redirect_header(ALBUM_ADMIN_URL . 'images.php', 2, $red_message);
			break;

		case "changeWeight":
			foreach ($_POST['mod_album_Images_objects'] as $key => $value) {
				$changed = FALSE;
				$imagesObj = $images_handler -> get( $value );
				if ($imagesObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$imagesObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$images_handler -> insert($imagesObj);
				}
			}
			$ret = 'images.php';
			redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_WEIGHT_UPDATED);
			break;

		case 'changeFields':
			foreach ($_POST['mod_album_Images_objects'] as $key => $value) {
				$changed = FALSE;
				$imagesObj = $images_handler->get($value);
				if($imagesObj->getVar('img_title', 'e') != $_POST['img_title'][$key]) {
					$imagesObj->setVar('img_title', $_POST['img_title'][$key]);
					$changed = TRUE;
				}
				if($imagesObj->getVar('img_description', 'e') != $_POST['img_description'][$key]) {
					$imagesObj->setVar('img_description', $_POST['img_description'][$key]);
					$changed = TRUE;
				}
				if($imagesObj->getVar('a_id', 'e') != $_POST['a_id'][$key]) {
					$imagesObj->setVar('a_id', $_POST['a_id'][$key]);
					$changed = TRUE;
				}
				if($imagesObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$imagesObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if($changed) {
					$imagesObj->_updating_table = TRUE;
					$images_handler->insert($imagesObj);
				}
			}
			$ret = 'images.php';
			redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_IMAGES_FIELDS_UPDATED);
			break;
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(2, _MI_ALBUM_MENU_IMAGES);
			$objectTable = new icms_ipf_view_Table($images_handler, FALSE);
			$objectTable->addColumn( new icms_ipf_view_Column( 'img_active', 'center', 50, 'img_active' ) );
			$objectTable->addColumn(new icms_ipf_view_Column('img_url', 'center', 70, 'getImgPreview'));
			$objectTable->addColumn( new icms_ipf_view_Column( 'img_title', FALSE, FALSE, 'getTitleControl' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'a_id', FALSE, FALSE, 'getAlbumControl' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'img_description', FALSE, FALSE, 'getDscControl' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'img_approve', 'center', TRUE, 'img_approve' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'img_publisher', 'center', 75, 'img_publisher' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'weight', 'center', TRUE, 'getWeightControl' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'img_published_date', 'center', TRUE, 'getPublishedDate' ) );
			$objectTable->setDefaultOrder("DESC");
			$objectTable->setDefaultSort("img_published_date");
			$objectTable->addFilter( 'img_active', 'img_active_filter' );
			$objectTable->addFilter( 'img_approve', 'img_approve_filter' );
			$objectTable->addFilter( 'a_id', 'getAlbumList' );

			$objectTable->addIntroButton( 'addform', 'images.php?op=mod', _AM_ALBUM_ADD );
			$objectTable->addActionButton( 'changeFields', FALSE, _SUBMIT );

			$icmsAdminTpl->assign( 'album_images_table', $objectTable->fetch() );
	  		$icmsAdminTpl->display( 'db:album_admin.html' );
			break;
	}
	include_once 'admin_footer.php';
}