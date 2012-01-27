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

$xoopsOption['template_main'] = 'portfolio_index.html';

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
$columns = $portfolioConfig['show_portfolio_columns'];
$rows = $portfolioConfig['show_portfolio_rows'];
$limit = (int)$columns * (int)$rows;
$portfolios = $portfolio_portfolio_handler->getPortfolios(TRUE, "weight", "DESC", 0, $limit, FALSE);
$portfolio_columns = array_chunk($portfolios, $columns);

$icmsTpl->assign("portfolio_columns", $portfolio_columns);

/**
 * make contct form avaiable
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

include_once 'footer.php';