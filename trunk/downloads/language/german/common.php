<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/english/common.php
 *
 * english language constants commonly used in the module
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

//some general language constants
define("_CO_DOWNLOADS_PREVIEW", "Vorschau");
define("_CO_DOWNLOADS_EDIT", "Bearbeiten");
if(!defined("_CO_SUBMIT")) define("_CO_SUBMIT", "Einsenden");
define("_CO_DOWNLOADS_DELETE", "Löschen");
define("_CO_DOWNLOADS_VIEW", "Anzeigen");
if(!defined("_NO_PERM")) define("_NO_PERM", "Keine Berechtigungen");

define("_CO_DOWNLOADS_MODIFIED", "Bearbeitet");
if(!defined("_ER_UP_UNKNOWNFILETYPEREJECTED")) define("_ER_UP_UNKNOWNFILETYPEREJECTED", "Unbekannte Dateiendung");
// language constants for adding new file
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TITLE", "Titel");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TITLE_DSC", "Geben Sie der Datei einen Titel");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_CID", "Kategorie");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_CID_DSC", "Hier können Sie eine Kategorie wöhlen, in der die Datei angezeigt werden soll");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHED_DATE", "Datum der Veröffentlichung");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHED_DATE_DSC", "  ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED_DATE", "Datum des Updates");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED_DATE_DSC", "  ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_IMG", "Vorschaubild");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_IMG_DSC", " Das Vorschaubild wird in der Dateiübersicht angezeigt ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DESCRIPTION", "Beschreibung");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DESCRIPTION_DSC", "Beschreibung der Datei ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ACTIVE", "Aktive?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ACTIVE_DSC", " Wähle 'JA' um die Datei online zu setzen ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_INBLOCKS", "Im Block?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_INBLOCKS_DSC", " Wähle 'JA' um die Datei im Block 'Neuste Downloads' zu zeigen ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_APPROVE", "Genehmigt?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_APPROVE_DSC", "Dateien sind standardmäßig genehmigt, wenn sie von Backend hinzugefügt wurden. Sollten Benutzer Dateien vom Frontend aus hinzufügen und Sie haben die Einstellung ''Überprüfen und Freischalten'' in den Moduleinstellungen gewählt, steht die Einstellung auf 'aus'.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHER", "Herausgeber");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHER_DSC", "Wählen Sie einen Herausgeber für diese Datei");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SUBMITTER", "Einsender");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV", "Entwickler");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_GRPPERM", "Berechtigungen zum Ansehen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_GRPPERM_DSC", " Wählen Sie, welche Gruppen berechtigt sind, diese Datei anzusehen. Dies bedeutet, dass Benutzer, welcher dieser Gruppe angehören, in der Lage sind, diese Datei im Frontend zu sehen.' ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE", "Dateiupload");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_DSC", "  ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_ALT", "ODER Bestimmen Sie eine Datei");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_ALT_DSC", " Sie können auch eine Datei in das Verzeichnis 'upload/downloads/download/' landen und hier eintragen. Zum Beispiel: 'datei.zip' ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_LINK", "Wähle <b>erste</b> Dateiversion");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_LINK_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_HISTORY", "Dateihistorie");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_HISTORY_DSC", "Fügen Sie hier die Dateihistorie ein. HTML ist rudimentär erlaubt.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TEASER", "Teaser");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TEASER_DSC", "Beschreiben Sie die Datei mit 1 bis 2 Sätzen. Der Teaser wird in der Indexliste angezeigt.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LANGUAGE", "Sprache");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LANGUAGE_DSC", "Geben Sie die Sprache Ihrer Datei an.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_KEYFEATURES", "Keyfeatures");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_KEYFEATURES_DSC", " Beschreiben sie die Kernfunktion Ihrer Datei. Verwenden Sie '|' und die Begriffe zu trennen.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_REQUIREMENTS", "Voraussetzungen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_REQUIREMENTS_DSC", " Beschreiben sie die Voraussetzungen Ihrer Datei. Verwenden Sie '|' und die Begriffe zu trennen.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_RELATED", "Verwandte Dateien");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_RELATED_DSC", "");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_1", "1. Screenshot");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_2", "2. Screenshot");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_3", "3. Screenshot");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_SCREEN_4", "4. Screenshot");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION", "Versions Nummer");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_DSC", "In welcher Version liegt Ihre Datei vor?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_STATUS", "Versions Status");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VERSION_STATUS_DSC", "Welchen Status hat Ihre Datei");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_FINAL", "Final");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_ALPHA", "Alpha");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_BETA", "Beta");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_RC", "Release Candidate");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_NONE", "None");
define("_CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_DEPRECATED", "Diese Version ist missbilligt. Bitte verwenden Sie die neuste Version.");

define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LIMITATIONS", "Datei-Limitierungen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LIMITATIONS_DSC", " ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LICENSE", "Lizenz");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LICENSE_DSC", "Wählen Sie eine Lizenz für ihre Datei");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PLATFORM", "Plattform");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PLATFORM_DSC", "Wählen Sie die benötigte Plattform für Ihre Datei");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_URL", "Download Mirror");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_URL_DSC", "Geben Sie die volle URL für ihre Datei zum Mirror an. Zum Beispiel: 'http://www.meinehomepage.de/Dateien/datei.rar'");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_TITLE", "Mirror Titel");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_TITLE_DSC", "Geben Sie hier die Bezeichung zum Mirror an. Dies wird im Frontend anstelle der URL dargestellt.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV_HP", "Entwickler Homepage");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEV_HP_DSC", "Geben Sie die URL zur Seite des Entwicklers an, z.B.: 'http://www.example.com/'");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEMO", "Demo Homepage");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEMO_DSC", "Geben Sie die URL zur Demo-Seite an, z.B.: 'http://www.example.com/'");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED", "'Aktualisiert?'");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_UPDATED_DSC", "Wählen Sie 'JA', wenn die Datei als aktualisiert hervorgehoben werden soll");
define("_CO_DOWNLOADS_DOWNLOAD_CATALOGUE_ITEM", "Wählen Sie einen Eintrag");
define("_CO_DOWNLOADS_DOWNLOAD_CATALOGUE_ITEM_DSC", "Wenn Sie einen Eintrag aus dem Catalog-Modul wählen, wird hier der Preis und Link zum Catalog-Eintrag angezeigt, anstelle des Download-Links");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ALBUM", "Wählen Sie ein Album");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_ALBUM_DSC", "Dies erscheint, weil Sie in den Einstellungen angegeben haben, das Album-Modul als Bildergallerie zu verwenden. Alle Bilder des ausgewählten Albums werden dem Eintrag im Frontend zugeordnet");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_BROKEN", "Defekt?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_BROKEN_DSC", "Diese Einstellung steht auf 'JA' wenn eine Datei als defekt gemeldet wurde.");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_HAS_MIRROR", "Hat einen Mirror?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_APPROVE", "Mirror genehmigt?");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_TAGS", "Tags");

define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_IMAGES", "Fügen Sie einige Bilder hinzu um ihre Datei visuell vorzustellen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_DESCRIPTIONS", "Beschreibe die Datei");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_HANDLING", "Download Mirror");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEVELOPER_INFO", "Entwickler information");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISH_INFO", "Veröffentlichungs-Informationen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VIEW_SECTION", "Öffentliche Berechtigungen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_STATIC_SECTION", "Weitere Beschreibungen");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DOWNCOUNTER", " runtergeladen  ");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_LIKE", "Like");
define("_CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DISLIKE", "Dislike");
// language constants for editing indexpage
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADER", "Titel");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADER_DSC", " Geben Sie den Titel an, welcher auf der Indexseite angezeigt werden soll. ");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADING", "Beschreibung für die Indexseite");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_HEADING_DSC", "  ");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_IMAGE", "Index-Vorschaubild");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_IMAGE_DSC", " Geben Sie ein Index-Vorschaubild ");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_IMG_UPLOAD", " Laden Sie ein neues Vorschaubild hoch ");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_FOOTER", "Footer der Indexseite");
define("_CO_DOWNLOADS_INDEXPAGE_INDEX_FOOTER_DSC", " Geben Sie den Footer an, welche auf der Indexseite angezeigt werden soll. ");
// language constants for adding new categories
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_TITLE", "Titel");
define("_CO_DOWNLOADS_CATEGORY_WEIGHT", "Gewichtung");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PID", "Oberkategorie");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PID_DSC", "Wählen Sie eine Oberkategorie");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_IMG", "Wählen Sie ein Bild");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_IMG_UPLOAD", "Sie können ein neues Bild hochladen");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_DESCRIPTION", "Beschreibung");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_DESCRIPTION_DSC", " Beschreibung der Kategorie ");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_ACTIVE", "Aktive?");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_ACTIVE_DSC", "Wählen Sie 'JA' um diese Kategorie online zu setzen");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_INBLOCKS", "Kategorie in den Blöcken anzeigen?");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_INBLOCKS_DSC", "Wählen Sie 'JA', um die Kategorie in den Blöcken anzuzeigen ");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_APPROVE", "Genehmigt?");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_APPROVE_DSC", "Wählen Sie 'JA' Um die Kategorie zu genehmigen. Benutzerseitig eingereichte Kategorien werden solange als 'abgelehnt' im System geführt, bis sie überprüft worden sind.");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PUBLISHER", "Veröffentlicht von");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_GRPPERM", "Lese-Berechtigungen");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_GRPPERM_DSC", "Wählen Sie, welche Gruppe Lese-Berechtigung für diese Kategorie haben soll.");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_PUBLISHED_DATE", "Veröffentlicht am");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_UPDATED_DATE", "Aktualisiert am");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_SUBMITTER", "Eingesendet von");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_UPLPERM", "Upload Berechtigungen");
define("_CO_DOWNLOADS_CATEGORY_CATEGORY_UPLPERM_DSC", "Wählen Sie, welche Gruppe berechtigt sein soll, Dateien in diese Kategorie zu laden.");
// review system
define("_CO_DOWNLOADS_REVIEW_REVIEW_ITEM_ID", "Eintrag");
define("_CO_DOWNLOADS_REVIEW_REVIEW_UID", "Benutzer");
define("_CO_DOWNLOADS_REVIEW_REVIEW_NAME", "Name");
define("_CO_DOWNLOADS_REVIEW_REVIEW_CASE", "Rezensions Nummer");
define("_CO_DOWNLOADS_REVIEW_REVIEW_EMAIL", "E-Mail");
define("_CO_DOWNLOADS_REVIEW_REVIEW_MESSAGE", "Nachricht");
define("_CO_DOWNLOADS_REVIEW_REVIEW_MESSAGE_DSC", 'Sie können etwas HTML-Code verwenden. Möglich sind &lt;b&gt; für <b>fett</b>, &lt;i&gt; für <i>kusiv</i> Text, &lt;a&gt; für einen Link und &lt;br&gt; für eine neue Zeile. Alles andere wird rausgefiltert.');
define("_CO_DOWNLOADS_REVIEW_REVIEW_DATE", "Datum");
define("_CO_DOWNLOADS_REVIEW_PRAISE", "Lob");
define("_CO_DOWNLOADS_REVIEW_SUGGESTION", "Vorschlag");
define("_CO_DOWNLOADS_REVIEW_PROBLEM", "Problem");
define("_CO_DOWNLOADS_REVIEW_QUESTION", "Frage");
// LOG system
define("_CO_DOWNLOADS_LOG_LOG_ITEM_ID", "Item Name");
define("_CO_DOWNLOADS_LOG_LOG_ITEM", "Item");
define("_CO_DOWNLOADS_LOG_LOG_IP", "IP");
define("_CO_DOWNLOADS_LOG_LOG_UID", "user");
define("_CO_DOWNLOADS_LOG_LOG_CASE", "Log case");
define("_CO_DOWNLOADS_LOG_LOG_DATE", "Log Date");