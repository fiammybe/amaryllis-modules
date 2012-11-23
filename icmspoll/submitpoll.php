<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /index.php
 * 
 * main index file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

include_once 'header.php';
icms::$logger->disableLogger();
$valid_op = array('vote', 'voteblock' );
$clean_op = isset($_POST['op']) ? filter_input(INPUT_POST, 'op') : '';

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'vote':
			$clean_poll_id = isset($_POST['poll_id']) ? filter_input(INPUT_POST, "poll_id", FILTER_SANITIZE_NUMBER_INT) : 0;
			if(!$clean_poll_id) {echo json_encode(array("status" => "error", "message" => _NOPERM)); unset($_POST); exit;}
			$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
			$clean_uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
			$pollObj = $polls_handler->get($clean_poll_id);
			if(is_object($pollObj) && !$pollObj->isNew() && $pollObj->viewAccessGranted() && $pollObj->voteAccessGranted()) {
				$poll_option = ($pollObj->isMultiple()) ? explode(",", $_POST['poll_option']) : $_POST['poll_option'];
				$vote = $pollObj->vote($poll_option, $_SERVER['REMOTE_ADDR'], $clean_uid, $_SESSION["icms_fprint"]);
				if($vote) {echo json_encode(array("status" => "success", "message" => _MD_ICMSPOLL_POLLS_THANKS_VOTING)); unset($_POST); exit;}
				echo json_encode(array("status" => "error", "message" => _MD_ICMSPOLL_POLLS_NOTVOTED)); unset($_POST); exit;
			} else {
				echo json_encode(array("status" => "error", "message" => _NOPERM)); unset($_POST); exit;
			}
			break;
	}
} else {
	echo json_encode(array("status" => "error", "message" => _NOPERM)); unset($_POST); exit;
}