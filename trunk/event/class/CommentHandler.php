<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/CommentHandler.php
 * 
 * Classes responsible for managing event comment objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.2.0
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_event_CommentHandler extends icms_ipf_Handler {
	
	private $_usersArray;
	private $_eventsArray;
	private $_eventsObjArray;
	private $_onlineUsers;
	
	public function __construct(&$db) {
		parent::__construct($db, "comment", "comment_id", "comment_fprint", "comment_body", EVENT_DIRNAME);
	}
	
	public function loadUsers() {
		global $icmsConfig;
		if(!count($this->_usersArray)) {
			$onlineUsers = $this->loadOnlineUsers();
			$member_handler = icms::handler("icms_member_user");
			$criteria = new icms_db_criteria_Item("level", 0, '>=');
			$users = $member_handler->getObjects($criteria, TRUE);
			$this->_usersArray[0] = $icmsConfig['anonymous'];
			foreach (array_keys($users) as $key) {
				$isOnline = ($onlineUsers && isset($onlineUsers[$key])) ? TRUE : FALSE;
				$arr = array();
				$arr['uid'] = $key;
				$arr['link'] = '<a class="user_link" href="'.ICMS_URL.'/userinfo.php?uid='.$key.'">'.$users[$key]->getVar("uname").'</a>';
				$arr['avatar'] = $users[$key]->gravatar();
				$arr['user_sig'] = icms_core_DataFilter::checkVar($users[$key]->getVar("user_sig", "n"), "html", "output");
				$arr['uname'] = $users[$key]->getVar("uname");
				$arr['online'] = $isOnline ? '<img class="user_online icon_middle" src="'.EVENT_IMAGES_URL.'/green.png" alt="online" />' : '';
				$arr['icq'] = $users[$key]->getVar("user_icq");
				$arr['msn'] = $users[$key]->getVar("user_msnm");
				$arr['yim'] = $users[$key]->getVar("user_yim");
				$arr['regdate'] = date("d/m/Y", $users[$key]->getVar("user_regdate", "e")); 
				$this->_usersArray[$key] = $arr;
			}
		}
		return $this->_usersArray;
	}
	
	private function loadOnlineUsers() {
		if(!count($this->_onlineUsers)) {
			$online_handler = icms::handler('icms_core_Online');
			$users = $online_handler->getAll(NULL);
			foreach (array_keys($users) as $key) {
				$this->_onlineUsers[$users[$key]['online_uid']] = $users[$key]['online_uid'];
			}
		}
		return $this->_onlineUsers;
	}
	
	public function userCanComment() {
		global $eventConfig;
		return (is_object(icms::$user) && $eventConfig['user_can_comment'] == 1) ? TRUE : FALSE;
	}
	
	public function getCommentCriterias($approve = FALSE, $event_id = FALSE, $uid = FALSE, $puid = FALSE, $start=0, $limit = 0, $order = "comment_pdate", $sort = "DESC", $admin_approve = FALSE) {
		global $event_isAdmin;
		$criteria = new icms_db_criteria_Compo();
		if($order) $criteria->setSort($order);
		if($sort) $criteria->setOrder($sort);
		//if($start) $criteria->setStart($start);
		//if($limit) $criteria->setLimit((int)$limit);
		if($approve) {
			if(!$event_isAdmin) {
				$crit = new icms_db_criteria_Compo();
				if(is_object(icms::$user)) {
					$crit->add(new icms_db_criteria_Item("comment_uid", icms::$user->getVar("uid")), 'OR');
				} else {
					$crit->add(new icms_db_criteria_Item("comment_fprint", $_SESSION['icms_fprint']), 'OR');
				}
				$crit->add(new icms_db_criteria_Item("comment_approve", TRUE), 'OR');
				$criteria->add($crit);
			}
		}
		if($admin_approve) $criteria->add(new icms_db_criteria_Item("comment_approve", 0));
		if($event_id) $criteria->add(new icms_db_criteria_Item("comment_eid", $event_id));
		if($uid) $criteria->add(new icms_db_criteria_Item("comment_uid", $uid));
		if($puid) $criteria->add(new icms_db_criteria_Item("comment_eid_uid", $puid));
		return $criteria;
	}

	public function loadEventLinks() {
		if(!count($this->_eventsArray)) {
			$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
			$events = $event_handler->getObjects(NULL, TRUE, TRUE);
			foreach (array_keys($events) as $key) {
				$this->_eventsArray[$key] = $events[$key]->getItemLink(TRUE);
			}
		}
		return $this->_eventsArray;
	}
	
	private function loadEventObjects() {
		if(!count($this->_eventsObjArray)) {
			$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
			$events = $event_handler->getObjects(NULL, TRUE, TRUE);
			foreach (array_keys($events) as $key) {
				$this->_eventsObjArray[$key] = $events[$key];
			}
		}
		return $this->_eventsObjArray;
	}
	
	public function getComments($approve = FALSE, $event_id = FALSE, $uid = FALSE, $puid = FALSE, $start = 0, $limit = 0, $order = "comment_pdate", $sort = "DESC", $admin_approve = FALSE, $forBlock = FALSE) {
		$criteria = $this->getCommentCriterias($approve, $event_id, $uid, $puid, $start, $limit, $order, $sort, $admin_approve);
		$comments = $this->getObjects($criteria, TRUE, TRUE);
		$events = $this->loadEventObjects();
		$ret = array();
		foreach (array_keys($comments) as $key) {
			if($limit > 0 && count($ret) == $limit) continue;
			$eid = $comments[$key]->getVar("comment_eid", "e");
			if(isset($events[$eid]) && $events[$eid]->accessGranted())
			$ret[$key] = (!$forBlock) ? $comments[$key]->renderComment(FALSE) : $comments[$key]->renderComment(TRUE);
		}
		//unset($events, $criteria, $comments);
		return $ret;
	}
	
	public function getCommentsCount($approve = FALSE, $event_id = FALSE, $uid = FALSE, $puid = FALSE, $start = 0, $limit = 0, $order = FALSE, $sort = FALSE, $admin_approve = FALSE) {
		$criteria = $this->getCommentCriterias($approve, $event_id, $uid, $puid, $start, $limit, $order, $sort, $admin_approve);
		return $this->getCount($criteria);
	}
	
	/**
	 * handling some functions to easily switch some fields
	 */
	public function changeField($comment_id, $field) {
		$commentObj = $this->get($comment_id);
		if ($commentObj->getVar("$field", 'e') == TRUE) {
			$commentObj->setVar("$field", 0);
			$value = 0;
		} else {
			$commentObj->setVar("$field", 1);
			$value = 1;
		}
		$commentObj->_updating = TRUE;
		$this->insert($commentObj, TRUE);
		return $value;
	}

	public function filterApprove() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	public function filterEid() {
		$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
		return $event_handler->getList();
	}
	
	public function filterUser(){
		$sql = "SELECT DISTINCT comment_uid FROM " . $this->table;
		if ($result = icms::$xoopsDB->query($sql)) {
			$bids = array();
			if($showNull) $bids[0] = '--------------';
			while ($myrow = icms::$xoopsDB->fetchArray($result)) {
				$bids[$myrow['comment_uid']] = icms_member_user_Object::getUnameFromId((int)$myrow['comment_uid']);
			}
			return $bids;
		}
	}
	
	protected function beforeInsert(&$obj) {
		$ip = $obj->getVar("comment_ip", "e");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		
		return TRUE;
	}
}