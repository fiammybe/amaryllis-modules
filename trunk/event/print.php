<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /print.php
 * 
 * Print file for event module
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

$clean_event = isset($_GET['event']) ? filter_input(INPUT_GET, 'event') : 0;
$clean_print = isset($_GET['print']) ? filter_input(INPUT_GET, 'print') : 'calendar';

$valid_print = array("event", "calendar", "month", "day", "week");

if(in_array($clean_print, $valid_print, TRUE)) {
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
	switch ($clean_print) {
		case 'event':
			$eventObj = $event_handler->getEventBySeo($clean_event);
			if (!$eventObj || !is_object($eventObj) || $eventObj->isNew()) {
				redirect_header(EVENT_URL, 2, "No Event");
			}
			$cid = $eventObj->getVar("event_cid", "e");
			$catObj = $category_handler->get($cid);
			if (!$catObj->accessGranted()){
				redirect_header(EVENT_URL, 3, _NOPERM);
			}
			$icmsTpl = new icms_view_Tpl();
			global $icmsConfig;
			$event = $eventObj->toArray();
			$printtitle = $icmsConfig['sitename']." - ". strip_tags($eventObj->title());
			$version = number_format(icms::$module->getVar('version')/100, 2);
			$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
			$powered_by = "Powered by &nbsp;<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Event</a>";
			$icmsTpl->assign('printtitle', $printtitle);
			$icmsTpl->assign('printlogourl', ICMS_URL . "/" .  $eventConfig['print_logo']);
			$icmsTpl->assign('printfooter', icms_core_DataFilter::undoHtmlSpecialChars($eventConfig['print_footer'] . $powered_by . "&nbsp;" . $version));
			$icmsTpl->assign('event', $event);
			$icmsTpl->display('db:event_print.html');
			break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}