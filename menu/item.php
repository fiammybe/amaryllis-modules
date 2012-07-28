<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /items.php
 * 
 * add, edit and delete menu items
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

$xoopsOption["template_main"] = "menu_items.html";
include_once ICMS_ROOT_PATH . "/header.php";

$menu_items_handler = icms_getModuleHandler("items", basename(dirname(__FILE__)), "menu");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_items_id = isset($_GET["items_id"]) ? (int)$_GET["items_id"] : 0 ;
$itemsObj = $menu_items_handler->get($clean_items_id);

if($itemsObj && !$itemsObj->isNew()) {
	$icmsTpl->assign("menu_items", $itemsObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($itemsObj->getVar("item_name"), $itemsObj->getVar("meta_keywords", "n"), $itemsObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("menu_title", _MD_MENU_ALL_ITEMSS);

	$objectTable = new icms_ipf_view_Table($menu_items_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("item_name"));
	$icmsTpl->assign("menu_items_table", $objectTable->fetch());
}

$icmsTpl->assign("menu_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";