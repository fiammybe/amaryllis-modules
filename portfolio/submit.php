<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /submit.php
 * 
 * handes some operations
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

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';

$valid_op = array ('addcontact');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addcontact':
			global $portfolioConfig;
			$clean_portfolio_id = isset($_GET['portfolio_id']) ? filter_input(INPUT_GET, 'portfolio_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_contact_id = isset($_GET['contact_id']) ? filter_input(INPUT_GET, 'contact_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$portfolio_contact_handler = icms_getModuleHandler("contact", basename(dirname(__FILE__)), "portfolio");
			$contactObj = $portfolio_contact_handler->get($clean_contact_id);
			if($contactObj->isNew() ) {
				if(is_object(icms::$user)){
					$contact_uid = icms::$user->getVar("uid");
				} else {
					$contact_uid = 0;
				}
				$contactObj->setVar('contact_submitter', $contact_uid);
				$contactObj->setVar('contact_date', (time()-200) );
				$contactObj->sendMessageIncoming();
				$controller = new icms_ipf_Controller($portfolio_contact_handler);
				if($clean_portfolio_id > 0) {
					$controller->storeFromDefaultForm(_THANKS_SUBMISSION_REV, _THANKS_SUBMISSION_REV, PORTFOLIO_URL . 'portfolio.php?portfolio_id=' . $clean_portfolio_id);
				} elseif ($clean_category_id <= 0 &&(strpos(xoops_getenv('HTTP_REFERER'), PORTFOLIO_URL . 'index.php') == FALSE )) {
					$controller->storeFromDefaultForm(_THANKS_SUBMISSION_REV, _THANKS_SUBMISSION_REV, PORTFOLIO_URL . 'category.php');
				} elseif ($clean_category_id > 0) {
					$controller->storeFromDefaultForm(_THANKS_SUBMISSION_REV, _THANKS_SUBMISSION_REV, PORTFOLIO_URL . 'category.php?category_id=' . $clean_category_id);
				} else {
					$controller->storeFromDefaultForm(_THANKS_SUBMISSION_REV, _THANKS_SUBMISSION_REV, PORTFOLIO_URL . 'index.php');
				}
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
			}
			break;
			
	}
} else {
	redirect_header(PORTFOLIO_URL . 'index.php', 4, _MD_PORTFOLIO_NO_PERM);
}
