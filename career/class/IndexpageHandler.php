<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /class/IndexpageHandler.php
 * 
 * Classes responsible for managing Career indexpage objects
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

class CareerIndexpageHandler extends icms_ipf_Handler {
	
	public $_moduleName;
	
	public $_uploadPath;

	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "indexpage", "index_id", "index_header", "index_heading", "career");
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, 2000000, 500, 500);
		
	}

	static public function getImageList() {
		$indeximages = array();
		$indeximages = icms_core_Filesystem::getFileList(CAREER_UPLOAD_ROOT . 'indexpage/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($indeximages) as $i ) {
			$ret[$i] = $indeximages[$i];
		}
		return $ret;
	}
	
	public function beforeInsert(&$obj) {
		$footer = $obj->getVar("index_footer", "s");
		$footer = icms_core_DataFilter::checkVar($footer, "html", "input");
		$obj->setVar("index_footer", $footer);
		if ($obj->getVar('index_img_upload') != '') {
			$obj->setVar('index_image', $obj->getVar('index_img_upload') );
		}
		return TRUE;
	}
}