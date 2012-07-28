<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /menu.php
 * 
 * add, edit and delete menu objects
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

include_once "header.php";

$xoopsOption["template_main"] = "menu_menu.html";
include_once ICMS_ROOT_PATH . "/header.php";

$menu_menu_handler = icms_getModuleHandler("menu", basename(dirname(__FILE__)), "menu");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_menu_id = isset($_GET["menu_id"]) ? (int)$_GET["menu_id"] : 0 ;
$menuObj = $menu_menu_handler->get($clean_menu_id);

if($menuObj && !$menuObj->isNew()) {
	$icmsTpl->assign("menu_menu", $menuObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($menuObj->getVar("menu_name"), $menuObj->getVar("meta_keywords", "n"), $menuObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("menu_title", _MD_MENU_ALL_MENUS);

	$objectTable = new icms_ipf_view_Table($menu_menu_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("menu_name"));
	$icmsTpl->assign("menu_menu_table", $objectTable->fetch());
}

$icmsTpl->assign("menu_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";