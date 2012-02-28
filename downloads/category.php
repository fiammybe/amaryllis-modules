<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /category.php
 * 
 * add, edit and delete Downloads category Objects in frontend
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

function editcategory($categoryObj = 0) {
	global $downloads_category_handler, $icmsTpl, $downloadsConfig;
	
	$downloads_log_handler = icms_getModuleHandler("log", basename(dirname(__FILE__)), "downloads");
	if (!is_object(icms::$user)) {
		$log_uid = 0;
	} else {
		$log_uid = icms::$user->getVar("uid");
	}
	
	if (!$categoryObj->isNew()){
		if (!$categoryObj->userCanEditAndDelete()) {
			redirect_header($categoryObj->getItemLink(TRUE), 3, _NOPERM);
		}
		$categoryObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'category_updated', 'category_publisher', 'category_submitter', 'category_approve', 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar( 'category_updated_date', (time() - 100) );
		$categoryObj->setVar('category_updated', TRUE );
		
		$logObj = $downloads_log_handler->create();
		$logObj->setVar('log_item_id', $categoryObj->getVar("category_id") );
		$logObj->setVar('log_date', (time()-200) );
		$logObj->setVar('log_uid', $log_uid);
		$logObj->setVar('log_item', 1 );
		$logObj->setVar('log_case', 3 );
		$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
		$logObj->store(TRUE);
		
		$sform = $categoryObj->getSecureForm(_MD_DOWNLOADS_CATEGORY_EDIT, 'addcategory');
		$sform->assign($icmsTpl, 'downloads_category_form');
		$icmsTpl->assign('downloads_cat_path', $categoryObj->getVar('category_title') . ' : ' . _MD_DOWNLOADS_CATEGORY_EDIT);
	} else {
		$categoryObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'category_updated', 'category_publisher', 'category_submitter', 'category_approve', 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar('category_published_date', (time() - 100) );
		if($downloadsConfig['category_needs_approve'] == 1) {
			$categoryObj->setVar('category_approve', FALSE );
		} else {
			$categoryObj->setVar('category_approve', TRUE );
		}
		$categoryObj->setVar('category_submitter', $log_uid);
		$categoryObj->setVar('category_publisher', $log_uid);
		
		$logObj = $downloads_log_handler->create();
		$logObj->setVar('log_item_id', $categoryObj->getVar("category_id") );
		$logObj->setVar('log_date', (time()-200) );
		$logObj->setVar('log_uid', $log_uid);
		$logObj->setVar('log_item', 1 );
		$logObj->setVar('log_case', 1 );
		$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
		$logObj->store(TRUE);
		
		$sform = $categoryObj->getSecureForm(_MD_DOWNLOADS_CATEGORY_CREATE, 'addcategory');
		$sform->assign($icmsTpl, 'downloads_category_form');
		$icmsTpl->assign('downloads_cat_path', _MD_DOWNLOADS_CATEGORY_CREATE);
	}
} 

include_once 'header.php';

$xoopsOption['template_main'] = 'downloads_forms.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$downloads_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'downloads' );

$indexpageObj = $downloads_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('downloads_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = ($clean_category_id == 0 && isset($_POST['category_id'])) ? filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT) : $clean_category_id;
$clean_category_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
$clean_category_pid = isset($_GET['category_pid']) ? filter_input(INPUT_GET, 'category_pid', FILTER_SANITIZE_NUMBER_INT) : ($clean_category_uid ? FALSE : 0);

$downloads_category_handler = icms_getModuleHandler( 'category', icms::$module -> getVar( 'dirname' ), 'downloads' );

/**
 * Get a whitelist of valid op's
 */
$valid_op = array ('mod', 'addcategory', 'del');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

/**
 * Only proceed if the supplied operation is a valid operation
 */
if(in_array($clean_op, $valid_op, TRUE) && $downloads_category_handler->userCanSubmit()) {
	switch ($clean_op) {
		case 'mod':
			$categoryObj = $downloads_category_handler->get($clean_category_id);
			if ($clean_category_id > 0 && $categoryObj->isNew()) {
				redirect_header(DOWNLOADS_URL, 3, _NOPERM);
			}
			editcategory($categoryObj);
			
			break;
			
		case 'addcategory':
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$categoryObj = $downloads_category_handler->get($clean_category_id);
			$categoryObj->sendCategoryNotification('category_submitted');
			
			$controller = new icms_ipf_Controller($downloads_category_handler);
			$controller->storeFromDefaultForm(_MD_DOWNLOADS_CATEGORY_CREATED, _MD_DOWNLOADS_CATEGORY_MODIFIED);
			break;
		
		case 'del':
			$categoryObj = $downloads_category_handler->get($clean_category_id);
			if (!$categoryObj->userCanEditAndDelete()) {
				redirect_header($categoryObj->getItemLink(TRUE), 3, _NOPERM);
			}
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($downloads_category_handler);
			$controller->handleObjectDeletionFromUserSide();
			$icmsTpl->assign('downloads_cat_path', $downloads_category_handler->getBreadcrumbForPid($categoryObj->getVar('category_id', 'e'), 1) . ' > ' . _DELETE);
			break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
}
include_once 'footer.php';