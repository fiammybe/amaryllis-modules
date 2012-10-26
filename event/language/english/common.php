<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /language/english/common.php
 * 
 * english common language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
// category
define("_CO_EVENT_CATEGORY_CATEGORY_NAME", "Name of Category");
define("_CO_EVENT_CATEGORY_CATEGORY_NAME_DSC", "");
define("_CO_EVENT_CATEGORY_CATEGORY_DSC", "Description");
define("_CO_EVENT_CATEGORY_CATEGORY_DSC_DSC", "");
define("_CO_EVENT_CATEGORY_CATEGORY_ICON", "Icon");
define("_CO_EVENT_CATEGORY_CATEGORY_ICON_DSC", "");
define("_CO_EVENT_CATEGORY_CATEGORY_COLOR", "Background Color");
define("_CO_EVENT_CATEGORY_CATEGORY_COLOR_DSC", "");
define("_CO_EVENT_CATEGORY_CATEGORY_TXTCOLOR", "Text Color");
define("_CO_EVENT_CATEGORY_CATEGORY_TXTCOLOR_DSC", "");
define("_CO_EVENT_CATEGORY_CAT_VIEW", "View Permissions");
define("_CO_EVENT_CATEGORY_CAT_VIEW_DSC", "");
define("_CO_EVENT_CATEGORY_CAT_SUBMIT", "Submit Permissions");
define("_CO_EVENT_CATEGORY_CAT_SUBMIT_DSC", "");
// calendar
define("_CO_EVENT_CALENDAR_CALENDAR_NAME", "Calendar Name");
define("_CO_EVENT_CALENDAR_CALENDAR_NAME_DSC", "");
define("_CO_EVENT_CALENDAR_CALENDAR_DSC", "Description");
define("_CO_EVENT_CALENDAR_CALENDAR_DSC_DSC", "");
define("_CO_EVENT_CALENDAR_CALENDAR_URL", "Feed url");
define("_CO_EVENT_CALENDAR_CALENDAR_URL_DSC", "The feed url of the calendar to recieve the events");
define("_CO_EVENT_CALENDAR_CALENDAR_COLOR", "Color");
define("_CO_EVENT_CALENDAR_CALENDAR_COLOR_DSC", "Background Color of the events assigned to this calendar");
define("_CO_EVENT_CALENDAR_CALENDAR_TXTCOLOR", "Text Color");
define("_CO_EVENT_CALENDAR_CALENDAR_TXTCOLOR_DSC", "Text Color of the events assigned to this calendar");
define("_CO_EVENT_CALENDAR_CALENDAR_TZ", "Default Time Zone");
define("_CO_EVENT_CALENDAR_CALENDAR_TZ_DSC", "Google Calendars Timezone. Look in Manual for more informations");
// event
define("_CO_EVENT_EVENT_EVENT_NAME", "Name of event");
define("_CO_EVENT_EVENT_EVENT_NAME_DSC", "");
define("_CO_EVENT_EVENT_EVENT_CID", "Category");
define("_CO_EVENT_EVENT_EVENT_CID_DSC", "");
define("_CO_EVENT_EVENT_EVENT_DSC", "Description");
define("_CO_EVENT_EVENT_EVENT_DSC_DSC", "");
define("_CO_EVENT_EVENT_EVENT_CONTACT", "Contact Person");
define("_CO_EVENT_EVENT_EVENT_CONTACT_DSC", "");
define("_CO_EVENT_EVENT_EVENT_CEMAIL", "Contact Mail");
define("_CO_EVENT_EVENT_EVENT_CEMAIL_DSC", "");
define("_CO_EVENT_EVENT_EVENT_URL", "URL");
define("_CO_EVENT_EVENT_EVENT_URL_DSC", "");
define("_CO_EVENT_EVENT_EVENT_PHONE", "Phone");
define("_CO_EVENT_EVENT_EVENT_PHONE_DSC", "");
define("_CO_EVENT_EVENT_EVENT_STREET", "Street/No");
define("_CO_EVENT_EVENT_EVENT_STREET_DSC", "");
define("_CO_EVENT_EVENT_EVENT_ZIP", "Postal Code");
define("_CO_EVENT_EVENT_EVENT_ZIP_DSC", "");
define("_CO_EVENT_EVENT_EVENT_CITY", "City");
define("_CO_EVENT_EVENT_EVENT_CITY_DSC", "");
define("_CO_EVENT_EVENT_EVENT_ALLDAY", "All Day Event?");
define("_CO_EVENT_EVENT_EVENT_ALLDAY_DSC", "");
define("_CO_EVENT_EVENT_EVENT_STARTDATE", "Start Date");
define("_CO_EVENT_EVENT_EVENT_STARTDATE_DSC", "");
define("_CO_EVENT_EVENT_EVENT_ENDDATE", "End Date");
define("_CO_EVENT_EVENT_EVENT_ENDDATE_DSC", "");
define("_CO_EVENT_EVENT_EVENT_PUBLIC", "Event is Public?");
define("_CO_EVENT_EVENT_EVENT_PUBLIC_DSC", "Select &#039;Yes&#039;, if the event is public and should be displayed in Events Block");
define("_CO_EVENT_EVENT_EVENT_JOINER", "Maximum Joiners");
define("_CO_EVENT_EVENT_EVENT_JOINER_DSC", "Enter the maximum amount of joiners for the event. '0' will allow uncountable joiners");
define("_CO_EVENT_EVENT_EVENT_CAN_JOINT", "Event can be joint (by)");
define("_CO_EVENT_EVENT_EVENT_TAGS", "Tags");
define("_CO_EVENT_EVENT_EVENT_TAGS_DSC", "You can enter multiple tags by seperating with a comma");
define("_CO_EVENT_EVENT_EVENT_SUBMITTER", "Submitted By");
define("_CO_EVENT_EVENT_EVENT_SUBMITTER_DSC", "");
define("_CO_EVENT_EVENT_EVENT_CREATED_ON", "Submitted on");
define("_CO_EVENT_EVENT_EVENT_CREATED_ON_DSC", "");
define("_CO_EVENT_EVENT_EVENT_APPROVE", "Approved?");
define("_CO_EVENT_EVENT_EVENT_APPROVE_DSC", "");
define("_CO_EVENT_EVENT_EVENT_NOTIF_SENT", "Notification Sent");
define("_CO_EVENT_EVENT_EVENT_NOTIF_SENT_DSC", "");
define("_CO_EVENT_HAS_APPROVED", "Your submitted Event has been approved");
define("_CO_EVENT_CANNOT_BOOK_PAST", "You cannot book a conference in the past!");
define("_CO_EVENT_CANNOT_BOOK_PASTEND", "The End Date needs to be after the start Date");
define("_CO_EVENT_AWAITING_APPROVAL", "Your Event still is awaiting approval");
define("_CO_EVENT_NEW_EVENT_APPROVAL", "%s has submitted a new Event which is awaiting approval");
define("_CO_EVENT_NEW_EVENT", "New Event is awaiting approval");
define("_CO_EVENT_NEW_EVENT_JOINER_BDY", "%s will attend your Event");
define("_CO_EVENT_NEW_EVENT_JOINER_SBJ", "Someone will attend your Event");

define("_CO_EVENT_NEW_EVENT_UNJOINER_BDY", "%s will not attend your Event");
define("_CO_EVENT_NEW_EVENT_UNJOINER_SBJ", "Someone will not attend your Event");
//calendar
define("_CO_EVENT_MONDAY", "Monday");
define("_CO_EVENT_TUESDAY", "Tuesday");
define("_CO_EVENT_WEDNESDAY", "Wednesday");
define("_CO_EVENT_THURSDAY", "Thursday");
define("_CO_EVENT_FRIDAY", "Friday");
define("_CO_EVENT_SATURDAY", "Saturday");
define("_CO_EVENT_SUNDAY", "Sunday");
define("_CO_EVENT_MO", "Mo");
define("_CO_EVENT_TU", "Tu");
define("_CO_EVENT_WE", "We");
define("_CO_EVENT_TH", "Th");
define("_CO_EVENT_FR", "Fr");
define("_CO_EVENT_SA", "Sa");
define("_CO_EVENT_SU", "Su");

define("_CO_EVENT_JANUARY", "January");
define("_CO_EVENT_FEBRUARY", "February");
define("_CO_EVENT_MARCH", "March");
define("_CO_EVENT_APRIL", "April");
define("_CO_EVENT_MAY", "May");
define("_CO_EVENT_JUNE", "June");
define("_CO_EVENT_JULY", "July");
define("_CO_EVENT_AUGUST", "August");
define("_CO_EVENT_SEPTEMBER", "September");
define("_CO_EVENT_OCTOBER", "October");
define("_CO_EVENT_NOVEMBER", "November");
define("_CO_EVENT_DECEMBER", "December");

define("_CO_EVENT_JAN", "Jan");
define("_CO_EVENT_FEB", "Feb");
define("_CO_EVENT_MAR", "Mar");
define("_CO_EVENT_APR", "Apr");
define("_CO_EVENT_MAI", "May");
define("_CO_EVENT_JUN", "Jun");
define("_CO_EVENT_JUL", "Jul");
define("_CO_EVENT_AUG", "Aug");
define("_CO_EVENT_SEP", "Sep");
define("_CO_EVENT_OCT", "Oct");
define("_CO_EVENT_NOV", "Nov");
define("_CO_EVENT_DEC", "Dec");

define("_CO_EVENT_TODAY", "Today");
define("_CO_EVENT_ALLDAY", "All day");
define("_CO_EVENT_DAY", "Day");
define("_CO_EVENT_DAYS", "Days");
define("_CO_EVENT_WEEK", "Week");
define("_CO_EVENT_WEEKS", "Weeks");
define("_CO_EVENT_MONTH", "Month");
define("_CO_EVENT_MONTHS", "Months");
define("_CO_EVENT_YEAR", "Year");
define("_CO_EVENT_YEARS", "Years");
//waiting plugin
define("_CO_EVENT_CATEGORY_APPROVE", "Waiting categories for approval");
define("_CO_EVENT_EVENT_APPROVE", "Waiting events for approval");
define("_CO_EVENT_EVENT_UNLIMITED", "unlimited");
define("_CO_EVENT_EVENT_JOINERS", "Subscribers");
define("_CO_EVENT_USERS", "Users");
define("_CO_EVENT_JOIN", "Join Event");
define("_CO_EVENT_UNJOIN", "Unjoin Event");