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
 
include_once 'header.php';

$xoopsOption['template_main'] = 'downloads_index.html';

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

$clean_download_id = isset($_GET['download_id']) ? filter_input(INPUT_GET, 'download_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_category_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : false;
$clean_category_pid = isset($_GET['category_pid']) ? filter_input(INPUT_GET, 'category_pid', FILTER_SANITIZE_NUMBER_INT) : ($clean_category_uid ? false : 0);

$downloads_category_handler = icms_getModuleHandler( 'category', icms::$module -> getVar( 'dirname' ), 'downloads' );
$downloads_download_handler = icms_getModuleHandler( 'download', icms::$module -> getVar( 'dirname' ), 'downloads' );

if ($clean_category_id != 0) {
	$categoryObj = $downloads_category_handler->get($clean_category_id);
} else {
	$categoryObj = false;
}
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
	if($downloads_category_handler->userCanSubmit()) {
		$icmsTpl->assign('user_submit', true);
		$icmsTpl->assign('user_submit_link', DOWNLOADS_URL . 'category.php?op=mod&category_id=' . $categoryObj->id());
	} else {
		$icmsTpl->assign('user_submit', false);
	}
	
} elseif ($clean_category_id == 0) {
	$categories = $downloads_category_handler->getCategories($clean_start, icms::$module->config['show_categories'], $clean_category_uid,  false, $clean_category_pid);
	$icmsTpl->assign('downloads_cat', $categories);
} else {
	redirect_header(DOWNLOADS_URL, 3, _NOPERM);
}
if($downloadsConfig['downloads_show_upl_disclaimer'] == 1) {
	$icmsTpl->assign('downloads_upl_disclaimer', true );
	$icmsTpl->assign('up_disclaimer', $downloadsConfig['downloads_upl_disclaimer']);
} else {
	$icmsTpl->assign('downloads_upl_disclaimer', false);
}

	if($downloads_category_handler->userCanSubmit()) {
		$icmsTpl->assign('user_submit', true);
		$icmsTpl->assign('user_submit_link', DOWNLOADS_URL . 'category.php?op=mod&category_id=' . $clean_category_id);
	} else {
		$icmsTpl->assign('user_submit', false);
	}
	
	

$xoTheme->addScript('/modules/' . DOWNLOADS_DIRNAME . '/scripts/downloads.js', array('type' => 'text/javascript'));


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


$files_count_criteria = $downloads_download_handler->getCountCriteria(true, true, $groups = array(), $perm = 'download_grpperm', $download_publisher = false, $download_id = false, $clean_category_id);
$files_count = $downloads_download_handler -> getCount($files_count_criteria, true, false);
$icmsTpl->assign('files_count', $files_count);
$download_pagenav = new icms_view_PageNav($files_count, $downloadsConfig['show_downloads'], $clean_start, 'start', false);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// ASSIGN //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if( $downloadsConfig['show_breadcrumbs'] == true ) {
		$icmsTpl->assign('downloads_show_breadcrumb', true);
	} else {
		$icmsTpl->assign('downloads_show_breadcrumb', false);
	}
	$icmsTpl->assign('category_pagenav', $category_pagenav->renderNav());
	$icmsTpl->assign('download_pagenav', $download_pagenav->renderNav());

include_once 'footer.php';