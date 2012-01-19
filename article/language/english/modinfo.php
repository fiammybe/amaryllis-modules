<?php
/**
 * English language constants related to module information
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		article
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_ARTICLE_MD_NAME", "Article");
define("_MI_ARTICLE_MD_DSC", "'Article' is an article management module for ImpressCMS. You can categorize your articles, attach files and related articles to each article file.");
// templates
define("_MI_ARTICLE_INDEX_TPL", "Article index page in frontend");
define("_MI_ARTICLE_ARTICLE_TPL", "Articles for article loop on index view");
define("_MI_ARTICLE_CATEGORY_TPL", "Categories for category loop on index view");
define("_MI_ARTICLE_FORMS_TPL", "Article submit forms to submit Articles and categories from frontend");
define("_MI_ARTICLE_SINGLEARTICLE_TPL", "Display a single article");
define("_MI_ARTICLE_ADMIN_TPL", "Template for module ACP");
define("_MI_ARTICLE_REQUIREMENTS_TPL", "Check requirements");
define("_MI_ARTICLE_HEADER_TPL", "header file included in all frontend templates. Contains CSS file, breadcrumb and rss feed link");
define("_MI_ARTICLE_FOOTER_TPL", "footer file included in all frontend templates. Contains module footer, comment loop and notifications");
// blocks
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE", "Recent Articles");
define("_MI_ARTICLE_BLOCK_RECENT_ARTICLE_DSC", "Displayes the recent published articles");
define("_MI_ARTICLE_BLOCK_RECENT_UPDATED", "recent updated articles");
define("_MI_ARTICLE_BLOCK_RECENT_UPDATED_DSC", "Displays recent updated articles");
define("_MI_ARTICLE_BLOCK_MOST_POPULAR", "Most popular articles");
define("_MI_ARTICLE_BLOCK_MOST_POPULAR_DSC", "Displays most popular articles");
define("_MI_ARTICLE_BLOCK_CATEGORY_MENU", "Category Menu");
define("_MI_ARTICLE_BLOCK_CATEGORY_MENU_DSC", "Category menu block");
// preferences
define("_MI_ARTICLE_AUTHORIZED_GROUPS", "Authorized groups for submitting categories from frontend");
define("_MI_ARTICLE_AUTHORIZED_GROUPS_DSC", "All selected groups will be allowed to submit new categories from frontend");
define("_MI_ARTICLE_DATE_FORMAT", "Date format");
define("_MI_ARTICLE_DATE_FORMAT_DSC", "For more informations: <a href=\"http://php.net/manual/en/function.date.php\" target=\"blank\">see php.net manual</a>");
define("_MI_ARTICLE_SHOW_BREADCRUMBS", "Display breadcrumb");
define("_MI_ARTICLE_SHOW_BREADCRUMBS_DSC", "Select 'YES' to display breadcrumb in frontend");
define("_MI_ARTICLE_SHOW_CATEGORIES", "Show Categories");
define("_MI_ARTICLE_SHOW_CATEGORIES_DSC", "How many Categories should be displayed in each page");
define("_MI_ARTICLE_SHOW_CATEGORY_COLUMNS", "Select category columns");
define("_MI_ARTICLE_SHOW_CATEGORY_COLUMNS_DSC", "You can select how many columns you want to see in the frontpage to sort categories");
define("_MI_ARTICLE_SHOW_ARTICLE", "Show Categories");
define("_MI_ARTICLE_SHOW_ARTICLE_DSC", "How many Categories should be displayed in each page");
define("_MI_ARTICLE_THUMBNAIL_WIDTH", "Screenshot Thumbnail width");
define("_MI_ARTICLE_THUMBNAIL_WIDTH_DSC", "choose width of screenshot thumbnails");
define("_MI_ARTICLE_THUMBNAIL_HEIGHT", "Screenshot Thumbnail height");
define("_MI_ARTICLE_THUMBNAIL_HEIGHT_DSC", "choose width of screenshot thumbnails");
define("_MI_ARTICLE_DISPLAY_WIDTH", "Display width");
define("_MI_ARTICLE_DISPLAY_WIDTH_DSC", "Image display width");
define("_MI_ARTICLE_DISPLAY_HEIGHT", "Display height");
define("_MI_ARTICLE_DISPLAY_HEIGHT_DSC", "Image display height");
define("_MI_ARTICLE_IMAGE_UPLOAD_WIDTH", "image upload width");
define("_MI_ARTICLE_IMAGE_UPLOAD_WIDTH_DSC", "set max width for uploading images");
define("_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT", "image upload height");
define("_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT_DSC", "set max height for uploading images");
define("_MI_ARTICLE_UPLOAD_ARTICLE_SIZE", "max file size");
define("_MI_ARTICLE_UPLOAD_ARTICLE_SIZE_DSC", "set max file size for uploading");
define("_MI_ARTICLE_SHOWDISCLAIMER", "Show disclaimer, before an user can submit new articles?");
define("_MI_ARTICLE_SHOWDISCLAIMER_DSC", "Select 'YES' to show the disclaimer before an user can submit new articles ");
define("_MI_ARTICLE_DISCLAIMER", "Disclaimer for Articleupload");
define("_MI_ARTICLE_UPL_DISCLAIMER_TEXT", "<h1>Terms of Service for {X_SITENAME}:</h1>
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
define("_MI_ARTICLE_SHOW_DOWN_DISCL", "Show disclaimer, before an user can download attached files?");
define("_MI_ARTICLE_SHOW_DOWN_DISCL_DSC", "Select 'YES' to show the disclaimer before an user can download attached files");
define("_MI_ARTICLE_DOWN_DISCLAIMER", "Disclaimer for Article attachment download");
define("_MI_ARTICLE_DOWN_DISCLAIMER_TEXT", "<h1>TERMS OF USE</h1>
												<p>All products available for download through this site are provided by third party software/scripts publishers pursuant to license agreements or other arrangements between such publishers and the end user. We disclaim any responsibility for or liability related to the software/scripts. Any questions complaints or claims related to the software should be directed to the appropriate Author or Company responsible for developing the software. We make no representations or warranties of any kind concerning the quality, safety or suitability of the software/script, either expressed or implied, including without limitation any implied warranties of merchantability, fitness for a particular purpose, or non-infringement. We make no representation or warrantie as to the truth, accuracy or completeness of any statements, information or materials concerning the software/script that is contained on and within any of the websites owned and operated by us. In no event will we be liable for any indirect, punitive, special, incidental or consequential damages however they may arise and even if we have been previously advised of the possibility of such damages. There are inherent dangers in the use of any software/script available for download on the Internet, and we caution you to make sure that you completely understand the potential risks before downloading any of the software/scripts. You are solely responsible for adequate protection and backup of the data and equipment used in connection with any of the software, and we will not be liable for any damages that you may suffer in connection with using, modifying or distributing any of the software.</p>
												<h2>PRIVACY STATEMENT</h2>
												<p>We record visits to this web site and logs the following information for statistical purposes: the user's server or proxy address, the date/time of the visit and the files requested. The information is used to analyse our server traffic. No attempt will be made to identify users or their browsing activities except where authorized by law. For example in the event of an investigation, a law enforcement agency may exercise their legal authority to inspect the internet service provider's logs. If you send us an email message or contact as via contact form, we will record your contact details. This information will only be used for the purpose for which you have provided it. We will not use your email for any other purpose and will not disclose it without your consent except where such use or disclosure is permitted under an exception provided in the Privacy Act. When users choose to join a mailing list their details are added to that specific mailing list and used for the stated purpose of that list only.</p>
												<h2>LINKING</h2>
												<p>Links to external web sites are inserted for convenience and do not constitute endorsement of material at those sites, or any associated organization, product or service.</p>");
define("_MI_ARTICLE_USE_RSS", "Use RSS-Feeds?");
define("_MI_ARTICLE_USE_RSS_DSC", "Set to 'YES' to provide a rss link.");
define("_MI_ARTICLE_USE_SPROCKETS", "Use 'Sprockets' Module?");
define("_MI_ARTICLE_USE_SPROCKETS_DSC", "You can use 'Sprockets' Module to deal with tags. Only Tags will be supported, not navigation Elements or Tags labled as both!");
define("_MI_ARTICLE_NEED_RELATED", "Do you need related Articles?");
define("_MI_ARTICLE_NEED_RELATED_DSC", "If set to 'YES', you can select related articles from a list.");
define("_MI_ARTICLE_ARTICLE_APPROVE", "Do you need approvals for new files?");
define("_MI_ARTICLE_ARTICLE_APPROVE_DSC", "Select 'YES' if you prefer to approve the files uploaded in frontend first, before providing the file");
define("_MI_ARTICLE_CATEGORY_APPROVE", "Do you need approvals for new categories?");
define("_MI_ARTICLE_CATEGORY_APPROVE_DSC", "Select 'YES' if you prefer to approve the new categories created on frontend first, before providing the link");
define("_MI_ARTICLE_DISPLAY_ARTICLE_SIZE", "How to display the file size?");
define("_MI_ARTICLE_DISPLAY_ARTICLE_SIZE_DSC", "Select 'byte' to display in byte, 'mb' to display in megabyte, 'gb' to display in gigabyte");
define("_MI_ARTICLE_POPULAR", "How many calls of one article before it's popular");
define("_MI_ARTICLE_DAYSNEW", "How many days to provide one article as new");
define("_MI_ARTICLE_DAYSUPDATED", "How many days to provide one article as updated after editing");

// Notifications
define('_MI_ARTICLE_GLOBAL_NOTIFY', 'Global');
define('_MI_ARTICLE_GLOBAL_NOTIFY_DSC', 'Global Article notification options.');

define('_MI_ARTICLE_CATEGORY_NOTIFY', 'Category');
define('_MI_ARTICLE_CATEGORY_NOTIFY_DSC', 'Notification options that apply to the current file category.');

define('_MI_ARTICLE_ARTICLE_NOTIFY', 'Article');
define('_MI_ARTICLE_ARTICLE_NOTIFY_DSC', 'Notification options that apply to the current article.');

define('_MI_ARTICLE_GLOBAL_CATSUBMIT_NOTIFY', 'Category Submitted');
define('_MI_ARTICLE_GLOBAL_CATSUBMIT_NOTIFY_CAP', 'Notify me when any new category is submitted.');
define('_MI_ARTICLE_GLOBAL_CATSUBMIT_NOTIFY_DSC', 'Receive notification when any new category is submitted (awaiting approval).');
define('_MI_ARTICLE_GLOBAL_CATSUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted');

define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY', 'New Category');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_CAP', 'Notify me when a new file category is created.');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_DSC', 'Receive notification when a new file category is created.');
define('_MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file category');

define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY', 'Category Modified');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_CAP', 'Notify me when any category is modified.');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_DSC', 'Receive notification when any category is modified.');
define('_MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Category Modified');

define('_MI_ARTICLE_GLOBAL_ARTICLEBROKEN_NOTIFY', 'Broken File Submitted');
define('_MI_ARTICLE_GLOBAL_ARTICLEBROKEN_NOTIFY_CAP', 'Notify me of any broken file report.');
define('_MI_ARTICLE_GLOBAL_ARTICLEBROKEN_NOTIFY_DSC', 'Receive notification when any broken file report is submitted.');
define('_MI_ARTICLE_GLOBAL_ARTICLEBROKEN_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Broken Article Reported');

define('_MI_ARTICLE_GLOBAL_ARTICLESUBMIT_NOTIFY', 'Article Submitted');
define('_MI_ARTICLE_GLOBAL_ARTICLESUBMIT_NOTIFY_CAP', 'Notify me when any new file is submitted (awaiting approval).');
define('_MI_ARTICLE_GLOBAL_ARTICLESUBMIT_NOTIFY_DSC', 'Receive notification when any new file is submitted (awaiting approval).');
define('_MI_ARTICLE_GLOBAL_ARTICLESUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted');

define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY', 'New Article');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_CAP', 'Notify me when any new file is posted.');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_DSC', 'Receive notification when any new file is posted.');
define('_MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file');

define('_MI_ARTICLE_CATEGORY_ARTICLESUBMIT_NOTIFY', 'Article Submitted');
define('_MI_ARTICLE_CATEGORY_ARTICLESUBMIT_NOTIFY_CAP', 'Notify me when a new file is submitted (awaiting approval) to the current category.');   
define('_MI_ARTICLE_CATEGORY_ARTICLESUBMIT_NOTIFY_DSC', 'Receive notification when a new file is submitted (awaiting approval) to the current category.');      
define('_MI_ARTICLE_CATEGORY_ARTICLESUBMIT_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted in category'); 

define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY', 'New Article');
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_CAP', 'Notify me when a new file is posted to the current category.');   
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_DSC', 'Receive notification when a new file is posted to the current category.');      
define('_MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file in category'); 

define('_MI_ARTICLE_ARTICLE_APPROVE_NOTIFY', 'Article Approved');
define('_MI_ARTICLE_ARTICLE_APPROVE_NOTIFY_CAP', 'Notify me when this file is approved.');
define('_MI_ARTICLE_ARTICLE_APPROVE_NOTIFY_DSC', 'Receive notification when this file is approved.');
define('_MI_ARTICLE_ARTICLE_APPROVE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Article Approved');

define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY', 'Article Modified');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_CAP', 'Notify me when this file is modified.');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_DSC', 'Receive notification when this file is modified.');
define('_MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Article Modified');

define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY', 'Article Modified');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_CAP', 'Notify me when a file in this category is modified.');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_DSC', 'Receive notification when a file in this category is modified.');
define('_MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Article Modified');

define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY', 'Article Modified');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_CAP', 'Notify me when any file is modified.');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_DSC', 'Receive notification when any file is modified.');
define('_MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Article Modified');

// ACP menu
define("_MI_ARTICLE_MENU_INDEX", "Index");
define("_MI_ARTICLE_MENU_ARTICLE", "Manage Articles");
define("_MI_ARTICLE_MENU_CATEGORY", "Manage Categories");
define("_MI_ARTICLE_MENU_INDEXPAGE", "Edit Indexpage");
define("_MI_ARTICLE_MENU_TEMPLATES", "Templates");
define("_MI_ARTICLE_MENU_MANUAL", "Manual");
// Submenu while calling a tab
define("_MI_ARTICLE_ARTICLE_EDIT", "Edit your Article");
define("_MI_ARTICLE_ARTICLE_CREATINGNEW", "Upload a new Article");
define("_MI_ARTICLE_CATEGORY_EDIT", "Edit your Category");
define("_MI_ARTICLE_CATEGORY_CREATINGNEW", "Create a new Category");