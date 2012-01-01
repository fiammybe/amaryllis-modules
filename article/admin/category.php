<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /admin/category.php
 * 
 * Add, edit, view and delete categories
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Artikel
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		artikel
 *
 */

/**
 * Edit a Category
 *
 * @param int $category_id Categoryid to be edited
*/
function editcategory($category_id = 0) {
	global $artikel_category_handler, $icmsModule, $icmsAdminTpl;

	$categoryObj = $artikel_category_handler->get($category_id);

	if (!$categoryObj->isNew()){
		$icmsModule->displayAdminMenu(0, _AM_ARTIKEL_CATEGORYS . " > " . _CO_ICMS_EDITING);
		$sform = $categoryObj->getForm(_AM_ARTIKEL_CATEGORY_EDIT, "addcategory");
		$sform->assign($icmsAdminTpl);
	} else {
		$icmsModule->displayAdminMenu(0, _AM_ARTIKEL_CATEGORYS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $categoryObj->getForm(_AM_ARTIKEL_CATEGORY_CREATE, "addcategory");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:artikel_admin_category.html");
}

include_once "admin_header.php";

$artikel_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "artikel");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod", "changedField", "addcategory", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_category_id = isset($_GET["category_id"]) ? (int)$_GET["category_id"] : 0 ;

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
*/
if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editcategory($clean_category_id);
			break;

		case "addcategory":
			$controller = new icms_ipf_Controller($artikel_category_handler);
			$controller->storeFromDefaultForm(_AM_ARTIKEL_CATEGORY_CREATED, _AM_ARTIKEL_CATEGORY_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($artikel_category_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$categoryObj = $artikel_category_handler->get($clean_category_id);
			icms_cp_header();
			$categoryObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(0, _AM_ARTIKEL_CATEGORYS);
			$objectTable = new icms_ipf_view_Table($artikel_category_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("category_title"));
			$objectTable->addIntroButton("addcategory", "category.php?op=mod", _AM_ARTIKEL_CATEGORY_CREATE);
			$icmsAdminTpl->assign("artikel_category_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:artikel_admin_category.html");
			break;
	}
	icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */