<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/admin_menu.php
 *
 * holds module ACP-Menu
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

$i = 0;
$adminmenu[$i]['title'] = _MI_TOOLS_MENU_INDEX;
$adminmenu[$i]['link'] = 'admin/index.php';
$adminmenu[$i]['icon'] = 'images/info_big.png';
$adminmenu[$i]['small'] = 'images/info_small.png';
$i++;
$adminmenu[$i]['title'] = _MI_TOOLS_MENU_TOOLS;
$adminmenu[$i]['link'] = 'admin/tools.php';
$adminmenu[$i]['icon'] = 'images/tools_big.png';
$adminmenu[$i]['small'] = 'images/tools_small.png';
$i++;
$adminmenu[$i]['title'] = _MI_TOOLS_MENU_BACKUP;
$adminmenu[$i]['link'] = 'admin/backup.php';
$adminmenu[$i]['icon'] = 'images/backup_big.png';
$adminmenu[$i]['small'] = 'images/backup_small.png';
$i++;
$adminmenu[$i]['title'] = _MI_TOOLS_MENU_MODULESADD;
$adminmenu[$i]['link'] = 'admin/modulesadd.php';
$adminmenu[$i]['icon'] = 'images/modules_big.png';
$adminmenu[$i]['small'] = 'images/modules_small.png';

$moddir = basename(dirname(dirname(__FILE__)));
$module = icms::handler("icms_module")->getByDirname($moddir);

global $icmsConfig;
$i = 0;
$i++;
$headermenu[$i]['title'] = _PREFERENCES;
$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $module->getVar('mid');
$i++;
$headermenu[$i]['title'] = "phpinfo";
$headermenu[$i]['link'] = ICMS_URL.'/modules/'.$moddir.'/admin/phpinfo.php';
$i++;
$headermenu[$i]['title'] = _MI_TOOLS_MENU_MANUAL;
$headermenu[$i]['link'] = ICMS_URL.'/modules/'.$moddir.'/admin/manual.php';

$i++;
$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
$headermenu[$i]['link'] = ICMS_URL.'/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;

$i++;
$headermenu[$i]['title'] = _MODABOUT_ABOUT;
$headermenu[$i]['link'] = ICMS_URL.'/modules/'.$moddir.'/admin/about.php';

unset($module_handler, $module);