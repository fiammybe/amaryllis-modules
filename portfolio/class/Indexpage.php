<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /class/Indexpage.php
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

class PortfolioIndexpage extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param PortfolioIndexpage $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("index_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("index_image", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar('index_img_upload', XOBJ_DTYPE_IMAGE);
		$this->quickInitVar("index_header", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("index_heading", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("index_footer", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("index_skills_1", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_2", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_3", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_4", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_5", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_6", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_7", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_8", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_9", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("index_skills_10", XOBJ_DTYPE_TXTBOX);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("dobr", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, FALSE, FALSE, 1);

		$this->setControl( 'index_img_upload', 'image' );
		$this -> setControl( 'index_heading','dhtmltextarea' );
		$this -> setControl( 'index_footer', 'textarea' );
		$this -> setControl( 'index_image', array( 'name' => 'select', 'itemHandler' => 'indexpage', 'method' => 'getImageList', 'module' => 'portfolio' ) );
		
	}

	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}

	public function getIndexImg() {
		$indeximage = $image_tag = '';
		$indeximage = $this->getVar('index_image', 'e');
		if (!empty($indeximage)) {
			$image_tag = PORTFOLIO_UPLOAD_URL . 'indeximages/' . $indeximage;
		}
		return '<div class="portfolio_indeximage"><img src="' . $image_tag . '" /></div>';
	}
	
	public function getIndexHeader() {
		$indexheader = '';
		$indexheader = $this->getVar('index_header', 'e');
		return '<div class="portfolio_indexheader">' . $indexheader . '</div>';
	}

	public function getIndexHeading() {
		$indexheading = '';
		$indexheading = icms_core_DataFilter::checkVar($this->getVar('index_heading', 's'), 'html', 'output');
		return '<div class="portfolio_indexheading">' . $indexheading . '</div>';
	}
	
	public function getIndexFooter() {
		$indexfooter = '';
		$indexfooter = icms_core_DataFilter::checkVar($this->getVar('index_footer', 's'), 'html', 'output');
		return '<div class="portfolio_indexfooter">' . $indexfooter . '</div>';
	}
	
	public function getSkill1() {
		$var = $this->getVar("index_skills_1", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill2() {
		$var = $this->getVar("index_skills_2", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill3() {
		$var = $this->getVar("index_skills_3", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill4() {
		$var = $this->getVar("index_skills_4", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill5() {
		$var = $this->getVar("index_skills_5", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill6() {
		$var = $this->getVar("index_skills_6", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill7() {
		$var = $this->getVar("index_skills_7", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill8() {
		$var = $this->getVar("index_skills_8", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill9() {
		$var = $this->getVar("index_skills_9", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}
	
	public function getSkill10() {
		$var = $this->getVar("index_skills_10", "s");
		if($var != "") {
			$skill_array = explode("|", $var);
			$skill = array();
			$skill['skill'] = $skill_array[0];
			$skill['value'] = $skill_array[1];
			return $skill;
		}
	}

	function toArray() {
		$ret = parent::toArray();
		$ret['image'] = $this->getIndexImg();
		$ret['header'] = $this->getIndexHeader();
		$ret['heading'] = $this->getIndexHeading();
		$ret['footer'] = $this->getIndexFooter();
		$ret['skill_1'] = $this->getSkill1();
		$ret['skill_2'] = $this->getSkill2();
		$ret['skill_3'] = $this->getSkill3();
		$ret['skill_4'] = $this->getSkill4();
		$ret['skill_5'] = $this->getSkill5();
		$ret['skill_6'] = $this->getSkill6();
		$ret['skill_7'] = $this->getSkill7();
		$ret['skill_8'] = $this->getSkill8();
		$ret['skill_9'] = $this->getSkill9();
		$ret['skill_10'] = $this->getSkill10();
		return $ret;
	}
}