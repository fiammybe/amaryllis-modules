<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /admin/menu.php
 * 
 * ACP Menu of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

$i = 0;

$adminmenu[$i]['title'] = _MI_PORTFOLIO_MENU_PORTFOLIO;
$adminmenu[$i]['link'] = 'admin/portfolio.php';

$i++;
$adminmenu[$i]['title'] = _MI_PORTFOLIO_MENU_CATEGORY;
$adminmenu[$i]['link'] = 'admin/category.php';

$i++;
$adminmenu[$i]['title'] = _MI_PORTFOLIO_MENU_CONTACT;
$adminmenu[$i]['link'] = 'admin/contact.php';

$i++;
$adminmenu[$i]['title'] = _MI_PORTFOLIO_MENU_INDEXPAGE;
$adminmenu[$i]['link'] = 'admin/indexpage.php?op=mod&index_id=1';

global $icmsConfig;
$portfolioModule = icms_getModuleInfo(basename(dirname(dirname(__FILE__))));
$moddir = basename(dirname(dirname(__FILE__)));

$i = 0;
	
	$headermenu[$i]['title'] = _CO_ICMS_GOTOMODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $portfolioModule->getVar('mid');
	
	$i++;
	$headermenu[$i]['title'] = _MI_PORTFOLIO_MENU_TEMPLATES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=tplsets&op=listtpl&tplset=' . $icmsConfig['template_set'] . '&moddir=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _CO_ICMS_UPDATE_MODULE;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $moddir;

	$i++;
	$headermenu[$i]['title'] = _MODABOUT_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $moddir . '/admin/about.php';
	
unset($module_handler);