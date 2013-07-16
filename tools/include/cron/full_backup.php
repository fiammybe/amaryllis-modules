<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /include/cron/full_backup.php
 *
 * Admin backup as cron job. Triggers a full backup including trunk and uploads folder
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

include_once '../../../../mainfile.php';
define("TOOLS_DIRNAME", basename(dirname(dirname(dirname(__FILE__)))));
include_once  ICMS_MODULES_PATH.'/'.TOOLS_DIRNAME.'/include/common.php';
icms_loadLanguageFile("tools", "admin");
if (!empty($argc) && strstr($argv[0], basename(__FILE__))) {
	$uname = urldecode(filter_var(trim($argv[1]), FILTER_SANITIZE_STRING));
	$password = urldecode(filter_var(trim($argv[2]), FILTER_SANITIZE_STRING));
	$debug = (isset($argv[3]) && filter_var($argv[3], FILTER_SANITIZE_NUMBER_INT) == 1) ? TRUE : FALSE;
	if($debug) icms_core_Debug::$_SERVER['argv'];
} else {
	parse_str($_SERVER['QUERY_STRING'], $args);
	$uname = urldecode(filter_var(trim($args["uname"]), FILTER_SANITIZE_STRING));
	$password = urldecode(filter_var(trim($args["password"]), FILTER_SANITIZE_STRING));
	$debug = (isset($args["debug"]) && filter_var($args["debug"], FILTER_SANITIZE_NUMBER_INT) == 1) ? TRUE : FALSE;
	if($debug) icms_core_Debug::vardump($args);
}

if(!$debug) icms::$logger->disableLogger();

$toolsModule_handler = icms::handler('icms_module');
$toolsModule = $toolsModule_handler->getByDirname(TOOLS_DIRNAME, TRUE);
if(!is_object($toolsModule)) die("Access denied");
$toolsModule_id = $toolsModule->getVar("mid");
if($toolsModule->config["require_cli"] == 1 && !defined('STDIN'))die(_AM_TOOLS_BACKUP_ACCESS_DENIED_CLI);

if($debug) {
	$require_cli = ($toolsModule->config["require_cli"] == 1) ? _AM_TOOLS_BACKUP_REQUIRE_CLI : _AM_TOOLS_BACKUP_REQUIRE_NOT_CLI;
	icms_core_Debug::message(_AM_TOOLS_BACKUP_TOOLS_LOADED." ".$require_cli);
}
$icmsAuth = icms_auth_Factory::getAuthConnection(icms_core_DataFilter::addSlashes($uname));

$uname4sql = addslashes(icms_core_DataFilter::stripSlashesGPC($uname));
$pass4sql = icms_core_DataFilter::stripSlashesGPC($password);

$user = $icmsAuth->authenticate($uname4sql, $pass4sql);

if(!$user || !is_object($user) || !$user->isAdmin($toolsModule_id)) die("Access denied");

$toolsModule->setVar("ipf", TRUE);
$toolsModule->registerClassPath();

$toolsBackup = mod_tools_Backup::instance($debug);
$toolsBackup::setCase("Cron Job by ".$user->getVar("uname"));
$toolsBackup::runFullBackup();