<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /class/Message.php
 * 
 * Class representing Career message Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class CareerMessage extends icms_ipf_Object {
	
	public function __construct(&$handler) {
		icms_ipf_Object::__construct($handler);
		
		$this->quickInitVar("message_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("message_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("message_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("message_mail", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("message_phone", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("message_body", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("message_file", XOBJ_DTYPE_FILE, TRUE);
		$this->quickInitVar("message_submitter", XOBJ_DTYPE_INT);
		$this->quickInitVar("message_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("message_cid", XOBJ_DTYPE_INT);
		$this->quickInitVar("message_did", XOBJ_DTYPE_INT);
		$this->quickInitVar("message_approve", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->quickInitVar("message_favorite", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 0);
		$this->quickInitVar("message_comments", XOBJ_DTYPE_INT);
		
		$this->setControl("message_approve", "yesno");
		$this->setControl("message_favorite", "yesno");
		$this->setControl("message_file", "file");
		$this->setControl("message_body", "dhtmltextarea");
		$this->hideFieldFromForm(array("message_submitter", "message_date", "message_cid", "message_did", "message_approve", "message_favorite", "message_comments"));
	}

	public function message_approve() {
		$approve = $this->getVar("message_approve", "e");
		if ($approve == FALSE) {
			return '<a href="' . CAREER_ADMIN_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeApprove">
				<img src="' . CAREER_IMAGES_URL . 'approved.png" alt="Rejected" /></a>';
		} else {
			return '<a href="' . CAREER_ADMIN_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeApprove">
				<img src="' . CAREER_IMAGES_URL . 'denied.png" alt="Possible" /></a>';
		}
	}
	
	public function message_approve_userside() {
		$approve = $this->getVar("message_approve", "e");
		if ($approve == FALSE) {
			return '<a href="' . CAREER_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeApprove">
				<img src="' . CAREER_IMAGES_URL . 'approved.png" alt="Rejected" /></a>';
		} else {
			return '<a href="' . CAREER_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeApprove">
				<img src="' . CAREER_IMAGES_URL . 'denied.png" alt="Possible" /></a>';
		}
	}
	
	public function message_favorite() {
		$favorite = $this->getVar("message_favorite", "e");
		if ($favorite == FALSE) {
			return '<a href="' . CAREER_ADMIN_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeFavorite">
				<img src="' . CAREER_IMAGES_URL . 'favorite.png" alt="Neutral" /></a>';
		} else {
			return '<a href="' . CAREER_ADMIN_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeFavorite">
				<img src="' . CAREER_IMAGES_URL . 'neutral.png" alt="Favorite" /></a>';
		}
	}
	
	public function message_favorite_userside() {
		$favorite = $this->getVar("message_favorite", "e");
		if ($favorite == FALSE) {
			return '<a href="' . CAREER_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeFavorite">
				<img src="' . CAREER_IMAGES_URL . 'favorite.png" alt="Neutral" /></a>';
		} else {
			return '<a href="' . CAREER_URL . 'message.php?message_id=' . $this->getVar("message_id") . '&amp;op=changeFavorite">
				<img src="' . CAREER_IMAGES_URL . 'neutral.png" alt="Favorite" /></a>';
		}
	}
	
	public function getMessageMail() {
		$mail = $this->getVar("message_mail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$title = $this->getVar("message_title", "e");
		return '<a href="maito:' . $mail . '?subject=RE: ' . $title . '" title="' . _CO_CAREER_MESSAGE_REPLY . '">' . $mail . '</a>';
	}
	
	public function getMessageBody() {
		$body = $this->getVar("message_body", "s");
		$body = icms_core_DataFilter::checkVar($body, "html", "output");
		return $body;
	}
	
	public function getMessageFile() {
		$file = 'message_file';
		$fileObj = $this->getFileObj($file);
		$filelink = $fileObj->getVar("url", "e");
		$titlelink = explode("/",$filelink);
		$last = (isset($titlelink[count($titlelink)-1])) ? $titlelink[count($titlelink)-1] : null;
		$url = '<a class="btn download" href="' . $filelink . '" title="' . $last . '" rel="external"> ' . $last . '</a>';
		return $url;
	}
	
	public function getMessageSubmitter () {
		return icms_member_user_Handler::getUserLink($this->getVar("message_submitter", "e"));
	}
	
	public function getMessageDate() {
		global $careerConfig;
		$date = $this->getVar("message_date", "e");
		return date($careerConfig['career_dateformat'], $date);
	}
	
	public function getMessageCid() {
		$career_career_handler = icms_getModuleHandler("career", basename(dirname(dirname(__FILE__))), "career");
		$cid = $this->getVar("message_cid", "e");
		$career = $career_career_handler->get($cid);
		return $career->getItemLink(FALSE);
	}
	
	public function getMessageDepartment() {
		$career_career_handler = icms_getModuleHandler("career", basename(dirname(dirname(__FILE__))), "career");
		$cid = $this->getVar("message_cid", "e");
		$career = $career_career_handler->get($cid);
		$department = $career->getCareerDid(TRUE);
		return $department;
	}
	
	public function getItemLink($onlyUrl = FALSE) {
		$url = CAREER_URL . 'message.php?message_id=' . $this->getVar("message_id", "e");
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this->getVar("message_title", "e") . ' ">' . $this -> getVar( "message_title" ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . CAREER_ADMIN_URL . 'message.php?op=view&amp;message_id=' . $this->getVar("message_id", "e") . '" title="' . _CO_CAREER_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . CAREER_URL . 'message.php?op=view&message_id=' . $this->getVar("message_id", "e") . '" title="' . _CO_CAREER_PREVIEW . '">' . $this->getVar("message_title", "e") . '</a>';
		return $ret;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("message_id", "e");
		$ret['title'] = $this->getVar("message_title", "e");
		$ret['name'] = $this->getVar("message_name", "e");
		$ret['mail'] = $this->getMessageMail();
		$ret['phone'] = $this->getVar("message_phone", "e");
		$ret['message'] = $this->getMessageBody();
		$ret['file'] = $this->getMessageFile();
		$ret['submitter'] = $this->getMessageSubmitter();
		$ret['date'] = $this->getMessageDate();
		$ret['career'] = $this->getMessageCid();
		$ret['department'] = $this->getMessageDepartment();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		return $ret;
	}
}