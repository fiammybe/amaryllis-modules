<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /submit.php
 * 
 * handle user actions from frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

function addUrlLink() {
	global $urllink_handler;
	$urlObj = $urllink_handler->create(TRUE);
	$urlObj->setVar("mid", filter_input(INPUT_POST, 'mid_event_url', FILTER_SANITIZE_NUMBER_INT));
	$urlObj->setVar("caption", filter_input(INPUT_POST, 'caption_event_url'));
	$urlObj->setVar("description", filter_input(INPUT_POST, 'desc_event_url'));
	$urlObj->setVar("url", filter_input(INPUT_POST, 'url_event_url'));
	$urlObj->setVar("target", filter_input(INPUT_POST, 'target_event_url'));
	$urllink_handler->insert($urlObj, TRUE);
	return $urlObj->id();
}

include_once 'header.php';
include_once ICMS_ROOT_PATH . 'header.php';
icms::$logger->disableLogger();
$clean_op = (isset($_GET['op'])) ? filter_input(INPUT_GET, "op") : '';

$valid_op = array("addevent", "resizeevent", "dropevent", "del", "join", "unjoin");

if(in_array($clean_op, $valid_op, TRUE)) {
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
    $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
    switch ($clean_op) {
        case 'addevent':
			$clean_event_id = $event = $clean_category = $cat = $eventname = $uid = $urllink_handler = $urllink = $allday = "";
			$clean_event_id = filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT);
			$event = $event_handler->get($clean_event_id);
			if($clean_event_id > 0 && $event->isNew())  { echo json_encode(array('status' => 'error','message'=> _NOPERM));unset($_POST); exit;}
            $clean_category = filter_input(INPUT_POST, "event_cid");
            if(!$clean_category) { echo json_encode(array( 'status' => 'error', 'message'=> _NOPERM,));unset($_POST); exit; }
            $cat = $category_handler->get($clean_category);
            if(!$cat->submitAccessGranted()) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_SUBMITACCESS_FAILED));unset($_POST); exit;}
            $eventname = filter_input(INPUT_POST, "event_name");
            if(!$eventname) { echo json_encode(array( 'status' => 'error', 'message'=> _MD_EVENT_NO_TITLE,));unset($_POST); exit; }
			$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
			if(isset($_POST['url_event_url']) && !empty($_POST['url_event_url'])) {
				$urllink_handler = icms::handler("icms_data_urllink");
				$urllink = addUrlLink();
			} else {
				$urllink = 0;
			}
			$allday = ($_POST['event_allday'] == "false") ? FALSE : TRUE;
			
            $event->setVar("event_name", $eventname);
			$event->setVar("event_cid", (int)$_POST['event_cid']);
			$event->setVar("event_dsc", $_POST['event_dsc']);
			$event->setVar("event_startdate", (int)$_POST['event_startdate']);
			$event->setVar("event_enddate", (int)$_POST['event_enddate']);
			$event->setVar("event_created_on", time());
			$event->setVar("event_submitter", $uid);
			$event->setVar("event_url", $urllink);
			$event->setVar("event_contact", filter_input(INPUT_POST,'event_contact'));
			$event->setVar("event_cemail", filter_input(INPUT_POST, 'event_cemail', FILTER_VALIDATE_EMAIL));
			$event->setVar("event_city", filter_input(INPUT_POST, 'event_city'));
			$event->setVar("event_phone", filter_input(INPUT_POST, 'event_phone'));
			$event->setVar("event_street", filter_input(INPUT_POST, 'event_street'));
			$event->setVar("event_zip", (int)filter_input(INPUT_POST, 'event_zip'));
			$event->setVar("event_public", filter_input(INPUT_POST, 'event_public', FILTER_SANITIZE_NUMBER_INT));
			$event->setVar("event_allday", $allday);
			$event->setVar("event_joiner", filter_input(INPUT_POST, 'event_joiners', FILTER_SANITIZE_NUMBER_INT));
			$event->setVar("event_can_joint", filter_input(INPUT_POST, 'event_can_joint', FILTER_SANITIZE_NUMBER_INT));
			if(!$event_isAdmin) {
				$event->setVar("event_approve", FALSE);
			} else {
				$event->setVar("event_approve", TRUE);
			}
			if(isset($_POST['event_tags']) && !empty($_POST['event_tags']) && icms_get_module_status("index")) {
				$event->setVar("event_tags", filter_input(INPUT_POST,'event_tags'));
			}
			if(!$event_handler->insert($event)) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_STORING_FAILED . " " . implode("<br />", $event->getErrors())));unset($_POST);exit;}
			$success_msg = ($event_isAdmin) ? _MD_EVENT_THANKS_SUBMITTING : _MD_EVENT_AWAITING_APPROVAL;
			if(!$event_isAdmin) { $event->sendMessageAwaiting(); }
			echo json_encode(array('status' => 'success','message'=> $success_msg));
			unset($_POST, $event, $event_handler);
			exit;
            break;
        
        case 'resizeevent':
			$allday = $dayDelta = $minDelta = $end = $new_end = $clean_event = $event = "" ;
			$clean_event = isset($_POST['event_id']) ? filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT) : 0;
            $event = $event_handler->get($clean_event);
			if(!$event->userCanEditAndDelete()) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_ACCESS_FAILED)); exit;}
			$allday = $dayDelta = $minDelta = $end = $new_end = "";
			$dayDelta = filter_input(INPUT_POST, 'day_diff', FILTER_SANITIZE_NUMBER_INT);
			$minDelta = filter_input(INPUT_POST, 'min_diff', FILTER_SANITIZE_NUMBER_INT);
			$end = $event->getVar("event_enddate", "e");
			$new_end = $end + ($minDelta*60) + ($dayDelta*60*60*24);
			$event->setVar("event_enddate", $new_end);
			$event->_updating = TRUE;
			if(!$event_handler->insert($event)) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_STORING_FAILED . " " . implode("<br />", $event->getErrors())));exit;}
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_SUCCESSFUL_RESIZED));
			exit;
            break;
		case 'dropevent':
			$allday = $dayDelta = $minDelta = $end = $new_end = $new_start = $clean_event = $event = "" ;
			$clean_event = isset($_POST['event_id']) ? filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT) : 0;
            $event = $event_handler->get($clean_event);
			if(!$event->userCanEditAndDelete()) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_ACCESS_FAILED));unset($_POST); exit;}
			$allday = $dayDelta = $minDelta = $end = $new_end = "";
			$allday = ($_POST['event_allday'] == "false") ? FALSE : TRUE;
			$dayDelta = filter_input(INPUT_POST, 'day_diff', FILTER_SANITIZE_NUMBER_INT);
			$minDelta = filter_input(INPUT_POST, 'min_diff', FILTER_SANITIZE_NUMBER_INT);
			$end = $event->getVar("event_enddate", "e");
			$start = $event->getVar("event_startdate", "e");
			$new_end = $end + ($minDelta*60) + ($dayDelta*60*60*24);
			$new_start = $start + ($minDelta*60) + ($dayDelta*60*60*24);
			$event->setVar("event_startdate", $new_start);
			$event->setVar("event_enddate", $new_end);
			$event->setVar("event_allday", $allday);
			$event->_updating = TRUE;
			if(!$event_handler->insert($event)) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_STORING_FAILED . " " . implode("<br />", $event->getErrors())));unset($_POST);exit;}
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_SUCCESSFUL_RESIZED));
			unset($_POST);
			exit;
			break;
		case 'del':
			$event_id = filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT);
			$event = $event_handler->get($event_id);
			if(!$event->userCanEditAndDelete()) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_ACCESS_FAILED));unset($_POST);exit;}
			if(!$event_handler->delete($event)) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_DELETING_FAILED . " " . implode("<br />", $event->getErrors())));unset($_POST);exit;}
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_SUCCESSFUL_DELETED));
			unset($_POST);
			exit;
			break;
		case 'join':
			$event_id = filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT);
			$event = $event_handler->get($event_id);
			if($event->hasJoint()) { echo json_encode(array( 'status' => 'error', 'message'=> _NOPERM,));unset($_POST); exit; }
			if(!$event->joinEvent()) { echo json_encode(array( 'status' => 'error', 'message'=> _NOPERM,));unset($_POST); exit; }
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			$event->sendMessageJoined($uid);
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_SUCCESSFUL_JOINED));
			unset($_POST); exit;
			break;
		
		case 'unjoin':
			$event_id = filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT);
			$event = $event_handler->get($event_id);
			if(!$event->hasJoint()) { echo json_encode(array( 'status' => 'error', 'message'=> _NOPERM,));unset($_POST); exit; }
			if(!$event->unjoinEvent()) { echo json_encode(array( 'status' => 'error', 'message'=> _NOPERM,));unset($_POST); exit; }
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			$event->sendMessageUnjoined($uid);
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_SUCCESSFUL_UNJOINED));
			unset($_POST); exit;
			break;
    }
    
    
} else {
	redirect_header(EVENT_URL, 3, _NOPERM);
}
