<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
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

function b_event_select_show($options) {
	global $eventConfig, $xoTheme;
	
	$block['event_form'] = getSelectForm($options);
	$block['event_url'] = ICMS_MODULES_URL . "/" . EVENT_DIRNAME . "/" ;
	$block['isRTL'] = (defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? 'true' : 'false';
	
	$xoTheme->addStylesheet(ICMS_MODULES_URL . '/' . EVENT_DIRNAME . '/scripts/module_event_blocks.css');
	
	return $block;
}

function b_event_select_edit($options) {
	global $eventConfig, $icmsTheme;
	
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	
	$catselect = new icms_form_elements_Select('', 'options[0]', $options[0] );
	$catselect->addOptionArray($event_handler->getCategoryList(TRUE));
	
	$zipselect = new icms_form_elements_Radioyn(_MB_EVENT_DISPLAY_PLZ, 'options[1]', $options[1]);
	$cityselect = new icms_form_elements_Radioyn(_MB_EVENT_DISPLAY_CITY, 'options[2]', $options[2]);
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td>' . _CO_EVENT_EVENT_EVENT_CID . '</td>';
	$form .= '<td>' . $catselect->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_EVENT_DISPLAY_PLZ . '</td>';
	$form .= '<td>' . $zipselect->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_EVENT_DISPLAY_CITY . '</td>';
	$form .= '<td>' . $cityselect->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}

function getSelectForm($options) {
	$form = new icms_form_Simple("", "event_select", ICMS_MODULES_URL."/".EVENT_DIRNAME."/blocks/event_block.php", "post");
	$field = new icms_form_elements_Text("Start", "range_start", 10, 25, date("d/m/Y"));
	$form->addElement($field);
	$form->addElement(new icms_form_elements_Text("End", "range_end", 10, 25, date("d/m/Y")));
	if($options[0] > 0) {
		$form->addElement(new icms_form_elements_Hidden("range_category", $options[0]));
	} else {
		$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
		$cat_array = $event_handler->getCategoryList();
		$first = array_shift($cat_array);
		$cat = new icms_form_elements_Select("", "range_category", $first);
		$cat->addOptionArray($event_handler->getCategoryList());
		$form->addElement($cat);
	}
	if($options[1] == 1) {
		$zip = new icms_form_elements_Select(_MB_EVENT_PLZ, "b_event_zip", 0);
		$zip->addOptionArray($event_handler->filterZip());
		$form->addElement($zip);
	}
	if($options[2] == 1) {
		$city = new icms_form_elements_Select(_MB_EVENT_CITY, "b_event_city", 0);
		$city->addOptionArray($event_handler->filterCity());
		$form->addElement($city);
	}
	return $form->render();
}