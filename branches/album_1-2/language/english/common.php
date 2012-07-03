<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /language/english/common.php
 *
 * english language constants commonly used in the module
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

// language constants for adding new album
define("_CO_ALBUM_ALBUM_ALBUM_TITLE", "Title");
define("_CO_ALBUM_ALBUM_ALBUM_TITLE_DSC", "Set Title of the Album");
define("_CO_ALBUM_ALBUM_ALBUM_PID", "Parent Album");
define("_CO_ALBUM_ALBUM_ALBUM_PID_DSC", "Here you can choose a parent Album, if needed to categorize Albums");
define("_CO_ALBUM_ALBUM_ALBUM_PUBLISHED_DATE", "Published Date");
define("_CO_ALBUM_ALBUM_ALBUM_PUBLISHED_DATE_DSC", "");
define("_CO_ALBUM_ALBUM_ALBUM_UPDATED_DATE", "Updated Date");
define("_CO_ALBUM_ALBUM_ALBUM_UPDATED_DATE_DSC", "");
define("_CO_ALBUM_ALBUM_ALBUM_IMG", "Album Image");
define("_CO_ALBUM_ALBUM_ALBUM_IMG_DSC", "Set Album image. You can upload a new album-image in 'Album Image upload'");
define("_CO_ALBUM_ALBUM_ALBUM_IMG_UPLOAD", "Album Image upload");
define("_CO_ALBUM_ALBUM_ALBUM_IMG_UPLOAD_DSC", "upload a new Album Image. Please, only use file upload, not url to the image. This will not be supported");
define("_CO_ALBUM_ALBUM_ALBUM_DESCRIPTION", "Description");
define("_CO_ALBUM_ALBUM_ALBUM_DESCRIPTION_DSC", "Set Description of the album");
define("_CO_ALBUM_ALBUM_WEIGHT", "weight");
define("_CO_ALBUM_ALBUM_WEIGHT_DSC", "set weight to order albums in frontend");
define("_CO_ALBUM_ALBUM_ALBUM_ACTIVE", "Active?");
define("_CO_ALBUM_ALBUM_ALBUM_ACTIVE_DSC", "Set 'YES' to set album online");
define("_CO_ALBUM_ALBUM_ALBUM_INBLOCKS", "In Blocks?");
define("_CO_ALBUM_ALBUM_ALBUM_INBLOCKS_DSC", "Set 'YES' to show album in block 'recent Albums'");
define("_CO_ALBUM_ALBUM_ALBUM_APPROVE", "Approved?");
define("_CO_ALBUM_ALBUM_ALBUM_APPROVE_DSC", "Set 'YES' to approve Album");
define("_CO_ALBUM_ALBUM_ALBUM_ONINDEX", "On Index");
define("_CO_ALBUM_ALBUM_ALBUM_ONINDEX_DSC", "Set 'YES' to show album on Index. This can be used, to approve albums and keep them active, but do not Display on Index-View. e.g. 'Downloads' can use Albums for describing a file. So you can allow these Album, but only show it in Downloads.");
define("_CO_ALBUM_ALBUM_ALBUM_UPDATED", "Updated?");
define("_CO_ALBUM_ALBUM_ALBUM_UPDATED_DSC", "Set 'YES' to show Album as updated");
define("_CO_ALBUM_ALBUM_ALBUM_UID", "Publisher");
define("_CO_ALBUM_ALBUM_ALBUM_UID_DSC", "Select the Publisher of the Album");
define("_CO_ALBUM_ALBUM_ALBUM_GRPPERM", "View Permission");
define("_CO_ALBUM_ALBUM_ALBUM_GRPPERM_DSC", "Select which groups will have view permission for this album. This means that a user belonging to one of these groups will be able to view the album when it is activated in the site.'");
define("_CO_ALBUM_ALBUM_ALBUM_UPLPERM", "Images submit permissions");
define("_CO_ALBUM_ALBUM_ALBUM_UPLPERM_DSC", "Select the groups to be allowed to submit images");
define("_CO_ALBUM_ALBUM_ALBUM_COMMENTS", "Comments");
define("_CO_ALBUM_ALBUM_ALBUM_COMMENTS_DSC", "");
define("_CO_ALBUM_ALBUM_ALBUM_NOTIFICATION_SENT", "Notification sent?");
define("_CO_ALBUM_ALBUM_ALBUM_NOTIFICATION_SENT_DSC", "");

// language constants for editing indexpage
define("_CO_ALBUM_INDEXPAGE_INDEX_HEADER", "Title");
define("_CO_ALBUM_INDEXPAGE_INDEX_HEADER_DSC", "Set Title displayed in the index at frontend ");
define("_CO_ALBUM_INDEXPAGE_INDEX_HEADING", "Description for Indexpage");
define("_CO_ALBUM_INDEXPAGE_INDEX_HEADING_DSC", "");
define("_CO_ALBUM_INDEXPAGE_INDEX_IMAGE", "Indeximage");
define("_CO_ALBUM_INDEXPAGE_INDEX_IMAGE_DSC", "Set indeximage");
define("_CO_ALBUM_INDEXPAGE_INDEX_IMG_UPLOAD", "Upload new indeximage");
define("_CO_ALBUM_INDEXPAGE_INDEX_FOOTER", "footer on indexpage");
define("_CO_ALBUM_INDEXPAGE_INDEX_FOOTER_DSC", "Set the footer displayed on Indexpage");
// language constants for adding new images
define("_CO_ALBUM_IMAGES_IMG_TITLE", "Title");
define("_CO_ALBUM_IMAGES_A_ID", "Album");
define("_CO_ALBUM_IMAGES_A_ID_DSC", "Set the Album of the image");
define("_CO_ALBUM_IMAGES_IMG_PUBLISHED_DATE", "Published Date");
define("_CO_ALBUM_IMAGES_IMG_PUBLISHED_DATE_DSC", "");
define("_CO_ALBUM_IMAGES_IMG_URL", "Select the image");
define("_CO_ALBUM_IMAGES_IMG_URL_DSC", "You can upload a new image. Please, do NOT use the url upload here");
define("_CO_ALBUM_IMAGES_IMG_DESCRIPTION", "Description");
define("_CO_ALBUM_IMAGES_IMG_DESCRIPTION_DSC", "Set Description of the image");
define("_CO_ALBUM_IMAGES_IMG_TAGS", "Select the tags for this image");
define("_CO_ALBUM_IMAGES_IMG_ACTIVE", "Active?");
define("_CO_ALBUM_IMAGES_IMG_ACTIVE_DSC", "Set 'YES' to set image online");
define("_CO_ALBUM_IMAGES_IMG_APPROVE", "Approved?");
define("_CO_ALBUM_IMAGES_IMG_PUBLISHER", "Uploader");
/**
 * added in 1.1
 */
//constants for class/Message.php
define("_CO_ALBUM_MESSAGE_MESSAGE_UID", "User");
define("_CO_ALBUM_MESSAGE_MESSAGE_ITEM", "Image");
define("_CO_ALBUM_MESSAGE_MESSAGE_BODY", "Comment");
define("_CO_ALBUM_MESSAGE_MESSAGE_DATE", "Date");
define("_CO_ALBUM_MESSAGE_MESSAGE_APPROVE", "Approved?");
// constants for admin/message.php
define("_CO_ALBUM_MESSAGE_MESSAGE_APPROVED", "Comment approved");
define("_CO_ALBUM_MESSAGE_MESSAGE_DENIED", "Comment denied");
// constants added in class/Images.php
define("_CO_ALBUM_IMAGES_IMG_URLLINK", "URL");
define("_CO_ALBUM_IMAGES_IMG_URLLINK_DSC", "Enter a full url (included http://)");
// constants added in class/Album.php
define("_CO_ALBUM_ALBUM_ALBUM_TAGS", "Tags");
define("_CO_ALBUM_ALBUM_ALBUM_TAGS_DSC", "Select the tags for this album");
/**
 * added in 1.2
 */
define("_CO_ALBUM_IMAGES_IMG_COPYRIGHT", "Watermark text");
define("_CO_ALBUM_IMAGES_IMG_COPYRIGHT_DSC", "You can add a watermark Text to your image");
define("_CO_ALBUM_IMAGES_IMG_COPY_POS", "Position of the copyright");
define("_CO_ALBUM_IMAGES_IMG_COPY_POS_DSC", "");
define("_CO_ALBUM_IMAGES_IMG_COPY_COLOR", "Color of the copyright");
define("_CO_ALBUM_IMAGES_IMG_COPY_COLOR_DSC", "");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_TL", "Top Left");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_TR", "Top right");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_TC", "top center");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_CL", "center left");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_CR", "center right");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_C", "center center");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_BL", "bottom left");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_BR", "bottom right");
define("_CO_ALBUM_IMAGES_WATERMARKPOS_BC", "bottom center");
define("_CO_ALBUM_IMAGES_WATERMARKCOLOR_BLACK", "black");
define("_CO_ALBUM_IMAGES_WATERMARKCOLOR_BLUE", "blue");
define("_CO_ALBUM_IMAGES_WATERMARKCOLOR_GREEN", "green");
define("_CO_ALBUM_IMAGES_WATERMARKCOLOR_WHITE", "white");
define("_CO_ALBUM_IMAGES_WATERMARKCOLOR_RED", "red");