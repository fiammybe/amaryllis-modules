<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/MessageHandler.php
 * 
 * Classes responsible for managing album message objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_album_MessageHandler extends icms_ipf_Handler {
	
	function __construct(&$db) {
		parent::__construct($db, "message", "message_id", "message_item", "message_body", "album");
	}
	
	public function getMessages($iid = FALSE, $approve = TRUE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) $criteria->add(new icms_db_criteria_Item("message_approve", TRUE));
		if($iid) $criteria->add(new icms_db_criteria_Item("message_item", $iid));
		$messages = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($messages as $message) {
			$ret[$message['message_id']] = $message;
		}
		return $ret;
	}
	
	// approve/deny message
	public function changeApprove($message_id) {
		$approve = '';
		$messageObj = $this->get($message_id);
		if ($messageObj->getVar('message_approve', 'e') == TRUE) {
			$messageObj->setVar('message_approve', 0);
			$approve = 0;
		} else {
			$messageObj->setVar('message_approve', 1);
			$approve = 1;
		}
		$this->insert($messageObj, TRUE);
		return $approve;
	}
	
	public function message_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	public function getImageFilter() {
		$album_images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
		$images = $album_images_handler->getList();
		return $images;
	}
	
	// some related functions for storing
	protected function beforeInsert(&$obj) {
		$body = $obj->getVar("message_body", "s");
		$message = strip_tags($body,'<br>');
		$body = icms_core_DataFilter::checkVar($message, "html", "input");
		$obj->setVar("message_body", $body);
		return TRUE;
	}
}
