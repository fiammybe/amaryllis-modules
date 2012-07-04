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

if(!defined("ICMSPOLL_DIRNAME")) define("ICMSPOLL_DIRNAME", basename(dirname(dirname(__FILE__))));

/**
 * Classes responsible for managing icmspoll poll objects
 */
class IcmspollPollsHandler extends icms_ipf_Handler {
	
	private $_poll_delimeters;
	
	public function __construct(&$db) {
		parent::__construct($db, 'polls', 'poll_id', 'question', 'description', 'icmspoll');
		$this->addPermission("polls_view", _CO_ICMSPOLL_POLLS_VIEWPERM, _CO_ICMSPOLL_POLLS_VIEWPERM_DSC);
		$this->addPermission("polls_vote", _CO_ICMSPOLL_POLLS_VOTEPERM, _CO_ICMSPOLL_POLLS_VOTEPERM_DSC);	
	}
	
	public function getDelimeters() {
		if(!$this->_poll_delimeters) {
			$this->_poll_delimeters = array(1 => _CO_ICMSPOLL_POLLS_DELIMETER_BRTAG, 2 => _CO_ICMSPOLL_POLLS_DELIMETER_SPACE);
		}
		return $this->_poll_delimeters;
	}
	
	public function getPolls($start = 0, $limit = 0, $order = "end_time", $sort = "DESC", $uid = FALSE, $expired = FALSE, $inBlocks = FALSE, $started = TRUE) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($uid) $criteria->add(new icms_db_criteria_Item("user_id", $uid));
		if($expired) {
		    $criteria->add(new icms_db_criteria_Item("expired", 1));
		} else {
			$criteria->add(new icms_db_criteria_Item("expired", 0));
		}
		if($inBlocks) $criteria->add(new icms_db_criteria_Item("display", TRUE));
		if($started) $criteria->add(new icms_db_criteria_Item("started", 1));
		$this->setGrantedObjectsCriteria($criteria, "polls_view");
		$polls = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($polls as $poll) {
			$ret[$poll["poll_id"]] = $poll;
		}
		return $ret;
	}
	
	public function getPollsCount ($expired = FALSE, $user_id = FALSE, $started = TRUE) {
		$criteria = new icms_db_criteria_Compo();
		if($expired && !$started) {
			$criteria->add(new icms_db_criteria_Item('expired', 1));
		} elseif ($started) {
			$criteria->add(new icms_db_criteria_Item('expired', 0));
		}
		if ($user_id) $criteria->add(new icms_db_criteria_Item('user_id', $user_id));
		if ($started) $criteria->add(new icms_db_criteria_Item('started', 1));
		$this->setGrantedObjectsCriteria($criteria, "polls_view");
		$count = $this->getCount($criteria);
		return $count;
	}
	
	/**
	 * reset poll
	 */
	function resetCountByPollId($poll_id) {
		$pollObj = $this->get($poll_id);
		$pollObj->setVar("votes", 0);
		$pollObj->setVar("voters", 0);
		$this->insert($pollObj, TRUE);
		return TRUE;
	}
	/**
	 * set poll as started
	 */
	public function setStarted($poll_id) {
		$pollObj = $this->get($poll_id);
		if(is_object($pollObj) && !$pollObj->isNew()) {
			$pollObj->setVar("started", "1");
			if (!$pollObj->getVar("notification_sent", "e") == 1 ) {
				$pollObj->sendNotifPollPublished();
				$pollObj->setVar('notification_sent', 1);
			}
			$this->insert($pollObj, TRUE);
			return TRUE;
		}
	}
	
	public function sendMessageExpired() {
        $subject = _CO_ICMSPOLL_POLLS_MESSAGE_SUBJECT;
        $itemLink = $this->getItemLink();
        $message = sprintf(_CO_ICMSPOLL_POLLS_MESSAGE_BDY, $itemLink);
        $pm_handler = icms::handler("icms_data_privmessage");
        $pmObj = $pm_handler->create(TRUE);
        $pmObj->setVar("subject", $subject);
        $pmObj->setVar("from_userid", 1);
        $pmObj->setVar("to_userid", $this->getVar("user_id", "e"));
        $pmObj->setVar("msg_time", time());
        $pmObj->setVar("msg_text", $message);
        $pm_handler->insert($pmObj, TRUE);
		unset($itemLink, $message, $pm_handler, $pmObj);
        return TRUE;
    }
	
	/**
	 * set a poll as expired
	 */
	public function setExpired($poll_id) {
		$pollObj = $this->get($poll_id);
		if(is_object($pollObj) && !$pollObj->isNew()) {
			$pollObj->updating_expired = TRUE;
			$pollObj->setVar("expired", "1");
			if($pollObj->getVar("mail_status", "e") == 1 && !$pollObj->getVar("message_sent", "e") == 1) {
        		$pollObj->sendMessageExpired();
			}
			$pollObj->setVar("message_sent", 1);
			$this->insert($pollObj, TRUE);
			return TRUE;
		}
	}
	
	/**
	 * update amount of votes and voters
	 */
	public function updateCount($poll_id) {
		$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$votes = $log_handler->getTotalVotesByPollId($poll_id);
		$voters = $log_handler->getTotalVotersByPollId($poll_id);
		$pollObj = $this->get($poll_id);
		$pollObj->setVar("votes", $votes);
		$pollObj->setVar("voters", $voters);
		$this->insert($pollObj, TRUE);
		unset($log_handler, $votes, $voters);
		return TRUE;
	}
	
	/**
	 * frontend permission control
	 */
	public function userCanSubmit() {
		global $icmspoll_isAdmin, $icmspollConfig;
		if ($icmspoll_isAdmin) return TRUE;
		$user_groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		return count(array_intersect($icmspollConfig['uploader_groups'], $user_groups)) > 0;
	}
	
	/**
	 * some filters for ACP Table
	 */
	 public function filterExpired() {
		return array(0 => _CO_ICMSPOLL_POLLS_FILTER_ACTIVE, 1 => _CO_ICMSPOLL_POLLS_FILTER_EXPIRED);
	 }
	 
	 public function filterStarted() {
		return array(0 => _CO_ICMSPOLL_POLLS_INACTIVE, 1 => _CO_ICMSPOLL_POLLS_FILTER_STARTED);
	 }
	 
	public function filterUsers($showNull = FALSE) {
		$sql = "SELECT DISTINCT (user_id) FROM " . icms::$xoopsDB->prefix("icmspoll_polls");
		if ($result = icms::$xoopsDB->query($sql)) {
			if($showNull) $bids[0] = '--------------';
			while ($myrow = icms::$xoopsDB->fetchArray($result)) {
				$bids[$myrow['user_id']] = icms_member_user_Object::getUnameFromId((int)$myrow['user_id']);
			}
			return $bids;
		}
	}
	 
	 /**
	  * update comments for poll results
	  */
	public function updateComments($poll_id, $total_num) {
		$pollObj = $this->get($poll_id);
		if ($pollObj && !$pollObj->isNew()) {
			$pollObj->setVar('poll_comments', $total_num);
			$this->insert($pollObj, TRUE);
			return TRUE;
		}
	}
	
	public function updateTotalInits($poll_id) {
		$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
		$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item("poll_id", (int)$poll_id));
		$options = $options_handler->getObjects($crit, TRUE, FALSE);
		$i = 0;
		foreach ($options as $option) {
			$optionObj = $options_handler->get($option['id']);
			$init = $optionObj->getVar("option_init", "e");
			$i = $i+(int)$init;
		}
		$pollObj = $this->get((int)$poll_id);
		$pollObj->updating_expired = TRUE;
		$pollObj->setVar("total_init_value", $i);
		$this->insert($pollObj, TRUE);
		return TRUE;
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
		$criteria->add(new icms_db_criteria_Item("started", 1));
		$this->setGrantedObjectsCriteria($criteria, "polls_view");
		return $this->getObjects($criteria, TRUE, FALSE);
	}
	
	/**
	 * related for storing/deleting objects
	 */
	protected function beforeSave(&$obj) {
		if ($obj->updating_expired) return TRUE;
		$time = time();
		$start_time = $obj->getVar("start_time", "e");
		$start_time = empty($start_time) ? $time : $start_time;
		$end_time = $obj->getVar("end_time", "e");
		$expired = $obj->getVar("expired", "e");
		$started = $obj->getVar("started", "e");
		if ( $end_time <= $start_time ) {
			$obj->setErrors(_CO_ICMSPOLL_POLLS_ENDTIME_ERROR);
			return FALSE;
		}
		if(($end_time > $time) && ($expired == 1)) {
			$obj->setVar("expired", 0);
		}
		if(($start_time > $time) && ($started == 1)) {
			$obj->setVar("started", 0);
		}
		$question = $obj->getVar("question", "s");
		$question = icms_core_DataFilter::checkVar($question, "html", "input");
		$obj->setVar("question", $question);
		
		$dsc = $obj->getVar("description", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$obj->setVar("description", $dsc);
		return TRUE;
	}
	
	protected function afterDelete(&$obj) {
		// unsubscribe notifications
		$notification_handler = icms::handler( 'icms_data_notification' );
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname(ICMSPOLL_DIRNAME);
		$module_id = $module->getVar('mid');
		$category = 'global';
		$poll_id = $obj->id();
		// delete global notifications
		$notification_handler->unsubscribeByItem($module_id, $category, $poll_id);
		unset($notification_handler, $module_handler, $module);
		// delete all options and log entries for this poll
		$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
		$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("poll_id", $obj->id()));
		$options_handler->deleteAll($criteria);
		$log_handler->deleteAll($criteria);
		unset($criteria, $log_handler, $options_handler);
		return TRUE;
	}
}