<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /language/english/modinfo.php
 * 
 * english modinfo language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_ICMSPOLL_MD_NAME", "Polls");
define("_MI_ICMSPOLL_MD_DSC", "'Icmspoll' is a poll module for ImpressCMS and iforum. This means, it can work as a standalone poll module or can be integrated in iforum to provide polls in forum.");
/**
 * module preferences
 */
define("_MI_ICMSPOLL_AUTHORIZED_CREATOR", "Select groups to be allowed adding new polls");
define("_MI_ICMSPOLL_AUTHORIZED_CREATOR_DSC", "");
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT", "Date Format");
define("_MI_ICMSPOLL_CONFIG_DATE_FORMAT_DSC", "");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP", "Restricted by IP");
define("_MI_ICMSPOLL_CONFIG_LIMITBYIP_DSC", "");
define("_MI_ICMSPOLL_CONFIG_LIMITBYSESSION", "Restricted by Session");
define("_MI_ICMSPOLL_CONFIG_LIMITBYSESSION_DSC", "");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID", "Restricted by user");
define("_MI_ICMSPOLL_CONFIG_LIMITBYUID_DSC", "");
define("_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS", "Display breadcrumb?");
define("_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS_DSC", "Select 'YES' to display breadcrumb in front end");
define("_MI_ICMSPOLL_CONFIG_SHOW_POLLS", "Limit of polls to be displayed on index");
define("_MI_ICMSPOLL_CONFIG_SHOW_POLLS_DSC", "Set the Limit of polls to be displayed on index before page nav will be renderd");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER", "Default Order");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_DSC", "Order Polls on index as default by:");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_WEIGHT", "Weight");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_CREATIONDATE", "Creation Date");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_STARTDATE", "Start Date");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_ENDDATE", "End Date");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT", "Default Sort");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DSC", "Sort polls on index as default by:");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_ASC", "ASC");
define("_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DESC", "DESC");
define("_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE", "Allow initial values?");
define("_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE_DSC", "Set 'YES' if you like to allow initial values for options");
define("_MI_ICMSPOLL_CONFIG_PRINT_FOOTER", "Print Footer");
define("_MI_ICMSPOLL_CONFIG_PRINT_FOOTER_DSC", "This footer will be used in print layouts");
define("_MI_ICMSPOLL_CONFIG_PRINT_LOGO", "Print Logo");
define("_MI_ICMSPOLL_CONFIG_PRINT_LOGO_DSC", "Enter the path to logo to be printed. E.g.: /themes/example/images/logo.gif");
define("_MI_ICMSPOLL_CONFIG_USE_RSS", "Use RSS-Feeds?");
define("_MI_ICMSPOLL_CONFIG_USE_RSS_DSC", "Set to 'YES' to provide a rss link.");
define("_MI_ICMSPOLL_CONFIG_RSS_LIMIT", "RSS Limit");
define("_MI_ICMSPOLL_CONFIG_RSS_LIMIT_DSC", "Limit of Polls for RSS");
/**
 * module Templates
 */
define("_MI_ICMSPOLL_TPL_INDEX", "Icmspoll indexview");
define("_MI_ICMSPOLL_TPL_HEADER", "Header file included in frontend");
define("_MI_ICMSPOLL_TPL_FOOTER", "Footer File Included in Frontend");
define("_MI_ICMSPOLL_TPL_POLLS", "Poll loop in index view");
define("_MI_ICMSPOLL_TPL_SINGLEPOLL", "Display a single poll");
define("_MI_ICMSPOLL_TPL_RESULTS", "Display Poll result");
define("_MI_ICMSPOLL_TPL_PRINT", "Print template");
define("_MI_ICMSPOLL_TPL_FORMS", "Forms for create/delete polls in frontend");
define("_MI_ICMSPOLL_TPL_ADMIN_FORM", "ACP Template");
define("_MI_ICMSPOLL_TPL_REQUIREMENTS", "Requirements check");
/**
 * module blocks
 */
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS", "Recent Polls");
define("_MI_ICMSPOLL_BLOCK_RECENT_POLLS_DSC", "Display a list of recent polls");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL", "Single Poll");
define("_MI_ICMSPOLL_BLOCK_SINGLE_POLL_DSC", "Display a single poll");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS", "Recent Results");
define("_MI_ICMSPOLL_BLOCK_RECENT_RESULTS_DSC", "Display recent results");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT", "Single Result");
define("_MI_ICMSPOLL_BLOCK_SINGLE_RESULT_DSC", "Display single result");
/**
 * module ACP menu
 */
define("_MI_ICMSPOLL_MENU_INDEX", "Index");
define("_MI_ICMSPOLL_MENU_POLLS", "Polls");
define("_MI_ICMSPOLL_MENU_OPTIONS", "Poll options");
define("_MI_ICMSPOLL_MENU_LOG", "Poll Log");
define("_MI_ICMSPOLL_MENU_INDEXPAGE", "Indexpage");
define("_MI_ICMSPOLL_MENU_TEMPLATES", "Templates");
define("_MI_ICMSPOLL_MENU_MANUAL", "Manual");
// submenu
define("_MI_ICMSPOLL_MENU_POLLS_EDITING", "Edit Poll");
define("_MI_ICMSPOLL_MENU_POLLS_CREATINGNEW", "Create a new Poll");
define("_MI_ICMSPOLL_MENU_OPTIONS_EDITING", "Edit Option");
define("_MI_ICMSPOLL_MENU_OPTIONS_CREATINGNEW", "Create a new option");
define("_MI_ICMSPOLL_MENU_INDEXPAGE_EDIT", "Edit Indexpage");
/**
 * Mainmenu
 */
define("_MI_ICMSPOLL_MENUMAIN_ADDPOLL", "Add Poll");
define("_MI_ICMSPOLL_MENUMAIN_VIEW_POLLS_TABLE", "View Polls Table");
define("_MI_ICMSPOLL_MENUMAIN_VIEW_OPTIONS_TABLE", "View options Table");
define("_MI_ICMSPOLL_MENUMAIN_VIEWRESULTS", "View Results");
/**
 * Notifications
 */
define("_MI_ICMSPOLL_GLOBAL_NOTIFY", "All Polls");
define("_MI_ICMSPOLL_GLOBAL_NOTIFY_DSC", "Notifications related to all polls in the module");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY", "New Poll published");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_CAP", "Notify me when a new Poll is published");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_DSC", "Receive notification when any new poll is published.");
define("_MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New Poll published");