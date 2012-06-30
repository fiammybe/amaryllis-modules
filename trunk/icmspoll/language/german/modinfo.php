<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /language/english/modinfo.php
 * 
 * english modinfo language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: modinfo.php 642 2012-06-30 09:09:03Z st.flohrer $
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_ICMSPOLL_MD_NAME", "Polls");
define("_MI_ICMSPOLL_MD_DSC", "'Icmspoll' is a poll module for ImpressCMS and iforum. This means, it can work as a standalone poll module or can be integrated in iforum to provide polls in forum.");
/**
 * module preferences
 */
define("_MI_ICMSPOLL_AUTHORIZED_CREATOR", "Erlaubte Gruppen zum erstellen von Umfragen");
define("_MI_ICMSPOLL_AUTHORIZED_CREATOR_DSC", "Wähle die Gruppen, die eine Berechtigung zum erstellen von Umfragen haben sollen (Front end)");
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT", "Datumsformat");
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT_DSC", "");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP", "Eingeschränkt nach IP");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP_DSC", "Einschränkung für Mehrfachvoting");
define("_MI_ICMSPOLL_CONFIG_LIMITBYSESSION", "Eingeschränkt nach Session");
define("_MI_ICMSPOLL_CONFIG_LIMITBYSESSION_DSC", "Einschränkung für Mehrfachvoting");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID", "Eingeschränkt nach Bernutzer");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID_DSC", "Einschränkung für Mehrfachvoting");
define("_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS", "Zeige breadcrumb?");
define("_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS_DSC", "Wähle 'JA' um die breadcrumb im front end zu zeigen");
define("_MI_ICMSPOLL_CONFIG_SHOW_POLLS", "Limit an Umfragen, welche auf der Indexseite gezeigt werden");
define("_MI_ICMSPOLL_CONFIG_SHOW_POLLS_DSC", "Setzen Sie das Limit an Umfragen, welche auf der Indexseite gezeigt werden, bevor die Seitennavigation erstellt wird");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER", "Ordne Umfragen standardgemäß nach");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_DSC", "Ordne Umfragen im Index standardgemäß nach:");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_WEIGHT", "Gewichtung");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_CREATIONDATE", "Erstelldatum");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_STARTDATE", "Startdatum");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_ENDDATE", "Enddatum");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT", "Sortiere Standardgemäß");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DSC", "");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_ASC", "Aufsteigend");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DESC", "Absteigend");
define("_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE", "Möchten Sie Anfangswerte für Optionen erlauben?");
define("_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE_DSC", "Wähle 'JA' wenn Sie erlauben möchten, dass Anfangswerte bei Optionen gesetzt werden, das heißt, dass die Umfrage NICHT bei 0 startet.");
define("_MI_ICMSPOLL_CONFIG_PRINT_FOOTER", "Print Footer");
define("_MI_ICMSPOLL_CONFIG_PRINT_FOOTER_DSC", "Dieser footer wird in print layouts genutzt");
define("_MI_ICMSPOLL_CONFIG_PRINT_LOGO", "Print Logo");
define("_MI_ICMSPOLL_CONFIG_PRINT_LOGO_DSC", "Setze den Pfad zu dem Logo, welches für den Druck verwendet werden soll. Z.B.: themes/example/images/logo.gif");
define("_MI_ICMSPOLL_CONFIG_USE_RSS", "Nutze RSS-Feeds?");
define("_MI_ICMSPOLL_CONFIG_USE_RSS_DSC", "Wähle 'JA' um einen RSS-Link bereitzustellen und RSS zu erlauben.");
define("_MI_ICMSPOLL_CONFIG_RSS_LIMIT", "RSS Limit");
define("_MI_ICMSPOLL_CONFIG_RSS_LIMIT_DSC", "Limit an Umfragen für RSS-Feeds");
/**
 * module Templates
 */
define("_MI_ICMSPOLL_TPL_INDEX", "Icmspoll Index");
define("_MI_ICMSPOLL_TPL_HEADER", "Header in allen Seiten im Frontend");
define("_MI_ICMSPOLL_TPL_FOOTER", "Footer in allen Seiten im Frontend");
define("_MI_ICMSPOLL_TPL_POLLS", "Umfrage-Schleife in der Index-Übersicht");
define("_MI_ICMSPOLL_TPL_SINGLEPOLL", "Einzelne Umfrage in der Einzelansichtz");
define("_MI_ICMSPOLL_TPL_RESULTS", "Umfrageergebnisse");
define("_MI_ICMSPOLL_TPL_PRINT", "Druck template für Print layouts");
define("_MI_ICMSPOLL_TPL_FORMS", "Formulare zum Erstellen/Bearbeiten/Löschen von Umfragen/Optionen im Frontend");
define("_MI_ICMSPOLL_TPL_ADMIN_FORM", "ACP Template");
define("_MI_ICMSPOLL_TPL_REQUIREMENTS", "Voraussetzungs-Check");
/**
 * module blocks
 */
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS", "Letzte Umfragen");
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS_DSC", "Zeigt eine Liste der zuletzt erstellten Umfragen");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL", "Umfrage");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL_DSC", "Zeigt eine einzelne Umfrage");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS", "Letzte Ergebnisse");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS_DSC", "Zeigt die letzten Ergebnisse");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT", "Ergebnis");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT_DSC", "Zeigt ein einzelnes Ergebnis einer Umfrage");
/**
 * module ACP menu
 */
define("_MI_ICMSPOLL_MENU_INDEX", "Index");
define("_MI_ICMSPOLL_MENU_POLLS", "Umfragen");
define("_MI_ICMSPOLL_MENU_OPTIONS", "Umfrage optionen");
define("_MI_ICMSPOLL_MENU_LOG", "Log");
define("_MI_ICMSPOLL_MENU_INDEXPAGE", "Indexseite");
define("_MI_ICMSPOLL_MENU_TEMPLATES", "Templates");
define("_MI_ICMSPOLL_MENU_MANUAL", "Manual");
// submenu
define("_MI_ICMSPOLL_MENU_POLLS_EDITING", "Bearbeite die Umfrage");
define("_MI_ICMSPOLL_MENU_POLLS_CREATINGNEW", "Erstelle eine neue Umfrage");
define("_MI_ICMSPOLL_MENU_OPTIONS_EDITING", "Bearbeite die Option");
define("_MI_ICMSPOLL_MENU_OPTIONS_CREATINGNEW", "Erstelle eine neue Option");
define("_MI_ICMSPOLL_MENU_INDEXPAGE_EDIT", "Bearbeite die Indexseite");
/**
 * Mainmenu
 */
define("_MI_ICMSPOLL_MENUMAIN_ADDPOLL", "Erstelle Umfrage");
define("_MI_ICMSPOLL_MENUMAIN_VIEW_POLLS_TABLE", "Zeige Tabelle für Umfragen");
define("_MI_ICMSPOLL_MENUMAIN_VIEW_OPTIONS_TABLE", "Zeige Tabelle für Optionen");
define("_MI_ICMSPOLL_MENUMAIN_VIEWRESULTS", "Zeige Ergebnisse");
/**
 * Notifications
 */
define("_MI_ICMSPOLL_GLOBAL_NOTIFY", "Alle Umfragen");
define("_MI_ICMSPOLL_GLOBAL_NOTIFY_DSC", "Benachrichtigungen für alle Umfragen");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY", "Neue Umfrage wurde erstellt");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_CAP", "Benachrichtige mich, wenn eine neue Umfrage erstellt wurde");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_DSC", "Erhalten Sie eine Benachrichtigung, wenn eine neue Umfrage gestartet wurde.");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : Neue Umfrage gestartet");