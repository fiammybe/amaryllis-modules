<?php
/**
* 'Album' is a light weight gallery module
*
* File: /language/english/modinfo.php
*
* English language constants related to module information
*
* @copyright	Copyright QM-B (Steffen Flohrer) 2011
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* ----------------------------------------------------------------------------------------------------------
* 				album
* @since		1.00
* @author		QM-B <qm-b@hotmail.de>
* @version		$Id$
* @package		album
*
*/
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(dirname(__FILE__)))));
// general informations
define("_MI_ALBUM_NAME", "Album");
define("_MI_ALBUM_DSC", "'Album' ist ein Gallerie-Modul, welches den Bild upload ermöglicht und diese in Alben kategorisiert. Alben nutzen die Rechte-Verwaltung von ImpressCMS und Bilder können mit Kommentaren von Besuchern versehen werden.");

// templates
define("_MI_ALBUM_INDEX_TPL", "'Album' Index Seite im front end");
define("_MI_ALBUM_HEADER_TPL", "'Album' header contains breadcrumb");
define("_MI_ALBUM_ADMIN_FORM_TPL", "'Album' Admin form");
define("_AM_ALBUM_REQUIREMENTS_TPL", "'Album' Requirements check");
define("_MI_ALBUM_FOOTER_TPL", "'Album' footer contains notifications and comment rules");
define("_MI_ALBUM_ALBUM_TPL", "'Album' view in frontend");
define("_MI_ALBUM_FORMS_TPL", "Form to add, edit and delete Albums and Images ");

// blocks
define("_MI_ALBUM_BLOCK_RECENT_ALBUMS", "Album List");
define("_MI_ALBUM_BLOCK_RECENT_ALBUMS_DSC", "List the latest published albums");
// config
define("_MI_ALBUM_USE_SPROCKETS", "Use Sprockets Module?");
define("_MI_ALBUM_USE_SPROCKETS_DSC", "Set 'YES' to use sprockets Module for tag support.");
define("_MI_ALBUM_AUTHORIZED_UPLOADER", "Groups allowed to add albums");
define("_MI_ALBUM_AUTHORIZED_UPLOADER_DSC", "Select the groups which are allowed to create new albums. Please note that a user belonging to one of these groups will be able to create albums directly on the site. The module currently has no moderation feature.");
define("_MI_ALBUM_NEEDS_APPROVAL", "Album needs approval?");
define("_MI_ALBUM_NEEDS_APPROVAL_DSC", "Albums created in frontend needs to be approved first");
define("_MI_IMAGE_NEEDS_APPROVAL", "Image needs approval?");
define("_MI_IMAGE_NEEDS_APPROVAL_DSC", "Images uploaded in frontend needs to be approved");
define("_MI_ALBUM_SHOWDISCLAIMER", "Show Disclaimer before user can upload?");
define("_MI_ALBUM_SHOWDISCLAIMER_DSC", "Set 'YES' to display disclaimer before user can upload.");
define("_MI_ALBUM_DISCLAIMER", "Disclaimer for Upload");
define("_MI_ALBUM_UPL_DISCLAIMER_TEXT", "<h1>Terms of Service for {X_SITENAME}:</h1>
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

define("_MI_ALBUM_DATE_FORMAT", "Date format");
define("_MI_ALBUM_DATE_FORMAT_DSC", "For more informations: <a href=\"http://php.net/manual/en/function.date.php\" target=\"blank\">see php.net manual</a>");
define("_MI_ALBUM_SHOW_BREADCRUMBS", "show breadcrumb");
define("_MI_ALBUM_SHOW_BREADCRUMBS_DSC", "choose 'YES' to show breadcrumb in frontend");
define("_MI_ALBUM_SHOW_ALBUMS", "show Albums");
define("_MI_ALBUM_SHOW_ALBUMS_DSC", "How many Albums should be displayed on indexpage before using page navigation?");
define("_MI_ALBUM_SHOW_ALBUM_COLUMNS", "How many columns in frontend to display albums?");
define("_MI_ALBUM_SHOW_ALBUM_COLUMNS_DSC", "");
define("_MI_ALBUM_SHOW_IMAGES", "Show Images");
define("_MI_ALBUM_SHOW_IMAGES_DSC", "How many Images should be displayed at one page");
define("_MI_ALBUM_SHOW_IMAGES_ROW", "Show Images per row");
define("_MI_ALBUM_SHOW_IMAGES_ROW_DSC", "How many Images should be displayed in one row");
define("_MI_ALBUM_THUMBNAIL_WIDTH", "Thumbnail width");
define("_MI_ALBUM_THUMBNAIL_WIDTH_DSC", "choose width of thumbnails");
define("_MI_ALBUM_THUMBNAIL_HEIGHT", "Thumbnail height");
define("_MI_ALBUM_THUMBNAIL_HEIGHT_DSC", "choose width of thumbnails");
define("_MI_ALBUM_THUMBNAIL_MARGIN_TOP", "margin top");
define("_MI_ALBUM_THUMBNAIL_MARGIN_BOTTOM", "margin bottom");
define("_MI_ALBUM_THUMBNAIL_MARGIN_LEFT", "margin left");
define("_MI_ALBUM_THUMBNAIL_MARGIN_RIGHT", "margin right");
define("_MI_ALBUM_THUMBNAIL_MARGIN_DSC", "set margin for thumbnails");
define("_MI_ALBUM_IMAGE_UPLOAD_WIDTH", "image upload width");
define("_MI_ALBUM_IMAGE_UPLOAD_WIDTH_DSC", "set max width for uploading images");
define("_MI_ALBUM_IMAGE_UPLOAD_HEIGHT", "image upload height");
define("_MI_ALBUM_IMAGE_UPLOAD_HEIGHT_DSC", "set max height for uploading images");
define("_MI_ALBUM_IMAGE_DISPLAY_WIDTH", "image display width");
define("_MI_ALBUM_IMAGE_DISPLAY_WIDTH_DSC", "set max width for displaying images");
define("_MI_ALBUM_IMAGE_DISPLAY_HEIGHT", "image display height");
define("_MI_ALBUM_IMAGE_DISPLAY_HEIGHT_DSC", "set max height for displaying images");
define("_MI_ALBUM_IMAGE_FILE_SIZE", "image file size");
define("_MI_ALBUM_IMAGE_FILE_SIZE_DSC", "set max file size for uploading");
define("_MI_ALBUM_POPULAR", "How many calls of one Album before it's popular");
define("_MI_ALBUM_DAYSNEW", "How many days to provide one Album as new");
define("_MI_ALBUM_DAYSUPDATED", "How many days to provide one Album as updated after editing");

// Blocks information
define("_MI_ALBUM_BLOCK_RECENT", "Recent Albums");

// Notifications
define("_MI_ALBUM_GLOBAL_NOTIFY", "All Albums");
define("_MI_ALBUM_GLOBAL_NOTIFY_DSC", "Notifications related to all Albums in the module");
define("_MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY", "New Album published");
define("_MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY_CAP", "Notify me when a new Album is published");
define("_MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY_DSC", "Receive notification when any new Album is published.");
define("_MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New Album published");

// ACP menu
define("_MI_ALBUM_MENU_ALBUM", "Alben");
define("_MI_ALBUM_MENU_IMAGES", "Bilder");
define("_MI_ALBUM_MENU_INDEXPAGE", "Indexseite");
define("_MI_ALBUM_MENU_TEMPLATES", "Templates");
// Submenu while calling a tab
define("_MI_ALBUM_ALBUM_EDITING", "Bearbeiten Sie Ihr Album");
define("_MI_ALBUM_ALBUM_CREATINGNEW", "Erstellen Sie ein neues Album");
define("_MI_ALBUM_IMAGES_EDIT", "Bearbeiten Sie Ihr Bild");
define("_MI_ALBUM_IMAGES_UPLOADNEW", "Laden Sie ein neues Bild hoch");

/**
 * added in 1.1
 */
// added messages, permissions and manual to menu
define("_MI_ALBUM_MENU_MESSAGE", "Bild-Kommentare");
define("_MI_ALBUM_MENU_PERMISSIONS", "Berechtigungen");
define("_MI_ALBUM_MENU_MANUAL", "Manual");
//added to config
define("_MI_ALBUM_MESSAGE_NEEDS_APPROVAL", "Brauchen Sie eine Genehmigung für neue Bild-Kommentare?");
define("_MI_ALBUM_MESSAGE_NEEDS_APPROVAL_DSC", "Bild-Kommentare können als 'abgelehnt' übermittelt, bis sie genehmigt wurden und sind so lange nicht sichtbar");
define("_MI_ALBUM_USE_MESSAGES", "Möchten Sie das Kommentar-System für Bilder nutzen?");
define("_MI_ALBUM_USE_MESSAGES_DSC", "Ein-/Ausschalten der Funktion für Bildkommentare.");
define("_MI_ALBUM_NEED_IMAGE_LINKS", "Benötigen Sie URL-Links, die zu jedem Bild zugefügt werden können?");
define("_MI_ALBUM_NEED_IMAGE_LINKS_DSC", "Wenn eingeschaltet, kann man unter jedem Bild einen Link bereitstellen, z.B. zu einer Produktseite");
//added to blocks
define("_MI_ALBUM_BLOCK_RECENT_IMAGES", "Letzte Bilder");
define("_MI_ALBUM_BLOCK_RECENT_IMAGES_DSC", "Anzeigen der letzten Bilder");
define("_MI_ALBUM_BLOCK_SINGLE_IMAGE", "Single Image");
define("_MI_ALBUM_BLOCK_SINGLE_IMAGE_DSC", "Display a single image in a block");
/**
 * added in 1.2
 */
// added batchupload and index to menu
define("_MI_ALBUM_MENU_BATCHUPLOAD", "Stapelverarbeitung");
define("_MI_ALBUM_MENU_INDEX", "Index");
//added to config
define("_MI_ALBUM_CONF_IMG_USE_COPYR", "Wasserzeichen für Bilder verwenden?");
define("_MI_ALBUM_CONF_IMG_USE_COPYR_DSC", "Wählen Sie ja, um Ihre Bilder automatisch mit einem Wasserzeichen zu versehen");
define("_MI_ALBUM_CONF_IMG_DEFAULT_COPYR", "Standard-Text für Wasserzeichen");
define("_MI_ALBUM_CONF_IMG_DEFAULT_COPYR_DSC", "Setzen Sie einen Standard für alle Bilder");
define("_MI_ALBUM_CONF_IMG_ALLOW_UPLOADER_COPYR", "Wollen Sie das Ändern des Wasserzeichen für einzelne Bilder erlauben");
define("_MI_ALBUM_CONF_IMG_ALLOW_UPLOADER_COPYR_DSC", "Wenn dies erlaubt wird, kann man den Wasserzeichentext beim Bildupload ändern, andernfalls wird ausschließlich der voreingestellte verwendet");
define("_MI_ALBUM_CONF_DEFAULT_ORDER_WEIGHT", "weight");
define("_MI_ALBUM_CONF_DEFAULT_ORDER_CREATIONDATE", "Published Date");
define("_MI_ALBUM_CONF_DEFAULT_ORDER_TITLE", "Title");
define("_MI_ALBUM_CONFIG_DEFAULT_ORDER", "Default Order for Albums");
define("_MI_ALBUM_CONFIG_DEFAULT_ORDER_DSC", "");
define("_MI_ALBUM_CONFIG_DEFAULT_SORT", "Default Sort for Albums");
define("_MI_ALBUM_CONFIG_DEFAULT_SORT_DSC", "");
define("_MI_ALBUM_CONFIG_DEFAULT_ORDER_IMG", "Default Order for Images");
define("_MI_ALBUM_CONFIG_DEFAULT_ORDER_IMG_DSC", "");
define("_MI_ALBUM_CONFIG_DEFAULT_SORT_IMG", "Default Sort for Images");
define("_MI_ALBUM_CONFIG_DEFAULT_SORT_IMG_DSC", "");
define("_MI_ALBUM_NEED_CATS", "Need Tags?");
define("_MI_ALBUM_NEED_CATS_DSC", "");
// added to mainmenu
define("_MI_ALBUM_MENUMAIN_ADDALBUM", "Submit Album");
define("_MI_ALBUM_MENUMAIN_ADDIMAGES", "Submit image");
/**
 * added in 1.3
 */
define("_MI_ALBUM_CONFIG_USE_MAIN", "Nutze nur die Hauptseite, ohne '/modules/".ALBUM_DIRNAME."/' in der URL?");
define("_MI_ALBUM_CONFIG_USE_MAIN_DSC", "Das Modul hat eine Haupt-Fronseite (aktuell nicht für das Übermitteln neuer Tutorials!). Du kannst hier direkt auf diese Seite umleiten Schau bitte <b>ERST</b> in die Anleitung!!.");
define("_MI_ALBUM_CONFIG_USE_REWRITE", "Nutze schöne URL's?");
define("_MI_ALBUM_CONFIG_USE_REWRITE_DSC", "Bitte ERST die Anleitung lesen!! ('Nutze nur die Hauptseite...' sollte aktiviert sein..)");