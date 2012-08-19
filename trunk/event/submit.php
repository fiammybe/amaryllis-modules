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

include_once 'header.php';

$clean_op = (isset($_GET['op'])) ? filter_input(INPUT_GET, "op") : '';

$valid_op = array("op");

if(in_array($clean_op, $valid_op, TRUE)) {
    $clean_event = isset($_GET['event_id']) ? filter_input(INPUT_GET, "event_id", FILTER_SANITIZE_NUMBER_INT) : 0;
    $event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
    $category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
    switch ($clean_op) {
        case 'add':
            $event = $event_handler->get($clean_event);
            if($clean_event > 0 && $event->isNew()) {redirect_header(EVENT_URL, 3, _NOPERM);}
            if($event->isNew()) {
                $clean_category = isset($_POST['event_cid']) ? filter_input(INPUT_POST, "event_cid", FILTER_SANITIZE_NUMBER_INT) : FALSE;
                if(!$clean_category) redirect_header(EVENT_URL, 3, _NOPERM);
                $cat = $category_handler->get($clean_category);
                if(!$cat->submitAccessGranted()) redirect_header(EVENT_URL, 3, _NOPERM);
                $eventname = (isset($_POST['event_name'])) ? filter_input(INPUT_POST, "event_name") : FALSE;
                if(!$eventname) redirect_header(EVENT_URL, 4, _MD_EVENT_NO_TITLE);
                $event_dsc = filter_input(INPUT_POST, "event_dsc");
                $event_start = filter_input(INPUT_POST, "event_startdate");
                $event_end = filter_input(INPUT_POST, "event_enddate");
                
                $event->setVar("event_name", $eventname);
                
            }
            break;
        
        case 'update':
            
            break;
    }
    
    
} else {
	redirect_header(EVENT_URL, 3, _NOPERM);
}
