<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /index.php
 * 
 * index view for Article module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
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

$article_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'article' );
$indexpageObj = $article_indexpage_handler->get(1);
$index = $indexpageObj->toArray();
$icmsTpl->assign('article_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_category_start = isset($_GET['cat_nav']) ? filter_input(INPUT_GET, 'cat_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_article_start = isset($_GET['article_nav']) ? filter_input(INPUT_GET, 'article_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_category_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
$clean_category_pid = isset($_GET['category_pid']) ? filter_input(INPUT_GET, 'category_pid', FILTER_SANITIZE_NUMBER_INT) : ($clean_category_uid ? FALSE : 0);

$article_category_handler = icms_getModuleHandler( 'category', ARTICLE_DIRNAME, 'article' );
$article_article_handler = icms_getModuleHandler( 'article', ARTICLE_DIRNAME, 'article' );

$valid_op = array ('getByTags', 'getMostPopular', 'viewRecentUpdated', 'viewRecentArticles', 'getByAuthor', 'getMostCommented', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if(in_array($clean_op, $valid_op)) {
	switch ($clean_op) {
		case 'getByTags':
			$clean_tag_id = isset($_GET['tag']) ? filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_NUMBER_INT) : 0;
			$article = $article_article_handler->getArticles($clean_article_start, icms::$module->config['show_articles'], $clean_tag_id, FALSE, FALSE,  FALSE);
			$icmsTpl->assign('articles', $article);
			$icmsTpl->assign("byTags", TRUE);
			$sprocketsModule = icms_getModuleInfo("sprockets");
			if(icms_get_module_status("sprockets")) {
				$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname"), "sprockets");
				$tag = $sprockets_tag_handler->get($clean_tag_id);
				$icmsTpl->assign("article_tag", $tag->getVar("title"));
			}
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, $clean_category_id, $clean_tag_id);
			/**
			 * pagination
			 */
			if (!empty($clean_tag_id)) {
				$extra_arg = 'op=getByTags&tag=' . $clean_tag_id;
			} else {
				$extra_arg = FALSE;
			}
			$article_pagenav = new icms_view_PageNav($count, $articleConfig['show_articles'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			break;
			
		case 'getMostPopular':
			$articles = $article_article_handler->getArticles($clean_article_start, $articleConfig['show_articles'], FALSE, FALSE, FALSE,  $clean_category_id, "counter", "DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("byPopular", TRUE);
			$count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, $clean_category_id);
			if (!empty($clean_category_id)) {
				$extra_arg = 'op=getMostPopular&category_id=' . $clean_category_id;
			} else {
				$extra_arg = 'op=getMostPopular';
			}
			$article_pagenav = new icms_view_PageNav($count, $articleConfig['show_articles'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($articleConfig['show_breadcrumbs'] == TRUE) {
				$article_category_handler = icms_getModuleHandler('category', basename(dirname(__FILE__)), 'article');
				$icmsTpl->assign('article_show_breadcrumb', TRUE);
				$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($clean_category_id, 1));
			} else {
				$icmsTpl->assign('article_cat_path', FALSE);
			}
			break;
		
		case 'viewRecentUpdated':
			$article = $article_article_handler->getArticles($clean_article_start, $articleConfig['show_articles'], FALSE, FALSE, FALSE,  $clean_category_id, "article_updated_date", "DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("byRecentUpdated", TRUE);
			$count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, $clean_category_id);
			if (!empty($clean_category_id)) {
				$extra_arg = 'op=viewRecentUpdated&category_id=' . $clean_category_id;
			} else {
				$extra_arg = 'op=viewRecentUpdated';
			}
			$article_pagenav = new icms_view_PageNav($count, $articleConfig['show_articles'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($articleConfig['show_breadcrumbs'] == TRUE) {
				$article_category_handler = icms_getModuleHandler('category', basename(dirname(__FILE__)), 'article');
				$icmsTpl->assign('article_show_breadcrumb', TRUE);
				$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($clean_category_id, 1));
			} else {
				$icmsTpl->assign('article_cat_path', FALSE);
			}
			break;
		
		case 'viewRecentArticles':
			$articles = $article_article_handler->getArticles($clean_article_start, $articleConfig['show_articles'], FALSE, FALSE, FALSE,  $clean_category_id, "article_published_date", "DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("byRecentArticles", TRUE);
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, $clean_category_id);
			if (!empty($clean_category_id)) {
				$extra_arg = 'op=viewRecentArticles&category_id=' . $clean_category_id;
			} else {
				$extra_arg = 'op=viewRecentArticles';
			}
			$article_pagenav = new icms_view_PageNav($count, $articleConfig['show_articles'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($articleConfig['show_breadcrumbs'] == TRUE) {
				$article_category_handler = icms_getModuleHandler('category', basename(dirname(__FILE__)), 'article');
				$icmsTpl->assign('article_show_breadcrumb', TRUE);
				$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($clean_category_id, 1));
			} else {
				$icmsTpl->assign('article_cat_path', FALSE);
			}
			break;
		
		case 'getByAuthor':
			$articles = $article_article_handler->getArticles($clean_article_start, $articleConfig['show_articles'], FALSE, $clean_uid, FALSE, FALSE, "article_published_date", "DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("byAuthor", TRUE);
			$icmsTpl->assign("article_user", icms_member_user_Handler::getUserLink($clean_uid));
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, $clean_category_id);
			if (!empty($clean_category_id)) {
				$extra_arg = 'op=getByAuthor&category_id=' . $clean_category_id;
			} else {
				$extra_arg = 'op=getByAuthor';
			}
			$article_pagenav = new icms_view_PageNav($count, $articleConfig['show_articles'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			break;
		
		case 'getMostCommented':
			$articles = $article_article_handler->getArticles($clean_article_start, $articleConfig['show_articles'], FALSE, FALSE, FALSE,  $clean_category_id, "article_comments", "DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("getMostCommented", TRUE);
			$count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, $clean_category_id);
			if (!empty($clean_category_id)) {
				$extra_arg = 'op=getMostCommented&category_id=' . $clean_category_id;
			} else {
				$extra_arg = 'op=getMostCommented';
			}
			$article_pagenav = new icms_view_PageNav($count, $articleConfig['show_articles'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($articleConfig['show_breadcrumbs'] == TRUE) {
				$article_category_handler = icms_getModuleHandler('category', basename(dirname(__FILE__)), 'article');
				$icmsTpl->assign('article_show_breadcrumb', TRUE);
				$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($clean_category_id, 1));
			} else {
				$icmsTpl->assign('article_cat_path', FALSE);
			}
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
				$article = $article_article_handler->getArticles($clean_article_start, $articleConfig['show_articles'], FALSE, FALSE, FALSE,  $clean_category_id);
				$icmsTpl->assign('article_files', $article);
				if ($articleConfig['show_breadcrumbs']){
					$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($categoryObj->getVar('category_id', 'e'), 1));
				}else{
					$icmsTpl->assign('article_cat_path',FALSE);
				}
				if($article_category_handler->userCanSubmit()) {
					$icmsTpl->assign('user_submit', TRUE);
					$icmsTpl->assign('user_submit_link', ARTICLE_URL . 'category.php?op=mod&category_id=' . $categoryObj->id());
				} else {
					$icmsTpl->assign('user_submit', FALSE);
				}
				$categories = $article_category_handler->getArticleCategories($clean_category_start, $articleConfig['show_categories'], $clean_category_uid,  FALSE, $clean_category_id, "weight", "ASC", TRUE, TRUE);
				$article_category_columns = array_chunk($categories, $articleConfig['show_category_columns']);
				$icmsTpl->assign('sub_category_columns', $article_category_columns);
				/**
				 * check pagination
				 */
				$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
				$files_count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, $clean_category_id);
				if (!empty($clean_category_id) && !empty($clean_category_start)) {
					$extra_arg = 'category_id=' . $clean_category_id . '&cat_nav=' . $clean_category_start;
				} elseif (!empty($clean_category_id) && empty($clean_category_start)) {
					$extra_arg = 'category_id=' . $clean_category_id;
				} else {
					$extra_arg = FALSE;
				}
				$article_pagenav = new icms_view_PageNav($files_count, $articleConfig['show_articles'], $clean_article_start, 'article_nav', $extra_arg);
				$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
				
				
			/**
			 * if there's no valid category, retrieve a list of all primary categories
			 */
			} elseif ($clean_category_id == 0) {
				$categories = $article_category_handler->getArticleCategories($clean_category_start, $articleConfig['show_categories'], $clean_category_uid,  FALSE, $clean_category_pid, "weight", "ASC", TRUE, TRUE);
				$article_category_columns = array_chunk($categories, $articleConfig['show_category_columns']);
				$icmsTpl->assign('category_columns', $article_category_columns);
				/**
				 * pagination control
				 */
				$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
				$category_count = $article_category_handler->getCategoriesCount(TRUE, TRUE, $groups,'category_grpperm',FALSE,FALSE, $clean_category_id);
				$category_pagenav = new icms_view_PageNav($category_count, $articleConfig['show_categories'], $clean_category_start, 'cat_nav', FALSE);
				$icmsTpl->assign('category_pagenav', $category_pagenav->renderNav());
				
			/**
			 * if not valid single category or no permissions -> redirect to module home
			 */
			} else {
				redirect_header(ARTICLE_URL, 3, _NOPERM);
			}
			
			/**
			 * check, if upload disclaimer is necessary and retrieve the link
			 */
			
			if($articleConfig['show_upl_disclaimer'] == 1) {
				$icmsTpl->assign('article_upl_disclaimer', TRUE );
				$icmsTpl->assign('up_disclaimer', $articleConfig['upl_disclaimer']);
			} else {
				$icmsTpl->assign('article_upl_disclaimer', FALSE);
			}
			/**
			 * check, if user can submit
			 */
			if($article_category_handler->userCanSubmit()) {
				$icmsTpl->assign('user_submit', TRUE);
				$icmsTpl->assign('user_submit_link', ARTICLE_URL . 'category.php?op=mod&amp;category_id=' . $clean_category_id);
			} else {
				$icmsTpl->assign('user_submit', FALSE);
			}
			break;
	}
	include_once 'footer.php';
}
