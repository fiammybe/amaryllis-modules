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

parse_str($_SERVER['QUERY_STRING'], $args);

$uname = trim($args["uname"]);
$password = trim($args["password"]);
$debug = (isset($args["debug"]) && filter_var($args["debug"], FILTER_SANITIZE_NUMBER_INT) == 1) ? TRUE : FALSE;

if($debug) {
	icms_core_Debug::vardump($args);
}

$module_handler = icms::handler('icms_module');
$module = $module_handler->getByDirname(TOOLS_DIRNAME);
if(!is_object($module)) die("Access denied");
$module_id = $module->getVar("mid");
if($debug) {
	icms_core_Debug::message("Tools Module loaded");
}
$icmsAuth = icms_auth_Factory::getAuthConnection(icms_core_DataFilter::addSlashes($uname));

$uname4sql = addslashes(icms_core_DataFilter::stripSlashesGPC($uname));
$pass4sql = icms_core_DataFilter::stripSlashesGPC($password);

$user = $icmsAuth->authenticate($uname4sql, $pass4sql);

if(!$user || !is_object($user) || !$user->isAdmin($module_id)) die("Access denied");

$module->setVar("ipf", TRUE);
$module->registerClassPath();

mod_tools_Tools::instance();
mod_tools_Tools::runTools();

echo "Tools successfully triggered";
exit;