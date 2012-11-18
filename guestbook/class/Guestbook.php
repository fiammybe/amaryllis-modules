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
	
	public $_guestbook_thumbs;
	
	public $_guestbook_images;
	
	public $_guestbook_images_url;
	
	public $_guestbook_thumbs_url;
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
		$this->quickInitVar("guestbook_fprint", XOBJ_DTYPE_OTHER, FALSE, FALSE, FALSE, FALSE);
		$this->quickInitVar("guestbook_hassub", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, FALSE);
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
		$this->hideFieldFromForm(array("guestbook_approve", "guestbook_fprint", "guestbook_hassub", "guestbook_pid", "guestbook_ip", "guestbook_uid", "guestbook_published_date"));
		if($guestbookConfig['needs_approval'] == 0) {
			$this->hideFieldFromSingleView("guestbook_approve");
		}
		$this->_guestbook_thumbs = $this->handler->getGuestbookThumbsPath();
		$this->_guestbook_images = $this->handler->getGuestbookImagesPath();
		$this->_guestbook_images_url = ICMS_URL . "/cache/" . $this->handler->_moduleName . "/" . $this->handler->_itemname . "/images/";
		$this->_guestbook_thumbs_url = ICMS_URL . "/cache/" . $this->handler->_moduleName . "/" . $this->handler->_itemname . "/thumbs/";
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
	
	public function getGuestbookImage($thumb = FALSE) {
		global $guestbookConfig;
		$guestbook_img = $cached_img = $cached_image_url = $srcpath = $image = "";
		$guestbook_img = $this->getVar('guestbook_image', 'e');
		if(!$guestbook_img == "" && !$guestbook_img == "0") {
			$cached_img = ($thumb == FALSE) ? $this->_guestbook_images . $guestbook_img : $this->_guestbook_thumbs . $guestbook_img;
			$cached_image_url = ($thumb == FALSE) ? $this->_guestbook_images_url . $guestbook_img : $this->_guestbook_thumbs_url . $guestbook_img;
			if(!is_file($cached_img)) {
			    require_once ICMS_MODULES_PATH.'/'.GUESTBOOK_DIRNAME.'/class/Image.php';
				$srcpath = GUESTBOOK_UPLOAD_ROOT . $this->handler->_itemname . "/";
				$image = new mod_guestbook_Image($guestbook_img, $srcpath);
				$resized = $image->resizeImage( ($thumb == FALSE) ? $guestbookConfig['display_width'] : $guestbookConfig['thumbnail_width'], 
										($thumb == FALSE) ? $guestbookConfig['display_height'] : $guestbookConfig['thumbnail_height'],
										($thumb == FALSE) ? $this->_guestbook_images : $this->_guestbook_thumbs, "100");
				unset($srcpath, $image, $resized);
			}
			unset($cached_img, $guestbook_img, $thumb);
			return $cached_image_url;
		}
		return FALSE;
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
	
	public function getIP() {
		global $guestbook_isAdmin;
		return ($guestbook_isAdmin) ? $this->getVar("guestbook_ip") : FALSE;
	}
	
	public function getGuestbookEmail() {
		global $guestbookConfig, $guestbook_isAdmin;
		if($guestbookConfig['show_email'] == 0 && !$guestbook_isAdmin) return FALSE;
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
	function getPublisher() {
		$uid = $this->getVar('guestbook_uid', 'e');
		$users = $this->handler->loadUsers();
		$user = (array_key_exists($uid, $users) && $uid > 0 ) ? $users[$uid] : FALSE;
		if($user) return $user;
		$userinfo = array();
		$userinfo['link'] = ucwords($this->getVar("guestbook_name"));
		$email = ($this->getVar("guestbook_email") !== "") ? $this->getVar("guestbook_email") : FALSE;
		$userinfo['avatar'] = ($email) ? "http://www.gravatar.com/avatar/" . md5(strtolower($email)) . "?d=identicon" : GUESTBOOK_URL."images/blank_gravatar.png";
		return $userinfo;
	}
	
	public function getPublishedDate() {
		global $guestbookConfig;
		$date = $this->getVar('guestbook_published_date', 'e');
		return date($guestbookConfig['guestbook_dateformat'], $date);
	}
	
	public function isApproved() {
		return ($this->getVar("guestbook_approve") == 1) ? TRUE : FALSE;
	}
	
	public function getApproved() {
		return (!$this->isApproved()) ? "guestbook_approval" : "";
	}
	
	public function getSubEntries($toArray = FALSE) {
		global $guestbookConfig;
		if($guestbookConfig['use_moderation'] == 1) {
			$pid = $this->id();
			return $this->handler->getSubEntries(TRUE, $pid, $toArray);
		}
	}
	
	public function getItemLink($urlonly = FALSE) {
		$id = $this->id();
		$title = $this->title();
		if($urlonly) {
			$link = GUESTBOOK_URL . '#entry_' . $id;
		} else {
			$link = '<a href="' . GUESTBOOK_URL . '#entry_' . $id . '" title="' . $title . '">' . $title . '</a>';
		}
		return $link;
	}

	public function hasImage() {
		return (($this->getVar("guestbook_image") !== "") && ($this->getVar("guestbook_image") !== "0")) ? TRUE : FALSE;
	}

	public function toArray() {
		global $guestbookConfig;
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['published_on'] = $this->getPublishedDate();
		$ret['published_by'] = $this->getPublisher();
		$ret['img'] = $this->getGuestbookImage();
		$ret['thumb'] = $this->getGuestbookImage(TRUE);
		$ret['homepage'] = $this->getVar("guestbook_url");
		$ret['email'] = $this->getGuestbookEmail();
		$ret['ip'] = $this->getIP();
		$ret['title'] = $this->title();
		$ret['message'] = $this->summary();
		$ret['teaser'] = $this->getMessageTeaser();
		$ret['avatar'] = ($guestbookConfig['show_avatar'] == 1) ? TRUE : FALSE;
		$ret['parent'] = $this->getVar("guestbook_pid", "e");
		if($guestbookConfig['use_moderation'] == 1){
			$ret['sub'] = $this->getSubEntries(TRUE);
			$ret['hassub'] = (count($ret['sub']) > 0) ? TRUE : FALSE;
		}
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['approved'] = $this->getApproved();
		$ret['has_image'] = $this->hasImage();
		return $ret;
	}
}