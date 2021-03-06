<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /language/english/common.php
 * 
 * english common language file
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
/**
 * constants for poll objects
 */
define("_CO_ICMSPOLL_POLLS_QUESTION", "Poll Question");
define("_CO_ICMSPOLL_POLLS_DESCRIPTION", "Poll Description");
define("_CO_ICMSPOLL_POLLS_DELIMETER", "Select the delimeter to be used");
define("_CO_ICMSPOLL_POLLS_DELIMETER_DSC", "The delimeters for options in this poll");
define("_CO_ICMSPOLL_POLLS_USER_ID", "Author of the Poll");
define("_CO_ICMSPOLL_POLLS_START_TIME", "Sart of Poll");
define("_CO_ICMSPOLL_POLLS_END_TIME", "End of Poll");
define("_CO_ICMSPOLL_POLLS_VOTES", "Total votes");
define("_CO_ICMSPOLL_POLLS_VOTERS", "Total voters");
define("_CO_ICMSPOLL_POLLS_DISPLAY", "Display in block?");
define("_CO_ICMSPOLL_POLLS_WEIGHT", "");
define("_CO_ICMSPOLL_POLLS_MULTIPLE", "Allow multiple selection?");
define("_CO_ICMSPOLL_POLLS_MAIL_STATUS", "Notify the poll author when expired?");
define("_CO_ICMSPOLL_POLLS_EXPIRED", "Expired?");
define("_CO_ICMSPOLL_POLLS_STARTED", "Started?");
define("_CO_ICMSPOLL_POLLS_CREATED_ON", "Created on");

define("_CO_ICMSPOLL_POLLS_VIEWPERM", "View permissions");
define("_CO_ICMSPOLL_POLLS_VIEWPERM_DSC", "Select groups, which can view the poll");
define("_CO_ICMSPOLL_POLLS_VOTEPERM", "Vote permissions");
define("_CO_ICMSPOLL_POLLS_VOTEPERM_DSC", "Select groups, which can vote the poll");
define("_CO_ICMSPOLL_POLLS_DELIMETER_BRTAG", "BR-Tag (&lt;br /&gt;)");
define("_CO_ICMSPOLL_POLLS_DELIMETER_SPACE", "Space (&amp;nbsp;)");

define("_CO_ICMSPOLL_POLLS_MESSAGE_SUBJECT", "Your poll has expired");
define("_CO_ICMSPOLL_POLLS_MESSAGE_BDY", "Your poll %s has expired, you can see the results now.");
define("_CO_ICMSPOLL_POLLS_GET_MORE_BY_USER", "Get more Polls by ");
define("_CO_ICMSPOLL_POLLS_GET_MORE_RESULTS_BY_USER", "Get more results by ");
define("_CO_ICMSPOLL_POLLS_FILTER_ACTIVE", "Active Polls");
define("_CO_ICMSPOLL_POLLS_FILTER_EXPIRED", "Expired Polls");
define("_CO_ICMSPOLL_POLLS_ENDTIME_ERROR", "End time must be set to future");
define("_CO_ICMSPOLL_POLLS_FILTER_INACTIVE", "Inactive");
define("_CO_ICMSPOLL_POLLS_FILTER_STARTED", "Started");
define("_CO_ICMSPOLL_RESET", "Reset Poll BEWARE: This cannot be undone! Once clicked and your poll will be reseted. All log entries will be deleted!");
/**
 * constants for options objects
 */
define("_CO_ICMSPOLL_OPTIONS_POLL_ID", "Select Poll");
define("_CO_ICMSPOLL_OPTIONS_POLL_ID_DSC", "");
define("_CO_ICMSPOLL_OPTIONS_OPTION_TEXT", "Option Text");
define("_CO_ICMSPOLL_OPTIONS_OPTION_TEXT_DSC", "The text to be displayed for this option");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COLOR", "Option Color");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COLOR_DSC", "Select the color of the option");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COUNT", "Amount of votes");
define("_CO_ICMSPOLL_OPTIONS_OPTION_COUNT_DSC", "");
define("_CO_ICMSPOLL_OPTIONS_USER_ID", "Added by");
define("_CO_ICMSPOLL_OPTIONS_OPTION_INIT", "Initial Value");
define("_CO_ICMSPOLL_OPTIONS_OPTION_INIT_DSC", "You might like to set an initial value. This will be shown in all results for users, not in results for module admins.");

define("_CO_ICMSPOLL_OPTIONS_VOTES", "Votes");
// colors
define("_CO_ICMSPOLL_OPTIONS_COLORS_AQUA", "Aqua");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLANK", "Blank");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLUE", "Blue");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BROWN", "Brown");
define("_CO_ICMSPOLL_OPTIONS_COLORS_DARKGREEN", "Dark green");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GOLD", "Gold");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GREEN", "Green");
define("_CO_ICMSPOLL_OPTIONS_COLORS_GREY", "Grey");
define("_CO_ICMSPOLL_OPTIONS_COLORS_ORANGE", "Orange");
define("_CO_ICMSPOLL_OPTIONS_COLORS_PINK", "Pink");
define("_CO_ICMSPOLL_OPTIONS_COLORS_PURPLE", "Purple");
define("_CO_ICMSPOLL_OPTIONS_COLORS_RED", "Red");
define("_CO_ICMSPOLL_OPTIONS_COLORS_YELLOW", "Yellow");
define("_CO_ICMSPOLL_OPTIONS_COLORS_TRANSPARENT", "Transparent");
define("_CO_ICMSPOLL_OPTIONS_COLORS_BLACK", "Black");
/**
 * constants for log objects
 */
define("_CO_ICMSPOLL_LOG_POLL_ID", "Affected Poll");
define("_CO_ICMSPOLL_LOG_POLL_ID_DSC", "");
define("_CO_ICMSPOLL_LOG_OPTION_ID", "Affected option");
define("_CO_ICMSPOLL_LOG_OPTION_ID_DSC", "");
define("_CO_ICMSPOLL_LOG_IP", "IP");
define("_CO_ICMSPOLL_LOG_USER_ID", "User");
define("_CO_ICMSPOLL_LOG_TIME", "Tracking Time");
define("_CO_ICMSPOLL_LOG_SESSION_ID", "Session Fingerprint");
/**
 * constants for indexpage objects
 */
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMAGE", "Select an Image");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMAGE_DSC", "Select an image from list or upload a new one.");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMG_UPLOAD", "Image Upload");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_IMG_UPLOAD_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADER", "Index Header");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADER_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADING", "Index Heading");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_HEADING_DSC", "");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_FOOTER", "Index footer");
define("_CO_ICMSPOLL_INDEXPAGE_INDEX_FOOTER_DSC", "");

define("_CO_ICMSPOLL_POLL_HAS_EXPIRED", "Your Poll has Expired");
define("_CO_ICMSPOLL_OPTION_TOTALVOTES", "votes");
define("_CO_ICMSPOLL_ADMIN_SHOW_DETAILS", "Show more informations");
define("_CO_ICMSPOLL_PRESENT_BY_USERPROFILE", "This Poll was created by");
define("_CO_ICMSPOLL_POLLS_VISIT_USERPROFILE", "Visit the profile");
define("_CO_ICMSPOLL_POLLS_VOTES_UNTIL_NOW", "Votes until now");
define("_CO_ICMSPOLL_POLL_HAS_ENDED", "Completed on");
define("_CO_ICMSPOLL_POLL_ENDS_ON", "Ends on");
define("_CO_ICMSPOLL_POLL_HAS_EXPIRED_VISITOR", "This poll has expired, you can see the results now:");
