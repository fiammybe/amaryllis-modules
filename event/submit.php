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
	$urlObj->setVar("mid", (int)$_POST['mid_img_urllink']);
	$urlObj->setVar("caption", $_POST['caption_img_urllink']);
	$urlObj->setVar("description", $_POST['desc_img_urllink']);
	$urlObj->setVar("url", $_POST['url_img_urllink']);
	$urlObj->setVar("target", $_POST['target_img_urllink']);
	$urllink_handler->insert($urlObj, TRUE);
	return $urlObj->id();
}

include_once 'header.php';

$clean_op = (isset($_GET['op'])) ? filter_input(INPUT_GET, "op") : '';

$valid_op = array("addevent");

if(in_array($clean_op, $valid_op, TRUE)) {
    $clean_event = isset($_GET['event_id']) ? filter_input(INPUT_GET, "event_id", FILTER_SANITIZE_NUMBER_INT) : 0;
    $event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
    $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
    switch ($clean_op) {
        case 'addevent':
            $event = $event_handler->get($clean_event);
            if($clean_event > 0 && $event->isNew()) {redirect_header(EVENT_URL, 3, _NOPERM);}
            if($event->isNew()) {
                $clean_category = isset($_POST['event_cid']) ? filter_input(INPUT_POST, "event_cid", FILTER_SANITIZE_NUMBER_INT) : FALSE;
                if(!$clean_category) redirect_header(EVENT_URL, 3, _NOPERM);
                $cat = $category_handler->get($clean_category);
                if(!$cat->submitAccessGranted()) redirect_header(EVENT_URL, 3, _NOPERM);
                $eventname = (isset($_POST['title'])) ? filter_input(INPUT_POST, "event_name") : FALSE;
                if(!$eventname) redirect_header(EVENT_URL, 4, _MD_EVENT_NO_TITLE);
				$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
                $event_dsc = filter_input(INPUT_POST, "event_dsc");
                $event_start = filter_input(INPUT_POST, "start", FILTER_SANITIZE_NUMBER_INT);
                $event_end = filter_input(INPUT_POST, "end", FILTER_SANITIZE_NUMBER_INT);
				$urllink_handler = icms::handler("icms_data_urllink");
				if(isset($_POST['url_event_url']) && !empty($_POST['url_event_url'])) {
					$urllink = addUrlLink();
				} else {
					$urllink = 0;
				}
				icms_core_Debug::vardump($_POST);
                
                $event->setVar("event_name", $eventname);
				$event->setVar("event_cid", $clean_category);
				$event->setVar("event_dsc", $event_dsc);
				$event->setVar("event_startdate", $event_start);
				$event->setVar("event_enddate", $event_end);
				$event->setVar("event_created_on", time());
				$event->setVar("event_submitter", $uid);
				$event->setVar("event_url", $urllink);
				$event->setVar("event_contact", $_POST['event_contact']);
				$event->setVar("event_cemail", $_POST['event_cemail']);
				$event->setVar("event_phone", $_POST['event_phone']);
				$event->setVar("event_street", $_POST['event_street']);
				$event->setVar("event_zip", $_POST['event_zip']);
				$event->setVar("event_public", $_POST['event_public']);
				if(isset($_POST['event_tags']) && !empty($_POST['event_tags']) && icms_get_module_status("index")) {
					$event->setVar("event_tags", $_POST['event_tags']);
				}
                
				redirect_header(EVENT_URL, 3, _MD_THANKS_SUBMITTING);
            }
            break;
        
        case 'update':
            
            break;
    }
    
    
} else {
	redirect_header(EVENT_URL, 3, _NOPERM);
}
