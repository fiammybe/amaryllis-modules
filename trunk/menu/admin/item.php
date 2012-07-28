<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /admin/item.php
 * 
 * add, edit and delete item objects
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

function edititem($item_id = 0, $menu_id = 0) {
	global $item_handler, $icmsModule, $icmsAdminTpl;

	$itemObj = $item_handler->get($item_id);

	if (!$itemObj->isNew()){
		icms::$module->displayAdminMenu(1, _MI_MENU_MENU_ITEM . " > " . _CO_ICMS_EDITING);
		$sform = $itemObj->getForm(_CO_ICMS_EDITING, "additem", "item.php?op=additem&item_id=" . $itemObj->id(), _CO_ICMS_SUBMIT, "location.href='item.php'");
		$sform->assign($icmsAdminTpl);
	} else {
		icms::$module->displayAdminMenu(1, _MI_MENU_MENU_ITEM . " > " . _CO_ICMS_CREATINGNEW);
		$itemObj->setVar("item_menu", $menu_id);
		$sform = $itemObj->getForm(_CO_ICMS_CREATINGNEW, "additem", "item.php?op=additem&menu_id=" . $menu_id, _CO_ICMS_SUBMIT, "location.href='item.php'");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:menu_admin.html");
}

include_once "admin_header.php";

$menu_handler = icms_getModuleHandler("menu", MENU_DIRNAME, "menu");
$count = $menu_handler->getCount(FALSE);
if(!$count > 0) redirect_header(MENU_ADMIN_URL, 3, _AM_MENU_NO_MENUS_FOUND);

$valid_op = array ("mod", "changedField", "additem", "del", "visible", "changeWeight", "");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_item_id = isset($_GET["item_id"]) ? filter_input(INPUT_GET, "item_id", FILTER_SANITIZE_NUMBER_INT) : 0 ;
$clean_menu_id = isset($_GET["menu_id"]) ? filter_input(INPUT_GET, "menu_id", FILTER_SANITIZE_NUMBER_INT) : FALSE ;

$item_handler = icms_getModuleHandler("item", MENU_DIRNAME, "menu");

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			edititem($clean_item_id, $clean_menu_id);
			break;

		case "additem":
			$itemObj = $item_handler->get($clean_item_id);
			if(is_object($itemObj) && !$itemObj->isNew() ) {
				$redirect_page = MENU_ADMIN_URL . "item.php";
			} else {
				$redirect_page = MENU_ADMIN_URL . "item.php?op=mod&menu_id=" . $clean_menu_id;
			}
			$controller = new icms_ipf_Controller($item_handler);
			$controller->storeFromDefaultForm(_AM_MENU_ITEM_CREATED, _AM_MENU_ITEM_MODIFIED, $redirect_page);
			break;

		case "del":
			$controller = new icms_ipf_Controller($item_handler);
			$controller->handleObjectDeletion();
			break;

		case 'changeWeight':
			foreach ($_POST['MenuItem_objects'] as $key => $value) {
				$changed = FALSE;
				$itemObj = $item_handler->get($value);

				if ($itemObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$itemObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$item_handler->insert($itemObj);
				}
			}
			$ret = 'item.php';
			redirect_header( MENU_ADMIN_URL . $ret, 2, _AM_MENU_WEIGHT_UPDATED);
			break;

		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(1, _MI_MENU_MENU_ITEM);
			$objectTable = new icms_ipf_view_Table($item_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("item_active", "center", 50, "item_active"));
			$objectTable->addColumn(new icms_ipf_view_Column("item_image", "center", 100, "getImgPreview"));
			$objectTable->addColumn(new icms_ipf_view_Column("item_name"));
			$objectTable->addColumn(new icms_ipf_view_Column("item_menu", FALSE, FALSE, "getItemMenu"));
			$objectTable->addColumn(new icms_ipf_view_Column("item_pid", FALSE, FALSE, "getParentItem"));
			$objectTable->addColumn(new icms_ipf_view_Column("weight", "center", 50, "getWeightControl"));
			
			$objectTable->addIntroButton("additem", "item.php?op=mod", _ADD);
			$objectTable->addFilter("item_active", "filterActive");
			$objectTable->addFilter("item_menu", "filterMenu");
			
			$objectTable->addActionButton('changeWeight', FALSE, _SUBMIT);
			
			$icmsAdminTpl->assign("menu_item_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:menu_admin.html");
			break;
	}
	include_once 'admin_footer.php';
}