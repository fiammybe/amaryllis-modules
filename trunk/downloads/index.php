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

$downloads_indexpage_handler = icms_getModuleHandler( "indexpage", DOWNLOADS_DIRNAME, "downloads");
$indexpageObj = $downloads_indexpage_handler->get(1);
$index = $indexpageObj->toArray();
$icmsTpl->assign('downloads_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_category_start = isset($_GET['cat_nav']) ? filter_input(INPUT_GET, 'cat_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_files_start = isset($_GET['file_nav']) ? filter_input(INPUT_GET, 'file_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_download_id = isset($_GET['download_id']) ? filter_input(INPUT_GET, 'download_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_category_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
$clean_category_pid = isset($_GET['category_pid']) ? filter_input(INPUT_GET, 'category_pid', FILTER_SANITIZE_NUMBER_INT) : ($clean_category_uid ? FALSE : 0);

$downloads_category_handler = icms_getModuleHandler("category", DOWNLOADS_DIRNAME, "downloads");
$downloads_download_handler = icms_getModuleHandler("download", DOWNLOADS_DIRNAME, "downloads");

$valid_op = array ('getByTags', 'viewRecentDownloads', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if(in_array($clean_op, $valid_op)) {
	switch ($clean_op) {
		case 'getByTags':
			$clean_tag_id = isset($_GET['tag']) ? filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_NUMBER_INT) : 0;
			$downloads = $downloads_download_handler->getDownloads($clean_files_start, icms::$module->config['show_downloads'], $clean_tag_id, FALSE, FALSE,  FALSE);
			$icmsTpl->assign('downloads_files', $downloads);
			$icmsTpl->assign("byTags", TRUE);
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$files_count = $downloads_download_handler->getCountCriteria(TRUE, TRUE, $groups,'download_grpperm',FALSE,FALSE, $clean_category_id, $clean_tag_id);
			if (!empty($clean_tag_id)) {
				$extra_arg = 'op=getByTags&tag_id=' . $clean_tag_id;
			} else {
				$extra_arg = FALSE;
			}
			$download_pagenav = new icms_view_PageNav($files_count, $downloadsConfig['show_downloads'], $clean_files_start, 'file_nav', $extra_arg);
			$icmsTpl->assign('download_pagenav', $download_pagenav->renderNav());
			break;
		
		case 'viewRecentDownloads':
			$downloads = $downloads_download_handler->getDownloads($clean_files_start, icms::$module->config['show_downloads'], FALSE, FALSE, FALSE,  $clean_category_id);
			$icmsTpl->assign('downloads', $downloads);
			$icmsTpl->assign("byRecentDownloads", TRUE);
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$count = $downloads_download_handler->getCountCriteria(TRUE, TRUE, $groups,'download_grpperm',FALSE,FALSE, $clean_category_id);
			if (!empty($clean_category_id)) {
				$extra_arg = 'op=viewRecentDownloads&category_id=' . $clean_category_id;
			} else {
				$extra_arg = 'op=viewRecentDownloads';
			}
			$download_pagenav = new icms_view_PageNav($count, $downloadsConfig['show_downloads'], $clean_files_start, 'file_nav', $extra_arg);
			$icmsTpl->assign('download_pagenav', $download_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($downloadsConfig['show_breadcrumbs'] == TRUE) {
				$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(__FILE__)), 'downloads');
				$icmsTpl->assign('downloads_show_breadcrumb', TRUE);
				$icmsTpl->assign('downloads_cat_path', $downloads_category_handler->getBreadcrumbForPid($clean_category_id, 1));
			} else {
				$icmsTpl->assign('downloads_cat_path', FALSE);
			}
			break;
		
		default:
			if ($clean_category_id != 0) {
				$categoryObj = $downloads_category_handler->get($clean_category_id);
			} else {
				$categoryObj = FALSE;
			}
			/**
			 * retrieve a single category including files of the category and subcategories
			 */
			if (is_object($categoryObj) && $categoryObj->accessGranted() && !$categoryObj->isNew()) {
				$downloads_category_handler->updateCounter($clean_category_id);
				$category = $categoryObj->toArray();
				$icmsTpl->assign('downloads_single_cat', $category);
				$downloads = $downloads_download_handler->getDownloads($clean_files_start, icms::$module->config['show_downloads'], FALSE, FALSE, FALSE,  $clean_category_id);
				$icmsTpl->assign('downloads_files', $downloads);
				if ($downloadsConfig['show_breadcrumbs']){
					$icmsTpl->assign('downloads_cat_path', $downloads_category_handler->getBreadcrumbForPid($categoryObj->getVar('category_id', 'e'), 1));
				}else{
					$icmsTpl->assign('downloads_cat_path',FALSE);
				}
				if($downloads_category_handler->userCanSubmit()) {
					$icmsTpl->assign('user_submit', TRUE);
					$icmsTpl->assign('user_submit_link', DOWNLOADS_URL . 'category.php?op=mod&category_id=' . $categoryObj->id());
				} else {
					$icmsTpl->assign('user_submit', FALSE);
				}
				$categories = $downloads_category_handler->getDownloadCategories($clean_category_start, $downloadsConfig['show_categories'], $clean_category_uid,  FALSE, $clean_category_id, "weight", "ASC", TRUE, TRUE);
				$downloads_category_columns = array_chunk($categories, $downloadsConfig['show_category_columns']);
				$icmsTpl->assign('sub_category_columns', $downloads_category_columns);
				/**
				 * pagination for categories
				 */
				$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
				$category_count = $downloads_category_handler->getCategoriesCount(TRUE, TRUE, $groups,'category_grpperm',FALSE,FALSE, $clean_category_id);
				if ((!$clean_category_id == 0) && ($clean_files_start == 0)) {
					$extra_arg = 'category_id=' . $clean_category_id;
				} elseif((!$clean_category_id == 0) && (!$clean_files_start == 0)) {
					$extra_arg = 'category_id=' . $clean_category_id . '&file_nav=' . $clean_files_start;
				}
				$category_pagenav = new icms_view_PageNav($category_count, $downloadsConfig['show_categories'], $clean_category_start, 'cat_nav', $extra_arg);
				$icmsTpl->assign('category_pagenav', $category_pagenav->renderNav());
				/**
				 * pagination for files
				 */
				$files_count = $downloads_download_handler->getCountCriteria(TRUE, TRUE, $groups,'download_grpperm',FALSE,FALSE, $clean_category_id);
				if ((!$clean_category_id == 0) && ($clean_category_start == 0)) {
					$extra_arg = 'category_id=' . $clean_category_id;
				} elseif((!$clean_category_id == 0) && (!$clean_category_start == 0)) {
					$extra_arg = 'category_id=' . $clean_category_id . '&cat_nav=' . $clean_category_start;
				}
				$download_pagenav = new icms_view_PageNav($files_count, $downloadsConfig['show_downloads'], $clean_files_start, 'file_nav', $extra_arg);
				$icmsTpl->assign('download_pagenav', $download_pagenav->renderNav());
				break;
			/**
			 * if there's no valid category, retrieve a list of all primary categories
			 */
			} elseif ($clean_category_id == 0) {
				$categories = $downloads_category_handler->getDownloadCategories($clean_category_start, $downloadsConfig['show_categories'], $clean_category_uid,  FALSE, $clean_category_pid, "weight", "ASC", TRUE, TRUE);
				$downloads_category_columns = array_chunk($categories, $downloadsConfig['show_category_columns']);
				$icmsTpl->assign('category_columns', $downloads_category_columns);
				/**
				 * pagination
				 */
				$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
				$category_count = $downloads_category_handler->getCategoriesCount(TRUE, TRUE, $groups,'category_grpperm',FALSE,FALSE, $clean_category_id);
				$category_pagenav = new icms_view_PageNav($category_count, $downloadsConfig['show_categories'], $clean_category_start, 'cat_nav', FALSE);
				$icmsTpl->assign('category_pagenav', $category_pagenav->renderNav());
			/**
			 * if not valid single category or no permissions -> redirect to module home
			 */
			} else {
				redirect_header(DOWNLOADS_URL, 3, _NO_PERM);
			}
			
			/**
			 * check, if upload disclaimer is necessary and retrieve the link
			 */
			
			if($downloadsConfig['downloads_show_upl_disclaimer'] == 1) {
				$icmsTpl->assign('downloads_upl_disclaimer', TRUE );
				$icmsTpl->assign('up_disclaimer', $downloadsConfig['downloads_upl_disclaimer']);
			} else {
				$icmsTpl->assign('downloads_upl_disclaimer', FALSE);
			}
			/**
			 * check, if user can submit
			 */
				if($downloads_category_handler->userCanSubmit()) {
					$icmsTpl->assign('user_submit', TRUE);
					$icmsTpl->assign('user_submit_link', DOWNLOADS_URL . 'category.php?op=mod&amp;category_id=' . $clean_category_id);
				} else {
					$icmsTpl->assign('user_submit', FALSE);
				}
			break;
	}
	include_once 'footer.php';
}