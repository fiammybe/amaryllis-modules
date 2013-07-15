<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/backup.php
 *
 * Admin backup
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

include_once 'admin_header.php';
icms_cp_header();
icms::$module->displayAdminMenu( 2, _MI_TOOLS_MENU_BACKUP);
icms::$module->setVar("ipf", TRUE);
icms::$module->registerClassPath(TRUE);
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, "op", FILTER_SANITIZE_STRING) : "";
$clean_op = isset($_POST['op']) ? filter_input(INPUT_POST, "op", FILTER_SANITIZE_STRING) : $clean_op;

$valid_op = array("backup_all", "backup_db", "backup_ok", "delete_backup", "confirm_delete", "");

if(in_array($clean_op, $valid_op, TRUE)) {
	$icmsAdminTpl->assign("tools_title", _MI_TOOLS_MENU_BACKUP);
	$icmsAdminTpl->assign("tools_url", TOOLS_URL);
	$icmsAdminTpl->assign("tools_admin_url", TOOLS_ADMIN_URL);
	$icmsAdminTpl->assign("tools_backup", TRUE);
	$backupPath = TOOLS_TRUST_PATH.'backup/';
	$logPath = TOOLS_TRUST_PATH.'logs/';
	switch ($clean_op) {
		case 'backup_all':
			//require_once TOOLS_ROOT_PATH.'class/Backup.php';
			$backup = mod_tools_Backup::instance(TRUE);
			$uname = icms::$user->getVar("uname");
			$backup::setCase("Button-Trigger by ".$uname);
			ob_start();
			while($backup::runFullBackup()) {
				sleep(1);
				flush();
				ob_flush();
			}
			ob_end_flush();
			//redirect_header(TOOLS_ADMIN_URL.'backup.php', 3);
			break;
		case 'backup_db':
			//require_once TOOLS_ROOT_PATH.'class/Backup.php';
			$backup = mod_tools_Backup::instance();
			$uname = icms::$user->getVar("uname");
			$backup::setCase("Button-Trigger by ".$uname);
			ob_start();
			while($backup::runBackup()) {
				sleep(1);
				flush();
				ob_flush();
			}
			ob_end_flush();
			redirect_header(TOOLS_ADMIN_URL.'backup.php', 3);
			break;
		case 'delete_backup':
		case 'confirm_delete':
			if (isset($_POST['confirm_delete'])) {
				if (!icms::$security->check()) {
					redirect_header(icms_getPreviousPage(), 3, _AM_TOOLS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				} else {
					if(icms_core_Filesystem::deleteRecursive($backupPath, FALSE)) {
						icms_core_Filesystem::deleteFile($logPath.'log_backup.php');
						icms_core_Filesystem::deleteFile($logPath.'log_ftp.php');
						icms_core_Filesystem::deleteFile($logPath.'log_pack.php');
						$icmsAdminTpl->assign('tools_delete_ok', TRUE);
					} else {
						$icmsAdminTpl->assign('tools_delete_failed', TRUE);
					}
				}
			} else {
				icms_core_Message::confirm(array("confirm_delete" => TRUE), $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], _AM_TOOLS_BACKUP_DELETE_CONFIRM, _YES);
			}
			$icmsAdminTpl->display("db:tools_admin.html");
			break;
		default:
			$backupFile = TOOLS_TRUST_PATH.'backup/backup_db.sql';
			$backupZip = TOOLS_TRUST_PATH.'backup/db_backup.zip';
			$backupZip2 = TOOLS_TRUST_PATH.'backup/backup.zip';
			$ftp_log_file = TOOLS_TRUST_PATH.'logs/log_ftp.php';
			$zip_log_file = TOOLS_TRUST_PATH.'logs/log_pack.php';
			$backup_log_file = TOOLS_TRUST_PATH.'logs/log_backup.php';
			if(is_file($backupFile) || is_file($backupZip) || is_file($backupZip2)) {
				$filectime = $toolsConfig['last_backup'];
				$warning = ($filectime <= (time()-(60*60*24*7))) ? TRUE : FALSE;
				$created = date("M d, Y ".strtolower("\a\T")." H:i:s \G\M\T P", $filectime);
				$icmsAdminTpl->assign('tools_warning', $warning);
				$icmsAdminTpl->assign('tools_backup_ok', TRUE);
				$zip1 = (is_file($backupZip) === TRUE) ? TRUE : FALSE;
				$zip2 = (is_file($backupZip2) === TRUE) ? TRUE : FALSE;
				$ftp_log = (is_file($ftp_log_file) === TRUE) ? TRUE : FALSE;
				$zip_log = (is_file($zip_log_file) === TRUE) ? TRUE : FALSE;
				$backup_log = (is_file($backup_log_file) === TRUE) ? TRUE : FALSE;
				$icmsAdminTpl->assign('tools_zip1', $zip1);
				$icmsAdminTpl->assign('tools_zip2', $zip2);
				$icmsAdminTpl->assign('tools_log_ftp', $ftp_log);
				$icmsAdminTpl->assign('tools_log_zip', $zip_log);
				$icmsAdminTpl->assign('tools_log_backup', $backup_log);
				$icmsAdminTpl->assign("tools_lastChanged", sprintf(_AM_TOOLS_LAST_BACKUP, $created));
			} else {
				$icmsAdminTpl->assign('tools_backup_warning', TRUE);
			}
			$icmsAdminTpl->display("db:tools_admin.html");
			break;
	}
}

include_once 'admin_footer.php';