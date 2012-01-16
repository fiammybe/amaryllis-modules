<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /class/Career.php
 * 
 * Class representing Career career Objects
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

class CareerCareer extends icms_ipf_seo_Object {
	
	public function __construct(&$handler) {
		icms_ipf_Object::__construct($handler);
		
		$this->quickInitVar("career_id", XOBJ_DTYPE_INT);
		$this->quickInitVar("career_title", XOBJ_DTYPE_TXTBOX);
		$this->initCommonVar("short_url");
		$this->quickInitVar("career_did", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_summary", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("career_description", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("career_rev_num", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_cname", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_uid", XOBJ_DTYPE_ARRAY);
		$this->quickInitVar("career_cpos", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_ctel", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_cfax", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_cemail", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_ccounty", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_czip", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_ccity", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_caddress", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_p_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("career_u_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("career_submitter", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_updater", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("career_active", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->initCommonVar("counter", FALSE);
		$this->initCommonVar("weight", FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doxcode", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		
		$this->setControl("career_did", array("name" => "select", "itemHandler" => "department", "method" => "getDepartmentList", "module" => "career"));
		$this->setControl("career_active", "yesno");
		$this->setControl("career_summary", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("career_description", "dhtmltextarea");
		$this->setControl("career_uid", "user_multi");
		
		$this->hideFieldFromForm(array("career_submitter", "career_updater", "career_p_date", "career_u_date"));
		$this->hideFieldFromSingleView(array("dohtml", "doxcode", "doimage", "dosmiley", "weight"));
		
		$this->initiateSEO();
	}
	
	public function career_active() {
		$active = $this->getVar("career_active", "e");
		if ($active == false) {
			return '<a href="' . CAREER_ADMIN_URL . 'career.php?career_id=' . $this->getVar("career_id") . '&amp;op=visible">
				<img src="' . CAREER_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . CAREER_ADMIN_URL . 'career.php?career_id=' . $this->getVar("career_id") . '&amp;op=visible">
				<img src="' . CAREER_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function getCareerWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( "weight", "e" ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	/**
	 * preparing some fields for output
	 */
	public function getCareerDid($itemlink = FALSE) {
		$did = $this->getVar("career_did", "e");
		$career_department_handler = icms_getModuleHandler("department", basename(dirname(dirname(__FILE__))), "career");
		$department = $career_department_handler->get($did);
		if($itemlink == FALSE) {
			$ret = $department->getVar("department_title");
		} else {
			$ret = $department->getItemLink(FALSE);
		}
		return $ret;
	}
	
	public function getCareerSummary() {
		$summary = $this->getVar("career_summary", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "output");
		return $summary;
	}
	
	public function getCareerDsc() {
		$summary = $this->getVar("career_description", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "output");
		return $summary;
	}
	
	public function getCareerMail() {
		$mail = $this->getVar("career_cemail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 1, 0);
		return $mail;
	}
	
	function getCareerSubmitter () {
		return icms_member_user_Handler::getUserLink($this->getVar("career_submitter", "e"));
	}
	
	function getCareerUpdater () {
		return icms_member_user_Handler::getUserLink($this->getVar("career_updater", "e"));
	}
	
	public function getCareerPublishedDate() {
		global $careerConfig;
		$date = $this->getVar("career_p_date", "e");
		return date($careerConfig['career_dateformat'], $date);
	}
	
	public function getCareerUpdatedDate() {
		global $careerConfig;
		$date = $this->getVar("career_u_date", "e");
		if($date != 0) {
			return date($careerConfig['career_dateformat'], $date);
		}
	}
	
	function getItemLink($onlyUrl = false) {
		$seo = $this->handler->makelink($this);
		$url = CAREER_URL . 'career.php?career_id=' . $this -> getVar("career_id", "e") . '&amp;career=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar("career_id", "e") . ' ">' . $this -> getVar( "career_title" ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . CAREER_ADMIN_URL . 'career.php?op=view&amp;career_id=' . $this->getVar("career_id", "e") . '" title="' . _CO_CAREER_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . CAREER_URL . 'career.php?career_id=' . $this->getVar("career_id", "e") . '" title="' . _CO_CAREER_PREVIEW . '" target="_blank">' . $this->getVar("career_title", "e") . '</a>';
		return $ret;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("career_id", "e");
		$ret['title'] = $this->getVar("career_title", "e");
		$ret['department'] = $this->getCareerDid(TRUE);
		$ret['summary'] = $this->getCareerSummary();
		$ret['dsc'] = $this->getCareerDsc();
		$ret['rev_num'] = $this->getVar("career_rev_num", "e");
		$ret['cname'] = $this->getVar("career_cname", "e");
		$ret['cpos'] = $this->getVar("career_cpos", "e");
		$ret['phone'] = $this->getVar("career_ctel", "e");
		$ret['fax'] = $this->getVar("career_cfax", "e");
		$ret['mail'] = $this->getCareerMail();
		$ret['county'] = $this->getVar("career_ccounty", "e");
		$ret['zip'] = $this->getVar("career_czip", "e");
		$ret['city'] = $this->getVar("career_ccity", "e");
		$ret['caddress'] = $this->getVar("career_caddress", "e");
		$ret['submitter'] = $this->getCareerSubmitter();
		$ret['updater'] = $this->getCareerUpdater();
		$ret['published_on'] = $this->getCareerPublishedDate();
		$ret['updated_on'] = $this->getCareerUpdatedDate();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		
		return $ret;
	}
}