<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /class/Visitorvoice.php
 * 
 * Class representing visitorvoice visitorvoice objects
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

class VisitorvoiceVisitorvoice extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param VisitorvoiceVisitorvoice $handler Object handler
	 */
	public function __construct(&$handler) {
		global $visitorvoiceConfig;
		parent::__construct($handler);

		$this->quickInitVar("visitorvoice_id", XOBJ_DTYPE_INT, TRUE);
		
		$this->quickInitVar("visitorvoice_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("visitorvoice_uid", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("visitorvoice_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("visitorvoice_email", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("visitorvoice_url", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("visitorvoice_image", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("visitorvoice_entry", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("visitorvoice_pid", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("visitorvoice_ip", XOBJ_DTYPE_OTHER, FALSE);
		$this->quickInitVar("visitorvoice_approve", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("visitorvoice_published_date", XOBJ_DTYPE_LTIME);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		
		$this->setControl("visitorvoice_approve", "yesno");
		if($visitorvoiceConfig['allow_imageupload'] == 0) {
			$this->hideFieldFromForm("visitorvoice_image");
			$this->hideFieldFromSingleView("visitorvoice_image");
		} else {
			$this->setControl("visitorvoice_image", "imageupload");
		}
		$this->hideFieldFromForm(array("visitorvoice_approve", "visitorvoice_pid", "visitorvoice_ip", "visitorvoice_uid", "visitorvoice_published_date"));
		if($visitorvoiceConfig['needs_approval'] == 0) {
			$this->hideFieldFromSingleView("visitorvoice_approve");
		}
	}

	public function visitorvoice_approve() {
		$active = $this->getVar('visitorvoice_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . VISITORVOICE_ADMIN_URL . 'visitorvoice.php?visitorvoice_id=' . $this->getVar('visitorvoice_id') . '&amp;op=changeApprove">
				<img src="' . VISITORVOICE_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . VISITORVOICE_ADMIN_URL . 'visitorvoice.php?visitorvoice_id=' . $this->getVar('visitorvoice_id') . '&amp;op=changeApprove">
				<img src="' . VISITORVOICE_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function getVisitorvoiceAvatar() {
		global $visitorvoiceConfig;
		if($visitorvoiceConfig['show_avatar'] == 1) {
			$review_uid = $this->getVar("visitorvoice_uid", "e");
			$user = icms::handler("icms_member")->getUser($review_uid);
			if((int)($review_uid > 0) && is_object($user)) {
				$avatar = icms::handler("icms_member")->getUser($review_uid)->gravatar();
				$avatar_image = $avatar;
				return $avatar_image;
			} else {
				$review_avatar = "blank_gravatar.png";
				$avatar_image = VISITORVOICE_IMAGES_URL . "/" . $review_avatar;
				return $avatar_image;
			}
		}
	}
	
	public function getMessage() {
		$message = icms_core_DataFilter::checkVar($this->getVar("visitorvoice_entry"), 'html', 'output');
		return $message;
	}
	
	public function getMessageTeaser() {
		$ret = $this->getVar("visitorvoice_entry", "s");
		$ret = icms_core_DataFilter::icms_substr(icms_cleanTags($ret, array()), 0, 120);
		return $ret;
	}
	
	public function getImageTag() {
		$visitorvoice_img = $image_tag = '';
		$visitorvoice_img = $this->getVar('visitorvoice_image', 'e');
		if (!empty($visitorvoice_img)) {
			$image_tag = VISITORVOICE_UPLOAD_URL . 'visitorvoice/' . $visitorvoice_img;
		}
		return $image_tag;
	}
	
	public function getVisitorvoiceEmail() {
		global $visitorvoiceConfig;
		$email = $this->getVar("visitorvoice_email", "s");
		if($visitorvoiceConfig['display_email'] == 1 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 0);
		} elseif($visitorvoiceConfig['display_email'] == 2 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		} elseif($visitorvoiceConfig['display_email'] == 3 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 1);
		} elseif($visitorvoiceConfig['display_email'] == 4 && $email != "") {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 1);
		}
		return $email;
	}
	
	// get publisher for frontend
	public function getPublisher($link = FALSE) {
			$publisher_uid = $this->getVar('visitorvoice_uid', 'e');
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
		global $visitorvoiceConfig;
		$date = '';
		$date = $this->getVar('visitorvoice_published_date', 'e');
		
		return date($visitorvoiceConfig['visitorvoice_dateformat'], $date);
	}
	
	public function getSubEntries($toArray = FALSE) {
		global $visitorvoiceConfig;
		if($visitorvoiceConfig['use_moderation'] == 1) {
			$pid = $this->getVar("visitorvoice_id", "e");
			return $this->handler->getSubEntries(TRUE, $pid, $toArray);
		}
	}

	public function getReplyLink() {
		global $visitorvoiceConfig;
		if($visitorvoiceConfig['use_moderation'] == 1) {
			$pid = $this->getVar("visitorvoice_id", "e");
			$link = VISITORVOICE_URL . 'submit.php?op=addreply&visitorvoice_pid=' . $this->getVar("visitorvoice_id");
		} else {
			$link = FALSE;
		}
		return $link;
	}
	
	public function getItemLink($urlonly = FALSE) {
		$id = $this->getVar("visitorvoice_id", "e");
		$title = $this->getVar("visitorvoice_title", "e");
		if($urlonly) {
			$link = VISITORVOICE_URL . '#entry_' . $id;
		} else {
			$link = '<a href="' . VISITORVOICE_URL . '#entry_' . $id . '" title="' . $title . '">' . $title . '</a>';
		}
		return $link;
	}
	
	public function toArray() {
		global $visitorvoiceConfig;
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("visitorvoice_id");
		$ret['published_on'] = $this->getPublishedDate();
		$ret['published_by'] = $this->getPublisher(TRUE);
		$ret['img'] = $this->getImageTag();
		$ret['name'] = $this->getVar("visitorvoice_name");
		$ret['homepage'] = $this->getVar("visitorvoice_url");
		$ret['email'] = $this->getVisitorvoiceEmail();
		$ret['ip'] = $this->getVar("visitorvoice_ip");
		$ret['title'] = $this->getVar("visitorvoice_title");
		$ret['message'] = $this->getMessage();
		$ret['teaser'] = $this->getMessageTeaser();
		$ret['avatar'] = $this->getVisitorvoiceAvatar();
		$ret['parent'] = $this->getVar("visitorvoice_pid", "e");
		if($visitorvoiceConfig['use_moderation'] == 1){
			$ret['sub'] = $this->getSubEntries(TRUE);
			$ret['hassub'] = (count($ret['sub']) > 0) ? TRUE : FALSE;
		}
		$ret['reply'] = $this->getReplyLink();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		return $ret;
	}
}