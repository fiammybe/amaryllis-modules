<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /class/Calendar.php
 * 
 * Class representing event calendar objects
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

class mod_event_Calendar extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_event_Calendar $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("calendar_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("calendar_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("calendar_url", XOBJ_DTYPE_TXTBOX, TRUE, FALSE, FALSE, 'https://www.google.com/calendar/feeds/' );
		$this->quickInitVar("calendar_color", XOBJ_DTYPE_OTHER, TRUE);
		$this->setControl("calendar_color", "color");

	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['name'] = $this->title();
		$ret['url'] = $this->getVar("calendar_url", "e");
		$ret['color'] = $this->getVar("calendar_color", "e");
		return $ret;
	}

	
}