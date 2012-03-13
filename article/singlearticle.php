<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /singlearticle.php
 * 
 * display single article
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

function addtags($clean_tag_id = 0, $clean_article_id = 0){
	global $sprockets_tag_handler, $articleConfig, $icmsTpl;
	
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");
	$articleObj = $article_article_handler->get($clean_article_id);
	$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
	if(icms_get_module_status("sprockets")) {
		$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname"), "sprockets");
		$tagObj = $sprockets_tag_handler->get($clean_tag_id);
		$tagObj->hideFieldFromForm(array("label_type", "parent_id", "navigation_element", "rss", "short_url", "meta_description", "meta_keywords"));
		if ($tagObj->isNew()){
			$tagObj->setVar("label_type", 0);
			$tagObj->setVar("navigation_element", 0);
			$tagObj = $tagObj->getSecureForm(_MD_ARTICLE_TAG_ADD, 'addtags', ARTICLE_URL . "submit.php?op=addtags&article_id=" . $articleObj->id() , 'OK', TRUE, TRUE);
			$tagObj->assign($icmsTpl, 'article_tag_form');
		} else {
			exit;
		}
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
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_review_start = isset($_GET['rev_nav']) ? filter_input(INPUT_GET, 'rev_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_article_start = isset($_GET['article_nav']) ? filter_input(INPUT_GET, 'article_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_seo = isset($_GET['article']) ? filter_input(INPUT_GET, 'article') : '';
$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");
$articleObj = $article_article_handler->get($clean_article_id);
if($articleObj && !$articleObj->isNew() && $articleObj->accessGranted()) {
	
	$article_article_handler->updateCounter($clean_article_id);
	/**
	 * Get the requested article and send it to Array
	 */	
	$article = $articleObj->toArray();
	$icmsTpl->assign("article", $article);
	
	$body_array = $articleObj->getArticleBody();
	$icmsTpl->assign('article_body', $body_array[0]);
	$extra_arg = 'article_id=' . $clean_article_id . '&article=' . $clean_seo . '&category_id=' . $clean_category_id;
	$article_pagenav = new icms_view_PageNav(count($body_array), 1, $clean_article_start, 'article_nav', $extra_arg);
	$icmsTpl->assign('article_pagenav', $article_pagenav->renderNav());
	/**
	 * forwarding new reports for broken links
	 */
	$icmsTpl->assign("broken_link", ARTICLE_URL . "submit.php?op=report_broken&article_id=" . $articleObj->id() . '&category_id=' . $clean_category_id);
	
	/**
	 * display disclaimer yes/no?
	 */
	if($articleConfig['show_down_disclaimer'] == 1) {
		$icmsTpl->assign('show_down_disclaimer', TRUE );
		$icmsTpl->assign('down_disclaimer', $articleConfig['down_disclaimer']);
	} else {
		$icmsTpl->assign('show_down_disclaimer', FALSE);
	}
	/**
	 * check if Sprockets Module can be used and if it's available
	 */
	$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
	if($articleConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
		$icmsTpl->assign("sprockets_module", TRUE);
	
		if(is_object(icms::$user)) {
			$icmsTpl->assign("tag_link", ARTICLE_URL . "submit.php?op=addtags&amp;article_id=" . $articleObj->getVar("article_id") );
			$icmsTpl->assign("tag_perm_denied", FALSE);
			addtags(0, $clean_article_id);
		} else {
			$icmsTpl->assign("tag_link", ICMS_URL . "/user.php");
			$icmsTpl->assign("tag_perm_denied", TRUE);
		}
	}
	/**
	 * display social media buttons
	 */
	if($articleConfig['display_twitter'] > 0) {
	//Twitter button
		switch ( $articleConfig['display_twitter'] ) {
			case 1:
				$counter = 'none';
				break;
			case 2:
				$counter = 'horizontal';
				break;
			case 3:
				$counter = 'vertical';
				break;
		}
		$tw = '<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
				<span style="margin-right: 10px;"><a href="https://twitter.com/share" class="twitter-share-button" data-count="' . $counter . '">' . _MD_ARTICLE_TWITTER . '</a></span>';
		$icmsTpl->assign("article_twitter", $tw);
	}
	
	if($articleConfig['display_fblike'] > 0) {
		//Facebook button
		switch ( $articleConfig['display_fblike'] ) {
			case 1:
				$counter = 'button_count';
				break;
			case 2:
				$counter = 'box_count';
				break;
		}
		$fb = '<div data-href="' . $articleObj->getItemLink(TRUE) . '" class="fb-like" data-send="FALSE" data-layout="' . $counter . '" data-show-faces="FALSE"></div>';
		$icmsTpl->assign("article_facebook", $fb);
	}
	
	//Google +1 button
	if($articleConfig['display_gplus'] > 0) {
		switch ( $articleConfig['display_gplus'] ) {
			case 1:
				$gplus = '<g:plusone size="medium" annotation="none"></g:plusone>';
				break;
			case 2:
				$gplus = '<span style="margin: 0; padding: 0;"><g:plusone size="medium" annotation="bubble"></g:plusone></span>';
				break;
			case 3:
				$gplus = '<span style="margin: 0; padding: 0;"><g:plusone size="tall" annotation="bubble"></g:plusone></span>';
				break;
		}
		$icmsTpl->assign("article_googleplus", $gplus);
	}
	
	/**
	 * include the comment rules
	 */
	if ($articleConfig['com_rule'] && $articleObj->userCanComment()) {
		$icmsTpl->assign('article_article_comment', TRUE);
		include_once ICMS_ROOT_PATH . '/include/comment_view.php';
	}
	
	/**
	 * include rating feature
	 
	if (file_exists(ICMS_ROOT_PATH . '/include/rating.rate.php')) {
		include_once(ICMS_ROOT_PATH . '/include/rating.rate.php');
	}
	*/
	/**
	 * aasign breadcrumb
	 */
	if ($articleConfig['show_breadcrumbs'] == TRUE) {
		$article_category_handler = icms_getModuleHandler('category', basename(dirname(__FILE__)), 'article');
		$icmsTpl->assign('article_show_breadcrumb', TRUE);
		$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($clean_category_id, 1));
	} else {
		$icmsTpl->assign('article_cat_path', FALSE);
	}
	/**
	 * get the meta informations
	 */
	$icms_metagen = new icms_ipf_Metagen($articleObj->getVar("article_title"), $articleObj->getVar("meta_keywords", "n"), $articleObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	redirect_header (ARTICLE_URL, 3, _NO_PERM);
}
if(isset($gplus) OR isset($fb) OR isset($tw)) {
	$xoTheme->addScript('/modules/' . ARTICLE_DIRNAME . '/scripts/jquery.socialshareprivacy.js', array('type' => 'text/javascript'));
	$xoTheme->addStylesheet('/modules/' . ARTICLE_DIRNAME . '/scripts/socialshareprivacy.css');
}
include_once "footer.php";