<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /blocks/event_mincal.php
 * 
 * Block holding the minicalendar for index calendar
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

function b_event_mincal_show($options) {
	global $eventConfig, $xoTheme;
	
	$block['event_url'] = ICMS_MODULES_URL . "/" . EVENT_DIRNAME . "/" ;
	$block['isRTL'] = (defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? 'true' : 'false';
	return $block;
}

function b_event_mincal_edit($options) {
	global $eventConfig, $xoTheme;
	$form = "";
	return $form;
}