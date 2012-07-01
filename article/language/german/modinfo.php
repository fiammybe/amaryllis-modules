<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /language/english/modinfo.php
 * 
 * modinfo language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_ARTICLE_MD_NAME", "Article");
define("_MI_ARTICLE_MD_DSC", "'Article' ist ein Artikel-Verwaltungs Module für ImpressCMS. Es ist möglich Kategorien anzulegen und Dateianhänge hinzuzufügen.");
// templates
define("_MI_ARTICLE_INDEX_TPL", "Article Startseite im Frontend");
define("_MI_ARTICLE_ARTICLE_TPL", "Articles for article loop on index view");
define("_MI_ARTICLE_CATEGORY_TPL", "Categories for category loop on index view");
define("_MI_ARTICLE_FORMS_TPL", "Article submit forms to submit Articles and categories from frontend");
define("_MI_ARTICLE_SINGLEARTICLE_TPL", "Display a single article");
define("_MI_ARTICLE_ADMIN_TPL", "Template for module ACP");
define("_MI_ARTICLE_REQUIREMENTS_TPL", "Check requirements");
define("_MI_ARTICLE_HEADER_TPL", "header and footer file included in all frontend templates.");
define("_MI_ARTICLE_PRINT_TPL", "Print template for single articles");
// blocks
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE", "Neuste Artikel");
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE_DSC", "Zeigt die neusten Artikel an");
define("_MI_ARTICLE_BLOCK_RECENT_UPDATED", "Zuletzt aktuellesiete Artikel");
define("_MI_ARTICLE_BLOCK_RECENT_UPDATED_DSC", "Zeigt die Artikel, welche zuletzt aktuellesiert wurden");
define("_MI_ARTICLE_BLOCK_MOST_POPULAR", "Beliebteste Artikel");
define("_MI_ARTICLE_BLOCK_MOST_POPULAR_DSC", "Zeigt die beliebtesten Artikel an");
define("_MI_ARTICLE_BLOCK_CATEGORY_MENU", "Kategorie Menü");
define("_MI_ARTICLE_BLOCK_CATEGORY_MENU_DSC", "Kategorie Menü Block");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT", "Article Spotlight");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT_DSC", "Spotlight Block für Articles");
define("_MI_ARTICLE_BLOCK_RANDOM_ARTICLES", "Zufalls Artikel");
define("_MI_ARTICLE_BLOCK_RANDOM_ARTICLES_DSC", "Zeigt zufällig einen Artikel");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT_IMAGE", "Galerie");
define("_MI_ARTICLE_BLOCK_SPOTLIGHT_IMAGE_DSC", "Spotlight Block für Artikel-Bilder");
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE_LIST", "Artikel Liste");
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE_LIST_DSC", "Zeigt eine einfache Liste der Artikel");
define("_MI_ARTICLE_BLOCK_MOST_COMMENTED", "Meist kommentiert");
define("_MI_ARTICLE_BLOCK_MOST_COMMENTED_DSC", "Zeigt den am häufigst kommentierten Artikel nach Kategorien sortiert");
define("_MI_ARTICLE_BLOCK_NEWSTICKER", "Newsticker");
define("_MI_ARTICLE_BLOCK_NEWSTICKER_DSC", "Es wird empfohlen, den Block-Titel zu entfernen um einen schöneren Newsticker zu erhalten.");
// preferences
define("_MI_ARTICLE_AUTHORIZED_GROUPS", "Autorisiere Gruppen, um vom Frontend Kategorien einzureichen.");
define("_MI_ARTICLE_AUTHORIZED_GROUPS_DSC", "Alle gewählten Gruppen sind in der Lage, Kategorien aus dem Frontend heraus einzureichen.");
define("_MI_ARTICLE_DATE_FORMAT", "Datumsformat");
define("_MI_ARTICLE_DATE_FORMAT_DSC", "Für mehr Informationen: <a href=\"http://php.net/manual/en/function.date.php\" target=\"blank\">siehe php.net Anleitung</a>");
define("_MI_ARTICLE_SHOW_BREADCRUMBS", "Zeige Breadcrumb");
define("_MI_ARTICLE_SHOW_BREADCRUMBS_DSC", "Wähle 'JA' um die Breadcrumb-Navigation im Frontend anzuzeigen.");
define("_MI_ARTICLE_SHOW_CATEGORIES", "Zeige Kategorien");
define("_MI_ARTICLE_SHOW_CATEGORIES_DSC", "Wie viele Kategorien sollen auf jeder Seite in der Übersicht angezeigt werden?");
define("_MI_ARTICLE_SHOW_CATEGORY_COLUMNS", "Kategorienspalten");
define("_MI_ARTICLE_SHOW_CATEGORY_COLUMNS_DSC", "In wie vielen Spalten sollen die Kategorien in der Übersicht angezeigt werden?");
define("_MI_ARTICLE_SHOW_ARTICLE", "Artikelanzahl");
define("_MI_ARTICLE_SHOW_ARTICLE_DSC", "Wie viele Artikel sollen in der Übersicht auf jeder Seite maximal angezeigt werden?");
define("_MI_ARTICLE_THUMBNAIL_WIDTH", "Screenshot Vorschaubild Breite");
define("_MI_ARTICLE_THUMBNAIL_WIDTH_DSC", "Bestimmen sie die maximale Breite des Vorschaubildes");
define("_MI_ARTICLE_THUMBNAIL_HEIGHT", "Screenshot Vorschaubild Höhe");
define("_MI_ARTICLE_THUMBNAIL_HEIGHT_DSC", "Bestimmen sie die maximale Höhe des Vorschaubildes");
define("_MI_ARTICLE_DISPLAY_WIDTH", "Anzeige Breite");
define("_MI_ARTICLE_DISPLAY_WIDTH_DSC", "Bild anzeige breite");
define("_MI_ARTICLE_DISPLAY_HEIGHT", "Anzeige Höhe");
define("_MI_ARTICLE_DISPLAY_HEIGHT_DSC", "Bild anzeige Höhe");
define("_MI_ARTICLE_IMAGE_UPLOAD_WIDTH", "Bild upload Breite");
define("_MI_ARTICLE_IMAGE_UPLOAD_WIDTH_DSC", "Bestimme die maximale Breite für den Bilderupload");
define("_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT", "Bild upload Höhe");
define("_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT_DSC", "Bestimme die maximale Höhe für den Bilderupload");
define("_MI_ARTICLE_UPLOAD_ARTICLE_SIZE", "Dateigröße");
define("_MI_ARTICLE_UPLOAD_ARTICLE_SIZE_DSC", "Bestimme die maximale Dateigröße für den Bilderupload");
define("_MI_ARTICLE_SHOWDISCLAIMER", "Zeige den Haftungsausschluss, bevor Benutzer Artikel einsenden können?");
define("_MI_ARTICLE_SHOWDISCLAIMER_DSC", "Wählen Sie 'Ja' aus, um einen Haftungsausschluss anzuzeigen");
define("_MI_ARTICLE_DISCLAIMER", "Haftungsausschluss für Artikeleinsendungen");
define("_MI_ARTICLE_UPL_DISCLAIMER_TEXT", "<h1>Terms of Service for {X_SITENAME}:</h1>
												<p>{X_SITENAME} reserves the right to remove any image or file for any reason what ever. Specifically, any image/file uploaded that infringes upon copyrights not held by the uploader, is illegal or violates any laws, will be immediately deleted and the IP address of the uploaded reported to authorities. Violating these terms will result in termination of your ability to upload further images/files.
												Do not link or embed images hosted on this service into a large-scale, non- forum website. You may link or embed images hosted on this service in personal sites, message boards, and individual online auctions.</p>
												<p>By uploading images to {X_SITENAME} you give permission for the owners of {X_SITENAME} to publish your images in any way or form, meaning websites, print, etc. You will not be compensated by {X_SITENAME} for any loss what ever!</p>
												<p>We reserve the right to ban any individual uploader or website from using our services for any reason.</p>
												<p>All images uploaded are copyright © their respective owners.</p>
												<h2>Privacy Policy :</h2> 
												<p>{X_SITENAME} collects user's IP address, the time at which user uploaded a file, and the file's URL. This data is not shared with any third party companies or individuals (unless the file in question is deemed to be in violation of these Terms of Service, in which case this data may be shared with law enforcement entities), and is used to enforce these Terms of Service as well as to resolve any legal matters that may arise due to violations of the Terms of Service. </p>
												<h2>Legal Policy:</h2> 
												<p>These Terms of Service are subject to change without prior warning to its users. By using {X_SITENAME}, user agrees not to involve {X_SITENAME} in any type of legal action. {X_SITENAME} directs full legal responsibility of the contents of the files that are uploaded to {X_SITENAME} to individual users, and will cooperate with law enforcement entities in the case that uploaded files are deemed to be in violation of these Terms of Service. </p>
												<p>All files are © to their respective owners · All other content © {X_SITENAME}. {X_SITENAME} is not responsible for the content any uploaded files, nor is it in affiliation with any entities that may be represented in the uploaded files.</p>");
define("_MI_ARTICLE_SHOW_DOWN_DISCL", "Zeige den Haftungsausschluss, bevor Benutzer Dateianhänge herunterladen können?");
define("_MI_ARTICLE_SHOW_DOWN_DISCL_DSC", "Wählen Sie 'Ja' aus, um einen Haftungsausschluss anzuzeigen");
define("_MI_ARTICLE_DOWN_DISCLAIMER", "Haftungsausschluss für Dateianhänge");
define("_MI_ARTICLE_DOWN_DISCLAIMER_TEXT", "<h1>TERMS OF USE</h1>
												<p>All products available for download through this site are provided by third party software/scripts publishers pursuant to license agreements or other arrangements between such publishers and the end user. We disclaim any responsibility for or liability related to the software/scripts. Any questions complaints or claims related to the software should be directed to the appropriate Author or Company responsible for developing the software. We make no representations or warranties of any kind concerning the quality, safety or suitability of the software/script, either expressed or implied, including without limitation any implied warranties of merchantability, fitness for a particular purpose, or non-infringement. We make no representation or warrantie as to the truth, accuracy or completeness of any statements, information or materials concerning the software/script that is contained on and within any of the websites owned and operated by us. In no event will we be liable for any indirect, punitive, special, incidental or consequential damages however they may arise and even if we have been previously advised of the possibility of such damages. There are inherent dangers in the use of any software/script available for download on the Internet, and we caution you to make sure that you completely understand the potential risks before downloading any of the software/scripts. You are solely responsible for adequate protection and backup of the data and equipment used in connection with any of the software, and we will not be liable for any damages that you may suffer in connection with using, modifying or distributing any of the software.</p>
												<h2>PRIVACY STATEMENT</h2>
												<p>We record visits to this web site and logs the following information for statistical purposes: the user's server or proxy address, the date/time of the visit and the files requested. The information is used to analyse our server traffic. No attempt will be made to identify users or their browsing activities except where authorized by law. For example in the event of an investigation, a law enforcement agency may exercise their legal authority to inspect the internet service provider's logs. If you send us an email message or contact as via contact form, we will record your contact details. This information will only be used for the purpose for which you have provided it. We will not use your email for any other purpose and will not disclose it without your consent except where such use or disclosure is permitted under an exception provided in the Privacy Act. When users choose to join a mailing list their details are added to that specific mailing list and used for the stated purpose of that list only.</p>
												<h2>LINKING</h2>
												<p>Links to external web sites are inserted for convenience and do not constitute endorsement of material at those sites, or any associated organization, product or service.</p>");
define("_MI_ARTICLE_USE_RSS", "Verwende RSS-Feeds?");
define("_MI_ARTICLE_USE_RSS_DSC", "Wähle 'JA', um einen RSS-Link anzubieten.");
define("_MI_ARTICLE_USE_SPROCKETS", "Verwende 'Sprockets' Module?");
define("_MI_ARTICLE_USE_SPROCKETS_DSC", "Sie können das 'Sprockets'-Module verwenden, um mit Tags zu arbeiten.");
define("_MI_ARTICLE_NEED_RELATED", "Benötigen Sie verwandte Artikel?");
define("_MI_ARTICLE_NEED_RELATED_DSC", "Wenn Sie 'JA' auswählen, können sie aus einer Liste verwandte Artikel auswählen.");
define("_MI_ARTICLE_NEED_ATTACHMENTS", "Benötigen Sie Dateianhänge?");
define("_MI_ARTICLE_NEED_ATTACHMENTS_DSC", "Hier können Sie die Funktion der Dateianhänge ein- und ausschalten");
define("_MI_ARTICLE_ARTICLE_APPROVE", "Benötigen Sie eine Überprüfung der eingesendeten Dateianhänge?");
define("_MI_ARTICLE_ARTICLE_APPROVE_DSC", "Wählen Sie 'JA', um Dateianhänge, welche über das Frontend eingesendet wurden, vorher zu kontrollieren.");
define("_MI_ARTICLE_CATEGORY_APPROVE", "Benötigen Sie eine Überprüfung eingesendeter Kategorien?");
define("_MI_ARTICLE_CATEGORY_APPROVE_DSC", "Wählen Sie 'JA', um Kategorien, welche über das Frontend eingesendet wurden, vorher zu kontrollieren.");
define("_MI_ARTICLE_DISPLAY_ARTICLE_SIZE", "Wie soll die Dateigröße angezeigt werden?");
define("_MI_ARTICLE_DISPLAY_ARTICLE_SIZE_DSC", "Wähle 'byte', um sie in Byte, 'mb', um sie in Megabyte, oder 'gb', um sie im Gigabyte-Format anzuzeigen");
define("_MI_ARTICLE_POPULAR", "Vie oft soll ein Artikel aufgerufen werden, bevor er als beliebt gilt?");
define("_MI_ARTICLE_DAYSNEW", "Wie viele Tage soll ein Artikel als 'Neu' gekennzeichnet werden?");
define("_MI_ARTICLE_DAYSUPDATED", "Wie viele Tage soll ein Artikel mit 'update' gekennzeichnet sein, nachdem er bearbeitet wurde.");
define("_MI_ARTICLE_DEFAULT", "Vorgabe");
define("_MI_ARTICLE_HORIZONTAL", "Horizontal");
define("_MI_ARTICLE_VERTICAL", "Vertikal");
define("_MI_ARTICLE_DISPLAY_TWITTER", "Zeige Twitter Button");
define("_MI_ARTICLE_DISPLAY_TWITTER_DSC", "");
define("_MI_ARTICLE_DISPLAY_FBLIKE", "Zeige Facebook Button");
define("_MI_ARTICLE_DISPLAY_FBLIKE_DSC", "");
define("_MI_ARTICLE_DISPLAY_GPLUS", "Zeige G+ Button");
define("_MI_ARTICLE_DISPLAY_GPLUS_DSC", "");
define("_MI_ARTICLE_PRINT_FOOTER", "Druck Fußzeile");
define("_MI_ARTICLE_PRINT_FOOTER_DSC", "Diese Fußzeile wird für die Druckansicht verwendet");
define("_MI_ARTICLE_PRINT_LOGO", "Druck Logo");
define("_MI_ARTICLE_PRINT_LOGO_DSC", "Geben Sie den Pfad zum Logo an, welches gedruckt werden soll, z.B.: /themes/example/images/logo.gif");
define("_MI_ARTICLE_DISPLAY_NEWSTICKER", "Zeige Newsticker?");
define("_MI_ARTICLE_DISPLAY_NEWSTICKER_DSC", "Wählen Sie 'JA', um den Newsticker anzuzeigen .<br />Hinweis: Es steht auch ein Block mit dem Newsticker zur Verfügung.");
define("_MI_ARTICLE_NEED_DEMO", "Benötigen Sie einen Demo-Link?");
define("_MI_ARTICLE_NEED_DEMO_DSC", "Benötigen Sie einen Demo-Link für Ihre articles/attachments?");
define("_MI_ARTICLE_NEED_CONCLUSION", "Benötigen Sie die Fazit-Sektion im Artikel?");
define("_MI_ARTICLE_NEED_CONCLUSION_DSC", "Wählen Sie 'JA' um ein Fazit anzuzeigen. Dies wird nur dann eingeblendet, wenn der Inhalt des Fazit nicht leer ist.");
// Notifications
define('_MI_ARTICLE_GLOBAL_NOTIFY', 'Global');
define('_MI_ARTICLE_GLOBAL_NOTIFY_DSC', 'Global Article Benachrichtigungsoptions.');
define('_MI_ARTICLE_CATEGORY_NOTIFY', 'Kategorie');
define('_MI_ARTICLE_CATEGORY_NOTIFY_DSC', 'Benachrichtigungsoptions welche zur entsprechenden Artikel-Kategorie gehören.');
define('_MI_ARTICLE_ARTICLE_NOTIFY', 'Article');
define('_MI_ARTICLE_ARTICLE_NOTIFY_DSC', 'Benachrichtigungsoptions welche zum aktuellen Artikel gehören.');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY', 'Neue Kategorie');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_CAP', 'Benachrichtigen Sie mich, wenn eine neue Kategorie erstellt wurde.');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_DSC', 'Receive notification when a new file category is created.');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New article category');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY', 'Kategorie bearbeitet');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_CAP', 'Notify me when any category is modified.');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_DSC', 'Receive notification when any category is modified.');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Kategorie bearbeitet');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY', 'Neuer Artikel');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_CAP', 'Notify me when any new file is posted.');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_DSC', 'Receive notification when any new file is posted.');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file');
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY', 'Neuer Artikel');
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_CAP', 'Notify me when a new file is posted to the current category.');   
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_DSC', 'Receive notification when a new file is posted to the current category.');      
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file in category'); 
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY', 'Artikel berarbeitet');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_CAP', 'Notify me when this file is modified.');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_DSC', 'Receive notification when this file is modified.');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Artikel berarbeitet');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY', 'Artikel berarbeitet');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_CAP', 'Notify me when a file in this category is modified.');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_DSC', 'Receive notification when a file in this category is modified.');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Artikel berarbeitet');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY', 'Artikel berarbeitet');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_CAP', 'Notify me when any file is modified.');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_DSC', 'Receive notification when any file is modified.');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Artikel berarbeitet');

// ACP menu
define("_MI_ARTICLE_MENU_INDEX", "Index");
define("_MI_ARTICLE_MENU_ARTICLE", "Artikel Übersicht");
define("_MI_ARTICLE_MENU_CATEGORY", "Kategorie Übersicht");
define("_MI_ARTICLE_MENU_INDEXPAGE", "Indexseite");
define("_MI_ARTICLE_MENU_PERMISSIONS", "Berechtigungen");
define("_MI_ARTICLE_MENU_TEMPLATES", "Templates");
define("_MI_ARTICLE_MENU_MANUAL", "Anleitung");
define("_MI_ARTICLE_MENU_IMPORT", "Import");
// Submenu while calling a tab
define("_MI_ARTICLE_ARTICLE_EDIT", "Bearbeite deinen Artikel");
define("_MI_ARTICLE_ARTICLE_CREATINGNEW", "Lade einen neuen Artikel hoch");
define("_MI_ARTICLE_CATEGORY_EDIT", "Bearbeite deine Kategorie");
define("_MI_ARTICLE_CATEGORY_CREATINGNEW", "Erstelle eine neue Kategorie");
/**
* added in 1.1
*/
//preferences
define("_MI_ARTICLE_RSSLIMIT", "RSS Limit");
define("_MI_ARTICLE_RSSLIMIT_DSC", "Limit of Articles for RSS");