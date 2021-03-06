<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /admin/menu.php
 * 
 * module ACP menu
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

$i = 0;

$adminmenu[$i]['title'] = _MI_VISITORVOICE_MENU_VISITORVOICE;
$adminmenu[$i]['link'] = 'admin/index.php';

$i++;
$adminmenu[$i]['title'] = _MI_VISITORVOICE_MENU_INDEXPAGE;
$adminmenu[$i]['link'] = 'admin/indexpage.php?op=mod&index_key=1';

global $icmsConfig;
$visitorvoiceModule = icms_getModuleInfo( basename( dirname( dirname( __FILE__) ) ) );
$moddir = basename( dirname( dirname( __FILE__) ) );

$i = 0;
	
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $visitorvoiceModule-> getVar ('mid');
	
	$i++;
	$headermenu[$i]['title'] = _MI_VISITORVOICE_MENU_TEMPLATES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=tplsets&op=listtpl&tplset=' . $icmsConfig['template_set'] . '&moddir=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MI_VISITORVOIVE_MENU_IMPORT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/import.php';
	
	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';
	
	
unset($module_handler);