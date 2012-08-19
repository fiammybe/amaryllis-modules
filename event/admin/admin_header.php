<?php
/**
 * 'Event' is an event/calendar module for ImpressCMS, which can display google calendars, too
 *
 * File: /admin/admin_header.php
 * 
 * admin header of the module
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

include_once "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/include/common.php";
if (!defined("EVENT_ADMIN_URL")) define("EVENT_ADMIN_URL", EVENT_URL . "admin/");
include_once EVENT_ROOT_PATH . "include/requirements.php";