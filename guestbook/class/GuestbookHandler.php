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
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "guestbook", "guestbook_id", "guestbook_title", "guestbook_entry", "guestbook");
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, icms::$module->config['image_file_size'], icms::$module->config['image_upload_width'], icms::$module->config['image_upload_height']);
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
		$this->insert($guestbookObj, TRUE);
		return $approve;
	}
	
	public function guestbook_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
	}

	public function getEntries($approve = null, $guestbook_pid = 0, $start = 0, $limit = 0, $order = 'guestbook_published_date', $sort = 'DESC') {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($approve) $criteria->add(new icms_db_criteria_Item('guestbook_approve', TRUE));
		$criteria->add(new icms_db_criteria_Item('guestbook_pid', $guestbook_pid));
		$entries = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach($entries as $entry) {
			$ret[$entry['id']] = $entry;
		}
		return $ret;
	}
	
	public function getSubEntries($approve = NULL, $guestbook_pid = 0, $toArray = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) $criteria->add(new icms_db_criteria_Item("guestbook_approve", TRUE));
		$criteria = new icms_db_criteria_Item("guestbook_pid", $guestbook_pid);
		$subentries = $this->getObjects($criteria, TRUE, TRUE);
		if(!$toArray) return $subentries;
		$ret = array();
		foreach(array_keys($subentries) as $i) {
			$ret[$i] = $subentries[$i]->toArray();
		}
		return $ret;
	}
	
	protected function beforeInsert(& $obj) {
		global $downloadsConfig;
		// filter and store entry
		$message = $obj->getVar("guestbook_entry", "s");
		$smessage = strip_tags($message,'<b><i><a><br>');
		$smessage = icms_core_DataFilter::checkVar($smessage, "html", "input");
		$obj->setVar("guestbook", $smessage);
		// filter and store e-mail
		$email = $obj->getVar("guestbook_email", "s");
		if($downloadsConfig['display_guestbook_email'] == 1 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 0);
		} elseif($downloadsConfig['display_guestbook_email'] == 2) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		} elseif($downloadsConfig['display_guestbook_email'] == 3) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 1);
		} elseif($downloadsConfig['display_guestbook_email'] == 4) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 1);
		}
		$obj->setVar("guestbook_email", $email);
		// validate and store ip
		$ip = $obj->getVar("guestbook_ip");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		$obj->setVar("guestbook_ip", $ip);
		// validate and store url
		$url = $obj->getVar("guestbook_url", "s");
		$url = icms_core_DataFilter::checkVar($url, "url");
		$obj->setVar("guestbook_url", $url);
		return TRUE;
	}
}