<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /admin/visitorvoice.php
 * 
 * List, edit and delete Visitorvoice visitorvoice objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

/**
 * Edit a Visitorvoice
 *
 * @param int $visitorvoice_id Visitorvoiceid to be edited
*/
function editvisitorvoice($visitorvoice_id = 0) {
	global $visitorvoice_visitorvoice_handler, $icmsModule, $icmsAdminTpl;

	$visitorvoiceObj = $visitorvoice_visitorvoice_handler->get($visitorvoice_id);

	if (!$visitorvoiceObj->isNew()){
		$icmsModule->displayAdminMenu(0, _MI_VISITORVOICE_MENU_VISITORVOICE . " > " . _CO_ICMS_EDITING);
		$sform = $visitorvoiceObj->getForm(_AM_VISITORVOICE_EDIT, "addvisitorvoice");
		$sform->assign($icmsAdminTpl);
	} else {
		redirect_header(VISITORVOICE_ADMIN_URL, 3, _NO_PERM);
	}
	$icmsAdminTpl->display("db:visitorvoice_admin.html");
}

include_once "admin_header.php";

$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", basename(dirname(dirname(__FILE__))), "visitorvoice");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod","changedField", "addvisitorvoice","changeApprove", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_visitorvoice_id = isset($_GET["visitorvoice_id"]) ? (int)$_GET["visitorvoice_id"] : 0 ;

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
			editvisitorvoice($clean_visitorvoice_id);
			break;

		case "addvisitorvoice":
			$controller = new icms_ipf_Controller($visitorvoice_visitorvoice_handler);
			$controller->storeFromDefaultForm(_AM_VISITORVOICE_VISITORVOICE_CREATED, _AM_VISITORVOICE_VISITORVOICE_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($visitorvoice_visitorvoice_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$visitorvoiceObj = $visitorvoice_visitorvoice_handler->get($clean_visitorvoice_id);
			icms_cp_header();
			$visitorvoiceObj->displaySingleObject();
			break;

		case 'changeApprove':
			$approve = $visitorvoice_visitorvoice_handler -> changeApprove( $clean_visitorvoice_id );
			$ret = 'visitorvoice.php';
			if ($approve == 0) {
				redirect_header( VISITORVOICE_ADMIN_URL . $ret, 2, _AM_VISITORVOICE_APPROVE_FALSE );
			} else {
				redirect_header( VISITORVOICE_ADMIN_URL . $ret, 2, _AM_VISITORVOICE_APPROVE_TRUE );
			}
			break;
			
		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(0, _MI_VISITORVOICE_MENU_VISITORVOICE);
			$criteria = "";
			if(empty($criteria)){
				$criteria = NULL;
			}
			
			$objectTable = new icms_ipf_view_Table($visitorvoice_visitorvoice_handler, $criteria, array('edit'));
			$objectTable->addColumn(new icms_ipf_view_Column("visitorvoice_approve", "center", 50, "visitorvoice_approve"));
			$objectTable->addColumn(new icms_ipf_view_Column("visitorvoice_title"));
			if($visitorvoiceConfig["use_moderation"] == 1) {
				$objectTable->addColumn(new icms_ipf_view_Column("visitorvoice_pid", 'center', 100, "visitorvoice_pid"));
			}
			$objectTable->addColumn(new icms_ipf_view_Column("visitorvoice_name"));
			$objectTable->addColumn(new icms_ipf_view_Column("visitorvoice_url"));
			$objectTable->addColumn(new icms_ipf_view_Column("visitorvoice_published_date", FALSE, FALSE, "getPublishedDate" ));
			$objectTable->setDefaultSort("visitorvoice_published_date");
			$objectTable->setDefaultOrder("DESC");
			$icmsAdminTpl->assign("visitorvoice_visitorvoice_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:visitorvoice_admin.html");
			break;
	}
	icms_cp_footer();
}