<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /admin/acp_menu.php
 *
 * ACP Menu of the module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */

$i = 0;

$adminmenu[$i]['title'] = _MI_MENU_MENU_MENU;
$adminmenu[$i]['link'] = 'admin/menu.php';

$i++;
$adminmenu[$i]['title'] = _MI_MENU_MENU_ITEM;
$adminmenu[$i]['link'] = 'admin/item.php';

global $icmsConfig;
$moddir = basename(dirname(dirname( __FILE__)));
//$menuModule = icms_getModuleInfo($moddir);
$i = 0;
$i++;
$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;
$i++;
$headermenu[$i]['title'] = _MODABOUT_ABOUT;
$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';