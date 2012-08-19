<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /admin/category.php
 * 
 * view, list, add, edit and delete category Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

/**
 * Edit a Category
 *
 * @param int $category_id Categoryid to be edited
*/
function editcategory($category_id = 0) {
	global $category_handler, $icmsModule, $icmsAdminTpl;

	$categoryObj = $category_handler->get($category_id);

	if (!$categoryObj->isNew()){
		$icmsModule->displayAdminMenu(1, _AM_EVENT_CATEGORYS . " > " . _CO_ICMS_EDITING);
		$sform = $categoryObj->getForm(_AM_EVENT_CATEGORY_EDIT, "addcategory");
		$sform->assign($icmsAdminTpl);
	} else {
		$categoryObj->setVar("category_created_on", time() - 100);
		$categoryObj->setVar("category_submitter", icms::$user->getVar("uid"));
		$icmsModule->displayAdminMenu(1, _AM_EVENT_CATEGORYS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $categoryObj->getForm(_AM_EVENT_CATEGORY_CREATE, "addcategory");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:event_admin.html");
}

include_once "admin_header.php";

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ("mod", "changedField", "addcategory", "del", "view", "");

$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");

$clean_category_id = isset($_GET["category_id"]) ? filter_input(INPUT_GET, "category_id", FILTER_SANITIZE_NUMBER_INT) : 0;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editcategory($clean_category_id);
			break;

		case "addcategory":
			$controller = new icms_ipf_Controller($category_handler);
			$controller->storeFromDefaultForm(_AM_EVENT_CATEGORY_CREATED, _AM_EVENT_CATEGORY_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($category_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$categoryObj = $category_handler->get($clean_category_id);
			icms_cp_header();
			$categoryObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(1, _AM_EVENT_CATEGORYS);
			$objectTable = new icms_ipf_view_Table($category_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("category_name"));
			$objectTable->addIntroButton("addcategory", "category.php?op=mod", _AM_EVENT_CATEGORY_CREATE);
			$icmsAdminTpl->assign("event_category_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:event_admin.html");
			break;
	}
	include_once 'admin_footer.php';
} else {
	redirect_header(EVENT_ADMIN_URL . "category.php", 3, _NOPERM);
}