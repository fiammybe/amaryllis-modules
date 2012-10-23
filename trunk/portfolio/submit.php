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
function setStatus($status, $message) {
	echo json_encode(array("status" => $status, "message" => $message));
}
include_once "header.php";
icms::$logger->disableLogger();
$valid_op = array ('addcontact');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');
$clean_op = (isset($_POST['op']) ? filter_input(INPUT_POST, 'op') : $clean_op);

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addcontact':
			global $portfolioConfig;
			$contact_handler = icms_getModuleHandler("contact", PORTFOLIO_DIRNAME, "portfolio");
			$contact_uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
			if($portfolioConfig['guest_contact'] == 0 && $contact_uid <= 0) setStatus("error", _NOPERM);
			$contactObj = $contact_handler->create(TRUE);
			$contactObj->setVar("contact_title", filter_input(INPUT_POST, "contact_title"));
			$contactObj->setVar("contact_name", filter_input(INPUT_POST, "contact_name"));
			$contactObj->setVar("contact_mail", filter_input(INPUT_POST, "contact_mail", FILTER_VALIDATE_EMAIL));
			$contactObj->setVar("contact_phone", filter_input(INPUT_POST, "contact_phone"));
			$contactObj->setVar("contact_body", filter_input(INPUT_POST, "contact_body"));
			$contactObj->setVar('contact_submitter', $contact_uid);
			$contactObj->setVar('contact_date', (time()-200) );
			$contactObj->setVar("contact_isnew", 0);
			if(!$contact_handler->insert($contactObj)) {setStatus("error", _MD_PORTFOLIO_ERROR_STORING); unset($_POST); exit;}
			$contactObj->sendMessageIncoming();
			setStatus("success", _THANKS_SUBMISSION_REV); unset($_POST); exit;
			break;
	}
} else {
	setStatus("error", _NOPERM); unset($_POST); exit;
}