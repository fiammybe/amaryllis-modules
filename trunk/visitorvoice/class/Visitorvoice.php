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
if(!defined("VISITORVOICE_DIRNAME")) define("VISITORVOICE_DIRNAME", basename(dirname(dirname(__FILE__))));
class VisitorvoiceVisitorvoice extends icms_ipf_Object {
	
	public $_updating = FALSE;
	public $_visitorvoice_thumbs;
	public $_visitorvoice_images;
	public $_visitorvoice_images_url;
	public $_visitorvoice_thumbs_url;
	
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
		$this->quickInitVar("visitorvoice_fprint", XOBJ_DTYPE_OTHER, FALSE, FALSE, FALSE, FALSE);
		$this->quickInitVar("visitorvoice_hassub", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doxcode", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		
		$this->setControl("visitorvoice_approve", "yesno");
		if($visitorvoiceConfig['allow_imageupload'] == 0) {
			$this->hideFieldFromForm("visitorvoice_image");
			$this->hideFieldFromSingleView("visitorvoice_image");
		} else {
			$this->setControl("visitorvoice_image", "imageupload");
		}
		$this->setControl("visitorvoice_hassub", "yesno");
		$this->hideFieldFromForm(array("visitorvoice_approve", "visitorvoice_fprint", "visitorvoice_hassub", "visitorvoice_pid", "visitorvoice_ip", "visitorvoice_uid", "visitorvoice_published_date"));
		if($visitorvoiceConfig['needs_approval'] == 0) {
			$this->hideFieldFromSingleView("visitorvoice_approve");
		}
		$this->_visitorvoice_thumbs = $this->handler->getVisitorvoiceThumbsPath();
		$this->_visitorvoice_images = $this->handler->getVisitorvoiceImagesPath();
		$this->_visitorvoice_images_url = ICMS_URL . "/cache/" . $this->handler->_moduleName . "/" . $this->handler->_itemname . "/images/";
		$this->_visitorvoice_thumbs_url = ICMS_URL . "/cache/" . $this->handler->_moduleName . "/" . $this->handler->_itemname . "/thumbs/";
	}

	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
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
	
	public function getVisitorvoiceImage($thumb = FALSE) {
		global $visitorvoiceConfig;
		$visitorvoice_img = $cached_img = $cached_image_url = $srcpath = $image = "";
		$visitorvoice_img = $this->getVar('visitorvoice_image', 'e');
		if(!$visitorvoice_img == "" && !$visitorvoice_img == "0") {
			$cached_img = ($thumb == FALSE) ? $this->_visitorvoice_images . $visitorvoice_img : $this->_visitorvoice_thumbs . $visitorvoice_img;
			$cached_image_url = ($thumb == FALSE) ? $this->_visitorvoice_images_url . $visitorvoice_img : $this->_visitorvoice_thumbs_url . $visitorvoice_img;
			if(!is_file($cached_img)) {
			    require_once ICMS_MODULES_PATH.'/'.VISITORVOICE_DIRNAME.'/class/Image.php';
				$srcpath = VISITORVOICE_UPLOAD_ROOT . $this->handler->_itemname . "/";
				$image = new mod_visitorvoice_Image($visitorvoice_img, $srcpath);
				$resized = $image->resizeImage( ($thumb == FALSE) ? $visitorvoiceConfig['display_width'] : $visitorvoiceConfig['thumbnail_width'], 
										($thumb == FALSE) ? $visitorvoiceConfig['display_height'] : $visitorvoiceConfig['thumbnail_height'],
										($thumb == FALSE) ? $this->_visitorvoice_images : $this->_visitorvoice_thumbs, "100");
				unset($srcpath, $image, $resized);
			}
			unset($cached_img, $visitorvoice_img, $thumb);
			return $cached_image_url;
		}
		return FALSE;
	}

	public function getMessageTeaser() {
		$ret = $this->getVar("visitorvoice_entry", "s");
		$ret = icms_core_DataFilter::icms_substr(icms_cleanTags($ret, array()), 0, 120);
		return $ret;
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
	
	public function getIP() {
		global $visitorvoice_isAdmin;
		return ($visitorvoice_isAdmin) ? $this->getVar("visitorvoice_ip") : FALSE;
	}
	
	public function getVisitorvoiceEmail() {
		global $visitorvoiceConfig, $visitorvoice_isAdmin;
		if($visitorvoiceConfig['show_email'] == 0 && !$visitorvoice_isAdmin) return FALSE;
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
	function getPublisher() {
		$uid = $this->getVar('visitorvoice_uid', 'e');
		$users = $this->handler->loadUsers();
		$user = (array_key_exists($uid, $users) && $uid > 0 ) ? $users[$uid] : FALSE;
		if($user) return $user;
		$userinfo = array();
		$userinfo['link'] = ucwords($this->getVar("visitorvoice_name"));
		$email = ($this->getVar("visitorvoice_email") !== "") ? $this->getVar("visitorvoice_email") : FALSE;
		$userinfo['avatar'] = ($email) ? "http://www.gravatar.com/avatar/" . md5(strtolower($email)) . "?d=identicon" : VISITORVOICE_URL."images/blank_gravatar.png";
		return $userinfo;
	}
	
	public function getPublishedDate() {
		global $visitorvoiceConfig;
		$date = $this->getVar('visitorvoice_published_date', 'e');
		return date($visitorvoiceConfig['visitorvoice_dateformat'], $date);
	}
	
	public function isApproved() {
		return ($this->getVar("visitorvoice_approve") == 1) ? TRUE : FALSE;
	}
	
	public function getApproved() {
		return (!$this->isApproved()) ? "visitorvoice_approval" : "";
	}
	
	public function hasSubs() {
		return ($this->getVar("visitorvoice_hassub")) ? TRUE : FALSE;
	}
	
	public function getSubEntries($toArray = FALSE) {
		global $visitorvoiceConfig;
		if(($visitorvoiceConfig['use_moderation'] == 1) && $this->hasSubs()) {
			$pid = $this->id();
			return $this->handler->getSubEntries(TRUE, $pid, $toArray);
		}
	}
	
	public function getItemLink($urlonly = FALSE) {
		$id = $this->id();
		$title = $this->title();
		if($urlonly) {
			$link = VISITORVOICE_URL . '#entry_' . $id;
		} else {
			$link = '<a href="' . VISITORVOICE_URL . '#entry_' . $id . '" title="' . $title . '">' . $title . '</a>';
		}
		return $link;
	}

	public function hasImage() {
		return (($this->getVar("visitorvoice_image") !== "") && ($this->getVar("visitorvoice_image") !== "0")) ? TRUE : FALSE;
	}

	public function toArray() {
		global $visitorvoiceConfig;
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['published_on'] = $this->getPublishedDate();
		$ret['published_by'] = $this->getPublisher();
		$ret['img'] = $this->getVisitorvoiceImage();
		$ret['thumb'] = $this->getVisitorvoiceImage(TRUE);
		$ret['homepage'] = $this->getVar("visitorvoice_url");
		$ret['email'] = $this->getVisitorvoiceEmail();
		$ret['ip'] = $this->getIP();
		$ret['title'] = $this->title();
		$ret['message'] = $this->summary();
		$ret['teaser'] = $this->getMessageTeaser();
		$ret['avatar'] = ($visitorvoiceConfig['show_avatar'] == 1) ? TRUE : FALSE;
		$ret['parent'] = $this->getVar("visitorvoice_pid", "e");
		if($visitorvoiceConfig['use_moderation'] == 1){
			$ret['sub'] = $this->getSubEntries(TRUE);
			$ret['hassub'] = $this->hasSubs();
		}
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['approved'] = $this->getApproved();
		$ret['has_image'] = $this->hasImage();
		return $ret;
	}

	public function sendMessageApproved() {
		$user = $this->getVar("visitorvoice_uid", "e");
		if($user <= 0) return TRUE;
		$pm_handler = icms::handler('icms_data_privmessage');
		$file = "visitorvoice_approved.tpl";
		$lang = "language/" . $icmsConfig['language'] . "/mail_template";
		$tpl = VISITORVOICE_ROOT_PATH . "$lang/$file";
		if (!file_exists($tpl)) {
			$lang = 'language/english/mail_template';
			$tpl = VISITORVOICE_ROOT_PATH . "$lang/$file";
		}
		$message = file_get_contents($tpl);
		$message = str_replace("{ENTRY_LINK}", $this->title(), $message);
		$uname = icms::handler('icms_member_user')->get($user)->getVar("uname");
		$message = str_replace("{X_UNAME}", $uname, $message);
		$pmObj = $pm_handler->create(TRUE);
		$pmObj->setVar("subject", _CO_ENTRY_HAS_APPROVED);
		$pmObj->setVar("from_userid", 1);
		$pmObj->setVar("to_userid", (int)$user);
		$pmObj->setVar("msg_time", time());
		$pmObj->setVar("msg_text", $message);
		$pm_handler->insert($pmObj, TRUE);
		return TRUE;
	}
}