<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /submit.php
 * 
 * handes some operations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';

$valid_op = array ('addmessage');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addmessage':
			global $careerConfig;
			$career_id = (int)filter_input(INPUT_GET, 'career_id');
			if ($career_id <= 0) return FALSE;
			$career_career_handler = icms_getModuleHandler("career", basename(dirname(__FILE__)),"career");
			$careerObj = $career_career_handler->get($career_id);
			if ($careerObj->isNew()) return FALSE;
			$clean_message_id = isset($_GET['message_id']) ? filter_input(INPUT_GET, 'message_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$career_message_handler = icms_getModuleHandler("message", basename(dirname(__FILE__)), "career");
			$messageObj = $career_message_handler->get($clean_message_id);
			if(is_object(icms::$user)){
				$message_uid = icms::$user->getVar("uid");
			} else {
				$message_uid = 0;
			}
			if($messageObj->isNew() ) {
				$messageObj->setVar('message_submitter', $message_uid);
				$messageObj->setVar('message_cid', $career_id );
				$messageObj->setVar('message_date', (time()-200) );
				$messageObj->setVar('message_did', $careerObj->getVar("career_did"));
				$careerObj->sendMessageIncoming();
				$controller = new icms_ipf_Controller($career_message_handler);
				$controller->storeFromDefaultForm(_THANKS_SUBMISSION_REV, _THANKS_SUBMISSION_REV, CAREER_URL . 'career.php?career_id=' . $career_id);
				return redirect_header (CAREER_URL . 'career.php?career_id=' . $career_id, 3, _THANKS_SUBMISSION);
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
			}
			break;
			
	}
} else {
	redirect_header(CAREER_URL . 'index.php', 4, _MD_CAREER_NO_PERM);
}
