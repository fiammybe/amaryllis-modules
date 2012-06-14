<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/Message.php
 * 
 * Class representing album message objects
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

class AlbumMessage extends icms_ipf_Object {
	
	public function __construct(&$handler) {
		parent::__construct($handler);
		
		$this->quickInitVar("message_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("message_uid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("message_item", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("message_body", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("message_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("message_approve", XOBJ_DTYPE_INT);
		
		$this->setControl("message_body", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("message_approve", "yesno");
		
		$this->hideFieldFromForm(array("message_date", "message_uid", "message_item", "message_approve"));
	}
	
	public function getPublisher() {
		return icms_member_user_Handler::getUserLink($this->getVar("message_uid", "e"));
	}
	
	public function getPublisherAvatar() {
		$publisher = $this->getVar("message_uid", "e");
		$ret = icms::handler("icms_member")->getUser($publisher)->gravatar();
		return $ret;
	}
	
	public function getItem() {
		$item = $this->getVar("message_item", "e");
		$album_images_handler = icms_getModuleHandler("images", basename(dirname(dirname(__FILE__))), "album");
		$itemObj = $album_images_handler->get($item);
		return $itemObj->getVar("img_title", "e");
	}
	
	public function getMessageBody() {
		$body = $this->getVar("message_body", "s");
		$body = icms_core_DataFilter::checkVar($body, "html", "output");
		return $body;
	}
	
	public function getBodyTeaser() {
		$ret = $this->getVar("message_body", "s");
		$ret = icms_core_DataFilter::icms_substr(icms_cleanTags($ret, array()), 0, 120);
		$ret = icms_core_DataFilter::checkVar($ret, "html", "output");
		return $ret;
	}
	
	public function getPublishedDate() {
		global $albumConfig;
		$date = $this->getVar("message_date", "e");
		return date($albumConfig['album_dateformat'], $date);
	}
	
	public function message_approve() {
		$active = $this->getVar("message_approve", "e");
		if ($active == FALSE) {
			return '<a href="' . ALBUM_ADMIN_URL . 'message.php?message_id=' . $this->getVar("message_id", "e") . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'message.php?message_id=' . $this->getVar("message_id", "e") . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}

	public function toArray() {
		$ret = parent::toArray();
		$ret['body'] = $this->getMessageBody();
		$ret['date'] = $this->getPublishedDate();
		$ret['user'] = $this->getPublisher();
		return $ret;
	}
}
