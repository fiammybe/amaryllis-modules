<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/album.php
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
	global $album_handler, $icmsAdminTpl;

	$albumObj = $album_handler->get($album_id);
	$album_uid = icms::$user->getVar("uid");

	if (!$albumObj->isNew()){
		$albumObj->hideFieldFromForm(array("album_approve", "meta_keywords", "meta_description", "album_updated"));
		$albumObj->makeFieldReadOnly("short_url");
		$albumObj->setVar( 'album_updated_date', (time() - 100) );
		$albumObj->setVar('album_updated', TRUE);
		icms::$module->displayAdminmenu( 1, _MI_ALBUM_MENU_ALBUM.' > '._MI_ALBUM_ALBUM_EDITING.' &raquo;'.$albumObj->getVar("album_title", "e")."&laquo;");
		$sform = $albumObj->getForm(_AM_ALBUM_ALBUM_EDIT, 'addalbum');
		$sform->assign($icmsAdminTpl);
	} else {
		$albumObj->hideFieldFromForm(array("album_approve", "meta_keywords", "meta_description", "album_updated"));
		$albumObj->setVar("album_uid", $album_uid);
		$albumObj->setVar( 'album_published_date', (time() - 100) );
		icms::$module->displayAdminmenu( 1, _MI_ALBUM_MENU_ALBUM . " > " . _MI_ALBUM_ALBUM_CREATINGNEW);
		$sform = $albumObj->getForm(_AM_ALBUM_CREATE, 'addalbum');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:album_admin.html');
}

include_once 'admin_header.php';
/**
 * define a whitelist of valid op's
 */
$valid_op = array ('mod', 'changedField', 'addalbum', 'del', 'view', 'visible', 'changeIndex','changeApprove', 'changeShow', 'changeWeight', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$album_handler = icms_getModuleHandler('album', ALBUM_DIRNAME, 'album');
$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editalbum($clean_album_id);
			break;

		case 'addalbum':
			$controller = new icms_ipf_Controller($album_handler);
			$controller->storeFromDefaultForm(_AM_ALBUM_ALBUM_CREATED, _AM_ALBUM_ALBUM_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($album_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$albumObj = $album_handler->get($clean_album_id);
			icms_cp_header();
			$albumObj->displaySingleObject();
			break;

		case 'visible':
			$visibility = $album_handler->changeField($clean_album_id, "album_active");
			$red_message = ($visibility == 0) ? _AM_ALBUM_OFFLINE : _AM_ALBUM_ONLINE;
			redirect_header(ALBUM_ADMIN_URL . 'album.php', 2, $red_message);
			break;

		case 'changeIndex':
			$visibility = $album_handler->changeField($clean_album_id, "album_onindex");
			$red_message = ($visibility == 0) ? _AM_ALBUM_OFFLINE : _AM_ALBUM_ONLINE;
			redirect_header(ALBUM_ADMIN_URL . 'album.php', 2, $red_message);
			break;

		case 'changeApprove':
			$approve = $album_handler->changeField($clean_album_id, "album_approve");
			if($approve == 1) {
				$albumObj = $album_handler->get($clean_album_id);
				$albumObj->sendMessageApproved();
			}
			$red_message = ($approve == 0) ? _AM_ALBUM_OFFLINE : _AM_ALBUM_ONLINE;
			redirect_header(ALBUM_ADMIN_URL . 'album.php', 2, $red_message);
			break;

		case 'changeShow':
			$visibility = $album_handler->changeField($clean_album_id, "album_inblocks");
			$red_message = ($visibility == 0) ? _AM_ALBUM_OFFLINE : _AM_ALBUM_ONLINE;
			redirect_header(ALBUM_ADMIN_URL . 'album.php', 2, $red_message);
			break;

		case "changeWeight":
			foreach ($_POST['mod_album_Album_objects'] as $key => $value) {
				$changed = FALSE;
				$albumObj = $album_handler -> get( $value );
				if ($albumObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$albumObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$albumObj->updating_counter = TRUE;
					$album_handler->insert($albumObj);
				}
			}
			$ret = 'album.php';
			redirect_header( ALBUM_ADMIN_URL . $ret, 2, _AM_ALBUM_WEIGHT_UPDATED);
			break;

		default:
			icms_cp_header();
			icms::$module->displayAdminmenu( 1, _MI_ALBUM_MENU_ALBUM );
			$criteria = '';
			if ($clean_album_id) {
				$albumObj = $album_handler->get($clean_album_id);
				if ($albumObj->id()) {
					$albumObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create album table
			$objectTable = new icms_ipf_view_Table($album_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_active', 'center', FALSE, 'album_active' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_title', FALSE, FALSE, 'getPreviewItemLink' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_pid', FALSE, FALSE, 'getAlbumParent' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'counter', 'center', 100));
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_approve', 'center', 50, 'album_approve' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_inblocks', 'center', 50, 'album_inblocks' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_onindex', 'center', 50, 'album_onindex' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_published_date', 'center', 100, TRUE ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_uid', 'center', FALSE, 'getPublisher' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'weight', 'center', TRUE, 'getWeightControl' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'album_tags', 'center', 70 ) );
			$objectTable->setDefaultOrder("DESC");
			$objectTable->setDefaultSort("album_published_date");
			$objectTable->addFilter( 'album_active', 'album_active_filter' );
			$objectTable->addFilter( 'album_approve', 'album_approve_filter' );
			$objectTable->addFilter( 'album_inblocks', 'album_inblocks_filter' );
			$objectTable->addFilter( 'album_pid', 'getAlbumListForPid' );
			$objectTable->addFilter( 'album_onindex', 'album_onindex_filter' );

			$objectTable->addIntroButton( 'addalbum', 'album.php?op=mod', _AM_ALBUM_ALBUM_ADD );
			$objectTable->addActionButton( 'changeWeight', FALSE, _SUBMIT );

			$objectTable->addCustomAction( 'getViewItemLink' );

			$icmsAdminTpl->assign( 'album_album_table', $objectTable->fetch() );
			$icmsAdminTpl->display( 'db:album_admin.html' );
			break;
	}
	include_once 'admin_footer.php';
}