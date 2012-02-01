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

class VisitorvoiceVisitorvoiceHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $visitorvoiceConfig;
		parent::__construct($db, "visitorvoice", "visitorvoice_id", "visitorvoice_title", "visitorvoice_entry", "visitorvoice");
		$this->_uploadPath = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/visitorvoice/';
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $visitorvoiceConfig['image_file_size'], $visitorvoiceConfig['image_upload_width'], $visitorvoiceConfig['image_upload_height']);
	}
	
	public function getImagePath() {
		$dir = $this->_uploadPath;
		if (!file_exists($dir)) {
			$moddir = basename(dirname(dirname(__FILE__)));
			icms_core_Filesystem::mkdir($dir, "0777", ICMS_ROOT_PATH . '/uploads/' . $moddir . '/' );
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
		$this->insert($visitorvoiceObj, TRUE);
		return $approve;
	}
	
	public function visitorvoice_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
	}

	public function getEntries($approve = null, $visitorvoice_pid = 0, $start = 0, $limit = 0, $order = 'visitorvoice_published_date', $sort = 'DESC') {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($approve) $criteria->add(new icms_db_criteria_Item('visitorvoice_approve', TRUE));
		$criteria->add(new icms_db_criteria_Item('visitorvoice_pid', $visitorvoice_pid));
		$entries = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach($entries as $entry) {
			$ret[$entry['id']] = $entry;
		}
		return $ret;
	}
	
	public function getSubEntries($approve = NULL, $visitorvoice_pid = 0, $toArray = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) $criteria->add(new icms_db_criteria_Item("visitorvoice_approve", TRUE));
		$criteria = new icms_db_criteria_Item("visitorvoice_pid", $visitorvoice_pid);
		$subentries = $this->getObjects($criteria, TRUE, TRUE);
		if(!$toArray) return $subentries;
		$ret = array();
		foreach(array_keys($subentries) as $i) {
			$ret[$i] = $subentries[$i]->toArray();
		}
		return $ret;
	}
	
	protected function beforeInsert(& $obj) {
		global $visitorvoiceConfig;
		// filter and store entry
		$message = $obj->getVar("visitorvoice_entry", "s");
		$smessage = strip_tags($message,'<b><i><a><br>');
		$smessage = icms_core_DataFilter::checkVar($smessage, "html", "input");
		$obj->setVar("visitorvoice", $smessage);
		// filter and store e-mail
		$email = $obj->getVar("visitorvoice_email", "s");
		if($visitorvoiceConfig['display_visitorvoice_email'] == 1 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 0);
		} elseif($visitorvoiceConfig['display_visitorvoice_email'] == 2) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		} elseif($visitorvoiceConfig['display_visitorvoice_email'] == 3) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 1);
		} elseif($visitorvoiceConfig['display_visitorvoice_email'] == 4) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 1);
		}
		$obj->setVar("visitorvoice_email", $email);
		// validate and store ip
		$ip = $obj->getVar("visitorvoice_ip");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		$obj->setVar("visitorvoice_ip", $ip);
		// validate and store url
		$url = $obj->getVar("visitorvoice_url", "s");
		$url = icms_core_DataFilter::checkVar($url, "url");
		$obj->setVar("visitorvoice_url", $url);
		return TRUE;
	}
}