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

// general informations
define("_MI_ALBUM_NAME", "Album");
define("_MI_ALBUM_DSC", "'Album' is a light weight photo-album module, which can handle image-uploads and categorize them to albums.");

// templates
define("_MI_ALBUM_INDEX_TPL", "'Album' index page in frontend");
define("_MI_ALBUM_HEADER_TPL", "'Album' header contains breadcrumb");
define("_MI_ALBUM_ADMIN_FORM_TPL", "'Album' Admin form");
define("_AM_ALBUM_REQUIREMENTS_TPL", "'Album' Requirements check");
define("_MI_ALBUM_FOOTER_TPL", "'Album' footer contains notifications and comment rules");
define("_MI_ALBUM_ALBUM_TPL", "'Album' view in frontend");

// blocks
define("_MI_ALBUM_BLOCK_RECENT_ALBUMS", "Album List");
define("_MI_ALBUM_BLOCK_RECENT_ALBUMS_DSC", "List the latest published albums");
// config
define("_MI_ALBUM_AUTHORIZED_UPLOADER", "Groups allowed to add albums");
define("_MI_ALBUM_AUTHORIZED_UPLOADER_DSC", "Select the groups which are allowed to create new albums. Please note that a user belonging to one of these groups will be able to create albums directly on the site. The module currently has no moderation feature.");
define("_MI_ALBUM_DATE_FORMAT", "Date format");
define("_MI_ALBUM_DATE_FORMAT_DSC", "For more informations: <a href=\"http://php.net/manual/en/function.date.php\" target=\"blank\">see php.net manual</a>");
define("_MI_ALBUM_SHOW_BREADCRUMBS", "show breadcrumb");
define("_MI_ALBUM_SHOW_BREADCRUMBS_DSC", "choose 'YES' to show breadcrumb in frontend");
define("_MI_ALBUM_SHOW_ALBUMS", "show Albums");
define("_MI_ALBUM_SHOW_ALBUMS_DSC", "How many Albums should be displayed on indexpage before using page navigation?");
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
define("_MI_ALBUM_IMAGE_FILE_SIZE", "image file size");
define("_MI_ALBUM_IMAGE_FILE_SIZE_DSC", "set max file size for uploading");

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
define("_MI_ALBUM_MENU_ALBUM", "Manage Albums");
define("_MI_ALBUM_MENU_IMAGES", "Manage Images");
define("_MI_ALBUM_MENU_IMAGEUPLOAD", "Module Image upload");
define("_MI_ALBUM_MENU_INDEXPAGE", "Edit Indexpage");
define("_MI_ALBUM_MENU_TEMPLATES", "Templates");
// Submenu while calling a tab
define("_MI_ALBUM_ALBUM_EDITING", "Edit your Album");
define("_MI_ALBUM_ALBUM_CREATINGNEW", "Create a new Album");
define("_MI_ALBUM_IMAGES_EDIT", "Edit your Image");
define("_MI_ALBUM_IMAGES_UPLOADNEW", "Upload a new Image");