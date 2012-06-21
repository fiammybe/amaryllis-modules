<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /class/IcmspollHandler.php
 * 
 * Classes responsible for managing icmspoll poll objects
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

icms_loadLanguageFile("icmspoll", "common");

if(!defined(ICMSPOLL_DIRNAME)) define(ICMSPOLL_DIRNAME, basename(dirname(dirname(__FILE__))));

/**
 * Classes responsible for managing icmspoll poll objects
 */
class IcmspollPollsHandler extends icms_ipf_Handler {
	
	public function __construct(&$db) {
		parent::__construct($db, 'polls', 'poll_id', 'question', 'description', 'icmspoll');
		$this->addPermission("polls_view", _CO_ICMSPOLL_POLLS_VIEWPERM, _CO_ICMSPOLL_POLLS_VIEWPERM_DSC);
		$this->addPermission("polls_vote", _CO_ICMSPOLL_POLLS_VOTEPERM, _CO_ICMSPOLL_POLLS_VOTEPERM_DSC);	
	}
	
	public function getDelimeters() {
		$delimeters = array(1 => _CO_ICMSPOLL_POLLS_DELIMETER_BRTAG, 2 => _CO_ICMSPOLL_POLLS_DELIMETER_SPACE);
		return $delimeters;
	}
	
	public function getPolls($start = 0, $limit = 0, $order = "end_time", $sort = "DESC", $uid = FALSE, $expired = FALSE, $inBlocks = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($uid) $criteria->add(new icms_db_criteria_Item("user_id", $uid));
		
		if($inBlocks) $criteria->add(new icms_db_criteria_Item("display", TRUE));
		$this->setGrantedObjectsCriteria($criteria, "polls_view");
		$polls = $this->getObjects($criteria, TRUE);
		$ret = array();
		foreach ($polls as $poll) {
			$ret[$poll["poll_id"]] = $poll;
		}
		return $ret;
	}
	
	public function getPollsCount ($expired = FALSE, $user_id = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($expired) {
			$criteria->add(new icms_db_criteria_Item('expired', TRUE));
		} else {
			$criteria->add(new icms_db_criteria_Item('expired', FALSE));
		}
		if ($user_id) $criteria->add(new icms_db_criteria_Item('user_id', $user_id));
		$this->setGrantedObjectsCriteria($criteria, "polls_view");
		return $this->getCount($criteria);
	}
	
	/**
	 * set a poll as expired
	 */
	public function setExpired($poll_id) {
		$pollObj = $this->get($poll_id);
		$pollObj->setVar("expired", "1");
		$this->insert($pollObj, TRUE);
		return TRUE;
	}
	
	/**
	 * update amount of votes and voters
	 */
	public function updateCount($poll_id) {
		$icmspoll_log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$votes = $icmspoll_log_handler->getTotalVotesByPollId($this->getVar("poll_id"));
		$voters = $icmspoll_log_handler->getTotalVotersByPollId($this->getVar("poll_id"));
		$pollObj = $this->get($poll_id);
		$pollObj->setVar("votes", $votes);
		$pollObj->setVar("voters", $voters);
		$this->insert($pollObj, TRUE);
		unset($icmspoll_log_handler, $votes, $voters);
		return TRUE;
	}
	
	/**
	 * some filters for ACP Table
	 */
	 public function filterExpired() {
		return array(0 => _CO_ICMSPOLL_POLLS_ACTIVE, 1 => _CO_ICMSPOLL_POLLS_EXPIRED);
	 }
	 
	 /**
	  * update comments for poll results
	  */
	public function updateComments($poll_id, $total_num) {
		$pollObj = $this->get($poll_id);
		if ($pollObj && !$pollObj->isNew()) {
			$pollObj->setVar('poll_comments', $total_num);
			$this->insert($pollObj, TRUE);
		}
	}
	
	/**
	 * core search function
	 */
	 // some fuctions related to icms core functions
	public function getPollsForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart($offset);
		$criteria->setLimit($limit);
		if ($userid != 0) $criteria->add(new icms_db_criteria_Item('user_id', $userid));

		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('question', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$this->setGrantedObjectsCriteria($criteria, "polls_view");
		return $this->getObjects($criteria, TRUE, FALSE);
	}
	
	/**
	 * related for storing/deleting objects
	 */
	protected function beforeInsert(&$obj) {
		$start_time = $obj->getVar("start_time", "e");
		$start_time = empty($start_time) ? time() : $start_time;
		$end_time = $obj->getVar("end_time", "e");
		if ( $end_time <= $start_time ) {
			$this->setErrors(_CO_ICMSPOLL_ICMSPOLL_ENDTIME_ERROR);
			return FALSE;
		} else {
			$obj->setVar("start_time", $start_time);
			$obj->setVar("end_time", $end_time);
		}
		return TRUE;
	}
	
	protected function afterDelete(&$obj) {
		$icmspoll_option_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
		$icmspoll_log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("poll_id", $obj->id()));
		$icmspoll_option_handler->deleteAll($criteria);
		$icmspoll_log_handler->deleteAll($criteria);
		unset($criteria, $icmspoll_log_handler, $icmspoll_option_handler);
		return TRUE;
	}
}