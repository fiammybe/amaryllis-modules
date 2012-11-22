<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /include/waiting.plugin.php
 * 
 * waiting block plugin for system waiting block
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

function b_waiting_event() {
	$module = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME);
	$category_handler = icms_getModuleHandler("category", $module->getVar("dirname"), "event");
	$event_handler = icms_getModuleHandler("event", $module->getVar("dirname"), "event");
	icms_loadLanguageFile("event", "common");
	$ret = array();
	// category approval
	$block = array();
	$approved = new icms_db_criteria_Compo(new icms_db_criteria_Item("category_approve", 0));
	$result = $category_handler->getCount($approved);
	if ($result > 0) {
		$block['adminlink'] = ICMS_MODULES_URL . "/" . EVENT_DIRNAME . "/admin/category.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _CO_EVENT_CATEGORY_APPROVE ;
		$ret[] = $block;
	}
	
	// event approval
	$block = array();
	$approve = new icms_db_criteria_Compo(new icms_db_criteria_Item("event_approve", 0));
	$result = $event_handler->getCount($approve);
	if ($result > 0) {
		$block['adminlink'] = ICMS_MODULES_URL . "/" . EVENT_DIRNAME . "/admin/event.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _CO_EVENT_EVENT_APPROVE;
		$ret[] = $block;
	}
	unset($module, $event_handler, $category_handler);
	return $ret;
}
