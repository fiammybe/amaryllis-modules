<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /class/VisitorvoiceHandler.php
 * 
 * Classes responsible for managing Visitorvoice visitorvoice objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("VISITORVOICE_DIRNAME")) define("VISITORVOICE_DIRNAME", basename(dirname(dirname(__FILE__))));
class VisitorvoiceVisitorvoiceHandler extends icms_ipf_Handler {
	
	private $_usersArray;
	private $_entryArray;
	
	public $_visitorvoice_cache_path;
	public $_visitorvoice_thumbs_path;
	public $_visitorvoice_images_path;
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $visitorvoiceConfig;
		parent::__construct($db, "visitorvoice", "visitorvoice_id", "visitorvoice_title", "visitorvoice_entry", "visitorvoice");
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $visitorvoiceConfig['image_file_size'], $visitorvoiceConfig['image_upload_width'], $visitorvoiceConfig['image_upload_height']);
		$this->_visitorvoice_cache_path = ICMS_CACHE_PATH . "/" . $this->_moduleName . "/" . $this->_itemname;
		$this->_visitorvoice_thumbs_path = $this->_visitorvoice_cache_path . "/thumbs";
		$this->_visitorvoice_images_path = $this->_visitorvoice_cache_path . "/images";
	}
	
	public function getVisitorvoiceThumbsPath() {
		$dir = $this->_visitorvoice_thumbs_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	public function getVisitorvoiceImagesPath() {
		$dir = $this->_visitorvoice_images_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	public function changeApprove($visitorvoice_id) {
		$approve = '';
		$visitorvoiceObj = $this->get($visitorvoice_id);
		if ($visitorvoiceObj->getVar('visitorvoice_approve', 'e') == TRUE) {
			$visitorvoiceObj->setVar('visitorvoice_approve', 0);
			$approve = 0;
		} else {
			$visitorvoiceObj->setVar('visitorvoice_approve', 1);
			$approve = 1;
		}
		$visitorvoiceObj->_updating = TRUE;
		$this->insert($visitorvoiceObj, TRUE);
		if($approve == 1) $visitorvoiceObj->sendMessageApproved();
		return $approve;
	}
	
	public function visitorvoice_approve_filter() {
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
	
	public function getEntryCriterias($approve = FALSE, $visitorvoice_pid = 0, $start = 0, $limit = 0, $order = 'visitorvoice_published_date', $sort = 'DESC') {
		global $visitorvoice_isAdmin;
		$criteria = new icms_db_criteria_Compo();
		if($start) $criteria->setStart($start);
		if($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($approve) {
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			if($uid) {
				if(!$visitorvoice_isAdmin) {
					$crit = new icms_db_criteria_Compo();
					$crit->add(new icms_db_criteria_Item("visitorvoice_uid", $uid));
					$crit->add(new icms_db_criteria_Item('visitorvoice_approve', TRUE), 'OR');
					$criteria->add($crit);
				}
			} else {
				$crit = new icms_db_criteria_Compo();
				$crit->add(new icms_db_criteria_Item("visitorvoice_fprint", $_SESSION['icms_fprint']));
				$crit->add(new icms_db_criteria_Item('visitorvoice_approve', TRUE), 'OR');
				$criteria->add($crit);
			}
		}
		$criteria->add(new icms_db_criteria_Item('visitorvoice_pid', $visitorvoice_pid));
		return $criteria;
	}
	
	public function getEntries($approve = FALSE, $visitorvoice_pid = 0, $start = 0, $limit = 0, $order = 'visitorvoice_published_date', $sort = 'DESC') {
		$criteria = $this->getEntryCriterias($approve, $visitorvoice_pid, $start, $limit, $order, $sort);
		$entries = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach($entries as $entry) {
			$ret[$entry['id']] = $entry;
		}
		return $ret;
	}
	
	public function getSubEntries($approve = FALSE, $visitorvoice_pid = 0, $toArray = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) {
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			if($uid) {
				$crit = new icms_db_criteria_Compo();
				$crit->add(new icms_db_criteria_Item("visitorvoice_uid", $uid));
				$crit->add(new icms_db_criteria_Item('visitorvoice_approve', TRUE), 'OR');
				$criteria->add($crit);
			} else {
				$criteria->add(new icms_db_criteria_Item('visitorvoice_approve', TRUE));
			}
		}
		$criteria = new icms_db_criteria_Item("visitorvoice_pid", $visitorvoice_pid);
		$subentries = $this->getObjects($criteria, TRUE, TRUE);
		if(!$toArray) return $subentries;
		$ret = array();
		foreach(array_keys($subentries) as $i) {
			$ret[$i] = $subentries[$i]->toArray();
		}
		return $ret;
	}
	
	public function canModerate() {
		global $visitorvoice_isAdmin, $visitorvoiceConfig;
		if($visitorvoiceConfig['use_moderation'] == 0) return FALSE;
		if($visitorvoice_isAdmin) return TRUE;
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		return count(array_intersect($visitorvoiceConfig['can_moderate'], $groups));
	}
	
	public function canUpload() {
		global $visitorvoice_isAdmin, $visitorvoiceConfig;
		if($visitorvoiceConfig['allow_imageupload'] == 0) return FALSE;
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		return count(array_intersect($visitorvoiceConfig['can_upload'], $groups));
	}
	
	protected function beforeInsert(& $obj) {
		if($obj->_updating) return TRUE;
		global $visitorvoiceConfig;
		$member_handler = icms::handler("icms_member_user");
		$user_sig = ($obj->getVar("visitorvoice_uid", "e") > 0) ? $member_handler->get($obj->getVar("visitorvoice_uid", "e"))->getVar("user_sig", "N") : FALSE;
		unset($member_handler);
		// filter and store entry
		$message = $obj->getVar("visitorvoice_entry", "s");
		$smessage = strip_tags(icms_core_DataFilter::undoHtmlSpecialChars($message),'<b><i><a><br>');
		$smessage = icms_core_DataFilter::checkVar($smessage, "html", "input");
		if($user_sig) $smessage = $smessage.'<br />'.$user_sig;
		$obj->setVar("visitorvoice", $smessage);
		// filter and store e-mail
		$email = $obj->getVar("visitorvoice_email", "e");
		$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		$obj->setVar("visitorvoice_email", $email);
		// validate and store ip
		$ip = $obj->getVar("visitorvoice_ip");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		$obj->setVar("visitorvoice_ip", $ip);
		// validate and store url
		$url = $obj->getVar("visitorvoice_url", "e");
		$url = icms_core_DataFilter::checkVar($url, "url");
		$obj->setVar("visitorvoice_url", $url);
		return TRUE;
	}

	protected function afterSave(&$obj) {
		if($obj->_updating) return TRUE;
		$pid = $obj->getVar("visitorvoice_pid", "e");
		if($pid) {
			$entry = $this->get($pid);
			$entry->setVar("visitorvoice_hassub", TRUE);
			$entry->_updating = TRUE;
			$this->insert($entry);
		}
		return TRUE;
	}
}