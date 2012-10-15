<?php
/**
 * 'Event' is an event/calendar module for ImpressCMS, which can display google calendars, too
 *
 * File: /admin/menu.php
 * 
 * admin menu for module
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

$i = 0;

$adminmenu[$i]['title'] = _MI_EVENT_MENU_EVENTS ;
$adminmenu[$i]['link'] = 'admin/event.php';

$i++;
$adminmenu[$i]['title'] = _MI_EVENT_MENU_CATEGORY;
$adminmenu[$i]['link'] = 'admin/category.php';

$i++;
$adminmenu[$i]['title'] = _MI_EVENT_MENU_CALENDAR;
$adminmenu[$i]['link'] = 'admin/calendar.php';

global $icmsConfig;
$moddir = basename(dirname(dirname( __FILE__)));
$eventModule = icms_getModuleInfo($moddir);
$i = 0;
	
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $eventModule->getVar('mid');
	
	$i++;
	$headermenu[$i]['title'] = _MI_EVENT_MENU_TEMPLATES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=tplsets&op=listtpl&tplset=' . $icmsConfig['template_set'] . '&moddir=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MI_EVENT_MENU_MANUAL;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/manual.php';

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';
	