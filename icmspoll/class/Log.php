<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /class/Log.php
 * 
 * Class representing icmspoll log objects
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
if(!defined("ICMSPOLL_DIRNAME")) define("ICMSPOLL_DIRNAME", basename(dirname(dirname(__FILE__))));

class IcmspollLog extends icms_ipf_Object {

	public function __construct(&$handler) {
		//$this->db =& Database::getInstance();
		parent::__construct($handler);
		$this->quickInitVar("log_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("poll_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("option_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("ip", XOBJ_DTYPE_OTHER, TRUE);
		$this->quickInitVar("session_id", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("user_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("time", XOBJ_DTYPE_INT, TRUE);
	}

	public function getTime() {
		global $icmspollConfig;
		$date = $this->getVar('time', 'e');
		return date($icmspollConfig['icmspoll_dateformat'], $date);
	}
	
	function getUser() {
		return icms_member_user_Handler::getUserLink($this->getVar('user_id', 'e'));
	}
	
	public function getPollName() {
		$icmspoll_polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$pollObj = $icmspoll_polls_handler->get($this->getVar("poll_id", "e"));
		return $pollObj->getQuestion();
	}
	
	public function getOptionText() {
		$icmspoll_options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
		$optionsObj = $icmspoll_options_handler->get($this->getVar("option_id", "e"));
		return $optionsObj->getOptionText();
	}
	
	public function getLogIP() {
		$ip = $this->getVar("ip", "s");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		return $ip;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("id");
		$ret['poll'] = $this->getPollName();
		$ret['option'] = $this->getOptionText();
		$ret['ip'] = $this->getLogIP();
		$ret['session'] = $this->getVar("session_id", "e");
		$ret['user'] = $this->getUser();
		$ret['time'] = $this->getTime();
		return $ret;
	}
}
