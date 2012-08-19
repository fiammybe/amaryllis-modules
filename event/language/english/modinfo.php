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

define("_MI_EVENT_MD_NAME", "event");
define("_MI_EVENT_MD_DESC", "ImpressCMS Simple event");
// acp menu
define("_MI_EVENT_MENU_EVENTS", "Events");
define("_MI_EVENT_MENU_CATEGORY", "Category");
define("_MI_EVENT_MENU_CALENDAR", "Calendars");
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
define("_MI_EVENT_CONFIG_EVENT_MINUTES", "Default event minutes");
define("_MI_EVENT_CONFIG_EVENT_MINUTES_DSC", "");

// notifications
define('_MI_INDEX_GLOBAL_NOTIFY', 'Global');
define('_MI_INDEX_GLOBAL_NOTIFY_DSC', 'Global Article notification options.');
define('_MI_INDEX_CATEGORY_NOTIFY', 'Category');
define('_MI_INDEX_CATEGORY_NOTIFY_DSC', 'Notification options that apply to the current file category.');
define('_MI_INDEX_GLOBAL_CATEGORY_PUBLISHED_NOTIFY', 'New Category');
define('_MI_INDEX_GLOBAL_CATEGORY_PUBLISHED_NOTIFY_CAP', 'Notify me when a new file category is created.');
define('_MI_INDEX_GLOBAL_CATEGORY_PUBLISHED_NOTIFY_DSC', 'Receive notification when a new file category is created.');
define('_MI_INDEX_GLOBAL_CATEGORY_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file category');
//define("", "");