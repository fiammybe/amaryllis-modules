<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /language/german/modinfo.php
 *
 * german modinfo language file
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
define("_AM_TOOLS_REQUIREMENTS", "Tools Voraussetzungen");
define("_AM_TOOLS_REQUIREMENTS_INFO", "We've reviewed your system, unfortunately it doesn't meet all the requirements needed for Tutorials to function. Below are the requirements needed.");
define("_AM_TOOLS_REQUIREMENTS_ICMS_BUILD", "Tools requires at least ImpressCMS 1.3.");
define("_AM_TOOLS_REQUIREMENTS_SUPPORT", "Should you have any question or concerns, please visit our forums at <a href='http://community.impresscms.org'>http://community.impresscms.org</a>.");
//tools
define("_AM_TOOLS_MAINTAIN_DB","Datenbank Wartung");
define("_AM_TOOLS_CLEAR_SESSION","Sessions bereinigen");
define("_AM_TOOLS_CLEAR_CACHE","\"cache\"-Verzeichnis reinigen");
define("_AM_TOOLS_CLEAR_CACHE_SUCCESS", "Cache Verzeichnis erfolgreich geleert");
define("_AM_TOOLS_CLEAR_CACHE_FAIL", "Cache Verzeichnis konnte nicht geleert werden");
define("_AM_TOOLS_CLEAR_TEMPLATES", "\"templates_c\"-Verzeichnis reinigen");
define("_AM_TOOLS_CLEAR_TEMPLATES_SUCCESS", "templates_c Verzeichnis erfolgreich geleert");
define("_AM_TOOLS_CLEAR_TEMPLATES_FAIL", "templates_c Verzeichnis konnte nicht geleert werden");
define("_AM_TOOLS_DELETED", "Gelöscht:");
define("_AM_TOOLS_LAST_MAINTENANCE", "Wartung wurde zuletzt am %s ausgeführt");
define("_AM_TOOLS_LAST_MAINTENANCE_OLD", "Letzte Wartung wurde vor mehr als einer Woche ausgeführt!");
define("_AM_TOOLS_MAINTAIN_NOW", "Jetzt warten!");
define("_AM_TOOLS_RUN_ALL_NOW", "Jetzt alle ausführen!");
define("_AM_TOOLS_NO_MAINTAIN", "Kein Log file gefunden");
//backup
define("_AM_TOOLS_BACKUP_NOW", "Datensicherung jetzt durchführen");
define("_AM_TOOLS_FULL_BACKUP_NOW", "Volle Datensicherung jetzt durchführen");
define("_AM_TOOLS_LAST_BACKUP", "Datensicherung wurde zuletzt am %s ausgeführt");
define("_AM_TOOLS_LAST_BACKUP_OLD", "Die Datensicherung ist über 1 Woche alt!");
define("_AM_TOOLS_BACKUP_DELETE", "Datensicherung löschen");
define("_AM_TOOLS_BACKUP_DELETE_CONFIRM", 'Sind Sie sicher, dass Sie alle Datensicherungen löschen wollen?');
define("_AM_TOOLS_DELETE_OK", "Datensicherungen wurden erfolgreich gelöscht");
define("_AM_TOOLS_DELETE_FAILED", "Datensicherungen konnten nicht gelöscht werden");
define("_AM_TOOLS_SECURITY_CHECK_FAILED", "ICMS-Sicherheitsprüfung nicht bestanden..");
define("_AM_TOOLS_NO_BACKUP", "ACHTUNG: Keine Datensicherung gefunden");
define("_AM_TOOLS_BACKUP_DOWNLOAD", "Datensicherung herunterladen");
define("_AM_TOOLS_BACKUP_SUCCESS", "Datensicherung erfolgreich abgeschlossen");
define("_AM_TOOLS_BACKUP_FILE_NOT_FOUND", "Datei '%s' nicht gefunden, um sie zu packen");
// Zip
define("_AM_TOOLS_ZIP_EXTENSION_FAILED", "Zip-Erweiterung in PHP nicht geladen");
define("_AM_TOOLS_ZIP_FAILED_OPEN", "Zip-Archiv konnte nicht geöffnet werden. Fehler Code: %d");
define("_AM_TOOLS_ZIP_FAILED_ADD_FILE", "Datei %s konnte nicht gefunden werden");
define("_AM_TOOLS_ZIP_FAILED_ADD_DIR", "Verzeichnis %s konnte nicht gefunden werden");
// Modules upload
define("_AM_TOOLS_MODULES_UPLOAD_FORM", "Lade ein neues Modul hoch");
define("_AM_TOOLS_MODULES_UPLOAD_FILE", "Zip-Datei mit dem Modul");
define("_AM_TOOLS_MODULES_FAIL_WRITABLE", "Achtung! Der Modules-Ordner ist nicht beschreibbar! bitte erst die Berechtigungen angleichen!");
define("_AM_TOOLS_MODULES_INSTALL_OK", "Modul wurde erfolgreich hochgeladen.");
define("_AM_TOOLS_MODULES_GOTO", "Zur Modul-Administration");