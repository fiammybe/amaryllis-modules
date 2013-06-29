<?php
/**
 * English language constants related to module information
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		visitorvoice
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_VISITORVOICE_NAME", "VisitorVoice");
define("_MI_VISITORVOICE_DSC", "ImpressCMS Simple VisitorVoice");
// Templates
define("_MI_VISITORVOICE_VISITORVOICE_TPL", "VisitorVoice index page");
define("_MI_VISITORVOICE_ADMIN_TPL", "VisitorVoice admin Template");
define("_MI_VISITORVOICE_REQUIREMENTS_TPL", "VisitorVoice requirements");
// Blocks
define("_MI_VISITORVOICE_BLOCK_RECENT_ENTRIES", "Last entries");
define("_MI_VISITORVOICE_BLOCK_RECENT_ENTRIES_DSC", "Displaying recent entries in a block");
// Config
define("_MI_VISITORVOICE_DATE_FORMAT", "Date Format");
define("_MI_VISITORVOICE_DATE_FORMAT_DSC", "You can set the Date Format output like prefered");
define("_MI_VISITORVOICE_SHOW_BREADCRUMBS", "Show the breadcrumb?");
define("_MI_VISITORVOICE_SHOW_BREADCRUMBS_DSC", "Show/Hide the breadcrumb in frontend");
define("_MI_VISITORVOICE_SHOW_ENTRIES", "How many entries should be displayed on Frontend?");
define("_MI_VISITORVOICE_SHOW_ENTRIES_DSC", "");
define("_MI_VISITORVOICE_USE_MODERATION", "Use moderation?");
define("_MI_VISITORVOICE_USE_MODERATION_DSC", "Do you like to moderate the entries?");
define("_MI_VISITORVOICE_SHOW_AVATAR", "Show avatar in Frontend");
define("_MI_VISITORVOICE_SHOW_AVATAR_DSC", "This will display the user avatars");
define("_MI_VISITORVOICE_NEEDS_APPROVAL", "Approve entries before they're public?");
define("_MI_VISITORVOICE_NEEDS_APPROVAL_DSC", "");
define("_MI_VISITORVOICE_ALLOW_IMAGEUPLOAD", "Do you like to allow image upload?");
define("_MI_VISITORVOICE_ALLOW_IMAGEUPLOAD_DSC", "");
define("_MI_VISITORVOICE_IMAGE_UPLOAD_WIDTH", "Max Image Upload Width");
define("_MI_VISITORVOICE_IMAGE_UPLOAD_WIDTH_DSC", "");
define("_MI_VISITORVOICE_IMAGE_UPLOAD_HEIGHT", "Max Image Upload Heigfht");
define("_MI_VISITORVOICE_IMAGE_UPLOAD_HEIGHT_DSC", "");
define("_MI_VISITORVOICE_IMAGE_FILE_SIZE", "Maximum allowed upload size");
define("_MI_VISITORVOICE_IMAGE_FILE_SIZE_DSC", "");
define("_MI_VISITORVOICE_THUMBNAIL_WIDTH", "Thumbnail width");
define("_MI_VISITORVOICE_THUMBNAIL_WIDTH_DSC", "Width of thumbnail for displaying uploaded images");
define("_MI_VISITORVOICE_THUMBNAIL_HEIGHT", "Thumbnail height");
define("_MI_VISITORVOICE_THUMBNAIL_HEIGHT_DSC", "Height of thumbnail for displaying uploaded images");
define("_MI_VISITORVOICE_GUEST_CAN_SUBMIT", "Guests can submit new entries?");
define("_MI_VISITORVOICE_GUEST_CAN_SUBMIT_DSC", "Do you like to allow guests to submit new entries, set'YES'");
define("_MI_VISITORVOICE_SHOW_EMAIL", "show E-Mail in Frontend?");
define("_MI_VISITORVOICE_SHOW_EMAIL_DSC", "Hide/Display E-Mail in fronted");
define("_MI_VISITORVOICE_DISPLAY_EMAIL", "How to display the email-address in frontend?");
define("_MI_VISITORVOICE_DISPLAY_EMAIL_DSC", "The first option 'Text spam protected' will display the email in the style of 'mymail at example dot com', the second will display a usual email 'myemail@example.com', which can be protected from core by creating an image from email.");
define("_MI_VISITORVOICE_DISPLAY_MAIL_SPAMPROT", "Text spam protected without checking banned list");
define("_MI_VISITORVOICE_DISPLAY_MAIL_IMGPROT", "usual email without checking banned list");
define("_MI_VISITORVOICE_DISPLAY_MAIL_SPAMPROT_BANNED", "Text spam protected with checking banned list");
define("_MI_VISITORVOICE_DISPLAY_MAIL_IMGPROT_BANNED", "usual email with checking banned list");
define("_MI_VISITORVOICE_USE_RSS", "Use RSS feeds?");
define("_MI_VISITORVOICE_USE_RSS_DSC", "Enable/disable RSS feeds for visitorvoice");
define("_MI_VISITORVOICE_RSSLIMIT", "RSS Limit");
define("_MI_VISITORVOICE_RSSLIMIT_DSC", "Set limit of Entries for RSS feeds");
// ACP menu
define("_MI_VISITORVOICE_MENU_VISITORVOICE", "VisitorVoice");
define("_MI_VISITORVOICE_MENU_INDEXPAGE", "Edit Indexpage");
define("_MI_VISITORVOICE_MENU_TEMPLATES", "Templates");
define("_MI_VISITORVOIVE_MENU_IMPORT", "Import");
/**
 * added in 1.1
 */
// config
define("_MI_VISITORVOICE_CAN_MODERATE", "Select the groups, which can moderate entries");
define("_MI_VISITORVOICE_CAN_MODERATE_DSC", "");
define("_MI_VISITORVOICE_DISPLAY_WIDTH", "Image Display Width");
define("_MI_VISITORVOICE_DISPLAY_WIDTH_DSC", "");
define("_MI_VISITORVOICE_DISPLAY_HEIGHT", "Image Display height");
define("_MI_VISITORVOICE_DISPLAY_HEIGHT_DSC", "");
define("_MI_VISITORVOICE_AVATAR_DIMENSIONS", "Avatar Dimensions");
define("_MI_VISITORVOICE_AVATAR_DIMENSIONS_DSC", "Avatar Dimensions in px");
define("_MI_VISITORVOICE_CAN_UPLOAD", "Groups to be allowed uploading images");
define("_MI_VISITORVOICE_CAN_UPLOAD_DSC", "");