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

function addcontact($clean_contact_id = 0){
	global $portfolio_contact_handler, $icmsTpl;
	$portfolio_contact_handler = icms_getModuleHandler("contact", basename(dirname(__FILE__)), "portfolio");
	$contactObj = $portfolio_contact_handler->get($clean_contact_id);
	if ($contactObj->isNew()){
		if(is_object(icms::$user)) {
			$uid = icms::$user->getVar("uid");
		} else {
			$uid = 0;
		}
		$contactObj->setVar("contact_submitter", $uid);
		$contactObj->setVar("contact_date", time() - 200);
		$contactObj->setVar("contact_isnew", 0);
		$contactObj = $contactObj->getSecureForm(_MD_PORTFOLIO_ADD_CONTACT, 'addcontact', PORTFOLIO_URL . "submit.php?op=addcontact", 'OK', TRUE, TRUE);
		$contactObj->assign($icmsTpl, 'portfolio_contact_form');
	} else {
		exit;
	}
}
 
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

$portfolio_portfolio_handler = icms_getModuleHandler( "portfolio", icms::$module->getVar('dirname'), "portfolio");
$clean_portfolio_id = isset($_GET['portfolio_id']) ? filter_input(INPUT_GET, 'portfolio_id', FILTER_SANITIZE_NUMBER_INT) : 0;

if ($clean_portfolio_id != 0) {
	$portfolioObj = $portfolio_portfolio_handler->get($clean_portfolio_id);
} else {
	$portfolioObj = FALSE;
}
/**
 * retrieve a single category including files of the category and subcategories
 */
if (is_object($portfolioObj) && (!$portfolioObj->isNew()) && ($portfolioObj->accessGranted())) {
	$portfolio = $portfolioObj->toArray();
	$icmsTpl->assign("portfolio", $portfolio);
	
	$albumModule = icms_getModuleInfo("album");
	if($portfolioObj->displayAlbum() && $albumModule) {
		$aid = $portfolioObj->getVar("portfolio_album", "e");
		$album_images_handler = icms_getModuleHandler("images", $albumModule->getVar("dirname", "album"));
		$directory_name = basename(dirname( __FILE__ ) );
		$script_name = getenv("SCRIPT_NAME");
		$document_root = str_replace('modules/' . $directory_name . '/portfolio.php', '', $script_name);
		$albumConfig = icms_getModuleConfig ($albumModule->getVar('name') );
		include_once ICMS_ROOT_PATH . '/modules/' . $albumModule->getVar('dirname') . '/include/common.php';
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('img_active', 1));
		$criteria->add(new icms_db_criteria_Item('a_id', $aid ));
		$imagesObjects = $album_images_handler->getObjects($criteria, TRUE, TRUE);
		$album_images = array();
		foreach ( $imagesObjects as $imagesObj ) {
			$image = $imagesObj -> toArray();
			$image['img_url'] = $document_root . 'uploads/' . $albumModule->getVar('dirname') . '/images/' . $imagesObj->getVar('img_url', 'e');
			$image['show_images_per_row'] = $albumConfig['show_images_per_row'];
			$image['thumbnail_width'] = $portfolioConfig['thumbnail_width'];
			$image['thumbnail_height'] = $portfolioConfig['thumbnail_height'];
			$album_images[] = $image;
		}
		$album_image_rows = array_chunk($album_images, $albumConfig['show_images_per_row']);
		$icmsTpl->assign('album_images', $album_images);
		$icmsTpl->assign('album_image_rows', $album_image_rows);
	}

	/**
	 * make contct form avaiable throughout the site
	 */
	if($portfolioConfig['guest_contact'] == 1) {
		$icmsTpl->assign("contact_link", PORTFOLIO_URL . "submit.php?op=addcontact&portfolio_id=" . $portfolioObj->getVar("portfolio_id", "e"));
		$icmsTpl->assign("contact_perm_denied", FALSE);
		addcontact(0);
	} else {
		if(is_object(icms::$user)) {
			addcontact(0);
			$icmsTpl->assign("contact_link", PORTFOLIO_URL . "submit.php?op=addcontact");
			$icmsTpl->assign("contact_perm_denied", FALSE);
		} else {
			$icmsTpl->assign("contact_link", ICMS_URL . "/user.php");
			$icmsTpl->assign("contact_perm_denied", TRUE);
		}
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
	if ($portfolioConfig['com_rule']) {
		$icmsTpl->assign('portfolio_portfolio_comment', TRUE);
		include_once ICMS_ROOT_PATH . '/include/comment_view.php';
	}
	
	if ($portfolioConfig['show_breadcrumbs']){
		$icmsTpl->assign('portfolio_cat_path', $portfolioObj->getPortfolioCid(TRUE));
	}else{
		$icmsTpl->assign('portfolio_cat_path',FALSE);
	}
}

include_once 'footer.php';