<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/admin_header.php
 *
 * List, add, edit and delete album objects
 *
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

function editalbum($album_id = 0) {
	global $album_album_handler, $icmsAdminTpl;

	$albumObj = $album_album_handler->get($album_id);

	if (!$albumObj->isNew()){
		$albumObj->hideFieldFromForm(array( 'album_published_date', 'album_updated_date' ) );
		$albumObj->setVar( 'album_updated_date', (time() - 100) );
		album_adminmenu( 0, _MI_ALBUM_MENU_ALBUM . ' > ' . _MI_ALBUM_ALBUM_EDITING);
		$sform = $albumObj->getForm(_AM_ALBUM_ALBUM_EDIT, 'addalbum');
		$sform->assign($icmsAdminTpl);
	} else {
		$albumObj->hideFieldFromForm(array( 'album_published_date', 'album_updated_date' ) );
		$albumObj->setVar( 'album_published_date', (time() - 100) );
		album_adminmenu( 0, _MI_ALBUM_MENU_ALBUM . " > " . _MI_ALBUM_ALBUM_CREATINGNEW);
		$sform = $albumObj->getForm(_AM_ALBUM_ALBUM_CREATE, 'addalbum');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:album_admin_album.html');
}

include_once 'admin_header.php';

$album_album_handler = icms_getModuleHandler('album', basename(dirname(dirname(__FILE__))), 'album');

$clean_op = '';

$valid_op = array ('mod', 'changedField', 'addalbum', 'del', 'view', 'visible', 'changeShow', 'changeWeight', '');

if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

$clean_album_id = isset($_GET['album_id']) ? (int)$_GET['album_id'] : 0 ;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editalbum($clean_album_id);
			break;

		case 'addalbum':
			$controller = new icms_ipf_Controller($album_album_handler);
			$controller->storeFromDefaultForm(_AM_ALBUM_ALBUM_CREATED, _AM_ALBUM_ALBUM_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($album_album_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$albumObj = $album_album_handler->get($clean_album_id);
			icms_cp_header();
			$albumObj->displaySingleObject();
			break;

		case "visible":
			$visibility = $album_album_handler -> changeVisible( $clean_album_id );
			$ret = 'album.php';
			if ($visibility == 0) {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_ALBUM_OFFLINE );
			} else {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_ALBUM_ONLINE );
			}
			break;
			
		case "changeShow":
			$show = $album_album_handler -> changeShow( $clean_album_id );
			$ret = 'album.php';
			if ($show == 0) {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_ALBUM_INBLOCK_FALSE );
			} else {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_ALBUM_INBLOCK_TRUE );
			}
			break;
			
		case "changeWeight":
			foreach ($_POST['AlbumAlbum_objects'] as $key => $value) {
				$changed = false;
				$albumObj = $album_album_handler -> get( $value );

				if ($albumObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$albumObj->setVar('weight', intval($_POST['weight'][$key]));
					$changed = true;
				}
				if ($changed) {
					$album_album_handler -> insert($albumObj);
				}
			}
			$ret = 'index.php';
			redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_ALBUM_WEIGHTS_UPDATED);
			break;
			
		default:
			icms_cp_header();
			album_adminmenu( 0, _MI_ALBUM_MENU_ALBUM );
			$criteria = '';
			if ($clean_album_id) {
				$albumObj = $album_album_handler->get($clean_album_id);
				if ($albumObj->id()) {
					$albumObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create album table
			$objectTable = new icms_ipf_view_Table($album_album_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_active', 'center', true ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_title', false, false, 'getPreviewItemLink' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_sub', 'center', 100));
			$objectTable->addColumn( new icms_ipf_view_Column( 'counter', 'center', 100));
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_inblocks', 'center', true ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_published_date', 'center', true ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_uid', 'center', true, 'album_uid' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'weight', 'center', true, 'getWeightControl' ) );
			
			$objectTable->addFilter( 'album_active', 'album_active_filter' );
			$objectTable->addFilter( 'album_inblocks', 'album_active_filter' );
			$objectTable->addFilter('album_pid', 'getAlbumListForPid');
			
			$objectTable->addIntroButton( 'addalbum', 'album.php?op=mod', _AM_ALBUM_ALBUM_ADD );
			$objectTable->addActionButton( 'changeWeight', false, _SUBMIT );
			
			$objectTable->addCustomAction( 'getViewItemLink' );
			
			$icmsAdminTpl->assign( 'album_album_table', $objectTable->fetch() );
			$icmsAdminTpl->display( 'db:album_admin_album.html' );
			break;
	}
	icms_cp_footer();
}
