<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /class/Contact.php
 * 
 * Class representing Portfolio contact Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class PortfolioContact extends icms_ipf_Object {
	
	public function __construct(&$handler) {
		icms_ipf_Object::__construct($handler);
		
		$this->quickInitVar("contact_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("contact_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("contact_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("contact_mail", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("contact_phone", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("contact_body", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("contact_submitter", XOBJ_DTYPE_INT);
		$this->quickInitVar("contact_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("contact_isnew", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		
		$this->setControl("contact_body", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("contact_isnew", "yesno");
		$this->hideFieldFromForm(array("contact_submitter", "contact_date", "contact_isnew"));
	}
	
	public function contact_isnew() {
		$active = $this->getVar("contact_isnew", "e");
		if ($active == FALSE) {
			return '<a href="' . PORTFOLIO_ADMIN_URL . 'contact.php?contact_id=' . $this->getVar('contact_id') . '&amp;op=changeNew">
				<img src="' . PORTFOLIO_IMAGES_URL . 'denied.png" alt="unread" /></a>';
		} else {
			return '<a href="' . PORTFOLIO_ADMIN_URL . 'contact.php?contact_id=' . $this->getVar('contact_id') . '&amp;op=changeNew">
				<img src="' . PORTFOLIO_IMAGES_URL . 'approved.png" alt="read" /></a>';
		}
	}
	
	public function contact_isnew_userside() {
		$active = $this->getVar("contact_isnew", "e");
		if ($active == FALSE) {
			return '<a href="' . PORTFOLIO_URL . 'contact.php?contact_id=' . $this->getVar('contact_id') . '&amp;op=changeNew">
				<img src="' . PORTFOLIO_IMAGES_URL . 'denied.png" alt="unread" /></a>';
		} else {
			return '<a href="' . PORTFOLIO_URL . 'contact.php?contact_id=' . $this->getVar('contact_id') . '&amp;op=changeNew">
				<img src="' . PORTFOLIO_IMAGES_URL . 'approved.png" alt="read" /></a>';
		}
	}
	
	public function getContactMail() {
		$mail = $this->getVar("contact_mail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$title = $this->getVar("contact_title", "e");
		return '<a href="maito:' . $mail . '?subject=RE: ' . $title . '" title="' . _CO_PORTFOLIO_MESSAGE_REPLY . '">' . $mail . '</a>';
		
	}
	
	public function getContactBody() {
		$body = $this->getVar("contact_body", "s");
		$body = icms_core_DataFilter::checkVar($body, "html", "output");
		return $body;
	}
	
	public function getContactSubmitter () {
		return icms_member_user_Handler::getUserLink($this->getVar("contact_submitter", "e"));
	}
	
	public function getContactDate() {
		global $portfolioConfig;
		$date = $this->getVar("contact_date", "e");
		return date($portfolioConfig['portfolio_dateformat'], $date);
	}
	
	public function getItemLink($onlyUrl = false) {
		$url = PORTFOLIO_URL . 'contact.php?contact_id=' . $this->getVar("contact_id", "e");
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this->getVar("contact_title", "e") . ' ">' . $this -> getVar( "contact_title" ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . PORTFOLIO_ADMIN_URL . 'contact.php?op=view&amp;contact_id=' . $this->getVar("contact_id", "e") . '" title="' . _CO_PORTFOLIO_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . PORTFOLIO_URL . 'contact.php?op=view&contact_id=' . $this->getVar("contact_id", "e") . '" title="' . _CO_PORTFOLIO_PREVIEW . '">' . $this->getVar("contact_title", "e") . '</a>';
		return $ret;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("contact_id", "e");
		$ret['title'] = $this->getVar("contact_title", "e");
		$ret['name'] = $this->getVar("contact_name", "e");
		$ret['mail'] = $this->getContactMail();
		$ret['phone'] = $this->getVar("contact_phone", "e");
		$ret['body'] = $this->getContactBody();
		$ret['submitter'] = $this->getContactSubmitter();
		$ret['date'] = $this->getContactDate();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		return $ret;
	}
	
	public function sendMessageIncoming() {
		$group = icms_member_group_Handler::get("1");
		$uid = is_object(icms::$user) ? icms::$user : new icms_member_user_Object;
		$pmObj = new icms_messaging_Handler();
		$pmObj->setFromUser($uid);
		$pmObj->setToGroups($group);
		$pmObj->setBody(_CO_PORTFOLIO_PORTFOLIO_CONTACT_BDY);
		$pmObj->setSubject(_CO_CAREER_CAREER_MESSAGE_SBJ);
		$pmObj->usePM();
		$pmObj->send();
		
		return TRUE;
	}
}