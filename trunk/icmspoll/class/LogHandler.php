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
if(!defined("ICMSPOLL_DIRNAME")) define("ICMSPOLL_DIRNAME", basename(dirname(dirname(__FILE__))));
icms_loadLanguageFile("icmspoll", "common");

class 	IcmspollLogHandler extends icms_ipf_Handler {
	
	function __construct(&$db) {
		parent::__construct($db, "log", "log_id", "poll_id", "option_id", "icmspoll");
	}
	
	function hasVoted($poll_id, $ip, $user_id = NULL, $sess_id) {
		global $icmspollConfig;
		$limit_by_ip = $icmspollConfig['limit_by_ip'];
		$limit_by_uid = $icmspollConfig['limit_by_uid'];
		$limit_by_sess = $icmspollConfig['limit_by_session'];
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("poll_id", $poll_id));
		if ($limit_by_uid != 1 && $limit_by_ip != 1 && $limit_by_sess != 1){
			return FALSE;
		} else {
			if($limit_by_uid == 1 && $limit_by_ip == 1 && $limit_by_sess == 1){
				// If limit by both user and ip
				if($user_id == 0){
					$criteria->add(new icms_db_criteria_Item("ip", $ip));
					$criteria->add(new icms_db_criteria_Item("session_id", $sess_id));
				} else {
					$criteria->add(new icms_db_criteria_Item("user_id", (int)$user_id));
				}
			} elseif ($limit_by_uid == 1 && $limit_by_ip != 1){
				if($limit_by_sess == 1) {
					$criteria->add(new icms_db_criteria_Item("session_id", $sess_id));
				}
				// If limit by user then only check for user		 
				 $criteria->add(new icms_db_criteria_Item("user_id", (int)$user_id));
			} elseif ($limit_by_uid != 1 && $limit_by_ip == 1) {
				if($limit_by_sess == 1) {
					$criteria->add(new icms_db_criteria_Item("session_id", $sess_id));
				}
				// Only remaining option is only limit by ip, then only check for ip
				 $criteria->add(new icms_db_criteria_Item("ip", $ip));
			} elseif ($limit_by_ip == 0 && $limit_by_uid == 0 && $limit_by_sess == 1) {
				$criteria->add(new icms_db_criteria_Item("session_id", $sess_id));
			}
			$count = $this->getCount($criteria);
			if ( $count > 0 ) return TRUE;
			return FALSE;
		}
	}

	public function getAllByPollId($poll_id, $order = "time", $sort = "ASC") {
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("poll_id", $poll_id));
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		$pollLogs = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($pollLogs as $pollLog) {
			$ret[$pollLog['log_id']] = $pollLog;
		}
		return $ret;
	}
 
	/**
	 * delete log entries by poll_id
	 * 
	 * @param $poll_id
	 */
	function deleteByPollId($poll_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("poll_id", $poll_id));
		return $this->deleteAll($criteria);
	}

	/**
	 * delete log entries by option_id
	 * 
	 * @param $option_id
	 */
	function deleteByOptionId($option_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("option_id", $option_id));
		return $this->deleteAll($criteria);
	}
	
	function getTotalAnonymousVoters($poll_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("poll_id", $poll_id));
		$criteria->add(new icms_db_criteria_Item("user_id", "0"));
		$count = $this->getCount($criteria);
		return $count;
	}
	
	function getTotalRegistredVoters($poll_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("poll_id", $poll_id));
		$criteria->add(new icms_db_criteria_Item("user_id", "0", "!="));
		$count = $this->getCount($criteria);
		return $count;
	}

	
	function getTotalVotersByPollId($poll_id) {
		$users = $this->getTotalRegistredVoters($poll_id);
		$anons = $this->getTotalAnonymousVoters($poll_id);
		return $users+$anons;
	}

	
	function getTotalVotesByPollId($poll_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("poll_id", $poll_id));
		$votes = $this->getCount($criteria);
		return $votes;
	}

	/**
	 * returns the amount of votes by optionid
	 * 
	 * @param $option_id
	 */
	function getTotalVotesByOptionId($option_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("option_id", $option_id));
		$votes = $this->getCount($criteria);
		return $votes;
	}
	/**
	 * returns the amount of anon votes by optionid
	 * 
	 * @param $option_id
	 * @param $user_id = 0
	 */
	public function getAnonVotesByOptionId($option_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("option_id", $option_id));
		$criteria->add(new icms_db_criteria_Item("user_id", "0"));
		$count = $this->getCount($criteria);
		return $count;
	}
	
	/**
	 * returns the amount of user votes by optionid
	 * 
	 * @param $option_id
	 * @param $user_id all != NULL
	 */
	public function getUserVotesByOptionId($option_id) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("option_id", $option_id));
		$criteria->add(new icms_db_criteria_Item("user_id", "0", "!="));
		$count = $this->getCount($criteria);
		return $count;
	}
	
	/**
	 * returns per cent of votes by option
	 * 
	 * @param $poll_id ->poll_id of the current option
	 * @param $options_id ->  current option
	 * 
	 */
	function getVotesPerCentByOptionId($poll_id, $option_id) {
		$totalVotes = $this->getTotalVotesByPollId($poll_id);
		$totalOptVotes = $this->getTotalVotesByOptionId($option_id);
		$optVote = @round((($totalOptVotes / $totalVotes) * 100),2);
		return $optVote;
	}
	
	/**
	 * filter for ACP
	 */
	public function filterPolls() {
		$icmspoll_polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
		$polls = $icmspoll_polls_handler->getList();
		return $polls;
	}
	
	public function beforeSave(&$obj) {
		$ip = $obj->getVar("ip", "s");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		$obj->setVar("ip", $ip);
		return TRUE;
	}

}
