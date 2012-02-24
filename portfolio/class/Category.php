<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /class/Category.php
 * 
 * Class representing Portfolio indexpage Objects
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

class PortfolioCategory extends icms_ipf_Object {
	
	public $updating_counter = FALSE;
	
	public function __construct(&$handler) {
		icms_ipf_Object::__construct($handler);
		
		$this->quickInitVar("category_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("category_title", XOBJ_DTYPE_TXTBOX);
		$this->initCommonVar("short_url");
		$this->quickInitVar("category_logo", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("category_logo_upl", XOBJ_DTYPE_IMAGE);
		$this->quickInitVar("category_description", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("category_submitter", XOBJ_DTYPE_INT);
		$this->quickInitVar("category_updater", XOBJ_DTYPE_INT);
		$this->quickInitVar("category_p_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("category_u_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("category_active", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->initCommonVar("weight");
		$this->initCommonVar("counter", FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doxcode", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		
		$this->setControl("category_logo", array("name" => "select", "itemHandler" => "category", "method" => "getImageList", "module" => "portfolio"));
		$this->setControl("category_summary", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("category_description", "dhtmltextarea");
		$this->setControl("category_active", "yesno");
		$this->setControl("category_logo_upl", "imageupload");
		
		$this->hideFieldFromForm(array("category_p_date", "category_u_date", "category_submitter", "category_updater"));
		$this->hideFieldFromSingleView(array("dohtml", "doxcode", "doimage", "dosmiley"));
		
	}

	public function category_active() {
		$active = $this->getVar("category_active", "e");
		if ($active == FALSE) {
			return '<a href="' . PORTFOLIO_ADMIN_URL . 'category.php?category_id=' . $this->getVar("category_id") . '&amp;op=visible">
				<img src="' . PORTFOLIO_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . PORTFOLIO_ADMIN_URL . 'category.php?category_id=' . $this->getVar("category_id") . '&amp;op=visible">
				<img src="' . PORTFOLIO_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function getCategoryWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( "weight", "e" ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	/**
	 * preparing some fields for output
	 */
	
	public function getCategoryLogo() {
		$logo = $image_tag = '';
		$logo = $this->getVar("category_logo", "e");
		if (!empty($logo)) {
			$image_tag = PORTFOLIO_UPLOAD_URL . 'categoryimages/' . $logo;
			return $image_tag;
		}
	}
	
	public function getCategoryDsc() {
		$catdsc = $this->getVar("category_description", "s");
		$catdsc = icms_core_DataFilter::checkVar($catdsc, "html", "output");
		return $catdsc;
	}
	
	function getCategorySubmitter () {
		return icms_member_user_Handler::getUserLink($this->getVar("category_submitter", "e"));
	}
	
	function getCategoryUpdater () {
		return icms_member_user_Handler::getUserLink($this->getVar("category_updater", "e"));
	}
	
	public function getCategoryPublishedDate() {
		global $portfolioConfig;
		$date = $this->getVar("category_p_date", "e");
		return date($portfolioConfig['portfolio_dateformat'], $date);
	}
	
	public function getCategoryUpdatedDate() {
		global $portfolioConfig;
		$date = $this->getVar("category_u_date", "e");
		if($date != 0) {
			return date($portfolioConfig['portfolio_dateformat'], $date);
		}
	}
	
	function getItemLink($onlyUrl = FALSE) {
		$seo = $this->handler->makelink($this);
		$url = PORTFOLIO_URL . 'category.php?category_id=' . $this -> getVar("category_id", "e") . '&amp;category=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar("category_title", "e") . ' ">' . $this -> getVar( "category_title" ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . PORTFOLIO_ADMIN_URL . 'category.php?op=view&amp;category_id=' . $this->getVar("category_id", "e") . '" title="' . _CO_PORTFOLIO_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . PORTFOLIO_URL . 'category.php?category_id=' . $this->getVar("category_id", "e") . '" title="' . _CO_PORTFOLIO_PREVIEW . '" target="_blank">' . $this->getVar("category_title", "e") . '</a>';
		return $ret;
	}
	
	public function accessGranted() {
		$active = $this->getVar("category_active", "e");
		return ($active == TRUE) ? TRUE : FALSE;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("category_id", "e");
		$ret['title'] = $this->getVar("category_title", "e");
		$ret['logo'] = $this->getCategoryLogo();
		$ret['dsc'] = $this->getCategoryDsc();
		$ret['submitter'] = $this->getCategorySubmitter();
		$ret['updater'] = $this->getCategoryUpdater();
		$ret['published_on'] = $this->getCategoryPublishedDate();
		$ret['updated_on'] = $this->getCategoryUpdatedDate();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		
		return $ret;
	}


}