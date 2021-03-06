<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /language/english/blocks.php
 *
 * English language constants used in blocks of the module
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

 if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// Recent Albums block
define("_MB_ALBUM_ALBUM_RECENT_LIMIT", "Number of new albums to show");

if(!defined("_AM_ALBUM_ALBUM_EDIT")) define("_AM_ALBUM_ALBUM_EDIT", "Edit");
define("_AM_ALBUM_ALBUM_DELETE", "Delete");

//recent images block, added in 1.1
define("_MB_ALBUM_SELECT_ALBUM", "Select an album to display  only images of the selected album");
define("_MB_ALBUM_SELECT_PUBLISHER", "Select a user to display only images of the selected user. Anonymous to get from all users");
define("_MB_ALBUM_SORT", "Sort by:");
define("_MB_ALBUM_ORDER", "Order by:");
define("_MB_ALBUM_DISPLAY_SIZE", "Display width of the thumbs");
define("_MB_ALBUM_IMAGE_RANDOM", "Random Image");
define("_MB_ALBUM_DISPLAY_HEIGHT", "Display height");
define("_MB_ALBUM_HORIZONTAL", "Select how to display");
define("_MB_ALBUM_AUTOSCROLL", "Enable autoscroll?");
define("_MB_ALBUM_DISPLAY_SINGLE_HORIZONTAL", "Single horizontal Image");
define("_MB_ALBUM_DISPLAY_GALLERY_HORIZONTAL", "horizontal Gallery");
define("_MB_ALBUM_DISPLAY_SINGLE_VERTICAL", "Single vertical Image");
define("_MB_ALBUM_DISPLAY_GALLERY_VERTICAL", "vertical Gallery");
define("_MB_ALBUM_DISPLAY_CAROUSEL", "Display carousel");
define("_MB_ALBUM_DISPLAY_DSC", "Display Description? (only gallery and carousel)");