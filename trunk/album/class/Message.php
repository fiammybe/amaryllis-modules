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
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_album_Message extends icms_ipf_Object {

	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("message_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("message_uid", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("message_item", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("message_album", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 0);
		$this->quickInitVar("message_body", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("message_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("message_approve", XOBJ_DTYPE_INT);
		$this->initCommonVar("dohtml", FALSE, TRUE);
		$this->initCommonVar("dosmiley", FALSE, TRUE);
		$this->initCommonVar("dobr", FALSE, FALSE);

		$this->setControl("message_body", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("message_approve", "yesno");

		$this->hideFieldFromForm(array("message_date", "message_uid", "message_item", "message_approve"));
	}

	/**
	 * Overriding the icms_ipf_Object::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	public function getVar($key, $format = "s") {
		if (strtolower($format) == "s" && in_array($key, array("message_uid", "message_date", "message_approve" ))) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}

	function message_uid($linkOnly = TRUE) {
		global $icmsConfig;
		$suid = $this->getVar("message_uid", "e");
		$this->handler->loadUsers();
		if($linkOnly) return isset($this->handler->_usersArray[$suid]) ? $this->handler->_usersArray[$suid]['link'] : $icmsConfig['anonymous'];
		return (isset($this->handler->_usersArray[$suid])) ? $this->handler->_usersArray[$suid] : array('uname' => $icmsConfig['anonymous'], 'link' => ICMS_URL.'/user.php');
	}

	public function getItem() {
		$item = $this->getVar("message_item", "e");
		$album_images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
		$itemObj = $album_images_handler->get($item);
		return $itemObj->getVar("img_title", "e");
	}

	public function getBodyTeaser() {
		$ret = $this->getVar("message_body", "s");
		$ret = icms_core_DataFilter::icms_substr(icms_cleanTags($ret, array()), 0, 120);
		$ret = icms_core_DataFilter::checkVar($ret, "html", "output");
		return $ret;
	}

	public function message_date() {
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

	public function accessGranted() {
		if(!$this->isApproved() && $this->sameUser()) {return TRUE;}
		if($this->isApproved()) return TRUE;
		return FALSE;
	}

	public function isApproved() {
		return ($this->getVar("message_approve", "e") == 1) ? TRUE : FALSE;
	}

	public function sameUser() {
		$userid = $this->getVar("message_uid", "e");
        $user = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
		return ($userid == $user) ? TRUE : FALSE;
	}

	public function toArray() {
		$ret = parent::toArray();
		$ret['user'] = $this->message_uid(FALSE);
		$ret['is_approved'] = $this->isApproved();
		$ret['mycomment'] = $this->sameUser();
		$ret['accessGranted'] = $this->accessGranted();
		return $ret;
	}
}
