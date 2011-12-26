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

function editimages($imagesObj) {
	global $album_images_handler, $icmsTpl, $albumConfig;
	
	if (!$imagesObj->isNew()){
		$imagesObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'img_publisher', 'img_active', 'img_approve', 'img_published_date', 'img_updated_date' ) );
		$imagesObj->setVar( 'img_updated_date', (time() - 100) );
		if($albumConfig['image_needs_approval'] == 1) {
			$imagesObj->setVar('img_approve', FALSE );
		} else {
			$imagesObj->setVar('img_approve', TRUE );
		}
		$sform = $imagesObj->getSecureForm(_MD_ALBUM_IMAGES_EDIT, 'addimages');
		$sform->assign($icmsTpl, 'album_images_form');
		$icmsTpl->assign('album_cat_path', $imagesObj->getVar('img_title') . ' > ' . _EDIT);
	} else {
		$imagesObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'img_updated','img_active', 'img_publisher', 'img_approve', 'img_published_date', 'img_updated_date' ) );
		$imagesObj->setVar('images_published_date', (time() - 100) );
		if($albumConfig['image_needs_approval'] == 1) {
			$imagesObj->setVar('img_approve', FALSE );
		} else {
			$imagesObj->setVar('img_approve', TRUE );
		}
		$imagesObj->setVar('img_publisher', icms::$user->getVar("uid"));
		
		$sform = $imagesObj->getSecureForm(_MD_ALBUM_IMAGES_CREATE, 'addimages');
		$sform->assign($icmsTpl, 'album_images_form');
		$icmsTpl->assign('album_cat_path', _SUBMIT);
	}
}

include_once 'header.php';

$xoopsOption['template_main'] = 'album_forms.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = $indexpageObj = $album_indexpage_handler = $indexpageObj = '';
$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$album_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'album' );

$indexpageObj = $album_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('album_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_images_id = isset($_GET['images_id']) ? filter_input(INPUT_GET, 'images_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$valid_op = array ('mod', 'addimages', 'del');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');


$album_images_handler = icms_getModuleHandler("images", basename(dirname(__FILE__)), "album");

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case('mod'):
			$imagesObj = $album_images_handler->get($clean_images_id);
			if ($clean_images_id > 0 && $imagesObj->isNew()) {
				redirect_header(ALBUM_URL, 3, _NO_PERM);
			}
			editimages($imagesObj);
			break;
		
		case('addimages'):
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($album_images_handler);
			$controller->storeFromDefaultForm(_MD_ALBUM_IMAGES_CREATED, _MD_ALBUM_IMAGES_MODIFIED);
			break;
		case('del'):
			$imagesObj = $album_images_handler->get($clean_images_id);
			if (!$imagesObj->userCanEditAndDelete()) {
				redirect_header($imagesObj->getItemLink(true), 3, _NO_PERM);
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
	redirect_header(ALBUM_URL, 3, _NO_PERM);
}

if( $albumConfig['show_breadcrumbs'] == true ) {
	$icmsTpl->assign('album_show_breadcrumb', true);
} else {
	$icmsTpl->assign('album_show_breadcrumb', false);
}

include_once "footer.php";