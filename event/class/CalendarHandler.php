<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/CalendarHandler.php
 * 
 * Classes responsible for managing event calendar objects
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

class mod_event_CalendarHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "calendar", "calendar_id", "calendar_name", "calendar_dsc", "event");

	}

	public function getCalendarBySeo($seo) {
		$criteria = new icms_db_criteria_Item("short_url", trim($seo));
		$cals = $this->getObjects($criteria, FALSE, TRUE);
		if(!$cals) return FALSE;
		return $cals[0];
	}

	protected function beforeInsert(&$obj) {
		if($obj->_updating)
		return TRUE;
		$seo = $obj->short_url();
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle($obj->title(), FALSE);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
			$obj->setVar("short_url", $seo);
		}
		$dsc = $obj->getVar("calendar_dsc", "e");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$dsc = str_replace("'",'"', $dsc);
		$obj->setVar("calendar_dsc", $dsc);
		return TRUE;
	}
}