<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/EventHandler.php
 * 
 * Classes responsible for managing event event objects
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
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_event_JoinerHandler extends icms_ipf_Handler {
	
	public function __construct(&$db) {
		parent::__construct($db, "joiner", "joiner_id", "joiner_eid", "joiner_uid", "event");
	}
	
	public function getJoinerCriterias($eid = FALSE, $uid = FALSE, $ip = FALSE, $fprint = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($eid) $criteria->add(new icms_db_criteria_Item("joiner_eid", $eid));
		if($uid) $criteria->add(new icms_db_criteria_Item("joiner_uid", $uid));
		if($fprint && !$uid) {
			$crit = new icms_db_criteria_Compo();
			$crit->add(new icms_db_criteria_Item("joiner_ip", $ip), 'OR');
			$crit->add(new icms_db_criteria_Item("joiner_fprint", $fprint), 'OR');
			$criteria->add($crit);
		}
		return $criteria;
	}
	
	public function getJoinersCount($eid = FALSE, $uid = FALSE, $ip = FALSE, $fprint = FALSE) {
		$criteria = $this->getJoinerCriterias($eid, $uid, $ip, $fprint);
		return $this->getCount($criteria);
	}
	
	public function getRegistredJoinersCount($eid = FALSE, $uid = FALSE, $ip = FALSE, $fprint = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("joiner_eid", $eid));
		$criteria->add(new icms_db_criteria_Item("joiner_uid", 0, '!='));
		return $this->getCount($criteria);
	}
	
	public function getUnregistredJoinersCount($eid = FALSE, $uid = FALSE, $ip = FALSE, $fprint = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("joiner_eid", $eid));
		$criteria->add(new icms_db_criteria_Item("joiner_uid", 0));
		return $this->getCount($criteria);
	}
	
	public function joinEvent($eid = FALSE, $uid = FALSE, $ip = FALSE, $fprint = FALSE, $date = FALSE) {
		$obj = $this->create(TRUE);
		$obj->setVar("joiner_eid", $eid);
		$obj->setVar("joiner_uid", $uid);
		$obj->setVar("joiner_ip", $ip);
		$obj->setVar("joiner_fprint", $fprint);
		$obj->setVar("joiner_date", $date);
		return $this->insert($obj);
	}
	
	public function unjoinEvent($eid = FALSE, $uid = FALSE, $ip = FALSE, $fprint = FALSE) {
		$criteria = $this->getJoinerCriterias($eid, $uid, $ip, $fprint);
		return $this->deleteAll($criteria);
	}
}
