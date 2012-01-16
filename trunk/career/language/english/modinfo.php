<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /language/english/modinfo.php
 * 
 * modinfo language constants
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
 
// general informations
define("_MI_CAREER_NAME", "Career");
define("_MI_CAREER_DSC", "'Career' is an career management module for ImpressCMS");
// templates
define("_MI_CAREER_INDEX_TPL", "Career index view");
define("_MI_CAREER_CAREER_TPL", "single Career view");
define("_MI_CAREER_MESSAGE_TPL", "message index- and single view");
define("_MI_CAREER_HEADER_TPL", "frontend header - contains breadcrumb and indeximage");
define("_MI_CAREER_FOOTER_TPL", "frontend footer - contains admin link and module footer");
define("_MI_CAREER_ADMIN_TPL", "admin template");
define("_MI_CAREER_REQUIREMENTS_TPL", "requirements check");
// constants for block descriptions
define("_MI_CAREER_BLOCK_RECENT_CAREERS", "Recent Careers");
define("_MI_CAREER_BLOCK_RECENT_CAREERS_DSC", "Display recent published careers in a block");
define("_MI_CAREER_BLOCK_RECENT_MESSAGES", "Recent Messages");
define("_MI_CAREER_BLOCK_RECENT_MESSAGES_DSC", "Display recent messages in a block");
define("_MI_CAREER_BLOCK_DEPARTMENTS", "Departments");
define("_MI_CAREER_BLOCK_DEPARTMENTS_DSC", "List of departments");
// constants for preferences
define("_MI_CAREER_DATE_FORMAT", "Date Format");
define("_MI_CAREER_DATE_FORMAT_DSC", "For more informations: <a href=\"http://php.net/manual/en/function.date.php\" target=\"blank\">see php.net manual</a>");
define("_MI_CAREER_SHOW_BREADCRUMBS", "show breadcrumb");
define("_MI_CAREER_SHOW_BREADCRUMBS_DSC", "choose 'YES' to show breadcrumb in frontend");
define("_MI_CAREER_DISPLAY_COMPANY", "Enter your company Name");
define("_MI_CAREER_DISPLAY_COMPANY_DSC", "The company Name will be displayed in frontend.");
define("_MI_CAREER_IMAGE_UPLOAD_WIDTH", "image upload width");
define("_MI_CAREER_IMAGE_UPLOAD_WIDTH_DSC", "set max width for uploading images");
define("_MI_CAREER_IMAGE_UPLOAD_HEIGHT", "image upload height");
define("_MI_CAREER_IMAGE_UPLOAD_HEIGHT_DSC", "set max height for uploading images");
define("_MI_CAREER_IMAGE_FILE_SIZE", "image file size");
define("_MI_CAREER_IMAGE_FILE_SIZE_DSC", "set max file size for uploading");
define("_MI_CAREER_UPLOAD_FILE_SIZE", "max file size");
define("_MI_CAREER_UPLOAD_FILE_SIZE_DSC", "set max file size for uploading");
define("_MI_CAREER_DAYSNEW", "How many days to provide one career as new?");
define("_MI_CAREER_DAYSNEW_DSC", "Enter the days or set to 0 to turn off");
define("_MI_CAREER_DAYSUPDATED", "How many days to provide one career as updated after editing?");
define("_MI_CAREER_DAYSUPDATED_DSC", "Enter the days or set to 0 to turn off");
// constants for notifications
define("_MI_CAREER_GLOBAL_NOTIFY", "Global");
define("_MI_CAREER_GLOBAL_NOTIFY_DSC", "Global Career notification options.");
define("_MI_CAREER_CAREER_NOTIFY", "Career");
define("_MI_CAREER_CAREER_NOTIFY_DSC", "");

define("_MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY", "New Career");
define("_MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY_CAP", "Notify me when any new career is posted.");
define("_MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY_DSC", "Receive notification when any new career is posted.");
define("_MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New Career'");

define("_MI_CAREER_CAREER_MODIFIED_NOTIFY", "Career updated");
define("_MI_CAREER_CAREER_MODIFIED_NOTIFY_CAP", "Notify me when any career is modified.");
define("_MI_CAREER_CAREER_MODIFIED_NOTIFY_DSC", "Receive notification when a career is modified.");
define("_MI_CAREER_CAREER_MODIFIED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : Career modified'");

define("_MI_CAREER_CAREER_MESSAGE_SUBMIT_NOTIFY", "Message submitted");
define("_MI_CAREER_CAREER_MESSAGE_SUBMIT_NOTIFY_CAP", "Notify me when any message is submitted.");
define("_MI_CAREER_CAREER_MESSAGE_SUBMIT_NOTIFY_DSC", "Receive notification when a message is submitted.");
define("_MI_CAREER_CAREER_MESSAGE_SUBMIT_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : Message submitted'");

// ACP Menu
define("_MI_CAREER_MENU_CAREER", "Manage Offerings");
define("_MI_CAREER_MENU_DEPARTMENT", "Manage departments");
define("_MI_CAREER_MENU_INDEXPAGE", "Edit Indexpage");
define("_MI_CAREER_MENU_MESSAGE", "Manage Messages");
define("_MI_CAREER_MENU_TEMPLATES", "Templates");
// ACP submenu
define("_MI_CAREER_CAREER_EDIT", "Edit job offering");
define("_MI_CAREER_CAREER_CREATINGNEW", "Create a new job Offering");
define("_MI_CAREER_DEPARTMENT_EDIT", "Edit department");
define("_MI_CAREER_DEPARTMENT_CREATINGNEW", "Create a new department");
define("_MI_CAREER_INDEXPAGE_EDIT", "Edit indexpage");
