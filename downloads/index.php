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

$clean_category_start = isset($_GET['cat_nav']) ? intval($_GET['cat_nav']) : 0;
$clean_files_start = isset($_GET['file_nav']) ? intval($_GET['file_nav']) : 0;
$clean_category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

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
/**
 * retrieve a single category including files of the category and subcategories
 */
if (is_object($categoryObj) && $categoryObj->accessGranted()) {
	$downloads_category_handler->updateCounter($clean_category_id);
	$category = $categoryObj->toArray();
	$icmsTpl->assign('downloads_single_cat', $category);
	$downloads = $downloads_download_handler->getDownloads($clean_files_start, icms::$module->config['show_downloads'], $clean_category_uid, false,  $clean_category_id);
	$icmsTpl->assign('downloads_files', $downloads);
	$directory_name = basename( dirname( __FILE__ ) );
	$script_name = getenv("SCRIPT_NAME");
	$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);
	foreach ($downloads as $download){
			$icmsTpl->assign("image_path",  $document_root . 'uploads/' . $directory_name . '/download/' . $download['download_img']);
	}
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
/**
 * if there's no valid category, retrieve a list of all primary categories
 */
} elseif ($clean_category_id == 0) {
	$categories = $downloads_category_handler->getCategories($clean_category_start, $downloadsConfig['show_categories'], $clean_category_uid,  false, $clean_category_pid, "weight", "ASC", TRUE, TRUE);
	$icmsTpl->assign('downloads_cat', $categories);
	$countcategories = $downloads_category_handler->getCategories(0, FALSE, $clean_category_uid, FALSE, $clean_category_pid, FALSE, FALSE, TRUE, TRUE );
	
/**
 * if not valid single category or no permissions -> redirect to module home
 */
} else {
	redirect_header(DOWNLOADS_URL, 3, _NOPERM);
}

/**
 * check, if upload disclaimer is necessary and retrieve the link
 */

if($downloadsConfig['downloads_show_upl_disclaimer'] == 1) {
	$icmsTpl->assign('downloads_upl_disclaimer', true );
	$icmsTpl->assign('up_disclaimer', $downloadsConfig['downloads_upl_disclaimer']);
} else {
	$icmsTpl->assign('downloads_upl_disclaimer', false);
}
/**
 * check, if user can submit
 */
	if($downloads_category_handler->userCanSubmit()) {
		$icmsTpl->assign('user_submit', true);
		$icmsTpl->assign('user_submit_link', DOWNLOADS_URL . 'category.php?op=mod&amp;category_id=' . $clean_category_id);
	} else {
		$icmsTpl->assign('user_submit', false);
	}
	
/**
 * force downloads.js to header
 */

$xoTheme->addScript('/modules/' . DOWNLOADS_DIRNAME . '/scripts/jquery.qtip.js', array('type' => 'text/javascript'));
$xoTheme->addStylesheet('/modules/' . DOWNLOADS_DIRNAME . '/scripts/jquery.qtip.css');
$xoTheme->addScript('/modules/' . DOWNLOADS_DIRNAME . '/scripts/downloads.js', array('type' => 'text/javascript'));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
$criteria = new icms_db_criteria_Compo();
$criteria->add(new icms_db_criteria_Item("category_pid", $clean_category_id));
$criteria->add(new icms_db_criteria_Item("category_approve", TRUE));
$criteria->add(new icms_db_criteria_Item("category_active", TRUE));
$categoryObjects = $downloads_category_handler->getObjects($criteria, TRUE, FALSE);

$category_count_crit = $downloads_category_handler->getCountCriteria(true, true, $groups,'category_grpperm',false,false, $clean_category_id);;
$category_count = $downloads_category_handler->getCount($criteria);
if (!empty($clean_category_id)) {
	$extra_arg = 'category_id=' . $clean_category_id;
} else {
	$extra_arg = false;
}
$category_pagenav = new icms_view_PageNav($category_count, $downloadsConfig['show_categories'], $clean_category_start, 'cat_nav', $extra_arg);
$icmsTpl->assign('category_pagenav', $category_pagenav->renderImageNav());

$files_count_criteria = $downloads_download_handler->getCountCriteria(true, true, $groups,'download_grpperm',false,false, $clean_category_id);
$files_count = $downloads_download_handler -> getCount($files_count_criteria, true, false);
$icmsTpl->assign('files_count', $files_count);
if (!empty($clean_download_id)) {
	$extra_arg = 'download_id=' . $clean_download_id;
} else {
	$extra_arg = false;
}
$download_pagenav = new icms_view_PageNav($files_count, $downloadsConfig['show_downloads'], $clean_files_start, 'file_nav', $extra_arg);
$icmsTpl->assign('download_pagenav', $download_pagenav->renderNav());
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// BREADCRUMB ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if( $downloadsConfig['show_breadcrumbs'] == true ) {
		$icmsTpl->assign('downloads_show_breadcrumb', true);
	} else {
		$icmsTpl->assign('downloads_show_breadcrumb', false);
	}

include_once 'footer.php';