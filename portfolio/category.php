<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /index.php
 * 
 * module home
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

$xoopsOption['template_main'] = 'portfolio_category.html';

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
$portfolio_category_handler = icms_getModuleHandler("category", icms::$module->getVar("dirname"), "portfolio");
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT) : 0;
if ($clean_category_id != 0) {
	$categoryObj = $portfolio_category_handler->get($clean_category_id);
} else {
	$categoryObj = FALSE;
}
/**
 * retrieve a single category including files of the category and subcategories
 */
if (is_object($categoryObj) && (!$categoryObj->isNew()) && ($categoryObj->accessGranted())) {
	$portfolio_category_handler->updateCounter($clean_category_id);
	$category = $categoryObj->toArray();
	$icmsTpl->assign('portfolio_single_cat', $category);
	
	$columns = $portfolioConfig['show_portfolio_columns'];
	$rows = $portfolioConfig['show_portfolio_rows'];
	$limit = (int)$columns * (int)$rows;
	$portfolios = $portfolio_portfolio_handler->getPortfolios(TRUE, "weight", "DESC", $clean_start, $limit, FALSE);
	$portfolio_columns = array_chunk($portfolios, $columns);
	$icmsTpl->assign("portfolio_columns", $portfolio_columns);
	
	$criteria = new icms_db_criteria_Compo();
	$criteria->add(new icms_db_criteria_Item("portfolio_cactive", TRUE));
	$count = $portfolio_portfolio_handler->getCount($criteria);
	if (!empty($clean_category_id)) {
		$extra_arg = 'category_id=' . $clean_category_id;
	} else {
		$extra_arg = FALSE;
	}
	$pagenav = new icms_view_PageNav($count, $limit, $clean_start, 'start', $extra_arg);
	$icmsTpl->assign('pagenav', $pagenav->renderNav());

	if ($portfolioConfig['show_breadcrumbs']){
		$icmsTpl->assign('portfolio_cat_path', $categoryObj->getitemLink());
	}else{
		$icmsTpl->assign('portfolio_cat_path',FALSE);
	}
	
	/**
	 * contact form
	 */
	if($portfolioConfig['guest_contact'] == 1) {
		$icmsTpl->assign("contact_link", PORTFOLIO_URL . "submit.php?op=addcontact");
		$icmsTpl->assign("contact_perm_denied", FALSE);
		addcontact(0);
	} else {
		if(is_object(icms::$user)) {
			addcontact(0);
			$icmsTpl->assign("contact_link", PORTFOLIO_URL . "submit.php?op=addcontact&category_id=" . $clean_category_id);
			$icmsTpl->assign("contact_perm_denied", FALSE);
		} else {
			$icmsTpl->assign("contact_link", ICMS_URL . "/user.php");
			$icmsTpl->assign("contact_perm_denied", TRUE);
		}
	}
		
	
/**
 * if there's no valid category, retrieve a list of all primary categories
 */
} elseif ($clean_category_id == 0) {
	$categories = $portfolio_category_handler->getCategories(TRUE, "weight", "ASC", 0, FALSE);
	$icmsTpl->assign('categories', $categories);
	
	/**
	 * make contct form avaiable throughout the site
	 */
	if($portfolioConfig['guest_contact'] == 1) {
		$icmsTpl->assign("contact_link", PORTFOLIO_URL . "submit.php?op=addcontact");
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

} else {
	redirect_header(PORTFOLIO_URL, 3, _NO_PERM);
}

include_once 'footer.php';