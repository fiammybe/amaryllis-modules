<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /admin/menu.php
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

function editmenu($menu_id = 0) {
	global $menu_handler, $icmsAdminTpl;

	$menuObj = $menu_handler->get($menu_id);

	if (!$menuObj->isNew()){
		icms::$module->displayAdminMenu(0, _MI_MENU_MENU_MENU . " > " . _CO_ICMS_EDITING);
		$sform = $menuObj->getForm(_CO_ICMS_EDITING, "addmenu");
		$sform->assign($icmsAdminTpl);
	} else {
		icms::$module->displayAdminMenu(0, _MI_MENU_MENU_MENU . " > " . _CO_ICMS_CREATINGNEW);
		$menuObj->setVar("item_menu", $menu_id);
		$sform = $menuObj->getForm(_CO_ICMS_CREATINGNEW, "addmenu");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:menu_admin.html");
}

include_once "admin_header.php";

$valid_op = array ("mod", "changedField", "addmenu", "del", "");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$clean_menu_id = isset($_GET["menu_id"]) ? filter_input(INPUT_GET, "menu_id", FILTER_SANITIZE_NUMBER_INT) : FALSE ;

$menu_handler = icms_getModuleHandler("menu", MENU_DIRNAME, "menu");

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editmenu($clean_menu_id);
			break;

		case "addmenu":
			$sql = "SHOW TABLE STATUS WHERE name='" . $menu_handler->table . "'";
			$result = icms::$xoopsDB->queryF($sql);
			$row = icms::$xoopsDB->fetchBoth($result);
			$menu_id = $row['Auto_increment'];
			if(!empty($clean_menu_id)) {
				$menu_id = $clean_menu_id;
			}
			$menuObj = $menu_handler->get($menu_id);
			if(is_object($menuObj) && !$menuObj->isNew()) {
				$redirect_page = MENU_ADMIN_URL . "menu.php";
			} else {
				$redirect_page = MENU_ADMIN_URL . "item.php?op=mod&menu_id=" . $menu_id;
			}
			$controller = new icms_ipf_Controller($menu_handler);
			$controller->storeFromDefaultForm(_AM_MENU_MENU_CREATED, _AM_MENU_MENU_MODIFIED, $redirect_page);
			break;

		case "del":
			$controller = new icms_ipf_Controller($menu_handler);
			$controller->handleObjectDeletion();
			break;

		case "visible" :
			$menuObj = $menu_handler->get($clean_menu_id);
			icms_cp_header();
			$menuObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(0, _MI_MENU_MENU_ITEM);
			$objectTable = new icms_ipf_view_Table($menu_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("menu_name"));
			$objectTable->addColumn(new icms_ipf_view_Column("menu_kind", FALSE, FALSE, "getMenuKind"));
			$objectTable->addColumn(new icms_ipf_view_Column("menu_images", FALSE, FALSE, "getMenuImgDisplay"));
			
			$objectTable->addIntroButton("addmenu", "menu.php?op=mod", _ADD);
			
			$icmsAdminTpl->assign("menu_menu_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:menu_admin.html");
			break;
	}
	include_once 'admin_footer.php';
}