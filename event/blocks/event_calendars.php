<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /blocks/event_calendars.php
 * 
 * Block holding the events for selected timezone
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

function b_event_calendars_show($options) {
	global $xoTheme;
	include_once ICMS_ROOT_PATH.'/modules/'.EVENT_DIRNAME.'/include/common.php';
	if($options[0] == 0 || $options[0] == 2) {
		$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
		$block['categories'] = $category_handler->getCategories("cat_view");
	}
	if($options[0] == 0 || $options[0] == 1) {
		$calendar_handler = icms_getModuleHandler("calendar", EVENT_DIRNAME, "event");
		$block['calendars'] = $calendar_handler->getObjects(FALSE, TRUE, FALSE);
	}
	$block['event_url'] = ICMS_URL.'/modules/'.EVENT_DIRNAME.'/';
	$xoTheme->addScript('/modules/' . EVENT_DIRNAME . '/scripts/jquery.qtip.min.js', array('type' => 'text/javascript'));
	$xoTheme->addStylesheet(ICMS_MODULES_URL . '/' . EVENT_DIRNAME . '/scripts/module_event_blocks.css');
	$xoTheme->addStylesheet(ICMS_MODULES_URL . '/' . EVENT_DIRNAME . '/scripts/jquery.qtip.min.css');
	return $block;
}

function b_event_calendars_edit($options) {
	include_once ICMS_ROOT_PATH.'/modules/'.EVENT_DIRNAME.'/include/common.php';
	$sel = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$sel->addOptionArray(array(0 => _MB_EVENT_BOTH, 1 => _MB_EVENT_CALENDAR, 2 => _MB_EVENT_CATEGORY));
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td width="30%">'._MB_EVENT_DISPLAY.'</td>';
	$form .= '<td>'.$sel->render().'</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}