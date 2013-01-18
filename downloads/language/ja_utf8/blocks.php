<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/english/blocks.php
 *
 * English language constants used in blocks of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: blocks.php 619 2012-06-28 08:34:35Z st.flohrer $
 * @package		downloads
 * 
 */

 if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

// Recent Downloads block
define("_MB_DOWNLOADS_DOWNLOAD_RECENT_LIMIT", "Number of new downloads to show");
// Category Menu Block
define('_MB_DOWNLOADS_CATEGORY_SELPAGE','<b>Page to display:</b> <br /><small>Select "---------------" to display always the last created page.</small>');
define('_MB_DOWNLOADS_CATEGORY_SHOWSUBS','<b>Show Subcategories:</b>');
define("_MB_DOWNLOADS_CATEGORY_SORT", "<b>Sort:</b>");
define("_MB_DOWNLOADS_CATEGORY_ORDER", "<b>Order:</b>");
define("_MB_DOWNLOADS_CATEGORY_CATSELECT", '<b>Show only Subcategories from:</b> <br /><small>Select "---------------" to not filter and show all categories.</small>');
//Gallery block, added in 1.1
define("_MB_DOWNLOADS_CATEGORY_CATSEL", "Select category to be displayed or select nothing to display from all categories");
define("_MB_DOWNLOADS_SHOWTEASER", "Display Teaser (in a popup box)?");
define("_MB_DOWNLOADS_SHOWMORE", "Display 'View More' Link?");
define("_MB_DOWNLOADS_DISPLAY_SIZE", "Display width (image)");
define("_MB_DOWNLOADS_VIEW_ALL", "View more");