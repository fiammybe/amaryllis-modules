<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /admin/menu.php
 * 
 * module ACP menu
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

$i = 0;

$adminmenu[$i]['title'] = _MI_DOWNLOADS_MENU_INDEX;
$adminmenu[$i]['link'] = 'admin/index.php';

$i++;
$adminmenu[$i]['title'] = _MI_DOWNLOADS_MENU_DOWNLOAD;
$adminmenu[$i]['link'] = 'admin/download.php';

$i++;
$adminmenu[$i]['title'] = _MI_DOWNLOADS_MENU_CATEGORY;
$adminmenu[$i]['link'] = 'admin/category.php';

$i++;
$adminmenu[$i]['title'] = _MI_DOWNLOADS_MENU_INDEXPAGE;
$adminmenu[$i]['link'] = 'admin/indexpage.php?op=mod&indexkey=1';

$i++;
$adminmenu[$i]['title'] = _MI_DOWNLOADS_MENU_REVIEW;
$adminmenu[$i]['link'] = 'admin/review.php';

$i++;
$adminmenu[$i]['title'] = _MI_DOWNLOADS_MENU_PERMISSIONS;
$adminmenu[$i]['link'] = 'admin/permissions.php';

global $icmsConfig;
$downloadsModule = icms_getModuleInfo( basename( dirname( dirname( __FILE__) ) ) );
$moddir = basename( dirname( dirname( __FILE__) ) );

$i = 0;
	
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/';

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $downloadsModule-> getVar ('mid');
	
	$i++;
	$headermenu[$i]['title'] = _MI_DOWNLOADS_MENU_TEMPLATES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=tplsets&op=listtpl&tplset=' . $icmsConfig['template_set'] . '&moddir=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;
	
	$i++;
	$headermenu[$i]['title'] = _MI_DOWNLOADS_MENU_IMPORT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/import.php';
	
	$i++;
	$headermenu[$i]['title'] = _MI_DOWNLOADS_MENU_MANUAL;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/manual.php';

	$i++;
	$headermenu[$i]['title'] = _MI_DOWNLOADS_MENU_LOG;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/log.php';
	
	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';
	
	
unset($module_handler);