<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /index.php
 * 
 * module home
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

include_once "header.php";

$xoopsOption["template_main"] = "event_index.html";

include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(icms_get_module_status("index")) {
	$indexpage_handler = icms_getModuleHandler( 'indexpage', INDEX_DIRNAME, 'index' );
	$indexpageObj = $indexpage_handler->getIndexByMid(icms::$module->getVar("mid", "e"));
	if(is_object($indexpageObj)) $icmsTpl->assign('index_index', $indexpageObj->toArray());
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_date = isset($_GET['date']) ? filter_input(INPUT_GET, "date") : $eventConfig['default_view'];

$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
$calendar_handler = icms_getModuleHandler("calendar", EVENT_DIRNAME, "event");
$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");

$categories = $category_handler->getCategories();
$icmsTpl->assign("categories", $categories);

$catIds = $category_handler->getIdsFromObjectsAsArray($categories);
$events = $event_handler->getEvents($catIds);
$icmsTpl->assign("events", $events );

$icmsTpl->assign("default_view", $clean_date);

$calendars = $calendar_handler->getObjects(FALSE, TRUE, FALSE);
$icmsTpl->assign("calendars", $calendars);

include_once 'footer.php';
