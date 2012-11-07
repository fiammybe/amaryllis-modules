<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /index.php
 * 
 * display a single category
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'portfolio_portfolio.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$portfolio_indexpage_handler = icms_getModuleHandler( "indexpage", icms::$module -> getVar( 'dirname' ), "portfolio" );
$indexpageObj = $portfolio_indexpage_handler->get(1);
$index = $indexpageObj->toArray();
$icmsTpl->assign('portfolio_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$portfolio_handler = icms_getModuleHandler( "portfolio", icms::$module->getVar('dirname'), "portfolio");
$clean_portfolio_id = isset($_GET['portfolio_id']) ? filter_input(INPUT_GET, 'portfolio_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_portfolio = isset($_GET['portfolio']) ? filter_input(INPUT_GET, 'portfolio') : FALSE;
if ($clean_portfolio) {
	$portfolioObj = $portfolio_handler->getPortfolioBySeo($clean_portfolio);
} else {
	$portfolioObj = FALSE;
}
/**
 * retrieve a single category including files of the category and subcategories
 */
if (is_object($portfolioObj) && (!$portfolioObj->isNew()) && ($portfolioObj->accessGranted())) {
	$portfolio_handler->updateCounter($portfolioObj->id());
	$portfolio = $portfolioObj->toArray();
	$icmsTpl->assign("portfolio", $portfolio);
	
	if($portfolioObj->displayAlbum() && icms_get_module_status("album")) {
		$albumModule = icms_getModuleInfo("album");
		$aid = $portfolioObj->getVar("portfolio_album", "e");
		$images_handler = icms_getModuleHandler("images", $albumModule->getVar("dirname"), "album");
		$directory_name = basename(dirname(dirname(dirname(__FILE__))));
		//include_once ICMS_ROOT_PATH . '/modules/' . $albumModule->getVar('dirname') . '/include/common.php';
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('img_active', 1));
		$criteria->add(new icms_db_criteria_Item('a_id', $aid ));
		$images = $images_handler->getObjects($criteria, TRUE, FALSE);
		$icmsTpl->assign('album_images', $images);
	}

	/**
	 * display social media buttons
	 */
	if($portfolioConfig['display_twitter'] > 0) {
	//Twitter button
		switch ( $portfolioConfig['display_twitter'] ) {
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
				<span style="margin-right: 10px;"><a href="https://twitter.com/share" class="twitter-share-button" data-count="' . $counter . '">' . _MD_PORTFOLIO_TWITTER . '</a></span>';
		$icmsTpl->assign("portfolio_twitter", $tw);
	}
	
	if($portfolioConfig['display_fblike'] > 0) {
		//Facebook button
		switch ( $portfolioConfig['display_fblike'] ) {
			case 1:
				$counter = 'button_count';
				break;
			case 2:
				$counter = 'box_count';
				break;
		}
		$fb = '<div data-href="' . $portfolioObj->getItemLink(TRUE) . '" class="fb-like" data-send="FALSE" data-layout="' . $counter . '" data-show-faces="FALSE"></div>';
		$icmsTpl->assign("portfolio_facebook", $fb);
	}
	
	//Google +1 button
	if($portfolioConfig['display_gplus'] > 0) {
		switch ( $portfolioConfig['display_gplus'] ) {
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
		$icmsTpl->assign("portfolio_googleplus", $gplus);
	}
	if(isset($gplus) OR isset($fb) OR isset($tw)) {
		$xoTheme->addScript('/modules/' . PORTFOLIO_DIRNAME . '/scripts/jquery.socialshareprivacy.js', array('type' => 'text/javascript'));
		$xoTheme->addStylesheet('/modules/' . PORTFOLIO_DIRNAME . '/scripts/socialshareprivacy.css');
	}
	
	/**
	 * include the comment rules
	 */
	if ($portfolioConfig['com_rule'] > 0) {
		$icmsTpl->assign('portfolio_portfolio_comment', TRUE);
		$_GET['portfolio_id'] = $portfolioObj->id();
		include_once ICMS_ROOT_PATH . '/include/comment_view.php';
	}
	
	if ($portfolioConfig['show_breadcrumbs'] == 1){
		$icmsTpl->assign('portfolio_cat_path', $portfolioObj->getPortfolioCid(TRUE).' : '.$portfolioObj->title());
	}

	$icms_metagen = new icms_ipf_Metagen($portfolioObj->title(), $portfolioObj->meta_keywords(), $portfolioObj->meta_description());
	$icms_metagen->createMetaTags();
} else {
	redirect_header(PORTFOLIO_URL, 5, _NOPERM);
}
include_once 'footer.php';