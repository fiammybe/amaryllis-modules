<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /language/english/admin.php
 * 
 * english language constants
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

// Requirements
define("_AM_ARTICLE_REQUIREMENTS", "Article Requirements");
define("_AM_ARTICLE_REQUIREMENTS_INFO", "We've reviewed your system, unfortunately it doesn't meet all the requirements needed for Article to function. Below are the requirements needed.");
define("_AM_ARTICLE_REQUIREMENTS_ICMS_BUILD", "Article requires at least ImpressCMS 1.3.");
define("_AM_ARTICLE_REQUIREMENTS_SUPPORT", "Should you have any question or concerns, please visit our forums at <a href='http://community.impresscms.org'>http://community.impresscms.org</a>.");
// constants for /admin/article.php
define("_AM_ARTICLE_ARTICLE_ADD", "Add Article");
define("_AM_ARTICLE_ARTICLE_EDIT", "Edit Article");
define("_AM_ARTICLE_ARTICLE_CREATE", "Create a new Article");
define("_AM_ARTICLE_ARTICLE_CREATED", "Article successfully submitted");
define("_AM_ARTICLE_ARTICLE_MODIFIED", "Article successfully modified");
define("_AM_ARTICLE_ARTICLE_OFFLINE", "Article offline");
define("_AM_ARTICLE_ARTICLE_ONLINE", "Article online");
define("_AM_ARTICLE_ARTICLE_INBLOCK_TRUE", "Article visible in block");
define("_AM_ARTICLE_ARTICLE_INBLOCK_FALSE", "Article hidden from block");
define("_AM_ARTICLE_ARTICLE_APPROVED", "Article approved");
define("_AM_ARTICLE_ARTICLE_DENIED", "Article denied");
define("_AM_ARTICLE_ARTICLE_WEIGHTS_UPDATED", "Weights have successfully been updated");
define("_AM_ARTICLE_NO_CAT_FOUND", "No Category found");
// constants for admin/category.php
define("_AM_ARTICLE_CATEGORY_ADD", "Add Category");
define("_AM_ARTICLE_CATEGORY_EDIT", "Edit Category");
define("_AM_ARTICLE_CATEGORY_CREATE", "Create a new Category");
define("_AM_ARTICLE_CATEGORY_CREATED", "Category successfully created");
define("_AM_ARTICLE_CATEGORY_MODIFIED", "Category successfully modified");
define("_AM_ARTICLE_CATEGORY_OFFLINE", "Category offline");
define("_AM_ARTICLE_CATEGORY_ONLINE", "Category online");
define("_AM_ARTICLE_INBLOCK_TRUE", "Category visible in block");
define("_AM_ARTICLE_INBLOCK_FALSE", "Category hidden from block");
define("_AM_ARTICLE_CATEGORY_APPROVED", "Category approved");
define("_AM_ARTICLE_CATEGORY_DENIED", "Category denied");
define("_AM_ARTICLE_CATEGORY_WEIGHTS_UPDATED", "Weights have successfully been updated");

// constants for /admin/indexpage.php
define("_AM_ARTICLE_INDEXPAGE_EDIT", "Edit the Indexpage");

//constants for admin/index.php
define("_AM_ARTICLE_INDEX_WARNING", "PLEASE READ MANUAL BEFORE USING");
define("_AM_ARTICLE_INDEX_TOTAL", "Total");
define("_AM_ARTICLE_FILES_IN", " Files in ");
define("_AM_ARTICLE_CATEGORIES", " Categories");
define("_AM_ARTICLE_INDEX_BROKEN_FILES", "Broken Attachments");
define("_AM_ARTICLE_INDEX_NEED_APPROVAL_FILES", "Files need approval");
define("_AM_ARTICLE_INDEX_NEED_APPROVAL_CATS", "Categories need approval");
define("_AM_ARTICLE_INDEX", "Article Index");

// import site
define("_AM_ARTICLE_IMPORT_SMARTSECTION_WARNING", "Please handle carefully! You should have a clean updated ImpressCMS 1.3.x site. Please beware, that you don't have used 'Downloads'-Module before and you don't have created articles/files!");