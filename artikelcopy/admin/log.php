<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /admin/log.php
 * 
 * Log of the module
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
 * Edit a Log
 *
 * @param int $log_id Logid to be edited
*/
function editlog($log_id = 0) {
	global $artikel_log_handler, $icmsModule, $icmsAdminTpl;

	$logObj = $artikel_log_handler->get($log_id);

	if (!$logObj->isNew()){
		$icmsModule->displayAdminMenu(4, _AM_ARTIKEL_LOGS . " > " . _CO_ICMS_EDITING);
		$sform = $logObj->getForm(_AM_ARTIKEL_LOG_EDIT, "addlog");
		$sform->assign($icmsAdminTpl);
	} else {
		$icmsModule->displayAdminMenu(4, _AM_ARTIKEL_LOGS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $logObj->getForm(_AM_ARTIKEL_LOG_CREATE, "addlog");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:artikel_admin_log.html");
}

include_once "admin_header.php";

$artikel_log_handler = icms_getModuleHandler("log", basename(dirname(dirname(__FILE__))), "artikel");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod", "changedField", "addlog", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_log_id = isset($_GET["log_id"]) ? (int)$_GET["log_id"] : 0 ;

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
			editlog($clean_log_id);
			break;

		case "addlog":
			$controller = new icms_ipf_Controller($artikel_log_handler);
			$controller->storeFromDefaultForm(_AM_ARTIKEL_LOG_CREATED, _AM_ARTIKEL_LOG_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($artikel_log_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$logObj = $artikel_log_handler->get($clean_log_id);
			icms_cp_header();
			$logObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(4, _AM_ARTIKEL_LOGS);
			$objectTable = new icms_ipf_view_Table($artikel_log_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("log_item_id"));
			$objectTable->addIntroButton("addlog", "log.php?op=mod", _AM_ARTIKEL_LOG_CREATE);
			$icmsAdminTpl->assign("artikel_log_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:artikel_admin_log.html");
			break;
	}
	icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */