<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/menu.php
 * 
 * Menu structure in ACP
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

icms_loadLanguageFile("album", "modinfo");

$i = 0;

$adminmenu[$i]['title'] = _MI_ALBUM_MENU_ALBUM;
$adminmenu[$i]['link'] = 'admin/album.php';

$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_IMAGES;
$adminmenu[$i]['link'] = 'admin/images.php';

$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_INDEXPAGE;
$adminmenu[$i]['link'] = 'admin/indexpage.php?op=mod&indexkey=1';


global $icmsConfig;
$albumModule = icms_getModuleInfo( basename( dirname( dirname( __FILE__) ) ) );
$moddir = basename( dirname( dirname( __FILE__) ) );

$i = 0;
	
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $albumModule-> getVar ('mid');
	
	$i++;
	$headermenu[$i]['title'] = _MI_ALBUM_MENU_TEMPLATES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=tplsets&op=listtpl&tplset=' . $icmsConfig['template_set'] . '&moddir=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';
	
	
unset($module_handler);