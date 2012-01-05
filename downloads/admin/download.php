<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /admin/about.php
 * 
 * About page of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

function editdownload($download_id = 0) {
	global $downloads_download_handler, $icmsAdminTpl, $downloadsConfig;
	
	$downloadObj = $downloads_download_handler->get($download_id);
	
	$downloads_log_handler = icms_getModuleHandler("log", basename(dirname(dirname(__FILE__))), "downloads");
	if (!is_object(icms::$user)) {
		$log_uid = 0;
	} else {
		$log_uid = icms::$user->getVar("uid");
	}
	
	
	if (!$downloadObj->isNew()){
		$downloadObj->hideFieldFromForm(array( 'download_published_date', 'download_updated_date', 'download_approve' ) );
		$downloadObj->setVar( 'download_updated_date', (time() - 100) );
		
		$logObj = $downloads_log_handler->create();
		$logObj->setVar('log_item_id', $downloadObj->id() );
		$logObj->setVar('log_date', (time()-200) );
		$logObj->setVar('log_uid', $log_uid);
		$logObj->setVar('log_item', 0 );
		$logObj->setVar('log_case', 3 );
		$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
		$logObj->store(TRUE);
		
		downloads_adminmenu( 1, _MI_DOWNLOADS_MENU_DOWNLOAD . ' > ' . _MI_DOWNLOADS_DOWNLOAD_EDIT);
		$sform = $downloadObj->getForm(_AM_DOWNLOADS_EDIT, 'adddownload');
		$sform->assign($icmsAdminTpl);
		
	} else {
		$downloadObj->hideFieldFromForm(array( 'download_published_date', 'download_updated_date', 'download_approve' ) );
		$downloadObj->setVar('download_approve', true);
		$downloadObj->setVar('download_mirror_approve', true);
		$downloadObj->setVar('download_has_mirror', true);
		$downloadObj->setVar( 'download_published_date', (time() - 100) );
		$downloadObj->setVar('download_submitter', icms::$user->getVar("uid"));
		downloads_adminmenu( 1, _MI_DOWNLOADS_MENU_DOWNLOAD . " > " . _MI_DOWNLOADS_DOWNLOAD_CREATINGNEW);
		$sform = $downloadObj->getForm(_AM_DOWNLOADS_CREATE, 'adddownload');
		$sform->assign($icmsAdminTpl);

		$logObj = $downloads_log_handler->create();
		$logObj->setVar('log_item_id', $downloadObj->id() );
		$logObj->setVar('log_date', (time()-200) );
		$logObj->setVar('log_uid', $log_uid);
		$logObj->setVar('log_item', 0 );
		$logObj->setVar('log_case', 1 );
		$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
		$logObj->store(TRUE);
	}
	$icmsAdminTpl->display('db:downloads_admin.html');
}

include_once "admin_header.php";

$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');
$count = $downloads_category_handler -> getCount(false, true, false);
if( $count <= 0 ) {
	redirect_header (DOWNLOADS_ADMIN_URL . 'category.php', 3, _AM_DOWNLOADS_NO_CAT_FOUND);
} else {
$valid_op = array ('mod', 'changedField', 'adddownload', 'del', 'view', 'visible', 'changeShow','changeBroken','changeApprove','changeMirrorApprove', 'changeWeight', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');

$clean_download_id = isset($_GET['download_id']) ? (int)$_GET['download_id'] : 0 ;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editdownload($clean_download_id);
			break;

		case 'adddownload':
			$controller = new icms_ipf_Controller($downloads_download_handler);
			$controller->storeFromDefaultForm(_AM_DOWNLOADS_CREATED, _AM_DOWNLOADS_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($downloads_download_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$downloadObj = $downloads_download_handler->get($clean_download_id);
			icms_cp_header();
			$downloadObj->displaySingleObject();
			break;

		case 'visible':
			$visibility = $downloads_download_handler -> changeVisible( $clean_download_id );
			$ret = 'download.php';
			if ($visibility == 0) {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_OFFLINE );
			} else {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_ONLINE );
			}
			break;
			
		case 'changeShow':
			$show = $downloads_download_handler -> changeShow( $clean_download_id );
			$ret = 'download.php';
			if ($show == 0) {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_INBLOCK_FALSE );
			} else {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_INBLOCK_TRUE );
			}
			break;
		
		case 'changeBroken':
			$show = $downloads_download_handler -> changeBroken( $clean_download_id );
			$ret = 'download.php';
			if ($show == 0) {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_OFFLINE );
			} else {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_ONLINE );
			}
			break;
		
		case 'changeMirrorApprove':
			$mirror_approve = $downloads_download_handler -> changeMirrorApprove( $clean_download_id );
			$ret = 'download.php';
			if ($show == 0) {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_MIRROR_FALSE );
			} else {
				$obj = $downloads_download_handler->get($clean_download_id);
				$obj->sendDownloadNotification('mirror_approved');
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_MIRROR_TRUE );
			}
			break;
		
		case 'changeApprove':
			$approve = $downloads_download_handler -> changeApprove( $clean_download_id );
			$ret = 'download.php';
			if ($approve == 0) {
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_APPROVE_FALSE );
			} else {
				$obj = $downloads_download_handler->get($clean_download_id);
				$obj->sendDownloadNotification('file_approved');
				redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_APPROVE_TRUE );
			}
			
			break;
			
		case "changeWeight":
			foreach ($_POST['DownloadsCategory_objects'] as $key => $value) {
				$changed = false;
				$downloadObj = $downloads_download_handler -> get( $value );

				if ($downloadObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$downloadObj->setVar('weight', intval($_POST['weight'][$key]));
					$changed = true;
				}
				if ($changed) {
					$downloads_download_handler -> insert($downloadObj);
				}
			}
			$ret = 'download.php';
			redirect_header( DOWNLOADS_ADMIN_URL . $ret, 2, _AM_DOWNLOADS_DOWNLOAD_WEIGHTS_UPDATED);
			break;
			
		default:
			icms_cp_header();
			downloads_adminmenu( 1, _MI_DOWNLOADS_MENU_DOWNLOAD );
			$criteria = '';
			if ($clean_download_id) {
				$downloadObj = $downloads_download_handler->get($clean_download_id);
				if ($downloadObj->id()) {
					$downloadObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create downloads table
			$objectTable = new icms_ipf_view_Table($downloads_download_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_active', 'center', 50, 'download_active' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_title', false, false, 'getPreviewItemLink' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_cid', false, false, 'getDownloadCid' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'counter', 'center', 50));
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_inblocks', 'center', 50, 'download_inblocks' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_approve', 'center', 50, 'download_approve' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_mirror_approve', 'center', 50, 'download_mirror_approve' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_broken', 'center', 50, 'download_broken' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_published_date', 'center', 100, true ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'download_publisher', 'center', true, 'download_publisher' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'weight', 'center', true, 'getDownloadWeightControl' ) );
			
			$objectTable->addFilter( 'download_active', 'download_active_filter' );
			$objectTable->addFilter( 'download_inblocks', 'download_inblocks_filter' );
			$objectTable->addFilter( 'download_approve', 'download_approve_filter' );
			$objectTable->addFilter( 'download_broken', 'download_broken_filter' );
			$objectTable->addFilter( 'download_has_mirror', 'download_has_mirror_filter' );
			//$objectTable->addFilter( 'download_cid', 'getCategoryList' );
			
			$objectTable->addQuickSearch(array('download_title', 'download_keyfeatures', 'download_requirements', 'download_platform', 'download_dev'));
			
			$objectTable->addIntroButton( 'adddownload', 'download.php?op=mod', _AM_DOWNLOADS_DOWNLOAD_ADD );
			$objectTable->addActionButton( 'changeWeight', false, _SUBMIT );
			
			$objectTable->addCustomAction( 'getViewItemLink' );
			
			$icmsAdminTpl->assign( 'downloads_download_table', $objectTable->fetch() );
			$icmsAdminTpl->display( 'db:downloads_admin.html' );
			break;
	}
	icms_cp_footer();
}

}