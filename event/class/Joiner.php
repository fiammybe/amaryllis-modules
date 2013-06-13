<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/Joiner.php
 * 
 * Class representing event joiner objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_event_Joiner extends icms_ipf_Object {
	
	public function __construct(&$handler) {
		parent::__construct($handler);
		
		$this->quickInitVar("joiner_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("joiner_eid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("joiner_uid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("joiner_ip", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("joiner_fprint", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("joiner_date", XOBJ_DTYPE_LTIME, TRUE);
	}
}