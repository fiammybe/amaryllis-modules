<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /language/german/common.php
 * 
 * german common language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: common.php 643 2012-06-30 09:50:55Z st.flohrer $
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
/**
 * constants for poll objects
 */
define("_CO_ICMSPOLL_POLLS_QUESTION", "Frage");
define("_CO_ICMSPOLL_POLLS_DESCRIPTION", "Beschreibung der Umfrage (optional)");
define("_CO_ICMSPOLL_POLLS_DELIMETER", "Wählen Sie das gewünschte Trennzeichen für Optionen");
define("_CO_ICMSPOLL_POLLS_DELIMETER_DSC", "Die Trennzeichen können ein Zeilenumbruch oder ein Leerzeichen sein.");
define("_CO_ICMSPOLL_POLLS_USER_ID", "Erstellt von");
define("_CO_ICMSPOLL_POLLS_START_TIME", "Sartzeit");
define("_CO_ICMSPOLL_POLLS_END_TIME", "Endzeit");
define("_CO_ICMSPOLL_POLLS_VOTES", "Stimmen insgesamt");
define("_CO_ICMSPOLL_POLLS_VOTERS", "Abstimmer insgesamt");
define("_CO_ICMSPOLL_POLLS_DISPLAY", "Zeige die Umfrage im Block?");
define("_CO_ICMSPOLL_POLLS_WEIGHT", "Gewichtung");
define("_CO_ICMSPOLL_POLLS_MULTIPLE", "Sind mehrere Stimmen erlaubt?");
define("_CO_ICMSPOLL_POLLS_MAIL_STATUS", "Möchten Sie eine Benachrichtigung (via PM), wenn die Umfrage abgelaufen ist?");
define("_CO_ICMSPOLL_POLLS_EXPIRED", "Abgelaufen?");
define("_CO_ICMSPOLL_POLLS_STARTED", "gestarted?");
define("_CO_ICMSPOLL_POLLS_CREATED_ON", "Erstellt am");

define("_CO_ICMSPOLL_POLLS_VIEWPERM", "Berechtigung zum Betrachten");
define("_CO_ICMSPOLL_POLLS_VIEWPERM_DSC", "Wähle die Gruppen, welche Berechtigung haben, die Umfrage zu sehen");
define("_CO_ICMSPOLL_POLLS_VOTEPERM", "Wahlberechtigung");
define("_CO_ICMSPOLL_POLLS_VOTEPERM_DSC", "Wähle die Gruppen, welche Berechtigung haben, bei der Umfrage abzustimmen");
define("_CO_ICMSPOLL_POLLS_DELIMETER_BRTAG", "Zeilenumbruch (&lt;br /&gt;)");
define("_CO_ICMSPOLL_POLLS_DELIMETER_SPACE", "Leerzeichen (&amp;nbsp;)");

define("_CO_ICMSPOLL_POLLS_MESSAGE_SUBJECT", "Ihre Umfrage ist abgelaufen");
define("_CO_ICMSPOLL_POLLS_MESSAGE_BDY", "Ihre Umfrage %s ist abgelaufen, Sie können jetzt das Ergebnis Betrachten..");
define("_CO_ICMSPOLL_POLLS_GET_MORE_BY_USER", "Zeige mehr Umfragen von ");
define("_CO_ICMSPOLL_POLLS_GET_MORE_RESULTS_BY_USER", "Zeige mehr Ergebnisse von ");
define("_CO_ICMSPOLL_POLLS_FILTER_ACTIVE", "Aktive Umfragen");
define("_CO_ICMSPOLL_POLLS_FILTER_EXPIRED", "Abgelaufene Umfragen");
define("_CO_ICMSPOLL_POLLS_ENDTIME_ERROR", "Endzeit muss in der Zukunft liegen");
define("_CO_ICMSPOLL_POLLS_FILTER_INACTIVE", "Inaktiv");
define("_CO_ICMSPOLL_POLLS_FILTER_STARTED", "gestartet");
define("_CO_ICMSPOLL_RESET", "Setze die Umfrage zurück VORSICHT: Das kann nicht rückgängig gemacht werden! Einmal geklickt und Ihre Umfrage wird zurückgesetzt. Alle Log-Einträge werden gelöscht!");
/**
 * constants for options objects
 */
define("_CO_ICMSPOLL_OPTIONS_POLL_ID", "Wähle die Umfrage");
define("_CO_ICMSPOLL_OPTIONS_POLL_ID_DSC", "");
define("_CO_ICMSPOLL_OPTIONS_OPTION_TEXT", "Text für diese Option");
define("_CO_ICMSPOLL_OPTIONS_OPTION_TEXT_DSC", "Der Tect, der zu dieser Option im Formular erscheint");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COLOR", "Farbe der Option");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COLOR_DSC", "Wähle die Farbe der Option. Diese wird dann im Front end als Hintergrundfarbe im Formular erscheinen");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COUNT", "Stimmen insgesamt");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COUNT_DSC", "");
define("_CO_ICMSPOLL_OPTIONS_USER_ID", "Erstellt von");
define("_CO_ICMSPOLL_OPTIONS_OPTION_INIT", "Anfangswert");
define("_CO_ICMSPOLL_OPTIONS_OPTION_INIT_DSC", "Wenn Sie möchten, können Sie einen Anfangswert für diese Option erstellen. Dieser Initialwert wird während der Umfrage für alle Benutzer eingerechnet, nicht aber bei Administratoren.");

define("_CO_ICMSPOLL_OPTIONS_VOTES", "Stimmen");
// colors
define("_CO_ICMSPOLL_OPTIONS_COLORS_AQUA", "Aqua");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLANK", "Weiß");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLUE", "Blau");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BROWN", "Braun");
define("_CO_ICMSPOLL_OPTIONS_COLORS_DARKGREEN", "Dunkelgrün");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GOLD", "Gold");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GREEN", "Grün");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GREY", "Grau");
define("_CO_ICMSPOLL_OPTIONS_COLORS_ORANGE", "Orange");
define("_CO_ICMSPOLL_OPTIONS_COLORS_PINK", "Pink");
define("_CO_ICMSPOLL_OPTIONS_COLORS_PURPLE", "Lila");
define("_CO_ICMSPOLL_OPTIONS_COLORS_RED", "Rot");
define("_CO_ICMSPOLL_OPTIONS_COLORS_YELLOW", "Gelb");
define("_CO_ICMSPOLL_OPTIONS_COLORS_TRANSPARENT", "Transparent");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLACK", "Schwarz");
/**
 * constants for log objects
 */
define("_CO_ICMSPOLL_LOG_POLL_ID", "Betroffene Umfrage");
define("_CO_ICMSPOLL_LOG_POLL_ID_DSC", "");
define("_CO_ICMSPOLL_LOG_OPTION_ID", "Betroffene Option");
define("_CO_ICMSPOLL_LOG_OPTION_ID_DSC", "");
define("_CO_ICMSPOLL_LOG_IP", "IP");
define("_CO_ICMSPOLL_LOG_USER_ID", "Benutzer");
define("_CO_ICMSPOLL_LOG_TIME", "Zeit");
define("_CO_ICMSPOLL_LOG_SESSION_ID", "Session Fingerprint");
/**
 * constants for indexpage objects
 */
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMAGE", "Wählen Sie ein Bild");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMAGE_DSC", "Sie können ein Bild aus der Liste wählen oder ein neues hochladen");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMG_UPLOAD", "Bild hochladen");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMG_UPLOAD_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADER", "Index Überschrift");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADER_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADING", "Index Heading");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADING_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_FOOTER", "Index footer");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_FOOTER_DSC", "");

/**
 * added in 2.2
 */
define("_CO_ICMSPOLL_ADMIN_SHOW_DETAILS", "Zeige Admin-Details");
define("_CO_ICMSPOLL_POLL_HAS_EXPIRED", "Eine Umfrage ist abgelaufen.");
define("_CO_ICMSPOLL_OPTION_TOTALVOTES", "Stimmen");
