<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/log.php
 * 
 * delete log objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: log.php 608 2012-06-26 19:35:55Z St.Flohrer@gmail.com $
 * @package		icmspoll
 *
 */

include_once 'admin_header.php';

/**
 * Create a whitelist of valid values
 */
$valid_op = array("del", "");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$clean_log_id = isset($_GET['log_id']) ? filter_input(INPUT_GET, 'log_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

$icmspoll_log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'del':
			$controller =  new icms_ipf_Controller($icmspoll_log_handler);
			$controller->handleObjectDeletion();
			break;
		default:
			icms_cp_header();
			icms::$module->displayAdminmenu(3, _MI_ICMSPOLL_MENU_LOG);
			
			$objectTable = new icms_ipf_view_Table($icmspoll_log_handler, NULL);
			$objectTable->addColumn(new icms_ipf_view_Column("poll_id", FALSE, FALSE, "getPollName"));
			$objectTable->addColumn(new icms_ipf_view_Column("option_id", FALSE, FALSE, "getOptionText"));
			$objectTable->addColumn(new icms_ipf_view_Column("user_id", "center", FALSE, "getUser"));
			$objectTable->addColumn(new icms_ipf_view_Column("time", "center", 50, "getTime"));
			
			$objectTable->addFilter("poll_id", "filterPolls");
			
			$icmsAdminTpl->assign('icmspoll_log_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:icmspoll_admin.html');
			
			break;
	}
	include_once 'admin_footer.php';
}