<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /admin/event.php
 * 
 * view, list, add, edit and delete event Objects
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

/**
 * Edit a Event
 *
 * @param int $event_id Eventid to be edited
*/
function editevent($event_id = 0) {
	global $event_handler, $icmsModule, $icmsAdminTpl;

	$eventObj = $event_handler->get($event_id);

	if (!$eventObj->isNew()){
		$icmsModule->displayAdminMenu(0, _AM_EVENT_EVENTS . " > " . _CO_ICMS_EDITING);
		$sform = $eventObj->getForm(_AM_EVENT_EVENT_EDIT, "addevent");
		$sform->assign($icmsAdminTpl);
	} else {
		$eventObj->setVar("event_enddate", time()+120*60);
		$eventObj->setVar("event_submitter", icms::$user->getVar("uid"));
		$eventObj->setVar("event_created_on", time() - 100);
		$icmsModule->displayAdminMenu(0, _AM_EVENT_EVENTS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $eventObj->getForm(_AM_EVENT_EVENT_CREATE, "addevent");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:event_admin.html");
}

include_once "admin_header.php";

$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
if(!$category_handler->getCount()) redirect_header(EVENT_ADMIN_URL . "category.php", 3, _AM_EVENT_NO_CATEGORY_FOUND);

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ("mod", "changedField", "addevent", "del", "view", "");

$event_handler = icms_getModuleHandler("event", basename(dirname(dirname(__FILE__))), "event");

$clean_event_id = isset($_GET["event_id"]) ? filter_input(INPUT_GET, "event_id", FILTER_SANITIZE_NUMBER_INT) : 0;

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
*/
if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editevent($clean_event_id);
			break;

		case "addevent":
			$controller = new icms_ipf_Controller($event_handler);
			$controller->storeFromDefaultForm(_AM_EVENT_EVENT_CREATED, _AM_EVENT_EVENT_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($event_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$eventObj = $event_handler->get($clean_event_id);
			icms_cp_header();
			$eventObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(0, _AM_EVENT_EVENTS);
			$objectTable = new icms_ipf_view_Table($event_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("event_name"));
			$objectTable->addIntroButton("addevent", "event.php?op=mod", _AM_EVENT_EVENT_CREATE);
			$icmsAdminTpl->assign("event_event_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:event_admin.html");
			break;
	}
	include_once 'admin_footer.php';
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */