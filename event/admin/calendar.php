<?php
/**
 * 'Event' is an event/calendar module for ImpressCMS, which can display google calendars, too
 *
 * File: /admin/calendar.php
 * 
 * view, list, add, edit and delete calendar Objects
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

/**
 * Edit a Calendar
 *
 * @param int $calendar_id Calendarid to be edited
*/
function editcalendar($calendar_id = 0) {
	global $calendar_handler, $icmsAdminTpl;

	$calendarObj = $calendar_handler->get($calendar_id);

	if (!$calendarObj->isNew()){
		icms::$module->displayAdminMenu(2, _AM_EVENT_CALENDARS . " > " . _CO_ICMS_EDITING);
		$sform = $calendarObj->getForm(_AM_EVENT_CALENDAR_EDIT, "addcalendar");
		$sform->assign($icmsAdminTpl);
	} else {
		icms::$module->displayAdminMenu(2, _AM_EVENT_CALENDARS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $calendarObj->getForm(_AM_EVENT_CALENDAR_CREATE, "addcalendar");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:event_admin.html");
}

include_once "admin_header.php";

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ("mod", "changedField", "addcalendar", "del", "view", "changeApprove", "");

$calendar_handler = icms_getModuleHandler("calendar", basename(dirname(dirname(__FILE__))), "event");

$clean_calendar_id = isset($_GET["calendar_id"]) ? filter_input(INPUT_GET, "calendar_id", FILTER_SANITIZE_NUMBER_INT) : 0;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editcalendar($clean_calendar_id);
			break;

		case "addcalendar":
			$controller = new icms_ipf_Controller($calendar_handler);
			$controller->storeFromDefaultForm(_AM_EVENT_CALENDAR_CREATED, _AM_EVENT_CALENDAR_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($calendar_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$calendarObj = $calendar_handler->get($clean_calendar_id);
			icms_cp_header();
			$calendarObj->displaySingleObject();
			break;
			
		case 'changeApprove':
			$approve = $calendar_handler->changeField($clean_calendar_id, "calendar_active");
			$red_message = ($approve == 0) ? _AM_EVENT_EVENT_DENIED : _AM_EVENT_EVENT_APPROVED;
			redirect_header(EVENT_ADMIN_URL . 'calendar.php', 2, $red_message);
			break;
			
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(2, _AM_EVENT_CALENDARS);
			$objectTable = new icms_ipf_view_Table($calendar_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("calendar_active", "center", 50,"calendar_active"));
			$objectTable->addColumn(new icms_ipf_view_Column("calendar_name", FALSE, FALSE,"getItemLink"));
			$objectTable->addColumn(new icms_ipf_view_Column("calendar_url", FALSE, FALSE,''));
			$objectTable->addColumn(new icms_ipf_view_Column("calendar_tz", FALSE, FALSE,''));
			$objectTable->addColumn(new icms_ipf_view_Column("calendar_color", "center", 150, "calendar_color" ));
			$objectTable->addColumn(new icms_ipf_view_Column("calendar_txtcolor", "center", 150, "calendar_txtcolor"));
			$objectTable->addIntroButton("addcalendar", "calendar.php?op=mod", _AM_EVENT_CALENDAR_CREATE);
			$icmsAdminTpl->assign("event_calendar_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:event_admin.html");
			break;
	}
	include_once 'admin_footer.php';
} else {
	redirect_header(EVENT_ADMIN_URL . "index.php", 3, _NOPERM);
}