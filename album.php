<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /album.php
 *
 * display a single album and album subs
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

function editalbum($albumObj = 0, $clean_album_pid = 0) {
	global $album_album_handler, $icmsTpl, $albumConfig;
	if(is_object(icms::$user)) {
		$album_uid = icms::$user->getVar("uid");
	} else {
		$album_uid = 0;
	}
	if (!$albumObj->isNew()){
		if (!$albumObj->userCanEditAndDelete()) {
			redirect_header($albumObj->getItemLink(TRUE), 3, _NOPERM);
		}
		$albumObj->hideFieldFromForm(array('album_pid', 'album_updated', 'meta_description', 'meta_keywords', 'album_uid','album_active', 'album_approve'));
		$albumObj->setVar( 'album_updated_date', (time() - 100) );
		$albumObj->setVar('album_updated', TRUE );
		if($albumConfig['album_needs_approval'] == 1) {
			$albumObj->setVar('album_approve', FALSE );
		} else {
			$albumObj->setVar('album_approve', TRUE );
		}
		$sform = $albumObj->getSecureForm(_MD_ALBUM_ALBUM_EDIT, 'addalbum');
		$sform->assign($icmsTpl, 'album_album_form');
		$icmsTpl->assign('album_cat_path', $albumObj->getVar('album_title') . ' > ' . _MD_ALBUM_ALBUM_EDIT);
	} else {
		if (!$album_album_handler->userCanSubmit()) {
			redirect_header($categoryObj->getItemLink(TRUE), 3, _NOPERM);
		}
		$albumObj->hideFieldFromForm(array('album_pid', 'album_updated', 'meta_description', 'meta_keywords', 'album_uid','album_active', 'album_approve'));
		$albumObj->setVar('album_published_date', (time() - 100) );
		if($albumConfig['album_needs_approval'] == 1) {
			$albumObj->setVar('album_approve', FALSE );
		} else {
			$albumObj->setVar('album_approve', TRUE );
		}
		$albumObj->setVar('album_uid', $album_uid);
		$albumObj->setVar('album_pid', $clean_album_pid);
		$sform = $albumObj->getSecureForm(_MD_ALBUM_ALBUM_CREATE, 'addalbum');
		$sform->assign($icmsTpl, 'album_album_form');
		$icmsTpl->assign('album_cat_path', $album_album_handler->getBreadcrumbForPid($clean_album_pid, 1) . ' > ' . _MD_ALBUM_ALBUM_CREATE);
	}
}

include_once 'header.php';

$xoopsOption['template_main'] = 'album_forms.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_album_pid = isset($_GET['album_pid']) ? filter_input(INPUT_GET, 'album_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? (int)($_GET['start']) : 0;

$valid_op = array ('mod', 'addalbum', 'del');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$album_album_handler = icms_getModuleHandler("album", ALBUM_DIRNAME, "album");

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case('mod'):
			$albumObj = $album_album_handler->get($clean_album_id);
			if ($clean_album_id > 0 && $albumObj->isNew()) {
				redirect_header(ALBUM_URL, 3, _NOPERM);
			}
			editalbum($albumObj, $clean_album_pid);
			break;
		case('addalbum'):
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($album_album_handler);
			$controller->storeFromDefaultForm(_MD_ALBUM_ALBUM_CREATED, _MD_ALBUM_ALBUM_MODIFIED);
			break;
		case('del'):
			$albumObj = $album_album_handler->get($clean_album_id);
			if (!$albumObj->userCanEditAndDelete()) {
				redirect_header($albumObj->getItemLink(TRUE), 3, _NOPERM);
			}
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($album_album_handler);
			$controller->handleObjectDeletionFromUserSide();
			break;
	}
} else {
	redirect_header(ALBUM_URL, 3, _NOPERM);
}
include_once "footer.php";