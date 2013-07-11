<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /include/cron/backup.php
 *
 * Admin backup as cron job
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
icms::$logger->disableLogger();

parse_str($_SERVER['QUERY_STRING'], $args);

$uname = trim($args["uname"]);
$password = trim($args["password"]);

$module_handler = icms::handler('icms_module');
$module = $module_handler->getByDirname(TOOLS_DIRNAME);
if(!is_object($module)) die("Access denied");
$module_id = $module->getVar("mid");

$icmsAuth = icms_auth_Factory::getAuthConnection(icms_core_DataFilter::addSlashes($uname));

$uname4sql = addslashes(icms_core_DataFilter::stripSlashesGPC($uname));
$pass4sql = icms_core_DataFilter::stripSlashesGPC($password);

$user = $icmsAuth->authenticate($uname4sql, $pass4sql);

if(!$user || !is_object($user) || !$user->isAdmin($module_id)) die("Access denied");

$module->setVar("ipf", TRUE);
$module->registerClassPath();
require_once TOOLS_ROOT_PATH.'class/Backup.php';
require_once TOOLS_ROOT_PATH.'class/Ftp.php';
mod_tools_Backup::instance();
mod_tools_Backup::runBackup();