<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /footer.php
 * 
 * menu main footer
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$icmsTpl->assign("menu_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/menu.php'>" ._MD_MENU_ADMIN_PAGE . "</a>");
$icmsTpl->assign("menu_is_admin", $menu_isAdmin);
$icmsTpl->assign('menu_url', MENU_URL);
$icmsTpl->assign('menu_images_url', MENU_IMAGES_URL);

$xoTheme->addStylesheet(MENU_URL . 'module' . ((defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? '_rtl' : '') . '.css');

include_once ICMS_ROOT_PATH . '/footer.php';