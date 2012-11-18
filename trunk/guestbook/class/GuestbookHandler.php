<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /class/GuestbookHandler.php
 * 
 * Classes responsible for managing Guestbook guestbook objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class GuestbookGuestbookHandler extends icms_ipf_Handler {
	
	private $_usersArray;
	private $_entryArray;
	
	public $_guestbook_cache_path;
	public $_guestbook_thumbs_path;
	public $_guestbook_images_path;
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $guestbookConfig;
		parent::__construct($db, "guestbook", "guestbook_id", "guestbook_title", "guestbook_entry", "guestbook");
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $guestbookConfig['image_file_size'], $guestbookConfig['image_upload_width'], $guestbookConfig['image_upload_height']);
		$this->_guestbook_cache_path = ICMS_CACHE_PATH . "/" . $this->_moduleName . "/" . $this->_itemname;
		$this->_guestbook_thumbs_path = $this->_guestbook_cache_path . "/thumbs";
		$this->_guestbook_images_path = $this->_guestbook_cache_path . "/images";
	}
	
	public function getGuestbookThumbsPath() {
		$dir = $this->_guestbook_thumbs_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	public function getGuestbookImagesPath() {
		$dir = $this->_guestbook_images_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	public function changeApprove($guestbook_id) {
		$approve = '';
		$guestbookObj = $this->get($guestbook_id);
		if ($guestbookObj->getVar('guestbook_approve', 'e') == TRUE) {
			$guestbookObj->setVar('guestbook_approve', 0);
			$approve = 0;
		} else {
			$guestbookObj->setVar('guestbook_approve', 1);
			$approve = 1;
		}
		$guestbookObj->_updating = TRUE;
		$this->insert($guestbookObj, TRUE);
		return $approve;
	}
	
	public function guestbook_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
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
				$arr['uid'] = $users[$key]->getVar("uid");
				$arr['link'] = ICMS_URL.'/userinfo.php?uid='.$key;
				$arr['avatar'] = $users[$key]->gravatar();
				$arr['user_sig'] = $users[$key]->getVar("user_sig", "N");
				$this->_usersArray[$key] = $arr;
			}
		}
		return $this->_usersArray;
	}
	
	public function getEntryCriterias($approve = FALSE, $guestbook_pid = 0, $start = 0, $limit = 0, $order = 'guestbook_published_date', $sort = 'DESC') {
		global $guestbook_isAdmin;
		$criteria = new icms_db_criteria_Compo();
		if($start) $criteria->setStart($start);
		if($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($approve) {
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			if($uid) {
				if(!$guestbook_isAdmin) {
					$crit = new icms_db_criteria_Compo();
					$crit->add(new icms_db_criteria_Item("guestbook_uid", $uid));
					$crit->add(new icms_db_criteria_Item('guestbook_approve', TRUE), 'OR');
					$criteria->add($crit);
				}
			} else {
				$crit = new icms_db_criteria_Compo();
				$crit->add(new icms_db_criteria_Item("guestbook_fprint", $_SESSION['icms_fprint']));
				$crit->add(new icms_db_criteria_Item('guestbook_approve', TRUE), 'OR');
				$criteria->add($crit);
			}
		}
		$criteria->add(new icms_db_criteria_Item('guestbook_pid', $guestbook_pid));
		return $criteria;
	}
	
	public function getEntries($approve = FALSE, $guestbook_pid = 0, $start = 0, $limit = 0, $order = 'guestbook_published_date', $sort = 'DESC') {
		$criteria = $this->getEntryCriterias($approve, $guestbook_pid, $start, $limit, $order, $sort);
		$entries = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach($entries as $entry) {
			$ret[$entry['id']] = $entry;
		}
		return $ret;
	}
	
	public function getSubEntries($approve = FALSE, $guestbook_pid = 0, $toArray = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) {
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			if($uid) {
				$crit = new icms_db_criteria_Compo();
				$crit->add(new icms_db_criteria_Item("guestbook_uid", $uid));
				$crit->add(new icms_db_criteria_Item('guestbook_approve', TRUE), 'OR');
				$criteria->add($crit);
			} else {
				$criteria->add(new icms_db_criteria_Item('guestbook_approve', TRUE));
			}
		}
		$criteria = new icms_db_criteria_Item("guestbook_pid", $guestbook_pid);
		$subentries = $this->getObjects($criteria, TRUE, TRUE);
		if(!$toArray) return $subentries;
		$ret = array();
		foreach(array_keys($subentries) as $i) {
			$ret[$i] = $subentries[$i]->toArray();
		}
		return $ret;
	}
	
	public function canModerate() {
		global $guestbook_isAdmin, $guestbookConfig;
		if($guestbook_isAdmin) return TRUE;
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		return count(array_intersect_key($guestbookConfig, $groups));
	}
	
	protected function beforeInsert(& $obj) {
		if($obj->_updating) return TRUE;
		global $guestbookConfig;
		$member_handler = icms::handler("icms_member_user");
		$user_sig = ($obj->getVar("guestbook_uid", "e") > 0) ? $member_handler->get($obj->getVar("guestbook_uid", "e"))->getVar("user_sig", "N") : FALSE;
		unset($member_handler);
		// filter and store entry
		$message = $obj->getVar("guestbook_entry", "e");
		$smessage = strip_tags($message,'<b><i><a><br>');
		$smessage = icms_core_DataFilter::checkVar($smessage, "html", "input");
		if($user_sig) $smessage = $smessage.'<br />'.$user_sig;
		$obj->setVar("guestbook", $smessage);
		// filter and store e-mail
		$email = $obj->getVar("guestbook_email", "e");
		$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		$obj->setVar("guestbook_email", $email);
		// validate and store ip
		$ip = $obj->getVar("guestbook_ip");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		$obj->setVar("guestbook_ip", $ip);
		// validate and store url
		$url = $obj->getVar("guestbook_url", "e");
		$url = icms_core_DataFilter::checkVar($url, "url");
		$obj->setVar("guestbook_url", $url);
		return TRUE;
	}

	protected function afterSave(&$obj) {
		if($obj->_updating) return TRUE;
		$pid = $obj->getVar("guestbook_pid", "e");
		if($pid) {
			$entry = $this->get($pid);
			$entry->setVar("guestbook_hassub", TRUE);
			$entry->_updating = TRUE;
			$this->insert($entry);
		}
		return TRUE;
	}
}