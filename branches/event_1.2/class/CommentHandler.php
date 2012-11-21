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
	
	public function __construct(&$db) {
		parent::__construct($db, "comment", "comment_id", "comment_fprint", "comment_body", EVENT_DIRNAME);
	}
	
	public function loadUsers() {
		global $icmsConfig;
		if(!count($this->_usersArray)) {
			$member_handler = icms::handler("icms_member_user");
			$criteria = new icms_db_criteria_Item("level", 0, '>=');
			$users = $member_handler->getObjects($criteria, TRUE);
			$this->_usersArray[0] = $icmsConfig['anonymous'];
			foreach (array_keys($users) as $key) {
				$arr = array();
				$arr['uid'] = $key;
				$arr['link'] = '<a class="user_link" href="'.ICMS_URL.'/userinfo.php?uid='.$key.'">'.$users[$key]->getVar("uname").'</a>';
				$arr['avatar'] = $users[$key]->gravatar();
				$arr['user_sig'] = icms_core_DataFilter::checkVar($users[$key]->getVar("user_sig", "n"), "html", "output");
				$arr['uname'] = $users[$key]->getVar("uname");
				$arr['online'] = $users[$key]->isOnline();
				$this->_usersArray[$key] = $arr;
			}
		}
		return $this->_usersArray;
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
		if($start) $criteria->setStart($start);
		if($limit) $criteria->setLimit((int)$limit);
		if($approve) {
			if(!$event_isAdmin) {
				$crit = new icms_db_criteria_Compo();
				if(is_object(icms::$user)) {
					$crit->add(new icms_db_criteria_Item("comment_uid", icms::$user->getVar("uid")));
				} else {
					$crit->add(new icms_db_criteria_Item("comment_fprint", $_SESSION['icms_fprint']));
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
	
	public function getComments($approve = FALSE, $event_id = FALSE, $uid = FALSE, $puid = FALSE, $start = 0, $limit = 0, $order = "comment_pdate", $sort = "DESC", $admin_approve = FALSE) {
		$criteria = $this->getCommentCriterias($approve, $event_id, $uid, $puid, $start, $limit, $order, $sort, $admin_approve);
		$comments = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($comments as $key => $value) {
			$ret[$key] = $value['comment'];
		}
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