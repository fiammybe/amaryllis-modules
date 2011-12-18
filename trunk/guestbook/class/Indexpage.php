<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /class/Indexpage.php
 * 
 * Class representing Guestbook indexpage objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

class GuestbookIndexpage extends icms_ipf_Object {
	
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

		$this->setControl('index_img_upload', 'image');
		$this->setControl('index_heading','dhtmltextarea');
		$this->setControl('index_footer', 'textarea');
		$this->setControl('index_image', array( 'name' => 'select', 'itemHandler' => 'indexpage', 'method' => 'getImageList', 'module' => 'guestbook'));
		
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
			$image_tag = GUESTBOOK_UPLOAD_URL . 'indeximages/' . $indeximage;
		}
		return '<div class="guestbook_indeximage"><img src="' . $image_tag . '" /></div>';
	}
	
	public function getIndexHeader() {
		$indexheader = '';
		$indexheader = $this->getVar('index_header', 'e');
		return '<div class="guestbook_indexheader">' . $indexheader . '</div>';
	}

	public function getIndexHeading() {
		$indexheading = '';
		$indexheading = $this->getVar('index_heading', 'e');
		return '<div class="guestbook_indexheading">' . $indexheading . '</div>';
	}
	
	public function getIndexFooter() {
		$indexfooter = '';
		$indexfooter = $this->getVar('index_footer', 's');
		$indexfooter = icms_core_DataFilter::checkVar($indexfooter, "html", "output");
		return '<div class="guestbook_indexfooter">' . $indexfooter . '</div>';
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
	