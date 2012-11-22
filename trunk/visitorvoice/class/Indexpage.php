<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /class/Indexpage.php
 * 
 * Class representing Visitorvoice indexpage objects
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

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

class VisitorvoiceIndexpage extends icms_ipf_Object {
	
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("index_key", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("index_image", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->initVar('index_img_upload', XOBJ_DTYPE_IMAGE);
		$this->quickInitVar("index_header", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("index_heading", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("index_footer", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("dobr", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, FALSE, FALSE, 1);

		$this->setControl('index_img_upload', 'imageupload');
		$this->setControl('index_heading','dhtmltextarea');
		$this->setControl('index_footer', array('name' => 'textarea', 'form_editor' => 'htmlarea'));
		$this->setControl('index_image', array( 'name' => 'select', 'itemHandler' => 'indexpage', 'method' => 'getImageList', 'module' => 'visitorvoice'));
		
	}

	public function getIndexImg() {
		$indeximage = $image_tag = '';
		$indeximage = $this->getVar('index_image', 'e');
		if (!$indeximage == 0 && !$indeximage == "") {
			$image_tag = VISITORVOICE_UPLOAD_URL . 'indexpage/' . $indeximage;
			return '<div class="visitorvoice_indeximage"><img src="' . $image_tag . '" /></div>';
		}
	}
	
	public function getIndexHeader() {
		$indexheader = $this->getVar('index_header', 's');
		if($indexheader != "") {
			return '<div class="visitorvoice_indexheader">' . icms_core_DataFilter::undoHtmlSpecialChars($indexheader) . '</div>';
		}
		return false;
	}

	public function getIndexHeading() {
		$indexheading = '';
		$indexheading = $this->getVar('index_heading', 's');
		if($indexheading != "") {
			$indexheading = icms_core_DataFilter::checkVar($indexheading, "html", "output");
			return '<div class="visitorvoice_indexheading">' . icms_core_DataFilter::undoHtmlSpecialChars($indexheading) . '</div>';
		}
	}
	
	public function getIndexFooter() {
		$indexfooter = '';
		$indexfooter = $this->getVar('index_footer', 's');
		if($indexfooter != "") {
			$indexfooter = icms_core_DataFilter::checkVar($indexfooter, "html", "output");
			return '<div class="visitorvoice_indexfooter">' . icms_core_DataFilter::undoHtmlSpecialChars($indexfooter) . '</div>';
		}
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