<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /language/english/admin.php
 *
 * English language constants used in admin section of the module
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

// Requirements
define("_AM_DOWNLOADS_REQUIREMENTS", "'Downloads' Requirements");
define("_AM_DOWNLOADS_REQUIREMENTS_INFO", "We've reviewed your system, unfortunately it doesn't meet all the requirements needed for 'Downloads' to function. Below are the requirements needed.");
define("_AM_DOWNLOADS_REQUIREMENTS_ICMS_BUILD", "'Downloads' requires at least ImpressCMS 1.3 final.");
define("_AM_DOWNLOADS_REQUIREMENTS_SUPPORT", "Should you have any question or concerns, please visit our forums at <a href='http://community.impresscms.org/modules/newbb/viewforum.php?forum=9'>ImpressCMS Community</a>.");
//Admin Index
define("_AM_DOWNLOADS_INDEX_WARNING", "<b>PLEASE READ MANUAL BEFORE USING THE MODULE.</b>");
define("_AM_DOWNLOADS_INDEX", "Downloads Summary");
define("_AM_DOWNLOADS_INDEX_TOTAL", "Currently there are");
define("_AM_DOWNLOADS_FILES_IN", "&nbsp;Files in &nbsp;");
define("_AM_DOWNLOADS_CATEGORIES", "&nbsp; Categories");
define("_AM_DOWNLOADS_INDEX_BROKEN_FILES", "Broken Files:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_FILES", "Files to approve:");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_MIRRORS", "Mirrors to approve ");
define("_AM_DOWNLOADS_INDEX_NEED_APPROVAL_CATS", "Categories to approve: &nbsp;");

// 
define("_AM_DOWNLOADS_DOWNLOAD_ADD", "Add File");
define("_AM_DOWNLOADS_CREATE", "New");
define("_AM_DOWNLOADS_EDIT", "Edit");
define("_AM_DOWNLOADS_CREATED", "Successfully created");
define("_AM_DOWNLOADS_MODIFIED", "Successfully modified");
define("_AM_DOWNLOADS_ONLINE", "Online");
define("_AM_DOWNLOADS_OFFLINE", "Offline");
define("_AM_DOWNLOADS_DOWNLOAD_WEIGHTS_UPDATED", "Weights updated");
define("_AM_DOWNLOADS_DOWNLOAD_NOFILEEXIST", "File not found");

define("_AM_DOWNLOADS_INDEXPAGE_EDIT", "Edit the Frontend-Indexpage");
define("_AM_DOWNLOADS_INDEXPAGE_MODIFIED", "Indexpage modified");

define("_AM_DOWNLOADS_CATEGORY_ADD", "Add Category");
define("_AM_DOWNLOADS_CATEGORY_WEIGHTS_UPDATED", "Weights updated");

define("_AM_DOWNLOADS_INBLOCK_TRUE", "Visible in Blocks");
define("_AM_DOWNLOADS_INBLOCK_FALSE", "Hidden in blocks");

define("_AM_DOWNLOADS_APPROVE_TRUE", "Approved");
define("_AM_DOWNLOADS_APPROVE_FALSE", "Denied");

define("_AM_DOWNLOADS_MIRROR_FALSE", "Mirror denied");
define("_AM_DOWNLOADS_MIRROR_TRUE", "Mirror approved");

define("_AM_DOWNLOADS_NO_CAT_FOUND", "No category was found. Please create a category first. If you have any further questions, please read the manual first.");

// constants for permission Form
define("_AM_DOWNLOADS_PREMISSION_DOWNLOADS_VIEW", "View Files");
define("_AM_DOWNLOADS_PREMISSION_CATEGORY_VIEW", "View Categories");
define("_AM_DOWNLOADS_PREMISSION_CATEGORY_SUBMIT", "Submit Files");