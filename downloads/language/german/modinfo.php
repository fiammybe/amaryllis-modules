<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/english/modinfo.php
 *
 * English language constants related to module information
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

// general informations
define("_MI_DOWNLOADS_NAME", "Downloads");
define("_MI_DOWNLOADS_DSC", "'Downloads' ist ein Modul, mit dem Sie Dateien zum runterladen bereitstellen können. Es bietet die Möglichkeit Dateien in Kategorien zu ordnen und optional einen User-seitigen Upload für Dateien.");

// templates
define("_MI_DOWNLOADS_INDEX_TPL", "'Downloads' Indexseite im Frontend");
define("_MI_DOWNLOADS_HEADER_TPL", "'Downloads' header enthält die breadcrumb-navigation");
define("_MI_DOWNLOADS_ADMIN_FORM_TPL", "'Downloads' Administrations Form");
define("_AM_DOWNLOADS_REQUIREMENTS_TPL", "'Downloads' Voraussetzungs-Überprüfung");
define("_MI_DOWNLOADS_FOOTER_TPL", "'Downloads' footer beinhaltet Benachrichtigungs- und Kommentarrichtlinien");
define("_MI_DOWNLOADS_CATEGORY_TPL", "'Downloads' Kategorie ansicht im Frontend");
define("_MI_DOWNLOADS_DOWNLOAD_TPL", "'Downloads' Ansicht einer einzelnen Datei im Frontend");

// blocks
define("_MI_DOWNLOADS_BLOCK_RECENT_DOWNLOADS", "Download Liste");
define("_MI_DOWNLOADS_BLOCK_RECENT_DOWNLOADS_DSC", "Auflistung der letzten Downloads");
define("_MI_DOWNLOADS_BLOCK_RECENT_UPDATED", "Zuletzt akualisiere Dateien");
define("_MI_DOWNLOADS_BLOCK_RECENT_UPDATED_DSC", "Auflistung der zuletzt aktualisierten Dateien");
define("_MI_DOWNLOADS_BLOCK_MOST_POPULAR", "Am beliebtesten");
define("_MI_DOWNLOADS_BLOCK_MOST_POPULAR_DSC", "Beliebteste Dateien");
define("_MI_DOWNLOADS_BLOCK_CATEGORY_MENU", "Kategorie Menü");
define("_MI_DOWNLOADS_BLOCK_CATEGORY_MENU_DSC", "Zeige alle Kategorien an, oder wähle eine aus um die Unterkategorien anzuzeigen.");
/**
 * Added in 1.1
 */
define("_MI_DOWNLOADS_BLOCK_SPOTLIGHT_IMAGE", "Gallery Block");
define("_MI_DOWNLOADS_BLOCK_SPOTLIGHT_IMAGE_DSC", "Gallery Block for recent Downloads. Note: The Block will only display Downloads with file image.");
/**
 * E N D added in 1.1
 */
// config
define("_MI_DOWNLOADS_AUTHORIZED_GROUPS", "Gruppen mit der Berechtigung Kategorien hinzuzufügen");
define("_MI_DOWNLOADS_AUTHORIZED_GROUPS_DSC", "Wählen Sie die Gruppen aus, welche berechtigt sein sollen Kategorien hinzuzufügen. Bitte beachten Sie, dass Benutzer, welche dieser Gruppe angehören, in der Lage sind, Kategorien direkt auf der Seite zu erstellen. Das Modul verfügt zur Zeit über keine Moderatoren-Funktionen.");
define("_MI_DOWNLOADS_DATE_FORMAT", "Datumsformat");
define("_MI_DOWNLOADS_DATE_FORMAT_DSC", "Für weitere Informationen: <a href=\"http://php.net/manual/en/function.date.php\" target=\"blank\">Siehe php.net Manual</a>");
define("_MI_DOWNLOADS_SHOW_BREADCRUMBS", "Zeige Breadcrumb");
define("_MI_DOWNLOADS_SHOW_BREADCRUMBS_DSC", "Wählen Sie 'JA', um eine Breadcrump-Navigation im Frontend anzuzeigen.");
define("_MI_DOWNLOADS_SHOW_DOWNLOADS", "zeige Dateien");
define("_MI_DOWNLOADS_SHOW_DOWNLOADS_DSC", "Wie viele Dateien sollen angezeigt werden, bis eine Seitennavigation eingeblendet wird?");
define("_MI_DOWNLOADS_SHOW_CATEGORIES", "Zeige Kategorien");
define("_MI_DOWNLOADS_SHOW_CATEGORIES_DSC", "Wie viele Kategorien sollen auf jeder Seite angezeigt werden?");
define("_MI_DOWNLOADS_SHOW_CATEGORY_COLUMNS", "Anzahl der Kategoriespalten");
define("_MI_DOWNLOADS_SHOW_CATEGORY_COLUMNS_DSC", "In wie vielen Spalten sollen die Kategorien im Frontend angezeigt werden?");
define("_MI_DOWNLOADS_THUMBNAIL_WIDTH", "Screenshot-Thumbnail Breite");
define("_MI_DOWNLOADS_THUMBNAIL_WIDTH_DSC", "Wählen Sie einen Wert für die Breite der Screenshot-Thumbnails");
define("_MI_DOWNLOADS_THUMBNAIL_HEIGHT", "Screenshot-Thumbnail Höhe");
define("_MI_DOWNLOADS_THUMBNAIL_HEIGHT_DSC", "Wählen Sie einen Wert für die Höhe der Screenshot-Thumbnails");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_WIDTH", "Download-Bild-Thumbnail Breite");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_WIDTH_DSC", "Wählen Sie einen Wert für die Breite der Download-Screenshot-Thumbnails");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_HEIGHT", "Download-Bild-Thumbnail Höhe");
define("_MI_DOWNLOADS_FILE_THUMBNAIL_HEIGHT_DSC", "Wählen Sie einen Wert für die Höhe der Download-Screenshot-Thumbnails");

define("_MI_DOWNLOADS_IMAGE_UPLOAD_WIDTH", "Bilder-Upload Breite");
define("_MI_DOWNLOADS_IMAGE_UPLOAD_WIDTH_DSC", "Wählen Sie eine maximale Breite für die Bilder beim Hochladen");
define("_MI_DOWNLOADS_IMAGE_UPLOAD_HEIGHT", "Bilder-Upload Höhe");
define("_MI_DOWNLOADS_IMAGE_UPLOAD_HEIGHT_DSC", "Wählen Sie eine maximale Höhe für die Bilder beim Hochladen");
define("_MI_DOWNLOADS_IMAGE_FILE_SIZE", "Bilder-Upload Größe");
define("_MI_DOWNLOADS_IMAGE_FILE_SIZE_DSC", "Wählen Sie eine maximale Dateigröße für die Bilder beim Hochladen");
define("_MI_DOWNLOADS_UPLOAD_FILE_SIZE", "Maximale Dateigröße");
define("_MI_DOWNLOADS_UPLOAD_FILE_SIZE_DSC", "Wählen Sie eine maximale Dateigröße für die Downloads beim Hochladen");
define("_MI_DOWNLOADS_LIMITS", "Datei Limitierungen");
define("_MI_DOWNLOADS_LIMITS_DSC", "Datei Limitierungen können bei der Erstellung einer Datei angegeben werden. Trennen Sie die einzelnen Limitierungen mit einem Strich: '|'");
define("_MI_DOWNLOADS_SHOWDISCLAIMER", "Zeige die Ausschlussklausel, Bevor Benutzer eine Datei hinzugügen können");
define("_MI_DOWNLOADS_SHOWDISCLAIMER_DSC", "Wähle 'Ja' um die Ausschlussklausel anzuzeigen, beovr Benutzer eine Datei hochladen können.");
define("_MI_DOWNLOADS_DISCLAIMER", "Ausschlussklausel fü den Datenupload");
define("_MI_DOWNLOADS_UPL_DISCLAIMER_TEXT", "<h1>Terms of Service for {X_SITENAME}:</h1>
												<p>{X_SITENAME} reserves the right to remove any image or file for any reason what ever. Specifically, any image/file uploaded that infringes upon copyrights not held by the uploader, is illegal or violates any laws, will be immediately deleted and the IP address of the uploaded reported to authorities. Violating these terms will result in termination of your ability to upload further images/files.
												Do not link or embed images hosted on this service into a large-scale, non- forum website. You may link or embed images hosted on this service in personal sites, message boards, and individual online auctions.</p>
												<p>By uploading images to {X_SITENAME} you give permission for the owners of {X_SITENAME} to publish your images in any way or form, meaning websites, print, etc. You will not be compensated by {X_SITENAME} for any loss what ever!</p>
												<p>We reserve the right to ban any individual uploader or website from using our services for any reason.</p>
												<p>All images uploaded are copyright Â© their respective owners.</p>
												<h2>Privacy Policy :</h2> 
												<p>{X_SITENAME} collects user's IP address, the time at which user uploaded a file, and the file's URL. This data is not shared with any third party companies or individuals (unless the file in question is deemed to be in violation of these Terms of Service, in which case this data may be shared with law enforcement entities), and is used to enforce these Terms of Service as well as to resolve any legal matters that may arise due to violations of the Terms of Service. </p>
												<h2>Legal Policy:</h2> 
												<p>These Terms of Service are subject to change without prior warning to its users. By using {X_SITENAME}, user agrees not to involve {X_SITENAME} in any type of legal action. {X_SITENAME} directs full legal responsibility of the contents of the files that are uploaded to {X_SITENAME} to individual users, and will cooperate with law enforcement entities in the case that uploaded files are deemed to be in violation of these Terms of Service. </p>
												<p>All files are Â© to their respective owners Â· All other content Â© {X_SITENAME}. {X_SITENAME} is not responsible for the content any uploaded files, nor is it in affiliation with any entities that may be represented in the uploaded files.</p>");
define("_MI_DOWNLOADS_SHOW_DOWN_DISCL", "Show disclaimer, before an user can download new files?");
define("_MI_DOWNLOADS_SHOW_DOWN_DISCL_DSC", "Select 'YES' to show the disclaimer before an user can upload new files");
define("_MI_DOWNLOADS_DOWN_DISCLAIMER", "Disclaimer for Filedownload");
define("_MI_DOWNLOADS_DOWN_DISCLAIMER_TEXT", "<h1>TERMS OF USE</h1>
												<p>All products available for download through this site are provided by third party software/scripts publishers pursuant to license agreements or other arrangements between such publishers and the end user. We disclaim any responsibility for or liability related to the software/scripts. Any questions complaints or claims related to the software should be directed to the appropriate Author or Company responsible for developing the software. We make no representations or warranties of any kind concerning the quality, safety or suitability of the software/script, either expressed or implied, including without limitation any implied warranties of merchantability, fitness for a particular purpose, or non-infringement. We make no representation or warrantie as to the truth, accuracy or completeness of any statements, information or materials concerning the software/script that is contained on and within any of the websites owned and operated by us. In no event will we be liable for any indirect, punitive, special, incidental or consequential damages however they may arise and even if we have been previously advised of the possibility of such damages. There are inherent dangers in the use of any software/script available for download on the Internet, and we caution you to make sure that you completely understand the potential risks before downloading any of the software/scripts. You are solely responsible for adequate protection and backup of the data and equipment used in connection with any of the software, and we will not be liable for any damages that you may suffer in connection with using, modifying or distributing any of the software.</p>
												<h2>PRIVACY STATEMENT</h2>
												<p>We record visits to this web site and logs the following information for statistical purposes: the user's server or proxy address, the date/time of the visit and the files requested. The information is used to analyse our server traffic. No attempt will be made to identify users or their browsing activities except where authorized by law. For example in the event of an investigation, a law enforcement agency may exercise their legal authority to inspect the internet service provider's logs. If you send us an email message or contact as via contact form, we will record your contact details. This information will only be used for the purpose for which you have provided it. We will not use your email for any other purpose and will not disclose it without your consent except where such use or disclosure is permitted under an exception provided in the Privacy Act. When users choose to join a mailing list their details are added to that specific mailing list and used for the stated purpose of that list only.</p>
												<h2>LINKING</h2>
												<p>Links to external web sites are inserted for convenience and do not constitute endorsement of material at those sites, or any associated organization, product or service.</p>");
define("_MI_DOWNLOADS_PLATFORM", "file platform requirements");
define("_MI_DOWNLOADS_PLATFORM_DSC", "file platform requirements can be select while creating/adding a new file. Seperate all platform requirements with '|'");
define("_MI_DOWNLOADS_LICENSE", "file license");
define("_MI_DOWNLOADS_LICENSE_DSC", "set the file licenses you need for your published files. The license can be selected while uploading/editing a file and will be displayed in the frontend.");
define("_MI_DOWNLOADS_USE_RSS", "Use RSS-Feeds?");
define("_MI_DOWNLOADS_USE_RSS_DSC", "Set to 'YES' to provide a rss link.");
define("_MI_DOWNLOADS_NEED_VERSION_CONTROL", "Do you need version controll?");
define("_MI_DOWNLOADS_NEED_VERSION_CONTROL_DSC", "If set to 'YES', you'll get Fields for Version number, version status, file history and previous Versions");

define("_MI_DOWNLOADS_NEED_RELATED", "Do you need related Files?");
define("_MI_DOWNLOADS_NEED_RELATED_DSC", "If set to 'YES', you can select related files from a list.");

define("_MI_DOWNLOADS_NEED_DEMO", "Do you need a link to a Demo-Site");
define("_MI_DOWNLOADS_NEED_DEMO_DSC", "If set to 'YES', you will get a Field for a Demo-Link.");

define("_MI_DOWNLOADS_NEED_REQUIREMENTS", "Do you need File requirements?");
define("_MI_DOWNLOADS_NEED_REQUIREMENTS_DSC", "");
define("_MI_DOWNLOADS_NEED_KEYFEATURES", "Do you need File keyfeatures?");
define("_MI_DOWNLOADS_NEED_KEYFEATURES_DSC", "");

define("_MI_DOWNLOADS_USE_SPROCKETS", "Use 'Sprockets' Module?");
define("_MI_DOWNLOADS_USE_SPROCKETS_DSC", "You can use 'Sprockets' Module to deal with tags. Only Tags will be supported, not navigation Elements or Tags labled as both!");

define("_MI_DOWNLOADS_USE_CATALOGUE", "Use 'catalogue' module?");
define("_MI_DOWNLOADS_USE_CATALOGUE_DSC", "You can use catalogue module to sell file downloads. Catalogue needs to be installed! You'll get a list of catalogue items to link a file with an item. If an item is selected you'll not get a download link, but a link to the item to add it to your card. Also the price of the item will be displayd.");
define("_MI_DOWNLOADS_USE_ALBUM", "use 'Album' module?");
define("_MI_DOWNLOADS_USE_ALBUM_DSC", "You can use an album for file screenshots instead of the usual 4 screenshots provided by 'Downloads' module. 'Album' needs to be installed! ");
define("_MI_DOWNLOADS_USE_MIRROR", "Use mirror system?");
define("_MI_DOWNLOADS_USE_MIRROR_DSC", "Select yes, if you like to use a download mirror.");
define("_MI_DOWNLOADS_MIRROR_APPROVE", "Do you need approvals for new mirrors?");
define("_MI_DOWNLOADS_MIRROR_APPROVE_DSC", "Select 'YES' if you prefer to approve the mirrors first, before providing the link");
define("_MI_DOWNLOADS_DOWNLOAD_APPROVE", "Do you need approvals for new files?");
define("_MI_DOWNLOADS_DOWNLOAD_APPROVE_DSC", "Select 'YES' if you prefer to approve the files uploaded in frontend first, before providing the file");
define("_MI_DOWNLOADS_CATEGORY_APPROVE", "Do you need approvals for new categories?");
define("_MI_DOWNLOADS_CATEGORY_APPROVE_DSC", "Select 'YES' if you prefer to approve the new categories created on frontend first, before providing the link");
define("_MI_DOWNLOADS_GUEST_CAN_VOTE", "Do you like to allow users to vote?");
define("_MI_DOWNLOADS_GUEST_CAN_VOTE_DSC", "Select 'YES' to allow guests to vote the files. Otherwise they will see a popup to register or login. ");
define("_MI_DOWNLOADS_GUEST_CAN_REVIEW", "do you like to allow guests to submit reviews?");
define("_MI_DOWNLOADS_GUEST_CAN_REVIEW_DSC", "Select 'YES' to allow guests to send reviews. Otherwise they will see a popup to register or login.");
define("_MI_DOWNLOADS_SHOW_REVIEWS", "show reviews?");
define("_MI_DOWNLOADS_SHOW_REVIEWS_DSC", "Do you like to show reviews in Frontend, select 'YES'. A new tab in single-file-view will show the reviews.");
define("_MI_DOWNLOADS_SHOW_REVIEWS_EMAIL", "show reviews email?");
define("_MI_DOWNLOADS_SHOW_REVIEWS_EMAIL_DSC", "Select'YES' to show email address in reviews on file-single-view");
define("_MI_DOWNLOADS_SHOW_REVIEWS_AVATAR", "show user avatar in reviews?");
define("_MI_DOWNLOADS_SHOW_REVIEWS_AVATAR_DSC", "select 'YES' to display users avatar in reviews");
define("_MI_DOWNLOADS_REVIEWS_COUNT", "How many reviews should be shown in one page?");
define("_MI_DOWNLOADS_REVIEWS_ORDER", "Order reviews date");
define("_MI_DOWNLOADS_DISPLAY_REVIEWS_EMAIL", "How to display the email-address in frontend?");
define("_MI_DOWNLOADS_DISPLAY_REVIEWS_EMAIL_DSC", "The first option 'Text spam protected' will display the email in the style of 'mymail at example dot com', the second will display a usual email 'myemail@example.com', which can be protected from core by creating an image from email.");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_SPAMPROT", "Text spam protected without checking banned list");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_IMGPROT", "usual email without checking banned list");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_SPAMPROT_BANNED", "Text spam protected with checking banned list");
define("_MI_DOWNLOADS_DISPLAY_REVEMAIL_IMGPROT_BANNED", "usual email with checking banned list");

define("_MI_DOWNLOADS_DISPLAY_FILE_SIZE", "How to display the file size?");
define("_MI_DOWNLOADS_DISPLAY_FILE_SIZE_DSC", "Select 'byte' to display in byte, 'mb' to display in megabyte, 'gb' to display in gigabyte");

define("_MI_DOWNLOADS_POPULAR", "How many downloads of one file before it's popular");
define("_MI_DOWNLOADS_DAYSNEW", "How many days to provide one file as new");
define("_MI_DOWNLOADS_DAYSUPDATED", "How many days to provide one file as updated after editing");
// Notifications
define('_MI_DOWNLOADS_GLOBAL_NOTIFY', 'Global');
define('_MI_DOWNLOADS_GLOBAL_NOTIFY_DSC', 'Global Downloads notification options.');

define('_MI_DOWNLOADS_CATEGORY_NOTIFY', 'Category');
define('_MI_DOWNLOADS_CATEGORY_NOTIFY_DSC', 'Notification options that apply to the current file category.');

define('_MI_DOWNLOADS_FILE_NOTIFY', 'File');
define('_MI_DOWNLOADS_FILE_NOTIFY_DSC', 'Notification options that apply to the current file.');

define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY', 'Category Submitted');
define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY_CAP', 'Notify me when any new category is submitted.');
define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY_DSC', 'Receive notification when any new category is submitted (awaiting approval).');
define('_MI_DOWNLOADS_GLOBAL_CATSUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted');

define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY', 'New Category');
define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY_CAP', 'Notify me when a new file category is created.');
define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY_DSC', 'Receive notification when a new file category is created.');
define('_MI_DOWNLOADS_GLOBAL_NEWCATEGORY_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file category');

define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY', 'Category Modified');
define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY_CAP', 'Notify me when any category is modified.');
define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY_DSC', 'Receive notification when any category is modified.');
define('_MI_DOWNLOADS_GLOBAL_CATEGORYMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Category Modified');

define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY', 'Broken File Submitted');
define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY_CAP', 'Notify me of any broken file report.');
define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY_DSC', 'Receive notification when any broken file report is submitted.');
define('_MI_DOWNLOADS_GLOBAL_FILEBROKEN_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Broken File Reported');

define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY', 'File Submitted');
define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY_CAP', 'Notify me when any new file is submitted (awaiting approval).');
define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY_DSC', 'Receive notification when any new file is submitted (awaiting approval).');
define('_MI_DOWNLOADS_GLOBAL_FILESUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted');

define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY', 'New File');
define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY_CAP', 'Notify me when any new file is posted.');
define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY_DSC', 'Receive notification when any new file is posted.');
define('_MI_DOWNLOADS_GLOBAL_NEWFILE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file');

define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY', 'File Submitted');
define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY_CAP', 'Notify me when a new file is submitted (awaiting approval) to the current category.');   
define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY_DSC', 'Receive notification when a new file is submitted (awaiting approval) to the current category.');      
define('_MI_DOWNLOADS_CATEGORY_FILESUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted in category'); 

define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY', 'New File');
define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY_CAP', 'Notify me when a new file is posted to the current category.');   
define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY_DSC', 'Receive notification when a new file is posted to the current category.');      
define('_MI_DOWNLOADS_CATEGORY_NEWFILE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file in category'); 

define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY', 'File Approved');
define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY_CAP', 'Notify me when this file is approved.');
define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY_DSC', 'Receive notification when this file is approved.');
define('_MI_DOWNLOADS_FILE_APPROVE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : File Approved');

define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY', 'File Modified');
define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY_CAP', 'Notify me when this file is modified.');
define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY_DSC', 'Receive notification when this file is modified.');
define('_MI_DOWNLOADS_FILE_FILEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : File Modified');

define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY', 'File Modified');
define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY_CAP', 'Notify me when a file in this category is modified.');
define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY_DSC', 'Receive notification when a file in this category is modified.');
define('_MI_DOWNLOADS_CATEGORY_FILEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : File Modified');

define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY', 'File Modified');
define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY_CAP', 'Notify me when any file is modified.');
define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY_DSC', 'Receive notification when any file is modified.');
define('_MI_DOWNLOADS_GLOBAL_FILEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : File Modified');

define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY', 'Review Submitted');
define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY_CAP', 'Notify me when any new review is submitted.');
define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY_DSC', 'Receive notification when any new review is submitted.');
define('_MI_DOWNLOADS_GLOBAL_REVIEWSUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New review submitted');

// ACP menu
define("_MI_DOWNLOADS_MENU_INDEX", "Index");
define("_MI_DOWNLOADS_MENU_DOWNLOAD", "Dateiverwaltung");
define("_MI_DOWNLOADS_MENU_CATEGORY", "Kategorieverwaltung");
define("_MI_DOWNLOADS_MENU_INDEXPAGE", "Bearbeite die Indexseite");
define("_MI_DOWNLOADS_MENU_TEMPLATES", "Templates");
define("_MI_DOWNLOADS_MENU_RATINGS", "Bewertungen");
define("_MI_DOWNLOADS_MENU_MANUAL", "Anleitung");
define("_MI_DOWNLOADS_MENU_REVIEW", "Rezensionen");
define("_MI_DOWNLOADS_MENU_PERMISSIONS", "Berechtigungen");
define("_MI_DOWNLOADS_MENU_LOG", "Log");
// Submenu while calling a tab
define("_MI_DOWNLOADS_DOWNLOAD_EDIT", "Bearbeite deine Datei");
define("_MI_DOWNLOADS_DOWNLOAD_CREATINGNEW", "Füge eine neue Datei hinzu");
define("_MI_DOWNLOADS_CATEGORY_EDIT", "Bearbeite diese Kategorie");
define("_MI_DOWNLOADS_CATEGORY_CREATINGNEW", "Erstelle eine neue Kategorie");
