<?php
/**
* Event page
*
* @copyright	
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		QM-B <qm-b@hotmail.de>
* @package		event
* @version		$Id$
*/

include_once "header.php";

$xoopsOption["template_main"] = "event_event.html";
include_once ICMS_ROOT_PATH . "/header.php";

$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");

$clean_event = isset($_GET["event"]) ? filter_input(INPUT_GET, "event") : FALSE ;
$eventObj = $event_handler->getEventBySeo($clean_event);

if($eventObj && !$eventObj->isNew() && $eventObj->accessGranted()) {
	define("EVENT_FOR_SINGLEVIEW", TRUE);
	$icmsTpl->assign("event", $eventObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($eventObj->title(), $eventObj->meta_keywords(), $eventObj->meta_description());
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("event_title", _MD_EVENT_ALL_EVENTS);

	$objectTable = new icms_ipf_view_Table($event_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("event_name"));
	$icmsTpl->assign("event_event_table", $objectTable->fetch());
}

$icmsTpl->assign("event_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";