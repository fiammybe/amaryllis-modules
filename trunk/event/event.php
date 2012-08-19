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

$event_event_handler = icms_getModuleHandler("event", basename(dirname(__FILE__)), "event");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_event_id = isset($_GET["event_id"]) ? (int)$_GET["event_id"] : 0 ;
$eventObj = $event_event_handler->get($clean_event_id);

if($eventObj && !$eventObj->isNew()) {
	$icmsTpl->assign("event_event", $eventObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($eventObj->getVar("event_name"), $eventObj->getVar("meta_keywords", "n"), $eventObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("event_title", _MD_EVENT_ALL_EVENTS);

	$objectTable = new icms_ipf_view_Table($event_event_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("event_name"));
	$icmsTpl->assign("event_event_table", $objectTable->fetch());
}

$icmsTpl->assign("event_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";