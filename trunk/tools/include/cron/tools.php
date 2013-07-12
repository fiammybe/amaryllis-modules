<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /include/cron/tools.php
 *
 * running all tools in a cron
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
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
	$uname = filter_var(trim($argv[1]), FILTER_SANITIZE_STRING);
	$password = filter_var(trim($argv[2]), FILTER_SANITIZE_STRING);
	$debug = (isset($argv[3]) && filter_var($argv[3], FILTER_SANITIZE_NUMBER_INT) == 1) ? TRUE : FALSE;
	if($debug) icms_core_Debug::$_SERVER['argv'];
} else {
	parse_str($_SERVER['QUERY_STRING'], $args);
	$uname = filter_var(trim($args["uname"]), FILTER_SANITIZE_STRING);
	$password = filter_var(trim($args["password"]), FILTER_SANITIZE_STRING);
	$debug = (isset($args["debug"]) && filter_var($args["debug"], FILTER_SANITIZE_NUMBER_INT) == 1) ? TRUE : FALSE;
	$uname = trim($args["uname"]);
	$password = trim($args["password"]);
	$debug = (isset($args["debug"]) && filter_var($args["debug"], FILTER_SANITIZE_NUMBER_INT) == 1) ? TRUE : FALSE;
	if($debug) icms_core_Debug::vardump($args);
}

if(!$debug) icms::$logger->disableLogger();

$toolsModule_handler = icms::handler('icms_module');
$toolsModule = $toolsModule_handler->getByDirname(TOOLS_DIRNAME, TRUE);
if(!is_object($toolsModule)) die("Access denied");
$toolsModule_id = $toolsModule->getVar("mid");
if($toolsModule->config["require_cli"] == 1 && !defined('STDIN'))die("Access Denied - You can not call this script directly!");
$require_cli = ($toolsModule->config["require_cli"] == 1) ? "Script requires to be triggered from SSH" : "Script does not require to be triggered from SSH";
if($debug) {
	icms_core_Debug::message("Tools Module loaded ".$require_cli);
}
$icmsAuth = icms_auth_Factory::getAuthConnection(icms_core_DataFilter::addSlashes($uname));

$uname4sql = addslashes(icms_core_DataFilter::stripSlashesGPC($uname));
$pass4sql = icms_core_DataFilter::stripSlashesGPC($password);

$user = $icmsAuth->authenticate($uname4sql, $pass4sql);

if(!$user || !is_object($user) || !$user->isAdmin($toolsModule_id)) die("Access denied");

$toolsModule->setVar("ipf", TRUE);
$toolsModule->registerClassPath();

mod_tools_Tools::instance();
mod_tools_Tools::runTools($debug);

echo "Tools successfully triggered";
exit;