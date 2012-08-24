<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /submit.php
 * 
 * submitting/updating single objects
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
	$urlObj->setVar("mid", (int)$_POST['mid_event_url']);
	$urlObj->setVar("caption", $_POST['caption_event_url']);
	$urlObj->setVar("description", $_POST['desc_event_url']);
	$urlObj->setVar("url", $_POST['url_event_url']);
	$urlObj->setVar("target", $_POST['target_event_url']);
	$urllink_handler->insert($urlObj, TRUE);
	return $urlObj->id();
}

include_once 'header.php';
include_once ICMS_ROOT_PATH . 'header.php';
icms::$logger->disableLogger();
$clean_op = (isset($_GET['op'])) ? filter_input(INPUT_GET, "op") : '';

$valid_op = array("addevent", "resizeevent", "dropevent");

if(in_array($clean_op, $valid_op, TRUE)) {
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
    $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
    switch ($clean_op) {
        case 'addevent':
            $clean_category = filter_input(INPUT_POST, "event_cid");
            if(!$clean_category) redirect_header(EVENT_URL, 3, "Keine Clean Category");
            $cat = $category_handler->get($_POST['event_cid']);
            if(!$cat->submitAccessGranted()) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_SUBMITACCESS_FAILED)); exit;}
            $eventname = filter_input(INPUT_POST, "event_name");
            if(!$eventname) { echo json_encode(array( 'status' => 'error', 'message'=> _MD_EVENT_NO_TITLE,)); exit; }
			$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
			if(isset($_POST['url_event_url']) && !empty($_POST['url_event_url'])) {
				$urllink_handler = icms::handler("icms_data_urllink");
				$urllink = addUrlLink();
			} else {
				$urllink = 0;
			}
			$allday = ($_POST['event_allday'] == "false") ? FALSE : TRUE;
			
			$event = $event_handler->create(TRUE);
            $event->setVar("event_name", $_POST['event_name']);
			$event->setVar("event_cid", (int)$_POST['event_cid']);
			$event->setVar("event_dsc", $_POST['event_dsc']);
			$event->setVar("event_startdate", (int)$_POST['event_startdate']);
			$event->setVar("event_enddate", (int)$_POST['event_enddate']);
			$event->setVar("event_created_on", time());
			$event->setVar("event_submitter", $uid);
			$event->setVar("event_url", $urllink);
			$event->setVar("event_contact", $_POST['event_contact']);
			$event->setVar("event_cemail", $_POST['event_cemail']);
			$event->setVar("event_phone", $_POST['event_phone']);
			$event->setVar("event_street", $_POST['event_street']);
			$event->setVar("event_zip", (int)$_POST['event_zip']);
			$event->setVar("event_public", (int)$_POST['event_public']);
			$event->setVar("event_allday", $allday);
			if(isset($_POST['event_tags']) && !empty($_POST['event_tags']) && icms_get_module_status("index")) {
				$event->setVar("event_tags", $_POST['event_tags']);
			}
			if(!$event_handler->insert($event, TRUE)) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_STORING_FAILED . " " . implode("<br />", $event->getErrors())));exit;}
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_THANKS_SUBMITTING,));
			exit;
            break;
        
        case 'resizeevent':
			$clean_event = isset($_POST['event_id']) ? filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT) : 0;
            $event = $event_handler->get($clean_event);
			if(!$event->userCanEditAndDelete()) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_ACCESS_FAILED)); exit;}
			$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
			$dayDelta = $_POST['day_diff'];
			$minDelta = $_POST['min_diff'];
			$end = $event->getVar("event_enddate", "e");
			$event->setVar("event_enddate", $end + ($minDelta*60) + ($dayDelta*60*60*24));
			$event->_updating = TRUE;
			if(!$event_handler->insert($event)) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_STORING_FAILED . " " . implode("<br />", $event->getErrors())));exit;}
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_SUCCESSFUL_RESIZED,));
            break;
		case 'dropevent':
			$clean_event = isset($_POST['event_id']) ? filter_input(INPUT_POST, "event_id", FILTER_SANITIZE_NUMBER_INT) : 0;
            $event = $event_handler->get($clean_event);
			if(!$event->userCanEditAndDelete()) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_ACCESS_FAILED)); exit;}
			$allday = ($_POST['event_allday'] == "false") ? FALSE : TRUE;
			$dayDelta = $_POST['day_diff'];
			$minDelta = $_POST['min_diff'];
			$end = $event->getVar("event_enddate", "e");
			$event->setVar("event_startdate", $end + ($minDelta*60) + ($dayDelta*60*60*24));
			$event->setVar("event_enddate", $end + ($minDelta*60) + ($dayDelta*60*60*24));
			$event->setVar("event_allday", $allday);
			$event->_updating = TRUE;
			if(!$event_handler->insert($event)) { echo json_encode(array('status' => 'error','message'=> _MD_EVENT_STORING_FAILED . " " . implode("<br />", $event->getErrors())));exit;}
			echo json_encode(array('status' => 'success','message'=> _MD_EVENT_SUCCESSFUL_RESIZED,));
			break;
    }
    
    
} else {
	redirect_header(EVENT_URL, 3, _NOPERM);
}
