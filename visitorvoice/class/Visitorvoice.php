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
		
		$this->setControl("visitorvoice_image", "image");
		$this->setControl("visitorvoice_approve", "yesno");
		if($visitorvoiceConfig['allow_imageupload'] == 0) {
			$this->hideFieldFromForm("visitorvoice_image");
			$this->hideFieldFromSingleView("visitorvoice_image");
		}
		$this->hideFieldFromForm(array("visitorvoice_approve", "visitorvoice_pid", "visitorvoice_ip", "visitorvoice_uid", "visitorvoice_published_date"));
		if($visitorvoiceConfig['needs_approval'] == 0) {
			$this->hideFieldFromSingleView("visitorvoice_approve");
		}
	}

	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	public function visitorvoice_approve() {
		$active = $this->getVar('visitorvoice_approve', 'e');
		if ($active == false) {
			return '<a href="' . VISITORVOICE_ADMIN_URL . 'visitorvoice.php?visitorvoice_id=' . $this->getVar('visitorvoice_id') . '&amp;op=changeApprove">
				<img src="' . VISITORVOICE_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . VISITORVOICE_ADMIN_URL . 'visitorvoice.php?visitorvoice_id=' . $this->getVar('visitorvoice_id') . '&amp;op=changeApprove">
				<img src="' . VISITORVOICE_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function getVisitorvoiceAvatar() {
		$review_uid = $this->getVar("visitorvoice_uid", "e");
		if(intval($review_uid > 0)) {
			$review_user = icms::handler("icms_member")->getUser($review_uid);
			$review_avatar = $review_user->getVar("user_avatar");
			$avatar_image = "<img src='" . ICMS_UPLOAD_URL . "/" . $review_user->getVar("user_avatar") . "' alt='avatar' />";
			return $avatar_image;
		} else {
			$review_avatar = "blank.gif";
			$avatar_image = "<img src='" . ICMS_UPLOAD_URL . "/" . $review_avatar . "' alt='avatar' />";
			return $avatar_image;
		}
	}
	
	public function getMessage() {
		$message = icms_core_DataFilter::checkVar($this->getVar("visitorvoice_entry"), 'html', 'output');
		return $message;
	}
	
	public function getImageTag() {
		$visitorvoice_img = $image_tag = '';
		$visitorvoice_img = $this->getVar('visitorvoice_image', 'e');
		if (!empty($visitorvoice_img)) {
			$image_tag = VISITORVOICE_UPLOAD_URL . 'visitorvoice/' . $visitorvoice_img;
		}
		return $image_tag;
	}
	
	// get publisher for frontend
	function getPublisher($link = false) {
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

	public function getReplyForm() {
		$pid = $this->getVar("visitorvoice_id", "e");
		//$sform = $this->getSecureForm(_MD_VISITORVOICE_CREATE, "addentry", 'submit.php?op=addentry&visitorvoice_pid=' . $pid, FALSE, TRUE);
		return $sform;
	}
	
	public function getItemLink() {
		$id = $this->getVar("visitorvoice_id", "e");
		$title = $this->getVar("visitorvoice_title", "e");
		$link = '<a href="' . VISITORVOICE_URL . '#entry_' . $id . '" title="' . $title . '">' . $title . '</a>';
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
		$ret['email'] = $this->getVar("visitorvoice_email");
		$ret['ip'] = $this->getVar("visitorvoice_ip");
		$ret['title'] = $this->getVar("visitorvoice_title");
		$ret['message'] = $this->getMessage();
		$ret['avatar'] = $this->getVisitorvoiceAvatar();
		$ret['parent'] = $this->getVar("visitorvoice_pid", "e");
		if($visitorvoiceConfig['use_moderation'] == 1){
			$ret['sub'] = $this->getSubEntries(TRUE);
			$ret['hassub'] = (count($ret['sub']) > 0) ? TRUE : FALSE;
		}
		$ret['reply'] = $this->getReplyLink();
		$ret['itemLink'] = $this->getItemLink();
		
		return $ret;
	}
	
}