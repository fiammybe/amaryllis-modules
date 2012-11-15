<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /language/german/modinfo.php
 * 
 * german modinfo language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		optimistdd
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_EVENT_MD_NAME", "Veranstaltung");
define("_MI_EVENT_MD_DESC", "ImpressCMS Simple Event module");
// acp menu
define("_MI_EVENT_MENU_EVENTS", "Veranstaltungen");
define("_MI_EVENT_MENU_CATEGORY", "Kategorie");
define("_MI_EVENT_MENU_CALENDAR", "Kalender");
define("_MI_EVENT_MENU_MANUAL", "Anleitung");
define("_MI_EVENT_MENU_TEMPLATES", "Templates");
// config
define("_MI_EVENT_CONFIG_DEFAULT_VIEW", "Ansicht");
define("_MI_EVENT_CONFIG_DEFAULT_VIEW_DSC", "W&auml;hlen Sie die Standardansicht f�r den Kalender.");
define("_MI_EVENT_CONFIG_DEFAULT_VIEW_MONTH", "Monat");
define("_MI_EVENT_CONFIG_DEFAULT_VIEW_DAY", "Tag");
define("_MI_EVENT_CONFIG_FIRST_DAY", "Der erste Tag welcher in der Woche angezeigt werden soll");
define("_MI_EVENT_CONFIG_FIRST_DAY_DSC", "Bei der Auswahl Sonntag, sicher sein, das Wochenenden in der Wochenansicht angezeigt werden sollen");
define("_MI_EVENT_CONFIG_DISPLAY_WEEKEND", "Wochenende anzeigen");
define("_MI_EVENT_CONFIG_DISPLAY_WEEKEND_DSC", "Soll das Wochenende angezeigt werden?");
define("_MI_EVENT_CONFIG_AGENDA_START", "Startzeit des Kalenders");
define("_MI_EVENT_CONFIG_AGENDA_START_DSC", "Dies wird die Startzeit des Kalenders zu sein, was bedeutet, dass die Zeit bis zur ersten angezeigt werden, wenn in einzelnen Tages-oder Wochenansicht. Muss 0-23 sein");
define("_MI_EVENT_CONFIG_AGENDA_MIN", "Min. Zeit f&uuml;r Woche / Tag Ansicht.");
define("_MI_EVENT_CONFIG_AGENDA_MIN_DSC", "Die minimale Zeit, sich auf &Uuml;bersicht angezeigt werden.");
define("_MI_EVENT_CONFIG_AGENDA_MAX", "Max Zeit f&uuml;r Woche / Tag Ansicht.");
define("_MI_EVENT_CONFIG_AGENDA_MAX_DSC", "Die maximale Zeit, um auf &Uuml;bersicht angezeigt werden.");
define("_MI_EVENT_CONFIG_AGENDA_SLOT", "Zeiteinteilung der Minuten");
define("_MI_EVENT_CONFIG_AGENDA_SLOT_DSC", "Zeiteinteilung der Stunden z.B. 15 Minuten Abschnitten");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_M", "Datumsformat Kopfzeile Monat");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_M_DSC", "Datumsformat f&uuml;r Kalender-Kopfzeile in der Monatsansicht. <b> Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung! </ b>");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_W", "Datumsformat Kopfzeile Woche");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_W_DSC", "Datumsformat f&uuml;r Kalender-Kopfzeile in der Wochenansicht. <b>Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_D", "Datumsformat Kopfzeile Tag");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_D_DSC", "Datumsformat f&uuml;r Kalender-Kopfzeile in der Tagesansicht. <b>Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_M", "Datumsformat Spalte Monat");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_M_DSC", "Datumsformat f&uuml;r Kalender-Spalte in der Monatsansicht. <b>Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung!!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_W", "Datumsformat Spalte Woche");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_W_DSC", "Datumsformat f&uuml;r Kalender-Spalte in der Wochenansicht. <b>Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_D", "Datumsformat Spalte Tag");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_D_DSC", "Datumsformat f&uuml;r Kalender-Spalte in der Tagesansicht. <b>Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_TIME_A", "Uhrzeitformat Agenda (Woche und Tag)");
define("_MI_EVENT_CONFIG_DEFAULT_TIME_A_DSC", "Uhrzeitformat f&uuml;r Kalender Agenda Ansicht. <b>Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_TIME", "Uhrzeitformat (Monat, alle au&szlig;erhalb der Agenda-Ansicht)");
define("_MI_EVENT_CONFIG_DEFAULT_TIME_DSC", "Uhrzeitformat f&uuml;r Kalender-Ansicht au&szlig;erhalb der Agenda Aussicht. <b>Bitte &uuml;berpr&uuml;fen Handbuch f&uuml;r Datumsformatierung!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_TIMEZONE", "Standard Zeitzone");
define("_MI_EVENT_CONFIG_DEFAULT_TIMEZONE_DSC", "");
define("_MI_EVENT_CONFIG_USE_THEME", "Verwenden Sie die jQuery UI in Ihrem Thema?");
define("_MI_EVENT_CONFIG_USE_THEME_DSC", "Standardm&auml;&szlig;ig verwendet der Kalender den jQuery UI in Ihrem Theme. Vielleicht m&ouml;chten Sie ein anderes Theme (google jquery ui theme roller) installieren Sie ein Neues Thema oder stellen Sie einfach ui aus, um Ihr eigenes Design f&uuml;r den Kalender zu entwerfen");
define("_MI_EVENT_CONFIG_PRINT_FOOTER", "Fusszeile drucken");
define("_MI_EVENT_CONFIG_PRINT_FOOTER_DSC", "");
define("_MI_EVENT_CONFIG_PRINT_LOGO", "Logo drucken");
define("_MI_EVENT_CONFIG_PRINT_LOGO_DSC", "");
// blocks
define("_MI_EVENT_BLOCK_MINICAL", "Mini Kalendar");
define("_MI_EVENT_BLOCK_MINICAL_DSC", "Mini Kalendar f&uuml;r Bl&ouml;cke");
define("_MI_EVENT_BLOCK_LIST", "Veranstaltungen");
define("_MI_EVENT_BLOCK_LIST_DSC", "Liste der Veranstaltungen in einem Zeitraum");
define("_MI_EVENT_BLOCK_SELECT", "Veranstaltungssuche");
define("_MI_EVENT_BLOCK_SELECT_DSC", "Ein Block, um den Zeitintervall w�hlen, um Events zu erhalten");
// notifications
define('_MI_EVENT_GLOBAL_NOTIFY', 'Global');
define('_MI_EVENT_GLOBAL_NOTIFY_DSC', 'Globale Event Benachrichtigungsoptionen.');
define('_MI_EVENT_EVENT_NOTIFY', 'Kategorie');
define('_MI_EVENT_EVENT_NOTIFY_DSC', 'Benachrichtigungs-Optionen, die zum aktuellen Event-Kategorie gelten.');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY', 'Neue Veranstaltung');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_CAP', 'Benachrichtigen Sie mich, wenn eine Neue Veranstaltung erstellt wurde.');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_DSC', 'Erhalten einer Benachrichtigung, wenn eine Neue Veranstaltung wird.');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Neue Veranstaltung');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY', 'Veranstaltung Ge�ndert');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY_CAP', 'Benachrichtigen Sie mich, wenn eine Veranstaltung ge�ndert wurde.');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY_DSC', 'Erhalten einer Benachrichtigung, wenn eine Veranstaltung ge�ndert wurde.');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Veranstaltung Ge�ndert');
/**
 * added in 1.1
 */
//config
define("_MI_EVENT_CONFIG_PROFILE_BIRTHDAY", "Field name of the birthday field");
define("_MI_EVENT_CONFIG_PROFILE_BIRTHDAY_DSC", "The Birthday Field needs to be a date Field and 'Profile' module is required!");
define("_MI_EVENT_CONFIG_PROFILE_BIRTHDAY_CAL", "Select the Calendar for User Birthdays");
define("_MI_EVENT_CONFIG_PROFILE_BIRTHDAY_CAL_DSC", "");
// autotasks
define("_MI_EVENT_AUTOTASK_PROFILE_BIRTHDAYS", "Profile Birthdays import for Event Module");
// blocks
define("_MI_EVENT_BLOCK_CALENDARS", "Calendars");
define("_MI_EVENT_BLOCK_CALENDARS_DSC", "Display Categories/Calendars in a Block");