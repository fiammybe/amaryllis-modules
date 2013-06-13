<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /blocks/event_list.php
 * 
 * Block holding the events for selected timezone
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

include_once '../../../mainfile.php';
icms::$logger->disableLogger();
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));
include_once '../include/common.php';
icms_loadLanguageFile("event", "blocks");
$clean_bid = isset($_POST['event_bid']) ? filter_input(INPUT_POST, "event_bid", FILTER_SANITIZE_NUMBER_INT) : FALSE;
if(!$clean_bid) exit;
$clean_start = isset($_POST['range_start_'.$clean_bid]) ? filter_input(INPUT_POST, "range_start_$clean_bid") : FALSE;
$clean_end = isset($_POST['range_end_'.$clean_bid]) ? filter_input(INPUT_POST, "range_end_$clean_bid") : FALSE;
$clean_cat = isset($_POST['range_category_'.$clean_bid]) ? filter_input(INPUT_POST, "range_category_$clean_bid", FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_zip = isset($_POST['b_event_zip_'.$clean_bid]) ? filter_input(INPUT_POST, "b_event_zip_$clean_bid") : FALSE;
$clean_city = isset($_POST['b_event_city_'.$clean_bid]) ? filter_input(INPUT_POST, "b_event_city_$clean_bid") : FALSE;

if(!$clean_cat) {echo json_encode(array("status" => "success", "message" => _NOPERM)); unset($_POST); exit;}
$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : FALSE;
if($clean_cat > 0) {
	$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
	$category = $category_handler->get($clean_cat);
	if(!$category->accessGranted($uid)) {echo json_encode(array("status" => "error", "message" => _NOPERM)); unset($_POST); exit;}
}
$start = explode("/", $clean_start);
$startdate = mktime(0 ,0,0,$start[1], $start[0], $start[2]);
$end = explode("/", $clean_end);
$enddate = mktime(23,59,59,$end[1],$end[0], $end[2]);
$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
$events = $event_handler->getRenderedEvents($clean_cat, $startdate, $enddate, $uid, "event_startdate", "ASC", FALSE, $clean_zip, $clean_city);
if(!$events) {echo json_encode(array("status" => "success", "message" => _MB_EVENT_NO_EVENTS));unset($_POST); exit;}
echo json_encode(array("status" => "success", "message" => $events)); unset($_POST); exit;