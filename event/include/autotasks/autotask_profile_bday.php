<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /include/autotasks/autotask_profile_bday.php
 * 
 * autotask checking for new user-birthdays of the current year
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined('ICMS_ROOT_PATH') or die("ImpressCMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(dirname(__FILE__)))));
icms_loadLanguageFile("event", "common");
$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
$event_handler->getProfileBirthdays();