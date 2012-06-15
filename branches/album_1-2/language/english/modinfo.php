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

/**
 * added in 1.1
 */
// added messages, permissions and manual to menu
define("_MI_ALBUM_MENU_MESSAGE", "Image Comments");
define("_MI_ALBUM_MENU_PERMISSIONS", "Permissions");
define("_MI_ALBUM_MENU_MANUAL", "Manual");
/**
 * added in 1.2
 */
// added batchupload to menu
define("_MI_ALBUM_MENU_BATCHUPLOAD", "Batchupload");
//added to config
define("_MI_ALBUM_MESSAGE_NEEDS_APPROVAL", "New comments for images needs approval?");
define("_MI_ALBUM_MESSAGE_NEEDS_APPROVAL_DSC", "If you need approval before publishing new comments on images, select yes");
define("_MI_ALBUM_USE_MESSAGES", "Use a comment system for single images?");
define("_MI_ALBUM_USE_MESSAGES_DSC", "Allow, disallow comments for single images.");
define("_MI_ALBUM_NEED_IMAGE_LINKS", "Do you need a field for adding an url to single images?");
define("_MI_ALBUM_NEED_IMAGE_LINKS_DSC", "Set yes, to get a new field to add a url-link to a product site to single images");
//added to blocks
define("_MI_ALBUM_BLOCK_RECENT_IMAGES", "Recent Images");
define("_MI_ALBUM_BLOCK_RECENT_IMAGES_DSC", "Display recent images of an album, a user or all recent images");
define("_MI_ALBUM_BLOCK_SINGLE_IMAGE", "Single Image");
define("_MI_ALBUM_BLOCK_SINGLE_IMAGE_DSC", "Display a single image in a block");