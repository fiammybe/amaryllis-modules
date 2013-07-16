<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /language/german/modinfo.php
 *
 * german modinfo language file
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
//index
define("_AM_TOOLS_INDEX_SYS_INFO", "System Informationen");
define("_AM_TOOLS_INDEX_TRUST_WRITABLE", "Tools gesichertes Verzeichnis ist beschreibbar.");
define("_AM_TOOLS_INDEX_TRUST_NOT_WRITABLE", "Tools gesichertes Verzeichnis ist <b>NICHT</b> beschreibbar!");
define("_AM_TOOLS_INDEX_FTP_LOADED", "FTP Erweiterung von PHP ist geladen");
define("_AM_TOOLS_INDEX_FTP_NOT_LOADED", "FTP Erweiterung von PHP ist nicht geladen! Kein FTP-Backup möglich!");
define("_AM_TOOLS_INDEX_ZIP_LOADED", "ZIP Erweiterung von PHP ist geladen");
define("_AM_TOOLS_INDEX_ZIP_NOT_LOADED", "ZIP Erweiterung von PHP ist nicht geladen! Benutzung von Tools nicht möglich!");
//general
define("_AM_TOOLS_ADMIN_FOOTER", "Wenn Sie Hilfe zu dem Modul benötigen, schauen Sie bitte in das <a href='manual.php' title='Handbuch' style='color: #336699;'>Handbuch</a>.");
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
define("_AM_TOOLS_MAINTAIN_NOW", "Jetzt volle Wartung durchführen!");
define("_AM_TOOLS_RUN_ALL_NOW", "Jetzt alle ausführen!");
define("_AM_TOOLS_NO_MAINTAIN", "Kein Log file gefunden");
define("_AM_TOOLS_DOWN_LOG", "Log herunterladen");
define("_AM_TOOLS_DEL_LOG", "Log File löschen");
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
define("_AM_TOOLS_BACKUP_DOWNLOAD_FULL", "Vollst. Datensicherung herunterladen");
define("_AM_TOOLS_BACKUP_SUCCESS", "Datensicherung erfolgreich abgeschlossen");
define("_AM_TOOLS_BACKUP_FILE_NOT_FOUND", "Datei '%s' nicht gefunden, um sie zu packen");
define("_AM_TOOLS_BACKUP_DOWN_FTP_LOG", "FTP-Log herunterladen");
define("_AM_TOOLS_BACKUP_DOWN_ZIP_LOG", "Zip-Log herunterladen");
define("_AM_TOOLS_BACKUP_DOWN_BACK_LOG", "Sicherungs-Log herunterladen");
define("_AM_TOOLS_BACKUP_TRIGGERED", "Vollständige Datensicherung eingeleitet");
define("_AM_TOOLS_BACKUP_ACCESS_DENIED_CLI", "Zugriff verweigert - Sie können das Skript nicht direkt aufrufen!");
define("_AM_TOOLS_BACKUP_REQUIRE_CLI", "Das Skript muss via shell aufgerufen werden (SSH)");
define("_AM_TOOLS_BACKUP_REQUIRE_NOT_CLI", "Das Skript muss nicht via shell aufgerufen werden (SSH)");
define("_AM_TOOLS_BACKUP_TOOLS_LOADED", "Tools Modul geladen");
define("_AM_TOOLS_BACKUP_NO_TABLES", "Tabellen konnten nicht geladen werden");
define("_AM_TOOLS_BACKUP_STARTED", "Datensicherung wurde am %s gestartet");
define("_AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_FROM", "Ihre E-Mail-Konfiguration ist nicht eingerichtet. \"Von-E-Mail Adresse\" ist leer");
define("_AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_FROM_NAME", "Ihre E-Mail-Konfiguration ist nicht eingerichtet. \"Von-Name\" ist leer");
define("_AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_ADMIN_MAIL", "Ihre Haupt-Konfiguration ist nicht komplett. \"Admin-E-Mail\" ist leer");
define("_AM_TOOLS_BACKUP_MAIL_SUBJ", "Tools Datensicherungs-Benachrichtigung");
define("_AM_TOOLS_BACKUP_FULL_TRIGGERED_ON", "Vollständige Datensicherung wurde am %s ausgeführt");
define("_AM_TOOLS_BACKUP_SIMPLE_TRIGGERED_ON", "Einfache Datensicherung wurde am %s ausgeführt");
define("_AM_TOOLS_BACKUP_TRIGGERED_BY", "Die Datensicherung wurde durch %s eingeleitet");
define("_AM_TOOLS_BACKUP_TRIGGERED_BY_BUTTON_CLICK", "Button-Klick von %s");
// Zip
define("_AM_TOOLS_ZIP_EXTENSION_FAILED", "Zip-Erweiterung in PHP nicht geladen");
define("_AM_TOOLS_ZIP_FAILED_OPEN", "Zip-Archiv konnte nicht geöffnet werden. Fehler Code: %d");
define("_AM_TOOLS_ZIP_FAILED_ADD_FILE", "Datei %s konnte nicht gefunden werden");
define("_AM_TOOLS_ZIP_FAILED_ADD_DIR", "Verzeichnis %s konnte nicht gefunden werden");
define("_AM_TOOLS_ZIP_FAILED_EXTRACT_ZIP", "Zip Datei konnte nicht zum Zielort extrahiert werden.");
define("_AM_TOOLS_ZIP_FAILED_EXTRACT_ZIPFILES", "Die Dateien %s konnten nicht zum Ziel entpackt werden.");
define("_AM_TOOLS_ZIP_FAILED_DESTINATION", "Sie müssen einen Zielort für das entpacken angeben.");
// Modules upload
define("_AM_TOOLS_MODULES_UPLOAD_FORM", "Lade ein neues Modul hoch");
define("_AM_TOOLS_MODULES_UPLOAD_FILE", "Zip-Datei mit dem Modul");
define("_AM_TOOLS_MODULES_FAIL_WRITABLE", "Achtung! Der Modules-Ordner ist nicht beschreibbar! bitte erst die Berechtigungen angleichen!");
define("_AM_TOOLS_MODULES_INSTALL_OK", "Modul wurde erfolgreich hochgeladen.");
define("_AM_TOOLS_MODULES_GOTO", "Zur Modul-Administration");
// Themes upload
define("_AM_TOOLS_THEMES_UPLOAD_FORM", "Lade ein neues Theme hoch");
define("_AM_TOOLS_THEMES_UPLOAD_FILE", "Zip-Datei mit dem Theme");
define("_AM_TOOLS_THEMES_FAIL_WRITABLE", "Achtung! Der Themes-Ordner ist nicht beschreibbar! bitte erst die Berechtigungen angleichen bevor Sie Themes hochladen können!");
define("_AM_TOOLS_THEMES_INSTALL_OK", "Theme wurde erfolgreich hochgeladen.");
define("_AM_TOOLS_THEMES_GOTO", "Theme jetzt erlauben");
define("_AM_TOOLS_THEMES_OK", "Theme(s) erfolgreich hochgeladen");