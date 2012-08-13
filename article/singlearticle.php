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

function addtags($clean_tag_id = 0, $article_id = 0){
	global $tag_handler, $articleConfig, $icmsTpl, $article_handler;
	
	$articleObj = $article_handler->get($article_id);
	$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
	if(icms_get_module_status("index")) {
		$tagObj = $tag_handler->get($clean_tag_id);
		if ($tagObj->isNew()){
			$tagObj->hideFieldFromForm(array("short_url", "tag_approve", "meta_keywords", "meta_description"));
			$tagObj->setVar("tag_uid", $uid);
			$tagObj->setVar("tag_created_on", time() - 300);
			$tagObj = $tagObj->getSecureForm(_MD_ARTICLE_TAG_ADD, 'addtags', ARTICLE_URL . "submit.php?op=addtags&article_id=" . $articleObj->id() , _SUBMIT, 'onclick="return false;"', TRUE);
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

$indexpage_handler = icms_getModuleHandler( 'indexpage', INDEX_DIRNAME, 'index' );
$indexpageObj = $indexpage_handler->getIndexByMid(icms::$module->getVar("mid", "e"));
$icmsTpl->assign('index_index', $indexpageObj->toArray());
unset($indexpage_handler);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_review_start = isset($_GET['rev_nav']) ? filter_input(INPUT_GET, 'rev_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_body_start = isset($_GET['body']) ? filter_input(INPUT_GET, 'body', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_cat_seo = isset($_GET['cat']) ? filter_input(INPUT_GET, "cat") : FALSE;
$clean_cat_id = "";
if(!$clean_cat_seo) $clean_cat_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_article_seo = isset($_GET['article']) ? filter_input(INPUT_GET, 'article') : '';
$clean_article_id = '';
if(!$clean_article_seo) $clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
$articleObj = ($clean_article_seo != FALSE) ? $article_handler->getArticleBySeo($clean_article_seo) : FALSE; 
if(!$articleObj) $articleObj = ($clean_article_id != 0) ? $article_handler->get($clean_article_id) : FALSE;

if($articleObj && !$articleObj->isNew() && $articleObj->accessGranted()) {
	// update hit counter
	$article_handler->updateCounter($articleObj->id());
	// Get the requested article and send it to Array	
	$article = $articleObj->toArray();
	$icmsTpl->assign("article", $article);
	// prepare body
	$body_array = $articleObj->getArticleBody();
	$body = implode("", array_slice($body_array, $clean_body_start, 1));
	$icmsTpl->assign('article_body', $body);
	// render page nav for body
	$art_extra = ($clean_article_seo) ? 'article=' . $clean_article_seo : 'article_id=' . $clean_article_id;
	$cat_extra = ($clean_cat_seo) ? '&cat=' . $clean_cat_seo : '&category_id=' . $clean_cat_id;
	$extra_arg = $art_extra . $cat_extra;
	$article_pagenav = new icms_view_PageNav($articleObj->getVar("article_pagescount", "e"), 1, $clean_body_start, 'body', $extra_arg);
	$icmsTpl->assign('article_bodynav', $article_pagenav->renderNav());
	// forwarding new reports for broken links
	$icmsTpl->assign("broken_link", ARTICLE_URL . "submit.php?op=report_broken&article_id=" . $articleObj->id() . '&cat=' . $clean_cat_seo);
	
	// display disclaimer yes/no?
	if($articleConfig['show_down_disclaimer'] == 1) {
		$icmsTpl->assign('show_down_disclaimer', TRUE );
		$discl = str_replace('{X_SITENAME}', $icmsConfig['sitename'], $articleConfig['down_disclaimer']);
		$icmsTpl->assign('down_disclaimer', $discl);
	}
	
	$tag_handler = icms_getModuleHandler("tag", INDEX_DIRNAME, "index");
	if($tag_handler->userCanSubmit()) {
		$icmsTpl->assign("tag_form", TRUE);
		$icmsTpl->assign("tag_link", ARTICLE_URL . "submit.php?op=addtags&amp;article_id=" . $articleObj->id() );
		$icmsTpl->assign("tag_perm_denied", FALSE);
		//addtags(0, $articleObj->id());
	} else {
		$icmsTpl->assign("tag_link", ICMS_URL . "/user.php");
		$icmsTpl->assign("tag_perm_denied", TRUE);
		unset($tag_handler);
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
	
	// include the comment rules
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
	// assign breadcrumb
	if ($indexConfig['show_breadcrumbs'] == TRUE) {
		$category_handler = icms_getModuleHandler('category', INDEX_DIRNAME, 'index');
		$cat = ($clean_cat_seo) ? $category_handler->getCatBySeo($clean_cat_seo) : $category_handler->get($clean_cat_id);
		$breadcrumb = $category_handler->getBreadcrumbForPid($cat->id());
		$icmsTpl->assign('index_cat_path', $breadcrumb);
		unset($category_handler, $cat);
	}
	// get the meta informations
	$icms_metagen = new icms_ipf_Metagen($articleObj->title(), $articleObj->meta_keywords(), $articleObj->meta_description());
	$icms_metagen->createMetaTags();
} else {
	redirect_header (ARTICLE_URL, 3, _NOPERM);
}
if(isset($gplus) OR isset($fb) OR isset($tw)) {
	$xoTheme->addScript('/modules/' . ARTICLE_DIRNAME . '/scripts/jquery.socialshareprivacy.js', array('type' => 'text/javascript'));
	$xoTheme->addStylesheet('/modules/' . ARTICLE_DIRNAME . '/scripts/socialshareprivacy.css');
}
include_once "footer.php";