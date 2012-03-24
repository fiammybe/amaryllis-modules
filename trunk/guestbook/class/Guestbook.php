<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /class/Guestbook.php
 * 
 * Class representing guestbook guestbook objects
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

class GuestbookGuestbook extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param GuestbookGuestbook $handler Object handler
	 */
	public function __construct(&$handler) {
		global $guestbookConfig;
		parent::__construct($handler);

		$this->quickInitVar("guestbook_id", XOBJ_DTYPE_INT, TRUE);
		
		$this->quickInitVar("guestbook_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("guestbook_uid", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("guestbook_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("guestbook_email", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("guestbook_url", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("guestbook_image", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("guestbook_entry", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("guestbook_pid", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("guestbook_ip", XOBJ_DTYPE_OTHER, FALSE);
		$this->quickInitVar("guestbook_approve", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("guestbook_published_date", XOBJ_DTYPE_LTIME);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doxcode", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		
		$this->setControl("guestbook_approve", "yesno");
		if($guestbookConfig['allow_imageupload'] == 0) {
			$this->hideFieldFromForm("guestbook_image");
			$this->hideFieldFromSingleView("guestbook_image");
		} else {
			$this->setControl("guestbook_image", "imageupload");
		}
		$this->hideFieldFromForm(array("guestbook_approve", "guestbook_pid", "guestbook_ip", "guestbook_uid", "guestbook_published_date"));
		if($guestbookConfig['needs_approval'] == 0) {
			$this->hideFieldFromSingleView("guestbook_approve");
		}
	}

	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	public function guestbook_approve() {
		$active = $this->getVar('guestbook_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . GUESTBOOK_ADMIN_URL . 'guestbook.php?guestbook_id=' . $this->getVar('guestbook_id') . '&amp;op=changeApprove">
				<img src="' . GUESTBOOK_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . GUESTBOOK_ADMIN_URL . 'guestbook.php?guestbook_id=' . $this->getVar('guestbook_id') . '&amp;op=changeApprove">
				<img src="' . GUESTBOOK_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function getGuestbookAvatar() {
		global $guestbookConfig;
		if($guestbookConfig['show_avatar'] == 1) {
			$review_uid = $this->getVar("guestbook_uid", "e");
			$user = icms::handler("icms_member")->getUser($review_uid);
			if((int)($review_uid > 0) && is_object($user)) {
				$avatar = icms::handler("icms_member")->getUser($review_uid)->gravatar();
				$avatar_image = $avatar;
				return $avatar_image;
			} else {
				$review_avatar = "blank_gravatar.png";
				$avatar_image = GUESTBOOK_IMAGES_URL . "/" . $review_avatar;
				return $avatar_image;
			}
		}
	}
	
	public function getMessageTeaser() {
		$ret = $this->getVar("guestbook_entry", "s");
		$ret = icms_core_DataFilter::icms_substr(icms_cleanTags($ret, array()), 0, 120);
		return $ret;
	}
	
	public function getMessage() {
		$message = icms_core_DataFilter::checkVar($this->getVar("guestbook_entry"), 'html', 'output');
		return $message;
	}
	
	public function getImageTag() {
		$guestbook_img = $image_tag = '';
		$guestbook_img = $this->getVar('guestbook_image', 'e');
		if (!empty($guestbook_img)) {
			$image_tag = GUESTBOOK_UPLOAD_URL . 'guestbook/' . $guestbook_img;
		}
		return $image_tag;
	}
	
	public function getGuestbookEmail() {
		global $guestbookConfig;
		$email = $this->getVar("guestbook_email", "s");
		if($guestbookConfig['display_email'] == 1 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 0);
		} elseif($guestbookConfig['display_email'] == 2 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		} elseif($guestbookConfig['display_email'] == 3 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 1);
		} elseif($guestbookConfig['display_email'] == 4 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 1);
		}
		return $email;
	}
	
	// get publisher for frontend
	function getPublisher($link = FALSE) {
			$publisher_uid = $this->getVar('guestbook_uid', 'e');
			$userinfo = array();
			$userObj = icms::handler('icms_member')->getuser($publisher_uid);
			if (is_object($userObj)) {
				$userinfo['uid'] = $publisher_uid;
				$userinfo['uname'] = $userObj->getVar('uname');
				$userinfo['link'] = '<a href="' . ICMS_URL . '/userinfo.php?uid=' . $userinfo['uid'] . '">' . $userinfo['uname'] . '</a>';
			} else {
				global $icmsConfig;
				$userinfo['uid'] = 0;
				$userinfo['uname'] = $icmsConfig['anonymous'];
			}
		if ($link && $userinfo['uid']) {
			return $userinfo['link'];
		} else {
			return $userinfo['uname'];
		}
	}
	
	public function getPublishedDate() {
		global $guestbookConfig;
		$date = $this->getVar('guestbook_published_date', 'e');
		return date($guestbookConfig['guestbook_dateformat'], $date);
	}
	
	public function getSubEntries($toArray = FALSE) {
		global $guestbookConfig;
		if($guestbookConfig['use_moderation'] == 1) {
			$pid = $this->getVar("guestbook_id", "e");
			return $this->handler->getSubEntries(TRUE, $pid, $toArray);
		}
	}

	public function getReplyLink() {
		global $guestbookConfig;
		if($guestbookConfig['use_moderation'] == 1) {
			$pid = $this->getVar("guestbook_id", "e");
			$link = GUESTBOOK_URL . 'submit.php?op=addreply&guestbook_pid=' . $this->getVar("guestbook_id");
		} else {
			$link = FALSE;
		}
		return $link;
	}
	
	public function getItemLink($urlonly = FALSE) {
		$id = $this->getVar("guestbook_id", "e");
		$title = $this->getVar("guestbook_title", "e");
		if($urlonly) {
			$link = GUESTBOOK_URL . '#entry_' . $id;
		} else {
			$link = '<a href="' . GUESTBOOK_URL . '#entry_' . $id . '" title="' . $title . '">' . $title . '</a>';
		}
		return $link;
	}

	public function toArray() {
		global $guestbookConfig;
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("guestbook_id", "e");
		$ret['published_on'] = $this->getPublishedDate();
		$ret['published_by'] = $this->getPublisher(TRUE);
		$ret['img'] = $this->getImageTag();
		$ret['name'] = $this->getVar("guestbook_name");
		$ret['homepage'] = $this->getVar("guestbook_url");
		$ret['email'] = $this->getGuestbookEmail();
		$ret['ip'] = $this->getVar("guestbook_ip");
		$ret['title'] = $this->getVar("guestbook_title");
		$ret['message'] = $this->getMessage();
		$ret['teaser'] = $this->getMessageTeaser();
		$ret['avatar'] = $this->getGuestbookAvatar();
		$ret['parent'] = $this->getVar("guestbook_pid", "e");
		if($guestbookConfig['use_moderation'] == 1){
			$ret['sub'] = $this->getSubEntries(TRUE);
			$ret['hassub'] = (count($ret['sub']) > 0) ? TRUE : FALSE;
		}
		$ret['reply'] = $this->getReplyLink();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		return $ret;
	}
}