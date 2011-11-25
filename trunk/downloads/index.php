<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /index.php
 * 
 * Frontend indexpage
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

function editcategory($category_id = 0) {
	global $downloads_category_handler, $icmsTpl, $downloadsConfig;
	
	if (!$categoryObj->isNew()){
		$categoryObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'category_updated', 'category_publisher', 'category_submitter', 'category_approve', 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar( 'category_updated_date', (time() - 100) );
		$categoryObj->setVar('category_updated', TRUE );
		$sform = $categoryObj->getSecureForm(_MD_DOWNLOADS_CATEGORY_EDIT, 'addcategory');
		$sform->assign($icmsTpl, 'downloads_category_form');
		$icmsTpl->assign('downloads_cat_path', $categoryObj->getVar('category_title') . ' > ' . _EDIT);
	} else {
		$categoryObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'category_updated', 'category_publisher', 'category_submitter', 'category_approve', 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar('category_published_date', (time() - 100) );
		if($downloadsConfig['category_needs_approve'] == 1) {
			$categoryObj->setVar('category_approve', FALSE );
		} else {
			$categoryObj->setVar('category_approve', TRUE );
		}
		$categoryObj->setVar('category_submitter', icms::$user->getVar("uid"));
		$categoryObj->setVar('category_publisher', icms::$user->getVar("uid"));
		$sform = $categoryObj->getSecureForm(_AM_DOWNLOADS_CATEGORY_CREATE, 'addcategory');
		$sform->assign($icmsTpl, 'downloads_category_form');
		$icmsTpl->assign('downloads_cat_path', _SUBMIT);
	}
} 
 
function editdownload($download_id = 0) {
	global $downloads_download_handler, $icmsTpl, $downloadsConfig;
	
	if (!$downloadObj->isNew()){
		$downloadObj->hideFieldFromForm(array('download_updated', 'download_broken','download_mirror_approve', 'meta_description', 'meta_keywords', 'download_updated', 'download_publisher', 'download_submitter', 'download_approve', 'download_published_date', 'download_updated_date' ) );
		$downloadObj->setVar( 'download_updated_date', (time() - 100) );
		$downloadObj->setVar('download_updated', TRUE );
		$sform = $downloadObj->getSecureForm(_MD_DOWNLOADS_DOWNLOAD_EDIT, 'adddownload');
		$sform->assign($icmsTpl, 'downloads_download_form');
		$icmsTpl->assign('downloads_cat_path', $downloadObj->getVar('download_title') . ' > ' . _EDIT);
	} else {
		$downloadObj->hideFieldFromForm(array('download_updated', 'download_broken','download_mirror_approve', 'meta_description', 'meta_keywords', 'download_updated', 'download_publisher', 'download_submitter', 'download_approve', 'download_published_date', 'download_updated_date' ) );
		$downloadObj->setVar('download_published_date', (time() - 100) );
		if($downloadsConfig['download_needs_approve'] == 1) {
			$downloadObj->setVar('download_approve', FALSE );
		} else {
			$downloadObj->setVar('download_approve', TRUE );
		}
		if($downloadsConfig['mirror_needs_approve'] == 1) {
			$downloadObj->setVar('download_mirror_approve', FALSE );
		} else {
			$downloadObj->setVar('download_mirror_approve', TRUE );
		}
		$downloadObj->setVar('download_submitter', icms::$user->getVar("uid"));
		$downloadObj->setVar('download_publisher', icms::$user->getVar("uid"));
		$sform = $downloadObj->getSecureForm(_MD_DOWNLOADS_DOWNLOAD_CREATE, 'adddownload');
		$sform->assign($icmsTpl, 'downloads_download_form');
		$icmsTpl->assign('downloads_cat_path', _SUBMIT);
	}
} 
 
include_once 'header.php';

$xoopsOption['template_main'] = 'downloads_index.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = $indexpageObj = $downloads_indexpage_handler = $indexpageObj = '';
$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$downloads_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'downloads' );

$indexpageObj = $downloads_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('downloads_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_start = $clean_op = $categoryObj = $downloads_category_handler = '';

$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_download_id = isset($_GET['download_id']) ? filter_input(INPUT_GET, 'download_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$downloads_category_handler = icms_getModuleHandler( 'category', icms::$module -> getVar( 'dirname' ), 'downloads' );
$downloads_download_handler = icms_getModuleHandler( 'download', icms::$module -> getVar( 'dirname' ), 'downloads' );

$clean_category_uid = isset($_GET['uid']) ? (int)$_GET['uid'] : false;
$clean_category_pid = isset($_GET['category_pid']) ? (int)$_GET['category_pid'] : ($clean_category_uid ? false : 0);

if ($clean_category_id != 0) {
	$categoryObj = $downloads_category_handler->get($clean_category_id);
}

if (isset($_GET['op'])) $clean_op = $_GET['op'];
if (isset($_POST['op'])) $clean_op = $_POST['op'];

/**
 * Get a whitelist of valid op's
 */
$valid_op = array ('mod', 'moddownload','addcategory', 'adddownload', 'del','deldownload', '');

/**
 * Only proceed if the supplied operation is a valid operation
 */
if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
			$categoryObj = $downloads_category_handler->get($clean_category_id);
			if ($clean_category_id > 0 && $categoryObj->isNew()) {
				redirect_header(DOWNLOADS_URL, 3, _NOPERM);
			}
			editcategory($categoryObj);
			break;
		
		case 'moddownload':
			$downloadObj = $downloads_download_handler->get($clean_download_id);
			if ($clean_download_id > 0 && $downloadObj->isNew()) {
				redirect_header(DOWNLOADS_URL, 3, _NOPERM);
			}
			editcategory($downloadObj);
			break;
			
		case 'addcategory':
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($downloads_category_handler);
			$controller->storeFromDefaultForm(_MD_DOWNLOADS_CATEGORY_CREATED, _MD_DOWNLOADS_CATEGORY_MODIFIED);
			break;
		
		case 'adddownload':
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($downloads_download_handler);
			$controller->storeFromDefaultForm(_MD_DOWNLOADS_DOWNLOAD_CREATED, _MD_DOWNLOADS_DOWNLOAD_MODIFIED);
			break;
		
		case 'del':
			if (!$categoryObj->userCanEditAndDelete()) {
				redirect_header($categoryObj->getItemLink(true), 3, _NOPERM);
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
		
		case 'deldownload':
			if (!$downloadObj->userCanEditAndDelete()) {
				redirect_header($categoryObj->getItemLink(true), 3, _NOPERM);
			}
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($downloads_download_handler);
			$controller->handleObjectDeletionFromUserSide();
			$icmsTpl->assign('downloads_cat_path', $downloads_download_handler->getBreadcrumbForPid($downloadObj->getVar('category_id', 'e'), 1) . ' > ' . _DELETE);
			break;
			
		default:
			if (is_object($categoryObj) && $categoryObj->accessGranted()) {
				$category = $categoryObj->toArray();
				$icmsTpl->assign('downloads_single_cat', $category);
				$downloads = $downloads_download_handler->getDownloads(0, icms::$module->config['show_downloads'], $clean_category_uid, false,  $clean_category_id);
				$icmsTpl->assign('downloads_files', $downloads);
				if ($downloadsConfig['show_breadcrumbs']){
					$icmsTpl->assign('downloads_cat_path', $downloads_category_handler->getBreadcrumbForPid($categoryObj->getVar('category_id', 'e'), 1));
				}else{
					$icmsTpl->assign('downloads_cat_path',false);
				}
			} elseif ($clean_category_id == 0) {
				$category = $downloads_category_handler->getCategories($clean_start, icms::$module->config['show_categories'], $clean_category_uid,  false, $clean_category_pid);
				$icmsTpl->assign('downloads_cat', $category);
			} else {
				redirect_header(DOWNLOADS_URL, 3, _NOPERM);
			}
			break;
	}
}


//$icms_metagen = new icms_ipf_Metagen($categoryObj->getVar('category_title'), $categoryObj->getVar('meta_keywords','n'), $categoryObj->getVar('meta_description', 'n'));
//$icms_metagen->createMetaTags();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$criteria = new icms_db_criteria_Compo();
$criteria->add(new icms_db_criteria_Item('category_active', true));
$criteria->add(new icms_db_criteria_Item('category_approve', true));
// adjust for tag, if present
$category_count = $downloads_category_handler->getCount($criteria);
unset($criteria);
$category_pagenav = new icms_view_PageNav($category_count, $downloadsConfig['show_categories'], $clean_start, 'start', false);

$criteria ='';
$criteria = new icms_db_criteria_Compo();
$criteria->add(new icms_db_criteria_Item('download_active', true));
$criteria->add(new icms_db_criteria_Item('download_approve', true));
// adjust for tag, if present
$file_count = $downloads_download_handler->getCount($criteria);
	
$download_pagenav = new icms_view_PageNav($file_count, $downloadsConfig['show_categories'], $clean_start, 'start', false);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// ASSIGN //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
	$icmsTpl->assign('downloads_show_breadcrumb', $downloadsConfig['show_breadcrumbs'] == true);
	$icmsTpl->assign('category_pagenav', $category_pagenav->renderNav());
	$icmsTpl->assign('download_pagenav', $download_pagenav->renderNav());

include_once 'footer.php';