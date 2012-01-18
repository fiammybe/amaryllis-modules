<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * article: /singlearticle.php
 * 
 * display single article
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

function addtags($clean_tag_id = 0, $clean_article_id = 0){
	global $sprockets_tag_handler, $articleConfig, $icmsTpl;
	
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");
	$articleObj = $article_article_handler->get($clean_article_id);
	$sprocketsModule = icms_getModuleInfo("sprockets");
	$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname"), "sprockets");
	$tagObj = $sprockets_tag_handler->get($clean_tag_id);
	$tagObj->hideFieldFromForm(array("label_type", "parent_id", "navigation_element", "rss", "short_url", "meta_description", "meta_keywords"));
	if ($tagObj->isNew()){
		$tagObj->setVar("label_type", 0);
		$tagObj->setVar("navigation_element", 0);
		$tagObj = $tagObj->getSecureForm(_MD_ARTICLE_TAG_ADD, 'addtags', ARTICLE_URL . "ajax.php?op=addtags&article_id=" . $articleObj->id() , 'OK', TRUE, TRUE);
		$tagObj->assign($icmsTpl, 'article_tag_form');
	} else {
		exit;
	}
	
}

include_once "header.php";

$xoopsOption["template_main"] = "article_singlearticle.html";

include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = $indexpageObj = $article_indexpage_handler = $indexpageObj = '';
$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$article_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'article' );

$indexpageObj = $article_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('article_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = isset($_GET['cid']) ? filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_review_start = isset($_GET['rev_nav']) ? filter_input(INPUT_GET, 'rev_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");
$articleObj = $article_article_handler->get($clean_article_id);
$article_article_handler->updateCounter($clean_article_id);
if($articleObj && !$articleObj->isNew() && $articleObj->accessGranted()) {
	/**
	 * Get the requested article and send it to Array
	 */	
	$article = $articleObj->toArray();
	$icmsTpl->assign("article", $article);
	/**
	 * forwarding new reports for broken links
	 */
	$icmsTpl->assign("broken_link", ARTICLE_URL . "submit.php?op=report_broken&article_id=" . $articleObj->id() );
	/**
	 * display article as popular
	 */
	$popular = article_display_popular($articleObj->getVar("counter"));
	if($popular) {
		$icmsTpl->assign('article_is_popular', TRUE );
		$icmsTpl->assign('article_is_popular_img', $popular );
	}
	/**
	 * display image if article is new or updated
	 */
	$newarticle = article_display_new( $articleObj->getVar( 'article_published_date' ) );
	if($newarticle) {
		$icmsTpl->assign('article_is_new', TRUE );
		$icmsTpl->assign('article_is_new_img', $newarticle );
	} else {
		$icmsTpl->assign('article_is_new', FALSE );
	}
	if( $articleObj->getVar('article_updated') == true && $articleObj->getVar('article_updated_date') != 0) {
		$newarticle = article_display_updated( $articleObj->getVar( 'article_published_date' ) );
		if($newarticle) {
			$icmsTpl->assign('article_is_updated', TRUE );
			$icmsTpl->assign('article_is_updated_img', $newarticle );
		} else {
			$icmsTpl->assign('article_is_updated', FALSE );
		}
	}
	if($articleObj->getVar('article_updated_date', 'e') > 0) {
		$icmsTpl->assign("show_updated", TRUE);
	}
	/**
	 * display disclaimer yes/no?
	 */
	if($articleConfig['article_show_down_disclaimer'] == 1) {
		$icmsTpl->assign('show_down_disclaimer', true );
		$icmsTpl->assign('down_disclaimer', $articleConfig['article_down_disclaimer']);
	} else {
		$icmsTpl->assign('show_down_disclaimer', false);
	}
	/**
	 * check if Sprockets Module can be used and if it's available
	 */
	$sprocketsModule = icms_getModuleInfo("sprockets");
	if($articleConfig['use_sprockets'] == 1 && $sprocketsModule) {
		$icmsTpl->assign("sprockets_module", TRUE);
	
		if(is_object(icms::$user)) {
			$icmsTpl->assign("tag_link", ARTICLE_URL . "ajax.php?op=addtags&amp;article_id=" . $articleObj->getVar("article_id") );
			$icmsTpl->assign("tag_perm_denied", FALSE);
			addtags(0, $clean_article_id);
		} else {
			$icmsTpl->assign("tag_link", ICMS_URL . "/user.php");
			$icmsTpl->assign("tag_perm_denied", TRUE);
		}
	}
	/**
	 * include the comment rules
	 */
	if ($articleConfig['com_rule']) {
		$icmsTpl->assign('article_article_comment', true);
		include_once ICMS_ROOT_PATH . '/include/comment_view.php';
	}
	
	/**
	 * voting -> can vote?
	 */
	if($articleConfig['guest_vote'] == 1){
		$icmsTpl->assign("can_vote", TRUE);
	} else {
		if(is_object(icms::$user)){
			$icmsTpl->assign("can_vote", TRUE);
		} else {
			$icmsTpl->assign("can_vote", FALSE);
			$icmsTpl->assign("register_link", ICMS_URL . "/user.php");
		}
	}
	
	/**
	 * 
	 */
	if ($articleConfig['show_breadcrumbs'] == true) {
		$article_category_handler = icms_getModuleHandler('category', basename(dirname(__FILE__)), 'article');
		$icmsTpl->assign('article_show_breadcrumb', TRUE);
		$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($clean_category_id, 1));
	} else {
		$icmsTpl->assign('article_cat_path', false);
	}
	/**
	 * get the meta informations
	 */
	$icms_metagen = new icms_ipf_Metagen($articleObj->getVar("article_title"), $articleObj->getVar("meta_keywords", "n"), $articleObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	redirect_header (ARTICLE_URL, 3, _NO_PERM);
}

include_once "footer.php";