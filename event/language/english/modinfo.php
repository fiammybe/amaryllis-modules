<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /language/english/modinfo.php
 * 
 * english modinfo language file
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

define("_MI_EVENT_MD_NAME", "Event");
define("_MI_EVENT_MD_DESC", "ImpressCMS Simple Event module");
// acp menu
define("_MI_EVENT_MENU_EVENTS", "Events");
define("_MI_EVENT_MENU_CATEGORY", "Category");
define("_MI_EVENT_MENU_CALENDAR", "Calendars");
define("_MI_EVENT_MENU_MANUAL", "Manual");
define("_MI_EVENT_MENU_TEMPLATES", "Templates");
// config
define("_MI_EVENT_CONFIG_DEFAULT_VIEW", "Default View");
define("_MI_EVENT_CONFIG_DEFAULT_VIEW_DSC", "Select the default view for the calendar");
define("_MI_EVENT_CONFIG_DEFAULT_VIEW_MONTH", "Month");
define("_MI_EVENT_CONFIG_DEFAULT_VIEW_DAY", "Day");
define("_MI_EVENT_CONFIG_FIRST_DAY", "The first Day displayed in week view");
define("_MI_EVENT_CONFIG_FIRST_DAY_DSC", "Before selecting Sunday, be sure that weekends are displayed in week view");
define("_MI_EVENT_CONFIG_DISPLAY_WEEKEND", "Display Weekend");
define("_MI_EVENT_CONFIG_DISPLAY_WEEKEND_DSC", "");
define("_MI_EVENT_CONFIG_AGENDA_START", "Start time of the calendar");
define("_MI_EVENT_CONFIG_AGENDA_START_DSC", "This will be the Start time of the calendar, which means the time to be displayed first when in single day or week view. Needs to be 0-23");
define("_MI_EVENT_CONFIG_AGENDA_MIN", "Min time for week/single day view.");
define("_MI_EVENT_CONFIG_AGENDA_MIN_DSC", "The minimum time to be displayed on agenda view.");
define("_MI_EVENT_CONFIG_AGENDA_MAX", "Max time for week/single day view.");
define("_MI_EVENT_CONFIG_AGENDA_MAX_DSC", "The maximum time to be displayed on agenda view.");
define("_MI_EVENT_CONFIG_AGENDA_SLOT", "Slot minutes in Agenda view");
define("_MI_EVENT_CONFIG_AGENDA_SLOT_DSC", "");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_M", "Date Format Header Month");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_M_DSC", "The Date format for Calendar header in Month view. <b>Please check Manual for Date formatting!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_W", "Date Format Header Week");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_W_DSC", "The Date format for Calendar header in Week view. <b>Please check Manual for Date formatting!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_D", "Date Format Header Day");
define("_MI_EVENT_CONFIG_DEFAULT_HEADER_D_DSC", "The Date format for Calendar header in Day view. <b>Please check Manual for Date formatting!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_M", "Date Format Column Month");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_M_DSC", "The Date format for Calendar column in Month view. <b>Please check Manual for Date formatting!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_W", "Date Format Column Week");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_W_DSC", "The Date format for Calendar column in Week view. <b>Please check Manual for Date formatting!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_D", "Date Format Column Day");
define("_MI_EVENT_CONFIG_DEFAULT_COLUMN_D_DSC", "The Date format for Calendar column in Day view. <b>Please check Manual for Date formatting!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_TIME_A", "Time Format Agenda (Week and Day)");
define("_MI_EVENT_CONFIG_DEFAULT_TIME_A_DSC", "The Time format for Calendar Agenda view. <b>Please check Manual for Time formatting!</b>");
define("_MI_EVENT_CONFIG_DEFAULT_TIME", "Time Format (Month, all outside Agenda View)");
define("_MI_EVENT_CONFIG_DEFAULT_TIME_DSC", "The Time format for Calendar view outside the Agenda views. <b>Please check Manual for Time formatting!</b>");
define("_MI_EVENT_CONFIG_USE_THEME", "Use the jquery ui theme?");
define("_MI_EVENT_CONFIG_USE_THEME_DSC", "As default, the calendar uses the jQuery UI Theme. You might like to install another theme (google jquery ui theme roller) or just turn ui off to design your own theme");
define("_MI_EVENT_CONFIG_PRINT_FOOTER", "Print Footer");
define("_MI_EVENT_CONFIG_PRINT_FOOTER_DSC", "");
define("_MI_EVENT_CONFIG_PRINT_LOGO", "Print Logo");
define("_MI_EVENT_CONFIG_PRINT_LOGO_DSC", "");
// blocks
define("_MI_EVENT_BLOCK_MINICAL", "Minicalendar");
define("_MI_EVENT_BLOCK_MINICAL_DSC", "Minicalendar for blocks");
define("_MI_EVENT_BLOCK_LIST", "Events");
define("_MI_EVENT_BLOCK_LIST_DSC", "List of Events in a time range");
define("_MI_EVENT_BLOCK_SELECT", "Find Events");
define("_MI_EVENT_BLOCK_SELECT_DSC", "A Block to select the Timerange to get Events");
// notifications
define('_MI_EVENT_GLOBAL_NOTIFY', 'Global');
define('_MI_EVENT_GLOBAL_NOTIFY_DSC', 'Global Event notification options.');
define('_MI_EVENT_EVENT_NOTIFY', 'Category');
define('_MI_EVENT_EVENT_NOTIFY_DSC', 'Notification options that apply to the current event category.');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY', 'New Event');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_CAP', 'Notify me when a new event is created.');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_DSC', 'Receive notification when a new event is created.');
define('_MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New event');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY', 'Event Modified');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY_CAP', 'Notify me when an event has been modified.');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY_DSC', 'Receive notification when an event has been modified.');
define('_MI_EVENT_GLOBAL_EVENT_MODIFIED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Event Modified');
