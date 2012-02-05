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
	global $album_images_handler, $icmsModule, $icmsAdminTpl;

	$imagesObj = $album_images_handler->get($images_id);
	if(is_object(icms::$user)) {
		$img_uid = icms::$user->getVar("uid");
	} else {
		$img_uid = 0;
	}
	if (!$imagesObj->isNew()){
		$imagesObj->setVar( 'img_updated_date', (time() - 300) );
		album_adminmenu( 1, _MI_ALBUM_MENU_IMAGES . " > " . _MI_ALBUM_IMAGES_EDIT);
		$sform = $imagesObj->getForm(_AM_ALBUM_IMAGES_EDIT, "addimages");
		$sform->assign($icmsAdminTpl);
	} else {
		$imagesObj->setVar('img_publisher', $img_uid);
		$imagesObj->setVar( 'img_published_date', (time() - 300) );
		album_adminmenu( 1, _MI_ALBUM_MENU_IMAGES . " > " . _MI_ALBUM_IMAGES_UPLOADNEW);
		$sform = $imagesObj->getForm(_MI_ALBUM_IMAGES_UPLOADNEW, "addimages");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:album_admin.html");
}

include_once "admin_header.php";

$album_album_handler = icms_getModuleHandler("album", basename(dirname(dirname(__FILE__))), "album");
$count = $album_album_handler->getCount(FALSE, TRUE, FALSE);
if($count == 0) {
	redirect_header(ALBUM_ADMIN_URL . 'album.php', 3, _AM_NO_ALBUM_FOUND);
} else {
	
	$clean_img_id = $clean_a_id = $clean_op = $valid_op = '';
	$valid_op = array ('mod', 'changedField', 'addimages', 'del','view','changeApprove','visible','changeWeight','');
	
	$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
	if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');
	
	$album_images_handler = icms_getModuleHandler('images', basename(dirname(dirname(__FILE__))), 'album');
	$clean_img_id = isset($_GET["img_id"]) ? filter_input(INPUT_GET, "img_id", FILTER_SANITIZE_NUMBER_INT) : 0 ;
	
	if (in_array($clean_op, $valid_op, TRUE)) {
		switch ($clean_op) {
			case "mod":
			case "changedField":
				icms_cp_header();
				editimages($clean_img_id);
				break;
	
			case "addimages":
				$controller = new icms_ipf_Controller($album_images_handler);
				$controller->storeFromDefaultForm(_AM_ALBUM_IMAGES_CREATED, _AM_ALBUM_IMAGES_MODIFIED);
				break;
	
			case "del":
				$controller = new icms_ipf_Controller($album_images_handler);
				$controller->handleObjectDeletion();
				break;
	
			case "view" :
				$imagesObj = $album_images_handler->get($clean_img_id);
				icms_cp_header();
				$imagesObj->displaySingleObject();
				break;
	
			case "visible":
				$visibility = $album_images_handler -> changeVisible( $clean_img_id );
				$ret = 'images.php';
				if ($visibility == 0) {
					redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_IMAGE_OFFLINE );
				} else {
					redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_IMAGE_ONLINE );
				}
				break;
			
			case 'changeApprove':
				$approve = $album_images_handler -> changeApprove( $clean_img_id );
				$ret = 'images.php';
				if ($approve == 0) {
					redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_APPROVE_FALSE );
				} else {
					redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_APPROVE_TRUE );
				}
				break;
				
			case "changeWeight":
				foreach ($_POST['AlbumImages_objects'] as $key => $value) {
					$changed = FALSE;
					$imagesObj = $album_images_handler -> get( $value );
					if ($imagesObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
						$imagesObj->setVar('weight', (int)($_POST['weight'][$key]));
						$changed = TRUE;
					}
					if ($changed) {
						$album_images_handler -> insert($imagesObj);
					}
				}
				$ret = 'index.php';
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_WEIGHT_UPDATED);
				break;
				
			default:
				icms_cp_header();
				$icmsModule->displayAdminMenu(1, _MI_ALBUM_MENU_IMAGES);
				$criteria = '';
				// if no op is set, but there is a (valid) album_id, display a single album
				if ($clean_img_id) {
					$imagesObj = $album_images_handler->get($clean_img_id);
					if ($imagesObj->id()) {
						$imagesObj->displaySingleObject();
					}
				}
				if (empty($criteria)) {
					$criteria = null;
				}
				
				$objectTable = new icms_ipf_view_Table($album_images_handler, $criteria);
				$objectTable->addColumn( new icms_ipf_view_Column( 'img_active', 'center', TRUE, 'img_active' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'a_id', FALSE, FALSE, 'image_aid' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'img_approve', 'center', TRUE, 'img_approve' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'img_title' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'weight', 'center', TRUE, 'getWeightControl' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'img_published_date', 'center', TRUE ) );
				
				$objectTable->addFilter( 'img_active', 'img_active_filter' );
				$objectTable->addFilter( 'img_approve', 'img_approve_filter' );
				$objectTable->addFilter( 'a_id', 'getAlbumList' );
		  		
				$objectTable->addIntroButton( 'addform', 'images.php?op=mod', _AM_ALBUM_ADD );
				$objectTable->addActionButton( 'changeWeight', FALSE, _SUBMIT );
		  				
				$icmsAdminTpl->assign( 'album_images_table', $objectTable->fetch() );
		  		$icmsAdminTpl->display( 'db:album_admin.html' );
				break;
		}
		icms_cp_footer();
	}
}