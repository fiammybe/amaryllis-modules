<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /images.php
 *
 * add, edit and delete images
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

function editimages($imagesObj, $clean_album_id) {
	global $album_images_handler, $album_album_handler, $icmsTpl, $albumConfig, $album_isAdmin;
	$album_uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
	
	if (!$imagesObj->isNew()){
		if(!$imagesObj->userCanEditAndDelete()) {
			redirect_header(icms_getPreviousPage(), 3, _NOPERM);
		}
		$imagesObj->hideFieldFromForm(array('a_id', 'meta_description', 'meta_keywords', 'img_publisher', 'img_active', 'img_approve', 'img_published_date', 'img_updated_date' ) );
		$imagesObj->setVar( 'img_updated_date', (time() - 100) );
		if($albumConfig['image_needs_approval'] == 1) {
			$imagesObj->setVar('img_approve', FALSE );
		} else {
			$imagesObj->setVar('img_approve', TRUE );
		}
		$sform = $imagesObj->getSecureForm(_MD_ALBUM_IMAGES_EDIT . " &raquo;" . $imagesObj->getVar("img_title", "e"). "&laquo;", 'addimages');
		$sform->assign($icmsTpl, 'album_images_form');
		$icmsTpl->assign('album_cat_path', $imagesObj->getVar('img_title') . ' > ' . _EDIT);
	} else {
		if(empty($clean_album_id) && !$album_isAdmin) {
			redirect_header(icms_getPreviousPage(), 3, _NOPERM);
		} else {
			$albumObj = $album_album_handler->get($clean_album_id);
			if($album_isAdmin || (is_object($albumObj) && !$albumObj->isNew() && $albumObj->submitAccessGranted())) {
				$imagesObj->hideFieldFromForm(array('a_id', 'meta_description', 'meta_keywords', 'img_updated','img_active', 'img_publisher', 'img_approve', 'img_published_date', 'img_updated_date' ) );
				$imagesObj->setVar('img_published_date', (time() - 100) );
				if($albumConfig['image_needs_approval'] == 1 && !$album_isAdmin) {
					$imagesObj->setVar('img_approve', FALSE );
				} else {
					$imagesObj->setVar('img_approve', TRUE );
				}
				$imagesObj->setVar('img_publisher', $album_uid);
				$imagesObj->setVar('a_id', $clean_album_id);
				$sform = $imagesObj->getSecureForm(_MD_ALBUM_IMAGES_CREATE, 'addimages');
				$sform->assign($icmsTpl, 'album_images_form');
				$icmsTpl->assign('album_cat_path', _SUBMIT);
			}
		}
	}
}

include_once 'header.php';

$xoopsOption['template_main'] = 'album_forms.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_images_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? (int)($_GET['start']) : 0;

$valid_op = array ('mod', 'addimages', 'del');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$album_images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
$album_album_handler = icms_getModuleHandler("album", ALBUM_DIRNAME, "album");
$albumObj = $album_album_handler->get($clean_album_id);
if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case('mod'):
			$imagesObj = $album_images_handler->get($clean_images_id);
			if ($clean_images_id > 0 && $imagesObj->isNew()) {
				redirect_header(ALBUM_URL, 3, _NOPERM);
			}
			editimages($imagesObj, $clean_album_id);
			break;
		
		case('addimages'):
			$controller = new icms_ipf_Controller($album_images_handler);
			$controller->storeFromDefaultForm(_MD_ALBUM_IMAGES_CREATED, _MD_ALBUM_IMAGES_MODIFIED);
			break;
		case('del'):
			$imagesObj = $album_images_handler->get($clean_images_id);
			if (!$imagesObj->userCanEditAndDelete()) {
				redirect_header(icms_getPreviousPage(), 3, _NOPERM);
			}
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($album_images_handler);
			$controller->handleObjectDeletionFromUserSide();
			break;
	}
} else {
	redirect_header(ALBUM_URL, 3, _NOPERM);
}

if( $albumConfig['show_breadcrumbs'] == TRUE ) {
	$icmsTpl->assign('album_show_breadcrumb', TRUE);
} else {
	$icmsTpl->assign('album_show_breadcrumb', FALSE);
}

include_once "footer.php";