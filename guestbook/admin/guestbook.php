<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /admin/guestbook.php
 * 
 * List, edit and delete Guestbook guestbook objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

/**
 * Edit a Guestbook
 *
 * @param int $guestbook_id Guestbookid to be edited
*/
function editguestbook($guestbook_id = 0) {
	global $guestbook_guestbook_handler, $icmsModule, $icmsAdminTpl;

	$guestbookObj = $guestbook_guestbook_handler->get($guestbook_id);

	if (!$guestbookObj->isNew()){
		$icmsModule->displayAdminMenu(0, _MI_GUESTBOOK_MENU_GUESTBOOK . " > " . _CO_ICMS_EDITING);
		$sform = $guestbookObj->getForm(_AM_GUESTBOOK_EDIT, "addguestbook");
		$sform->assign($icmsAdminTpl);
	} else {
		redirect_header(GUESTBOOK_ADMIN_URL, 3, _NO_PERM);
	}
	$icmsAdminTpl->display("db:guestbook_admin.html");
}

include_once "admin_header.php";

$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(dirname(__FILE__))), "guestbook");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod","changedField", "addguestbook","changeApprove", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_guestbook_id = isset($_GET["guestbook_id"]) ? (int)$_GET["guestbook_id"] : 0 ;

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
			editguestbook($clean_guestbook_id);
			break;

		case "addguestbook":
			$controller = new icms_ipf_Controller($guestbook_guestbook_handler);
			$controller->storeFromDefaultForm(_AM_GUESTBOOK_GUESTBOOK_CREATED, _AM_GUESTBOOK_GUESTBOOK_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($guestbook_guestbook_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$guestbookObj = $guestbook_guestbook_handler->get($clean_guestbook_id);
			icms_cp_header();
			$guestbookObj->displaySingleObject();
			break;

		case 'changeApprove':
			$approve = $guestbook_guestbook_handler -> changeApprove( $clean_guestbook_id );
			$ret = 'guestbook.php';
			if ($approve == 0) {
				redirect_header( GUESTBOOK_ADMIN_URL . $ret, 2, _AM_GUESTBOOK_APPROVE_FALSE );
			} else {
				redirect_header( GUESTBOOK_ADMIN_URL . $ret, 2, _AM_GUESTBOOK_APPROVE_TRUE );
			}
			break;
			
		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(0, _MI_GUESTBOOK_MENU_GUESTBOOK);
			$criteria = "";
			if(empty($criteria)){
				$criteria = NULL;
			}
			
			$objectTable = new icms_ipf_view_Table($guestbook_guestbook_handler, $criteria);
			$objectTable->addColumn(new icms_ipf_view_Column("guestbook_approve", "center", 50, "guestbook_approve"));
			$objectTable->addColumn(new icms_ipf_view_Column("guestbook_title"));
			if($guestbookConfig["use_moderation"] == 1) {
				$objectTable->addColumn(new icms_ipf_view_Column("guestbook_pid", 'center', 100, "guestbook_pid"));
			}
			$objectTable->addColumn(new icms_ipf_view_Column("guestbook_name"));
			$objectTable->addColumn(new icms_ipf_view_Column("guestbook_url"));
			$objectTable->addColumn(new icms_ipf_view_Column("guestbook_published_date", FALSE, FALSE, "getPublishedDate" ));
			$objectTable->setDefaultSort("guestbook_published_date");
			$objectTable->setDefaultOrder("DESC");
			$icmsAdminTpl->assign("guestbook_guestbook_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:guestbook_admin.html");
			break;
	}
	icms_cp_footer();
}