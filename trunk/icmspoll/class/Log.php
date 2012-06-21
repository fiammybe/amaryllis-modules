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

class IcmspollLog extends icms_ipf_Object {

	public function __construct(&$handler) {
		//$this->db =& Database::getInstance();
		parent::__construct($handler);
		$this->quickInitVar("log_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("poll_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("option_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("ip", XOBJ_DTYPE_OTHER, TRUE);
		$this->quickInitVar("user_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("time", XOBJ_DTYPE_INT, TRUE);
	}

	function commentMode() {
		global $icmspollConfig;
		$module_handler = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$comment_mode = $icmspollConfig['com_rule'];
		return $comment_mode;
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
}
