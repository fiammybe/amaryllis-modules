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

// Requirements
define("_AM_TOOLS_REQUIREMENTS", "Tools Requirements");
define("_AM_TOOLS_REQUIREMENTS_INFO", "We've reviewed your system, unfortunately it doesn't meet all the requirements needed for Tutorials to function. Below are the requirements needed.");
define("_AM_TOOLS_REQUIREMENTS_ICMS_BUILD", "Tools requires at least ImpressCMS 1.3.");
define("_AM_TOOLS_REQUIREMENTS_SUPPORT", "Should you have any question or concerns, please visit our forums at <a href='http://community.impresscms.org'>http://community.impresscms.org</a>.");
// tools
define("_AM_TOOLS_MAINTAIN_DB","Database Maintenance");
define("_AM_TOOLS_CLEAR_SESSION","Clear Sessions");
define("_AM_TOOLS_CLEAR_CACHE","Clear \"cache\"-folder");
define("_AM_TOOLS_CLEAR_CACHE_SUCCESS", "Cache successfully cleared");
define("_AM_TOOLS_CLEAR_CACHE_FAIL", "Something went wrong on clearing cache");
define("_AM_TOOLS_CLEAR_TEMPLATES", "Clear \"templates_c\"-folder");
define("_AM_TOOLS_CLEAR_TEMPLATES_SUCCESS", "templates_c successfully cleared");
define("_AM_TOOLS_CLEAR_TEMPLATES_FAIL", "Something went wrong on clearing templates_c");
define("_AM_TOOLS_DELETED", "Deleted:");
define("_AM_TOOLS_LAST_MAINTENANCE", "Database Maintenance last triggered on %s");
define("_AM_TOOLS_LAST_MAINTENANCE_OLD", "Last maintenance older than 1 week!");
define("_AM_TOOLS_MAINTAIN_NOW", "Maintain now!");
define("_AM_TOOLS_RUN_ALL_NOW", "Run now!");
define("_AM_TOOLS_NO_MAINTAIN", "No Log file found");
// backup
define("_AM_TOOLS_BACKUP_NOW", "Backup Now!");
define("_AM_TOOLS_FULL_BACKUP_NOW", "Run full backup now");
define("_AM_TOOLS_LAST_BACKUP", "Backup last triggered on %s");
define("_AM_TOOLS_LAST_BACKUP_OLD", "Your last backup is older than 1 week!");
define("_AM_TOOLS_BACKUP_DELETE", "Delete Backup");
define("_AM_TOOLS_BACKUP_DELETE_CONFIRM", 'Are you sure, that you want to delete the backup?');
define("_AM_TOOLS_DELETE_OK", "Backup successfully deleted");
define("_AM_TOOLS_DELETE_FAILED", "Backup couldn't been deleted");
define("_AM_TOOLS_SECURITY_CHECK_FAILED", "ICMS-Security-check failed..");
define("_AM_TOOLS_NO_BACKUP", "ATTENTION: No backup found!");
define("_AM_TOOLS_BACKUP_DOWNLOAD", "Download backup");
define("_AM_TOOLS_BACKUP_SUCCESS", "Backup successfully finished");
define("_AM_TOOLS_BACKUP_FILE_NOT_FOUND", "File '%s' not found, to add to zip");
// Zip
define("_AM_TOOLS_ZIP_EXTENSION_FAILED", "Zip-Extension in php.ini not loaded");
define("_AM_TOOLS_ZIP_FAILED_OPEN", "Zip-Archiv konnte nicht geöffnet werden. Fehler Code: %d");
define("_AM_TOOLS_ZIP_FAILED_ADD_FILE", "Datei %s konnte nicht gefunden werden");
define("_AM_TOOLS_ZIP_FAILED_ADD_DIR", "Verzeichnis %s konnte nicht gefunden werden");
// modules
define("_AM_TOOLS_MODULES_UPLOAD_FORM", "Upload a new module");
define("_AM_TOOLS_MODULES_UPLOAD_FILE", "packed module");
define("_AM_TOOLS_MODULES_FAIL_WRITABLE", "ATTENTION! Modules folder is not writable! please first adjust permissons!");
define("_AM_TOOLS_MODULES_INSTALL_OK", "Module successfully uploaded.");
define("_AM_TOOLS_MODULES_GOTO", "Go to Module-Administration");