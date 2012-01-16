<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /class/Department.php
 * 
 * Class representing Career indexpage Objects
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

class CareerDepartment extends icms_ipf_Object {
	
	public $updating_counter = FALSE;
	
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);
		
		$this->quickInitVar("department_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("department_title", XOBJ_DTYPE_TXTBOX);
		$this->initCommonVar("short_url");
		$this->quickInitVar("department_logo", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_logo_upl", XOBJ_DTYPE_IMAGE);
		$this->quickInitVar("department_summary", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("department_description", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("department_leader", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_phone", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_fax", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_mail", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_address", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_kanton", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_zipcode", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_city", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("department_submitter", XOBJ_DTYPE_INT);
		$this->quickInitVar("department_updater", XOBJ_DTYPE_INT);
		$this->quickInitVar("department_p_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("department_u_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("department_active", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->initCommonVar("weight");
		$this->initCommonVar("counter", FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doxcode", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		
		$this->setControl("department_logo", array("name" => "select", "itemHandler" => "department", "method" => "getImageList", "module" => "career"));
		$this->setControl("department_summary", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("department_description", "dhtmltextarea");
		$this->setControl("department_active", "yesno");
		$this->setControl("department_logo_upl", "image");
		
		$this->hideFieldFromForm(array("department_p_date", "department_u_date", "department_submitter", "department_updater"));
		$this->hideFieldFromSingleView(array("dohtml", "doxcode", "doimage", "dosmiley"));
		
	}

	public function department_active() {
		$active = $this->getVar("department_active", "e");
		if ($active == false) {
			return '<a href="' . CAREER_ADMIN_URL . 'department.php?department_id=' . $this->getVar("department_id") . '&amp;op=visible">
				<img src="' . CAREER_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . CAREER_ADMIN_URL . 'department.php?department_id=' . $this->getVar("department_id") . '&amp;op=visible">
				<img src="' . CAREER_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function getDepartmentWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( "weight", "e" ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	/**
	 * preparing some fields for output
	 */
	
	public function getDepartmentLogo() {
		$logo = $image_tag = '';
		$logo = $this->getVar("department_logo", "e");
		if (!empty($logo)) {
			$image_tag = CAREER_UPLOAD_URL . 'department/' . $logo;
			return $image_tag;
		}
	}
	
	public function getDepartmentSummary() {
		$summary = $this->getVar("department_summary", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "output");
		return $summary;
	}
	
	public function getDepartmentDsc() {
		$summary = $this->getVar("department_description", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "output");
		return $summary;
	}
	
	public function getDepartmentMail() {
		$mail = $this->getVar("department_mail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		return $mail;
	}
	
	function getDepartmentSubmitter () {
		return icms_member_user_Handler::getUserLink($this->getVar("department_submitter", "e"));
	}
	
	function getDepartmentUpdater () {
		return icms_member_user_Handler::getUserLink($this->getVar("department_updater", "e"));
	}
	
	public function getDepartmentPublishedDate() {
		global $careerConfig;
		$date = $this->getVar("department_p_date", "e");
		return date($careerConfig['career_dateformat'], $date);
	}
	
	public function getDepartmentUpdatedDate() {
		global $careerConfig;
		$date = $this->getVar("department_u_date", "e");
		if($date != 0) {
			return date($careerConfig['career_dateformat'], $date);
		}
	}
	
	function getItemLink($onlyUrl = false) {
		$seo = $this->handler->makelink($this);
		$url = CAREER_URL . 'index.php?department_id=' . $this -> getVar("department_id", "e") . '&amp;department=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar("department_title", "e") . ' ">' . $this -> getVar( "department_title" ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . CAREER_ADMIN_URL . 'department.php?op=view&amp;department_id=' . $this->getVar("department_id", "e") . '" title="' . _CO_CAREER_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . CAREER_URL . 'index.php?department_id=' . $this->getVar("department_id", "e") . '" title="' . _CO_CAREER_PREVIEW . '" target="_blank">' . $this->getVar("department_title", "e") . '</a>';
		return $ret;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("department_id", "e");
		$ret['title'] = $this->getVar("department_title", "e");
		$ret['logo'] = $this->getDepartmentLogo();
		$ret['summary'] = $this->getDepartmentSummary();
		$ret['dsc'] = $this->getDepartmentDsc();
		$ret['leader'] = $this->getVar("department_leader", "e");
		$ret['phone'] = $this->getVar("department_phone", "e");
		$ret['fax'] = $this->getVar("department_fax", "e");
		$ret['mail'] = $this->getDepartmentMail();
		$ret['county'] = $this->getVar("department_kanton", "e");
		$ret['zip'] = $this->getVar("department_zipcode", "e");
		$ret['city'] = $this->getVar("department_city", "e");
		$ret['address'] = $this->getVar("department_address", "e");
		$ret['submitter'] = $this->getDepartmentSubmitter();
		$ret['updater'] = $this->getDepartmentUpdater();
		$ret['published_on'] = $this->getDepartmentPublishedDate();
		$ret['updated_on'] = $this->getDepartmentUpdatedDate();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		
		return $ret;
	}


}
