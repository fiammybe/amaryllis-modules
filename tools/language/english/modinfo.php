<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /language/english/modinfo.php
 *
 * English modinfo language file
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
// general
define("_MI_TOOLS_MD_NAME", "Tools");
define("_MI_TOOLS_MD_DESC", "Tools is a small admin-tool module");
// autotasks
define("_MI_TOOLS_AUTOTASK_OPTIMIZE_DB", "Optimize ICMS-Tables");
define("_MI_TOOLS_AUTOTASK_CLEAR_SESSION", "Clear ICMS-Sessions");
define("_MI_TOOLS_AUTOTASK_CLEAR_CACHE", "Clear ICMS-Cache");
define("_MI_TOOLS_AUTOTASK_ALL_TOOLS", "Run all Tools");
// ACP Menu
define("_MI_TOOLS_MENU_INDEX", "Index");
define("_MI_TOOLS_MENU_TOOLS", "Tools");
define("_MI_TOOLS_MENU_BACKUP", "Backup");
define("_MI_TOOLS_MENU_MODULESADD", "Upload Modules");
define("_MI_TOOLS_MENU_MANUAL", "Manual");
// configs
define("_MI_TOOLS_CONFIG_ENABLE_FTP", "Enable FTP-Backup?");
define("_MI_TOOLS_CONFIG_ENABLE_FTP_DSC", "As default the backup will be stored in TRUST. If you run a full Backup, the TRUST- and Upload-Directories will be stored, too. In this case it would be better storing the files on an external FTP-Server");
define("_MI_TOOLS_CONFIG_FTP_URL", "URL to FTP-Server");
define("_MI_TOOLS_CONFIG_FTP_URL_DSC", "Example: http://ftp.example.com/");
define("_MI_TOOLS_CONFIG_FTP_USER", "FTP-User");
define("_MI_TOOLS_CONFIG_FTP_USER_DSC", "");
define("_MI_TOOLS_CONFIG_FTP_PASS", "FTP-Password");
define("_MI_TOOLS_CONFIG_FTP_PASS_DSC", "Password for FTP-User");
define("_MI_TOOLS_CONFIG_FTP_PATH", "FTP-Path");
define("_MI_TOOLS_CONFIG_FTP_PATH_DSC", "path to Backup-Directory. ATTENTION: This folder MUST exist and the User MUST have write permissions!");
define("_MI_TOOLS_CONFIG_REQUIRE_CLI", "Require triggering Cron from CLI?");
define("_MI_TOOLS_CONFIG_REQUIRE_CLI_DSC", "Enable only, if you know, what you do..");