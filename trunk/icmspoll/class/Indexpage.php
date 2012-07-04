<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /class/Indexpage.php
 * 
 * Class representing icmspoll indexpage objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */
 
defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class IcmspollIndexpage extends icms_ipf_Object {
	
	private $index_heading;
	private $index_header;
	private $index_footer;
	private $index_image;
	
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("index_key", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("index_image", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar('index_img_upload', XOBJ_DTYPE_IMAGE);
		$this->quickInitVar("index_header", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("index_heading", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("index_footer", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("dobr", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, FALSE, FALSE, 1);

		$this->setControl( 'index_img_upload', 'imageupload' );
		$this -> setControl( 'index_heading','dhtmltextarea' );
		$this -> setControl( 'index_footer', 'textarea' );
		$this -> setControl( 'index_image', array( 'name' => 'select', 'itemHandler' => 'indexpage', 'method' => 'getImageList', 'module' => 'icmspoll' ) );
		
	}

	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}

	public function getIndexImg() {
		if(!$this->index_image) {
			$indeximage = $this->getVar('index_image', 'e');
			if (!$indeximage == "" && !$indeximage == "0") {
				$image_tag = ICMSPOLL_UPLOAD_URL . 'indexpage/' . $indeximage;
				$this->index_image = '<div class="icmspoll_indeximage"><img src="' . $image_tag . '" /></div>';
			}
		}
		return $this->index_image;
	}
	
	public function getIndexHeader() {
		if(!$this->index_header) {
			$indexheader = $this->getVar('index_header', 'e');
			if($indexheader != "") {
				$this->index_header = '<div class="icmspoll_indexheader">' . $indexheader . '</div>';
			}
		}
		return $this->index_header;
	}

	public function getIndexHeading() {
		if(!$this->index_heading) {
			$indexheading = icms_core_DataFilter::checkVar($this->getVar('index_heading', 's'), 'str', 'encodelow');
			if($indexheading != "") {
				$this->index_heading = '<div class="icmspoll_indexheading">' . $indexheading . '</div>';
			}
		}
		return $this->index_heading;
	}
	
	public function getIndexFooter() {
		if(!$this->index_footer) {
			$indexfooter = icms_core_DataFilter::checkVar($this->getVar('index_footer', 's'), 'str', 'encodelow');
			if($indexfooter != "") {
				$this->index_footer = '<div class="icmspoll_indexfooter">' . $indexfooter . '</div>';
			}
		}
		return $this->index_footer;
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