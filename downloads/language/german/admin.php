<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/english/admin.php
 *
 * English language constants used in admin section of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 * 
 */

// Requirements
define("_AM_DOWNLOADS_REQUIREMENTS", "'Downloads' Voraussetzungen");
define("_AM_DOWNLOADS_REQUIREMENTS_INFO", "Eine Überprüfung Ihres Systems ergab, das leider nicht alle Vorraussetzungen für 'Downloads' erfüllt sind, um ein Funktionieren zu garantieren. Unten stehen die benötigten Voraussetzungen.");
define("_AM_DOWNLOADS_REQUIREMENTS_ICMS_BUILD", "'Downloads' benötigt mindestens ImpressCMS 1.3 final.");
define("_AM_DOWNLOADS_REQUIREMENTS_SUPPORT", "Sollten sie Fragen oder Bedenken haben, besuchen Sie bitte unser Forum unter <a href='http://impresscms.de/modules/forum/'>ImpressCMS.DE Community</a>.");
//Admin Index
define("_AM_DOWNLOADS_INDEX_WARNING", "<b>BITTE LESEN SIE DIE ANLEITUNG BEVOR SIE DAS MODUL BENUTZEN.</b>");
define("_AM_DOWNLOADS_INDEX", "Downloads Zusammenfassung");
define("_AM_DOWNLOADS_INDEX_TOTAL", "Gegenwärtig gibt es");
define("_AM_DOWNLOADS_FILES_IN", "&nbsp;Dateien in &nbsp;");
define("_AM_DOWNLOADS_CATEGORIES", "&nbsp; Kategorien");
define("_AM_DOWNLOADS_INDEX_BROKEN_FILES", "Defekte Dateien:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_FILES", "Dateien zum freischalten:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_MIRRORS", "Mirrors zum bewilligen:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_CATS", "Kategorien zum bewilligen: &nbsp;");

// 
define("_AM_DOWNLOADS_DOWNLOAD_ADD", "Datei hinzufügen");
define("_AM_DOWNLOADS_CREATE", "Neu");
define("_AM_DOWNLOADS_EDIT", "Bearbeiten");
define("_AM_DOWNLOADS_CREATED", "Erfolgreich erstellt");
define("_AM_DOWNLOADS_MODIFIED", "Erfolgreich bearbeitet");
define("_AM_DOWNLOADS_ONLINE", "Online");
define("_AM_DOWNLOADS_OFFLINE", "Offline");
define("_AM_DOWNLOADS_DOWNLOAD_WEIGHTS_UPDATED", "Gewichtung aktualisiert");
define("_AM_DOWNLOADS_DOWNLOAD_NOFILEEXIST", "Datei nicht gefunden");

define("_AM_DOWNLOADS_INDEXPAGE_EDIT", "Bearbeite die Frontend-Indexseite");
define("_AM_DOWNLOADS_INDEXPAGE_MODIFIED", "Indexseite bearbeitet");

define("_AM_DOWNLOADS_CATEGORY_ADD", "Kategorie hinzufügen");
define("_AM_DOWNLOADS_CATEGORY_WEIGHTS_UPDATED", "Gewichtung aktualisiert");

define("_AM_DOWNLOADS_INBLOCK_TRUE", "Sichtbar in den Blöcken");
define("_AM_DOWNLOADS_INBLOCK_FALSE", "Versteckt in den Blöcken");

define("_AM_DOWNLOADS_APPROVE_TRUE", "Genehmigt");
define("_AM_DOWNLOADS_APPROVE_FALSE", "Abegelehnt");

define("_AM_DOWNLOADS_MIRROR_FALSE", "Mirror abgelehnt");
define("_AM_DOWNLOADS_MIRROR_TRUE", "Mirror genehmigt");

define("_AM_DOWNLOADS_NO_CAT_FOUND", "Es wurde keine Kategorie gefunden. Bitte erstellen Sie zuerst eine Kategorie. Sollten sie weitere Fragen haben, lesen Sie bitte die Anleitung.");

// constants for permission Form
define("_AM_DOWNLOADS_PREMISSION_DOWNLOADS_VIEW", "Dateien anzeigen");
define("_AM_DOWNLOADS_PREMISSION_CATEGORY_VIEW", "Kategorien anzeigen");
define("_AM_DOWNLOADS_PREMISSION_CATEGORY_SUBMIT", "Kategorien einreichen");