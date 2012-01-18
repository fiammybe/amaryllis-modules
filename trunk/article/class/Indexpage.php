<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/Indexpage.php
 * 
 * Class representing Article indexpage Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class ArticleIndexpage extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_article_Indexpage $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("index_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("index_header", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("index_heading", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("index_footer", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("index_img", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("index_img_upl", XOBJ_DTYPE_IMAGE, FALSE);
		$this->initCommonVar("dohtml");
		$this->initCommonVar("doimage");
		$this->initCommonVar("dosmiley");
		$this->initCommonVar("docxode");
		$this->setControl("index_image_upl", "image");

	}

	/**
	 * Overriding the icms_ipf_Object::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	/**
	 * preparing indexpage for output
	 */
	
	public function getIndexImg() {
		$indeximage = $image_tag = '';
		$indeximage = $this->getVar("index_image", "e");
		if (!empty($indeximage)) {
			$image_tag = ARTICLE_UPLOAD_URL . 'indeximages/' . $indeximage;
		}
		return '<div class="article_indeximage"><img src="' . $image_tag . '" class="indeximage" alt="indeximage" /></div>';
	}
	
	public function getIndexHeader() {
		$indexheader = $this->getVar("index_header", "e");
		return '<div class="article_indexheader">' . $indexheader . '</div>';
	}

	public function getIndexHeading() {
		$indexheading = $this->getVar("index_heading", "s");
		$indexheading = icms_core_DataFilter::checkVar($indexheading, "html", "output");
		return '<div class="article_indexheading">' . $indexheading . '</div>';
	}
	
	public function getIndexFooter() {
		$indexfooter = $this->getVar("index_footer", "s");
		$indexfooter = icms_core_DataFilter::checkVar($indexfooter, "html", "output");
		return '<div class="article_indexfooter">' . $indexfooter . '</div>';
	}

	function toArray() {
		$ret = parent::toArray();
		$ret['image'] = $this->getIndexImg();
		$ret['header'] = $this->getIndexHeader();
		$ret['heading'] = $this->getIndexHeading();
		$ret['footer'] = $this->getIndexFooter();
		return $ret;
	}
}