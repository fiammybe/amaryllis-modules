<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /class/Portfolio.php
 * 
 * Class representing Portfolio portfolio Objects
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

class PortfolioPortfolio extends icms_ipf_seo_Object {
	
	public function __construct(&$handler) {
		global $portfolioConfig;
		icms_ipf_Object::__construct($handler);
		
		$this->quickInitVar("portfolio_id", XOBJ_DTYPE_INT);
		$this->quickInitVar("portfolio_title", XOBJ_DTYPE_TXTBOX);
		$this->initCommonVar("short_url");
		$this->quickInitVar("portfolio_cid", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("portfolio_summary", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("portfolio_show_summary", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->quickInitVar("portfolio_description", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("portfolio_img", XOBJ_DTYPE_IMAGE);
		$this->quickInitVar("portfolio_album", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("portfolio_customer", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("portfolio_url", XOBJ_DTYPE_URLLINK);
		$this->quickInitVar("portfolio_p_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("portfolio_u_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("portfolio_submitter", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("portfolio_updater", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("portfolio_active", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->initCommonVar("counter", FALSE);
		$this->initCommonVar("weight", FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doxcode", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		
		$this->setControl("portfolio_cid", array("name" => "select", "itemHandler" => "category", "method" => "getCategoryList", "module" => "portfolio"));
		$this->setControl("portfolio_summary", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("portfolio_description", "dhtmltextarea");
		$this->setControl("portfolio_img", "image");
		$this->setControl("portfolio_active", "yesno");
		$albumModule = icms_getModuleInfo("album");
		if($albumModule && $portfolioConfig['use_album'] == 1) {
			$this->setControl("portfolio_album", array("name" => "select", "itemHandler" => "album", "method" => "getAlbumListForPid", "module" => "album"));
		} else {
			$this->hideFieldFromForm("portfolio_album");
			$this->hideFieldFromSingleView("portfolio_album");
		}
		$this->hideFieldFromForm(array("portfolio_submitter", "portfolio_updater", "portfolio_p_date", "portfolio_u_date"));
		$this->hideFieldFromSingleView(array("dohtml", "doxcode", "doimage", "dosmiley", "weight"));
		
		$this->initiateSEO();
	}
	
	public function portfolio_active() {
		$active = $this->getVar("portfolio_active", "e");
		if ($active == false) {
			return '<a href="' . PORTFOLIO_ADMIN_URL . 'portfolio.php?portfolio_id=' . $this->getVar("portfolio_id") . '&amp;op=visible">
				<img src="' . PORTFOLIO_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . PORTFOLIO_ADMIN_URL . 'portfolio.php?portfolio_id=' . $this->getVar("portfolio_id") . '&amp;op=visible">
				<img src="' . PORTFOLIO_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function getPortfolioWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( "weight", "e" ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	/**
	 * preparing some fields for output
	 */
	public function getPortfolioCid($itemlink = FALSE) {
		$did = $this->getVar("portfolio_cid", "e");
		$portfolio_department_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "portfolio");
		$department = $portfolio_department_handler->get($did);
		if($itemlink == FALSE) {
			$ret = $department->getVar("category_title");
		} else {
			$ret = $department->getItemLink(FALSE);
		}
		return $ret;
	}
	
	public function getPortfolioSummary() {
		$summary = $this->getVar("portfolio_summary", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "output");
		return $summary;
	}
	
	public function getPortfolioDsc() {
		$display_summary = $this->getVar("portfolio_show_summary", "e");
		$dsc = $this->getVar("portfolio_description", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		if($display_summary == 0) {
			$body = $dsc;
		} else {
			$summary = $this->getPortfolioSummary();
			$body = $summary;
			$body .= $dsc;
		}
		return $body;
	}
	
	public function displayAlbum() {
		$album = $this->getVar("portfolio_album", "e");
		return ($album > 0) ? TRUE : FALSE;
	}
	
	public function getDemoLink() {
		if($this->getVar("portfolio_url") != 0) {
			$demo = 'portfolio_url';
			$linkObj = $this-> getUrlLinkObj($demo);
			$url = $linkObj->render();
			return $url;
		}
	}
	
	public function getPortfolioImageTag($singleview = TRUE, $catview = FALSE) {
		$portfolio_img = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$portfolio_img = $this->getVar('portfolio_img', 'e');
		if($singleview) {
			$document_root = str_replace('modules/' . $directory_name . '/portfolio.php', '', $script_name);
			if (!$portfolio_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/portfolio/' . $portfolio_img;
			}else {
				$image_tag = FALSE;
			}
		} elseif($catview) {
			$document_root = str_replace('modules/' . $directory_name . '/category.php', '', $script_name);
			if (!$portfolio_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/portfolio/' . $portfolio_img;
			} else {
				$image_tag = FALSE;
			}
		} else {
			$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);
			if (!$portfolio_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/portfolio/' . $portfolio_img;
			} else {
				$image_tag = FALSE;
			}
		}
		return $image_tag;
	}
	
	function getPortfolioSubmitter () {
		return icms_member_user_Handler::getUserLink($this->getVar("portfolio_submitter", "e"));
	}
	
	function getPortfolioUpdater () {
		return icms_member_user_Handler::getUserLink($this->getVar("portfolio_updater", "e"));
	}
	
	public function getPortfolioPublishedDate() {
		global $portfolioConfig;
		$date = $this->getVar("portfolio_p_date", "e");
		return date($portfolioConfig['portfolio_dateformat'], $date);
	}
	
	public function getPortfolioUpdatedDate() {
		global $portfolioConfig;
		$date = $this->getVar("portfolio_u_date", "e");
		if($date != 0) {
			return date($portfolioConfig['portfolio_dateformat'], $date);
		}
	}
	
	function getItemLink($onlyUrl = false) {
		$seo = $this->handler->makelink($this);
		$url = PORTFOLIO_URL . 'portfolio.php?portfolio_id=' . $this -> getVar("portfolio_id", "e") . '&amp;portfolio=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar("portfolio_title", "e") . ' ">' . $this -> getVar( "portfolio_title" ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . PORTFOLIO_ADMIN_URL . 'portfolio.php?op=view&amp;portfolio_id=' . $this->getVar("portfolio_id", "e") . '" title="' . _CO_PORTFOLIO_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . PORTFOLIO_URL . 'portfolio.php?portfolio_id=' . $this->getVar("portfolio_id", "e") . '" title="' . _CO_PORTFOLIO_PREVIEW . '" target="_blank">' . $this->getVar("portfolio_title", "e") . '</a>';
		return $ret;
	}
	
	public function accessGranted() {
		$active = $this->getVar("portfolio_active", "e");
		return ($active == TRUE) ? TRUE : FALSE;
	}
	
	public function getImagePath() {
		$image = $this->getVar("portfolio_img", "e");
		$url = ICMS_URL . "/uploads/" . basename(dirname(dirname(__FILE__))) . "/portfolio/" . $image;
		return $url;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("portfolio_id", "e");
		$ret['title'] = $this->getVar("portfolio_title", "e");
		$ret['imgpath'] = $this->getImagePath();
		$ret['img'] = $this->getPortfolioImageTag(TRUE, FALSE);
		$ret['index_img'] = $this->getPortfolioImageTag(FALSE, FALSE);
		$ret['cat_img'] = $this->getPortfolioImageTag(FALSE, TRUE);
		$ret['cat'] = $this->getPortfolioCid(TRUE);
		$ret['summary'] = $this->getPortfolioSummary();
		$ret['dsc'] = $this->getPortfolioDsc();
		$ret['customer'] = $this->getVar("portfolio_customer", "e");
		$ret['demo'] = $this->getDemoLink();
		$ret['submitter'] = $this->getPortfolioSubmitter();
		$ret['updater'] = $this->getPortfolioUpdater();
		$ret['published_on'] = $this->getPortfolioPublishedDate();
		$ret['updated_on'] = $this->getPortfolioUpdatedDate();
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['album'] = $this->displayAlbum();
		return $ret;
	}

}