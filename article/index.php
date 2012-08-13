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
 * @version		$Id: index.php 678 2012-07-05 23:07:23Z st.flohrer $
 * @package		article
 *
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'article_index.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$indexpage_handler = icms_getModuleHandler( 'indexpage', INDEX_DIRNAME, 'index' );
$indexpageObj = $indexpage_handler->getIndexByMid(icms::$module->getVar("mid", "e"));
$icmsTpl->assign('index_index', $indexpageObj->toArray());

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_cat_nav = isset($_GET['cat_nav']) ? filter_input(INPUT_GET, 'cat_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_article_start = isset($_GET['article_nav']) ? filter_input(INPUT_GET, 'article_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_tag_seo = isset($_GET['tag']) ? filter_input(INPUT_GET, "tag") : FALSE;
$clean_tag = "";
if(!$clean_tag_seo) $clean_tag = isset($_GET['tag_id']) ? filter_input(INPUT_GET, 'tag_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_cat_seo = isset($_GET['cat']) ? filter_input(INPUT_GET, "cat") : FALSE;
$clean_cat_id = "";
if(!$clean_cat_seo) $clean_cat_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$article_handler = icms_getModuleHandler( 'article', ARTICLE_DIRNAME, 'article' );

$valid_op = array ('getByTag', 'getMostPopular', 'viewRecentUpdated', 'viewRecentArticles', 'getByAuthor', 'getMostCommented', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

$form = new icms_form_Simple("", "opform", "index.php", "get");
$select = new icms_form_elements_Select("", "op", $clean_op);
$select->setExtra('onchange="document.forms.opform.submit()"');
$select->addOption("", "-------------------------");
$select->addOption("viewRecentArticles", _MD_ARTICLE_GET_RECENT_CREATED);
$select->addOption("viewRecentUpdated", _MD_ARTICLE_GET_RECENT_UPDATED);
$select->addOption("getMostPopular", _MD_ARTICLE_GET_POPULAR);
$select->addOption("getMostCommented", _MD_ARTICLE_GET_COMMENTED);
$form->addElement($select);
$icmsTpl->assign("op_select_form", $form->render());

if(in_array($clean_op, $valid_op)) {
	switch ($clean_op) {
		case 'getByTag':
			icms_loadLanguageFile("index", "main");
			$xoTheme->addStylesheet('/modules/' . INDEX_DIRNAME . '/scripts/module_index.css');
			$tag_handler = icms_getModuleHandler("tag", INDEX_DIRNAME, "index");
			$tagObj = ($clean_tag_seo != FALSE) ? $tag_handler->getTagBySeo($clean_tag_seo) : FALSE; 
			if(!$tagObj) $tagObj = ($clean_tag != 0) ? $category_handler->get($clean_tag) : FALSE;
			if(!$tagObj || !$tagObj->accessGranted()) redirect_header(ARTICLE_URL);
			
			$link_handler = icms_getModuleHandler("link", INDEX_DIRNAME, "index");
			$links = $link_handler->getLinks($tagObj->id(), 1, icms::$module->getVar("mid"),$article_handler->_itemname, FALSE);
			
			$tag_title = $tagObj->title();
			
			$icmsTpl->assign('articles', $links);
			$icmsTpl->assign("byTags", TRUE);
			$icmsTpl->assign("article_tag", $tag_title);
			
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$count = $article_handler->getArticlesCount(TRUE, TRUE, $groups,'article_grpperm',FALSE,FALSE, FALSE, $tagObj->id());
			// pagination
			if (!empty($clean_tag) && !empty($clean_article_start)) {
				$extra_arg = 'tag_id=' . $clean_tag . '&article_nav=' . $clean_article_start;
			} elseif ($clean_tag_seo && !empty($clean_article_start)) {
				$extra_arg = 'tag=' . $clean_tag_seo . '&article_nav=' . $clean_article_start;
			} elseif (!empty($clean_tag) && empty($clean_article_start)) {
				$extra_arg = 'tag_id=' . $clean_tag;
			} elseif ($clean_tag_seo && empty($clean_article_start)) {
				$extra_arg = 'tag=' . $clean_tag_seo;
			} else {
				$extra_arg = FALSE;
			}
			$article_pagenav = new icms_view_PageNav($count, $indexConfig['show_items'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			break;
			
		case 'getMostPopular':
			$articles = $article_handler->getArticles(TRUE, TRUE, $clean_uid, $clean_article_id, FALSE, $clean_tag, FALSE, TRUE, $clean_article_start, $indexConfig['show_items'], "counter", "DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("byPopular", TRUE);
			$count = $article_handler->getArticlesCount(TRUE, TRUE, $clean_uid, $clean_article_id, FALSE, $clean_tag, FALSE, TRUE, $clean_article_start, $indexConfig['show_items'], "counter", "DESC");
			if (!empty($clean_cat_id)) {
				$extra_arg = 'op=getMostPopular&category_id=' . $clean_cat_id;
			} else {
				$extra_arg = 'op=getMostPopular';
			}
			$article_pagenav = new icms_view_PageNav($count, $indexConfig['show_items'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($indexConfig['show_breadcrumbs'] == TRUE) {
				$category_handler = icms_getModuleHandler( 'category', INDEX_DIRNAME, 'index' );
				$icmsTpl->assign('article_show_breadcrumb', TRUE);
				$icmsTpl->assign('article_cat_path', $category_handler->getBreadcrumbForPid($clean_cat_id, 1));
			} else {
				$icmsTpl->assign('article_cat_path', FALSE);
			}
			break;
		
		case 'viewRecentUpdated':
			$article = $article_handler->getArticles(TRUE, TRUE, $clean_uid, $clean_article_id, FALSE, $clean_tag, FALSE, FALSE, $clean_article_start, $indexConfig['show_items'], "article_updated_date", "DESC");
			$icmsTpl->assign('articles', $article);
			$icmsTpl->assign("byRecentUpdated", TRUE);
			$count = $article_handler->getArticlesCount(TRUE,TRUE,$clean_uid,$clean_article_id, FALSE, $clean_tag, FALSE, FALSE, $clean_article_start, $indexConfig['show_items'], "article_updated_date","DESC");
			if (!empty($clean_cat_id)) {
				$extra_arg = 'op=viewRecentUpdated&category_id=' . $clean_cat_id;
			} else {
				$extra_arg = 'op=viewRecentUpdated';
			}
			$article_pagenav = new icms_view_PageNav($count, $indexConfig['show_items'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			
			break;
		
		case 'viewRecentArticles':
			$articles = $article_handler->getArticles(TRUE, TRUE, $clean_uid, $clean_article_id, FALSE, $clean_tag, FALSE, FALSE, $clean_article_start, $indexConfig['show_items'], "article_published_date","DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("byRecentArticles", TRUE);
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$count = $article_handler->getArticlesCount(TRUE, TRUE, $clean_uid, $clean_article_id, FALSE, $clean_tag, FALSE, FALSE,$clean_article_start,$indexConfig['show_items'],"article_published_date","DESC");
			if (!empty($clean_cat_id)) {
				$extra_arg = 'op=viewRecentArticles&category_id=' . $clean_cat_id;
			} else {
				$extra_arg = 'op=viewRecentArticles';
			}
			$article_pagenav = new icms_view_PageNav($count, $indexConfig['show_items'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($indexConfig['show_breadcrumbs'] == TRUE) {
				$category_handler = icms_getModuleHandler( 'category', INDEX_DIRNAME, 'index' );
				$icmsTpl->assign('article_show_breadcrumb', TRUE);
				//$icmsTpl->assign('article_cat_path', $category_handler->getBreadcrumbForPid($clean_cat_id, 1));
			} else {
				$icmsTpl->assign('article_cat_path', FALSE);
			}
			break;
		
		case 'getByAuthor':
			$articles = $article_handler->getArticles(TRUE,TRUE,$clean_uid,$clean_article_id,FALSE,$clean_tag,FALSE,FALSE,$clean_article_start,$indexConfig['show_items'],"article_published_date","DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("byAuthor", TRUE);
			$icmsTpl->assign("article_user", icms_member_user_Handler::getUserLink($clean_uid));
			$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
			$count = $article_handler->getArticlesCount(TRUE,TRUE,$clean_uid,$clean_article_id,FALSE,$clean_tag,FALSE,FALSE,$clean_article_start,$indexConfig['show_items'],"article_published_date","DESC");
			if (!empty($clean_cat_id)) {
				$extra_arg = 'op=getByAuthor&category_id=' . $clean_cat_id;
			} else {
				$extra_arg = 'op=getByAuthor';
			}
			$article_pagenav = new icms_view_PageNav($count, $indexConfig['show_items'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			break;
		
		case 'getMostCommented':
			$articles = $article_handler->getArticles(TRUE, TRUE, $clean_uid, $clean_article_id,FALSE,$clean_tag,FALSE,FALSE,$clean_article_start,$indexConfig['show_items'],"article_comments","DESC");
			$icmsTpl->assign('articles', $articles);
			$icmsTpl->assign("getMostCommented", TRUE);
			$count = $article_handler->getArticlesCount(TRUE, TRUE, $clean_uid, $clean_article_id,FALSE,$clean_tag,FALSE,FALSE,$clean_article_start,$indexConfig['show_items'],"article_comments","DESC");
			if (!empty($clean_cat_id)) {
				$extra_arg = 'op=getMostCommented&category_id=' . $clean_cat_id;
			} else {
				$extra_arg = 'op=getMostCommented';
			}
			$article_pagenav = new icms_view_PageNav($count, $indexConfig['show_items'], $clean_article_start, 'article_nav', $extra_arg);
			$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
			/**
			 * assign breadcrumb cat-path
			 */
			if ($indexConfig['show_breadcrumbs'] == TRUE) {
				$category_handler = icms_getModuleHandler( 'category', INDEX_DIRNAME, 'index' );
				$icmsTpl->assign('article_show_breadcrumb', TRUE);
				//$icmsTpl->assign('article_cat_path', $category_handler->getBreadcrumbForPid($clean_cat_id, 1));
			} else {
				$icmsTpl->assign('article_cat_path', FALSE);
			}
			break;
		
		default:
			$category_handler = icms_getModuleHandler( 'category', INDEX_DIRNAME, 'index' );
			$catObj = ($clean_cat_seo != FALSE) ? $category_handler->getCatBySeo($clean_cat_seo) : FALSE; 
			if(!$catObj) $catObj = ($clean_cat_id != 0) ? $category_handler->get($clean_cat_id) : FALSE;
			/**
			 * retrieve a single category including files of the category and subcategories
			 */
			if (is_object($catObj) && !$catObj->isNew() && $catObj->accessGranted()) {
				//update hit counter
				$category_handler->updateCounter($catObj->id());
				// assign category vars to template
				$category = $catObj->toArray();
				$icmsTpl->assign('article_single_cat', $category);
				// get articles assigned to the categories
				$articles = $article_handler->getArticles(TRUE, TRUE, FALSE, FALSE, $catObj->id(), FALSE, FALSE, FALSE,	$clean_article_start, $indexConfig['show_items'], 'weight', 'ASC', FALSE, FALSE);
				$icmsTpl->assign('article_files', $articles);
				// get Breadcrumb
				if ($indexConfig['show_breadcrumbs'] == 1){
					$icmsTpl->assign('index_cat_path', $category_handler->getBreadcrumbForPid($catObj->id()));
				}
				// check, if user can submit to provide submit links
				($category_handler->userCanSubmit()) ? $icmsTpl->assign('submit_link', INDEX_URL . 'category.php?op=mod&amp;category_id=' . $clean_cat_id) : $icmsTpl->assign('submit_link', FALSE);
				// get sub categories 
				$categories = $category_handler->getCategories(FALSE, TRUE, TRUE, $clean_cat_nav, $indexConfig['show_categories'], "weight", "ASC", $catObj->id(), FALSE, FALSE);
				$article_category_columns = array_chunk($categories, $indexConfig['show_category_columns']);
				$icmsTpl->assign('sub_category_columns', $article_category_columns);
				/**
				 * check pagination
				 */
				$files_count = $article_handler->getArticlesCount(TRUE, TRUE, FALSE, FALSE, $catObj->id(), FALSE, FALSE, FALSE,	$clean_article_start, $indexConfig['show_items'],
																	 'weight', 'ASC', FALSE, FALSE);
				if (!empty($clean_cat_id) && !empty($clean_cat_nav)) {
					$extra_arg = 'category_id=' . $clean_cat_id . '&cat_nav=' . $clean_cat_nav;
				} elseif ($clean_cat_seo && !empty($clean_cat_nav)) {
					$extra_arg = 'cat=' . $clean_cat_seo . '&cat_nav=' . $clean_cat_nav;
				} elseif (!empty($clean_cat_id) && empty($clean_cat_nav)) {
					$extra_arg = 'category_id=' . $clean_cat_id;
				} elseif ($clean_cat_seo && empty($clean_cat_nav)) {
					$extra_arg = 'cat=' . $clean_cat_seo;
				} else {
					$extra_arg = FALSE;
				}
				$article_pagenav = new icms_view_PageNav($files_count, $indexConfig['show_items'], $clean_article_start, 'article_nav', $extra_arg);
				$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
				
			//if there's no valid category, retrieve a list of all primary categories
			} elseif (!$clean_cat_seo && $clean_cat_id == 0) {
				// fetch categories assigned to this item
				$link_handler = icms_getModuleHandler("link", INDEX_DIRNAME, "index");
				$criteria = $link_handler->getLinkCriterias(FALSE, 1, icms::$module->getVar("mid"), $article_handler->_itemname, FALSE);
				$criteria2 = new icms_db_criteria_Compo();
				$sql = "SELECT DISTINCT (link_cid) FROM " . icms::$xoopsDB->prefix('index_link') . " " . $criteria->renderWhere();
				if ($result = icms::$xoopsDB->query($sql)) {
					while ($myrow = icms::$xoopsDB->fetchBoth($result)) {
						$criteria2->add(new icms_db_criteria_Item("category_id", $myrow['link_cid']), "OR");
					}
				}
				$criteria3 = $category_handler->getCategoryCriterias(FALSE, TRUE, TRUE, $clean_cat_nav, $indexConfig['show_categories'], $indexConfig['category_default_order'], $indexConfig['category_default_sort']);
				$criteria3->add($criteria2);
				$categories = $category_handler->getObjects($criteria3, TRUE, FALSE);
				// split categories to predefined columns
				$cat_columns = array_chunk($categories, $indexConfig['show_category_columns']);
				$icmsTpl->assign('category_columns', $cat_columns);
				// pagination control
				$category_count = $category_handler->getCategoriesCount($clean_cat_seo, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE, $clean_cat_id);
				$category_pagenav = new icms_view_PageNav($category_count, $indexConfig['show_categories'], $clean_cat_nav, 'cat_nav', FALSE);
				$icmsTpl->assign('category_pagenav', $category_pagenav->renderNav());
				// check, if user can submit to provide submit links
				($category_handler->userCanSubmit()) ? $icmsTpl->assign('submit_link', INDEX_URL . 'category.php?op=mod&amp;category_id=' . $clean_cat_id) : $icmsTpl->assign('submit_link', FALSE);
			// if not valid single category or no permissions -> redirect to module home
			} else {
				redirect_header(ARTICLE_URL, 3, _NOPERM);
			}
			
			// check, if upload disclaimer is necessary and retrieve the link
			if($articleConfig['show_upl_disclaimer'] == 1) {
				$discl = str_replace('{X_SITENAME}', $icmsConfig['sitename'], $articleConfig['upl_disclaimer']);
				$icmsTpl->assign('article_upl_disclaimer', TRUE );
				$icmsTpl->assign('up_disclaimer', $discl);
			}
			break;
	}
	include_once 'footer.php';
} else {
	redirect_header(ARTICLE_URL, 3, _NOPERM);
}