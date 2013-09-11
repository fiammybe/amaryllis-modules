<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/icmspoll.php
 * 
 * Add, edit and delete poll objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

$i = 0;

$adminmenu[$i]['title'] = _MI_ICMSPOLL_MENU_INDEX;
$adminmenu[$i]['link'] = 'admin/index.php';

$i++;
$adminmenu[$i]['title'] = _MI_ICMSPOLL_MENU_POLLS;
$adminmenu[$i]['link'] = 'admin/polls.php';

$i++;
$adminmenu[$i]['title'] = _MI_ICMSPOLL_MENU_OPTIONS;
$adminmenu[$i]['link'] = 'admin/options.php';

$i++;
$adminmenu[$i]['title'] = _MI_ICMSPOLL_MENU_LOG;
$adminmenu[$i]['link'] = 'admin/log.php';

$i++;
$adminmenu[$i]['title'] = _MI_ICMSPOLL_MENU_INDEXPAGE;
$adminmenu[$i]['link'] = 'admin/indexpage.php?op=mod&index_key=1';

global $icmsConfig;
$icmspollModule = icms_getModuleInfo( basename( dirname( dirname( __FILE__) ) ) );
$moddir = basename( dirname( dirname( __FILE__) ) );

$i = 0;
	
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $icmspollModule->getVar('mid');
	
	$i++;
	$headermenu[$i]['title'] = _MI_ICMSPOLL_MENU_TEMPLATES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=tplsets&op=listtpl&tplset=' . $icmsConfig['template_set'] . '&moddir=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MI_ICMSPOLL_MENU_MANUAL;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/manual.php';

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';
	
	
unset($module_handler);