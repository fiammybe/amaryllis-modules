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
// general
define("_MI_TOOLS_MD_NAME", "Tools");
define("_MI_TOOLS_MD_DESC", "Tools ist ein kleines Admin-Tool zur Optimierung, Analyse und Reperatur der Datenbank");
// autotasks
define("_MI_TOOLS_AUTOTASK_OPTIMIZE_DB", "Optimiere ICMS-Tabellen");
define("_MI_TOOLS_AUTOTASK_CLEAR_SESSION", "Reinige die ICMS-Sessions Tabelle");
define("_MI_TOOLS_AUTOTASK_CLEAR_CACHE", "Leere den ICMS-Cache Ordner");
define("_MI_TOOLS_AUTOTASK_ALL_TOOLS", "Führe alle Tools aus");
// ACP Menu
define("_MI_TOOLS_MENU_INDEX", "Start");
define("_MI_TOOLS_MENU_TOOLS", "Tools");
define("_MI_TOOLS_MENU_MODULESADD", "Module/Themes hochladen");
define("_MI_TOOLS_MENU_BACKUP", "Datensicherung");
define("_MI_TOOLS_MENU_MANUAL", "Handbuch");
// configs
define("_MI_TOOLS_CONFIG_ENABLE_FTP", "Erlaube die FTP-Datensicherung?");
define("_MI_TOOLS_CONFIG_ENABLE_FTP_DSC", "Das Backup wird normalerweise im TRUST abgelegt. Beim vollen Backup kann man aber auch das TRUST- und Upload-Verzeichnis sichern. Für diesen Zweck ist die FTP-Lösung gedacht");
define("_MI_TOOLS_CONFIG_FTP_URL", "URL zum FTP-Backup-Server");
define("_MI_TOOLS_CONFIG_FTP_URL_DSC", "Beispiel: http://ftp.example.de/");
define("_MI_TOOLS_CONFIG_FTP_USER", "FTP-User des Backup-Servers");
define("_MI_TOOLS_CONFIG_FTP_USER_DSC", "");
define("_MI_TOOLS_CONFIG_FTP_PASS", "FTP-Password des Backup-Servers");
define("_MI_TOOLS_CONFIG_FTP_PASS_DSC", "Passwort für den FTP-Nutzer");
define("_MI_TOOLS_CONFIG_FTP_PATH", "FTP-Pfad des FTP-Servers");
define("_MI_TOOLS_CONFIG_FTP_PATH_DSC", "pfad zum Sicherungs-Ordner. ACHTUNG: Dieser MUSS exisitieren und der User MUSS schreibrechte haben!");
define("_MI_TOOLS_CONFIG_REQUIRE_CLI", "Erlaube Cron-Jobs nur, wenn sie vom Server ausgeführt werden?");
define("_MI_TOOLS_CONFIG_REQUIRE_CLI_DSC", "Erlauben Sie das nur, wenn Sie wissen, was sie machen..");