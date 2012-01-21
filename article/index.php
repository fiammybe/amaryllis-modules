<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /index.php
 * 
 * index view for Article module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'article_index.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$article_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'article' );

$indexpageObj = $article_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('article_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_category_start = isset($_GET['cat_nav']) ? filter_input(INPUT_GET, 'cat_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_files_start = isset($_GET['file_nav']) ? filter_input(INPUT_GET, 'file_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_category_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : false;
$clean_category_pid = isset($_GET['category_pid']) ? filter_input(INPUT_GET, 'category_pid', FILTER_SANITIZE_NUMBER_INT) : ($clean_category_uid ? false : 0);

$article_category_handler = icms_getModuleHandler( 'category', icms::$module -> getVar( 'dirname' ), 'article' );
$article_article_handler = icms_getModuleHandler( 'article', icms::$module -> getVar( 'dirname' ), 'article' );

$valid_op = array ('getByTags', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if(in_array($clean_op, $valid_op)) {
	switch ($clean_op) {
		case 'getByTags':
			$clean_tag_id = isset($_GET['tag']) ? filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_NUMBER_INT) : 0;
			$article = $article_article_handler->getArticles($clean_files_start, icms::$module->config['show_article'], $clean_tag_id, FALSE, FALSE,  FALSE);
			$icmsTpl->assign('articles', $article);
			$icmsTpl->assign("byTags", TRUE);
			break;
		
		default:
			
			if ($clean_category_id != 0) {
				$categoryObj = $article_category_handler->get($clean_category_id);
			} else {
				$categoryObj = FALSE;
			}
			/**
			 * retrieve a single category including files of the category and subcategories
			 */
			if (is_object($categoryObj) && $categoryObj->accessGranted()) {
				$article_category_handler->updateCounter($clean_category_id);
				$category = $categoryObj->toArray();
				$icmsTpl->assign('article_single_cat', $category);
				$article = $article_article_handler->getArticles($clean_files_start, icms::$module->config['show_articles'], FALSE, FALSE, FALSE,  $clean_category_id);
				$icmsTpl->assign('article_files', $article);
				if ($articleConfig['show_breadcrumbs']){
					$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($categoryObj->getVar('category_id', 'e'), 1));
				}else{
					$icmsTpl->assign('article_cat_path',false);
				}
				if($article_category_handler->userCanSubmit()) {
					$icmsTpl->assign('user_submit', true);
					$icmsTpl->assign('user_submit_link', ARTICLE_URL . 'category.php?op=mod&category_id=' . $categoryObj->id());
				} else {
					$icmsTpl->assign('user_submit', false);
				}
				$categories = $article_category_handler->getArticleCategories($clean_category_start, $articleConfig['show_categories'], $clean_category_uid,  false, $clean_category_id, "weight", "ASC", TRUE, TRUE);
				$article_category_columns = array_chunk($categories, $articleConfig['show_category_columns']);
				$icmsTpl->assign('sub_category_columns', $article_category_columns);
			/**
			 * if there's no valid category, retrieve a list of all primary categories
			 */
			} elseif ($clean_category_id == 0) {
				$categories = $article_category_handler->getArticleCategories($clean_category_start, $articleConfig['show_categories'], $clean_category_uid,  false, $clean_category_pid, "weight", "ASC", TRUE, TRUE);
				$article_category_columns = array_chunk($categories, $articleConfig['show_category_columns']);
				$icmsTpl->assign('category_columns', $article_category_columns);
				
			/**
			 * if not valid single category or no permissions -> redirect to module home
			 */
			} else {
				redirect_header(ARTICLE_URL, 3, _NO_PERM);
			}
			
			/**
			 * check, if upload disclaimer is necessary and retrieve the link
			 */
			
			if($articleConfig['show_upl_disclaimer'] == 1) {
				$icmsTpl->assign('article_upl_disclaimer', true );
				$icmsTpl->assign('up_disclaimer', $articleConfig['upl_disclaimer']);
			} else {
				$icmsTpl->assign('article_upl_disclaimer', false);
			}
			/**
			 * check, if user can submit
			 */
				if($article_category_handler->userCanSubmit()) {
					$icmsTpl->assign('user_submit', true);
					$icmsTpl->assign('user_submit_link', ARTICLE_URL . 'category.php?op=mod&amp;category_id=' . $clean_category_id);
				} else {
					$icmsTpl->assign('user_submit', false);
				}
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
				$category_count = $article_category_handler->getCategoriesCount(TRUE, TRUE, $groups,'category_grpperm',FALSE,FALSE, $clean_category_id);
			
				if (!$clean_category_id == 0) {
					$extra_arg = 'category_id=' . $clean_category_id;
				} else {
					$extra_arg = false;
				}
				$category_pagenav = new icms_view_PageNav($category_count, $articleConfig['show_categories'], $clean_category_start, 'cat_nav', $extra_arg);
				$icmsTpl->assign('category_pagenav', $category_pagenav->renderImageNav());
			
			$files_count = $article_article_handler->getCountCriteria(true, true, $groups,'article_grpperm',false,false, $clean_category_id);
			
			$icmsTpl->assign('files_count', $files_count);
			if (!empty($clean_article_id)) {
				$extra_arg = 'article_id=' . $clean_article_id;
			} else {
				$extra_arg = false;
			}
			$article_pagenav = new icms_view_PageNav($files_count, $articleConfig['show_articles'], $clean_files_start, 'file_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderImageNav());
			break;
	}
	/**
	 * check, if rss feeds are enabled. if so, display link
	 */
	if($articleConfig['use_rss'] == 1) {
		$icmsTpl->assign("article_show_rss", TRUE);
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////// BREADCRUMB ////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		if( $articleConfig['show_breadcrumbs'] == true ) {
			$icmsTpl->assign('article_show_breadcrumb', true);
		} else {
			$icmsTpl->assign('article_show_breadcrumb', false);
		}
	include_once 'footer.php';
}
