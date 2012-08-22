<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /feeds.php
 * 
 * render events
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
icms::$logger->disableLogger();
$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, "start") : 0;
$clean_end = isset($_GET['end']) ? filter_input(INPUT_GET, "end") : 0;
$clean_cat = isset($_GET['cat']) ? filter_input(INPUT_GET, "cat", FILTER_SANITIZE_NUMBER_INT) : FALSE;
$clean_cal = isset($_GET['cal']) ? filter_input(INPUT_GET, "cal", FILTER_SANITIZE_NUMBER_INT) : FALSE;

if(!$clean_cat == FALSE ){
	$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
	$catObj = $category_handler->get($clean_cat);
	if(is_object($catObj) && !$catObj->isNew() && $catObj->accessGranted($clean_uid)) {
		$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
		$events = $event_handler->getEvents($catObj->id(), $clean_start, $clean_end, $clean_uid);
		$feeds = array();
		foreach ($events as $event) {
			$feeds[] = array (
				'id'			=> $event['id'],
				'title'			=> $event['name'],
				'url'			=> $event['itemURL'],
				'start'			=> $event['start'],
				'end'			=> $event['end'],
				'allDay'		=> $event['allDay'],
				'author'		=> $event['submitter'],
				'description'	=> $event['dsc'],
				'pubdate'		=> $event['event_created_on'],
				'editable'		=> $event['canEditAndDelete']
			);
		}
		echo json_encode($feeds);
	}
}