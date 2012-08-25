<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /blocks/event_list.php
 * 
 * Block holding the events for selected timezone
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

function b_event_list_show($options) {
	global $eventConfig, $xoTheme;
	
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	
	if($options[1] == "curweek") {
		$time = date("d, m, Y", time());
		$end = getWeekRange($time, FALSE);
	} elseif ($options[1] == "week") {
		$end = time() + 60*60*24*7;
	} elseif ($options[1] == "curmonth" ) {
		$end = strtotime('last day of this month'); 
	} elseif ($options[1] == "month") {
		$end = time() + 60*60*24*30;
	} elseif ($options[1] == "day") {
		$time = mktime(23,59,59);
	}
	
	$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
	
	$block['event_list'] = $event_handler->getEvents($options[0], time(), $end, $uid, "event_startdate", "ASC");
	$block['event_url'] = ICMS_MODULES_URL . "/" . EVENT_DIRNAME . "/" ;
	$block['isRTL'] = (defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? 'true' : 'false';
	
	$xoTheme->addStylesheet(ICMS_MODULES_URL . '/' . EVENT_DIRNAME . '/scripts/module_event_blocks.css');
	
	return $block;
}

function b_event_list_edit($options) {
	global $eventConfig, $xoTheme;
	icms_loadCommonLanguageFile("event");
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	
	$catselect = new icms_form_elements_Select('', 'options[0]', $options[0] );
	$catselect->addOptionArray($event_handler->getCategoryList(TRUE));
	
	$timerange = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$timerange->addOptionArray(array("day" => _MB_EVENT_CURRENT_DAY, "curweek" => _MB_EVENT_CURRENT_WEEK, "week" => _CO_EVENT_WEEK, "curmonth" => _MB_EVENT_CURRENT_MONTH, "month" => _CO_EVENT_MONTH));
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td>' . _CO_EVENT_EVENT_EVENT_CID . '</td>';
	$form .= '<td>' . $catselect->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_EVENT_TIMERANGE . '</td>';
	$form .= '<td>' . $timerange->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}

function getWeekRange($day='', $month='', $year='', $start = FALSE) {
	$weekday = date('w', mktime(0,0,0,$month, $day, $year));
	$sunday  = $day - $weekday;
	$start_week = mktime(0,0,0,$month, $sunday, $year);
	$end_week   = mktime(0,0,0,$month, $sunday+6, $year);
	if($start) return $start_week;
	return $end_week;
}