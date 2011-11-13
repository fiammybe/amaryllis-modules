<?php
/**
 * 'Download' is a light weight download handling module for ImpressCMS
 *
 * File: /class/Indexpage.php
 * 
 * Class representing Download indexpage objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Download
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		download
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

class mod_download_Indexpage extends icms_ipf_seo_Object {
	
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

		$this->setControl( 'index_img_upload', array( 'name' => 'imageupload' ) );
		$this -> setControl( 'index_heading','dhtmltextarea' );
		$this -> setControl( 'index_footer', 'textarea' );
		$this -> setControl( 'index_image', array( 'name' => 'select', 'itemHandler' => 'indexpage', 'method' => 'getImageList', 'module' => 'downloads' ) );
		
		$this->hideFieldFromForm( array( 'index_key', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );
		$this->hideFieldFromSingleView( array( 'index_key', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );
	}

	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	public function get_indeximage_tag() {
		$indeximage = $image_tag = '';
		$indeximage = $this->getVar('index_image', 'e');
		if (!empty($indeximage)) {
			$image_tag = ALBUM_UPLOAD_URL . 'indeximages/' . $indeximage;
		}
		return $image_tag;
	}
	
}
	