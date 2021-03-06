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

$adminmenu[$i]['title'] = _MI_ALBUM_MENU_INDEX;
$adminmenu[$i]['link'] = 'admin/index.php';
$adminmenu[$i]['icon'] = 'images/album_icon.png';
$adminmenu[$i]['small'] = 'images/icons/album_icon_small.png';
$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_ALBUM;
$adminmenu[$i]['link'] = 'admin/album.php';
$adminmenu[$i]['icon'] = 'images/add_cat.png';
$adminmenu[$i]['small'] = 'images/icons/add_cat.png';
$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_IMAGES;
$adminmenu[$i]['link'] = 'admin/images.php';
$adminmenu[$i]['icon'] = 'images/add_img.png';
$adminmenu[$i]['small'] = 'images/icons/add_img.png';
$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_MESSAGE;
$adminmenu[$i]['link'] = 'admin/message.php';

$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_BATCHUPLOAD;
$adminmenu[$i]['link'] = 'admin/batchupload.php';
$adminmenu[$i]['icon'] = 'images/add_zip.png';
$adminmenu[$i]['small'] = 'images/icons/add_zip.png';
$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_INDEXPAGE;
$adminmenu[$i]['link'] = 'admin/indexpage.php?op=mod&indexkey=1';
$adminmenu[$i]['icon'] = 'images/indexpage_big.png';
$adminmenu[$i]['small'] = 'images/icons/indexpage_small.png';
$i++;
$adminmenu[$i]['title'] = _MI_ALBUM_MENU_PERMISSIONS;
$adminmenu[$i]['link'] = 'admin/permissions.php';

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
	$headermenu[$i]['title'] = _MI_ALBUM_MENU_MANUAL;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/manual.php';

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';

unset($module_handler);