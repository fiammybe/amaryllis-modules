<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /class/IndexpageHandler.php
 * 
 * Classes responsible for managing Guestbook indexpage objects
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

class GuestbookIndexpageHandler extends icms_ipf_Handler {
	
	public $_moduleName;
	
	public $_uploadPath;

	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "indexpage", "index_key", "index_header", "index_heading", "guestbook");
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, 2000000, 900, 900);
		
	}
	
	static public function getImageList() {
		$indeximages = array();
		$indeximages = icms_core_Filesystem::getFileList(GUESTBOOK_UPLOAD_ROOT . 'indexpage/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($indeximages) as $i ) {
			$ret[$i] = $indeximages[$i];
		}
		return $ret;
	}
	
	protected function beforeInsert(&$obj) {
		$heading = $obj->getVar("index_heading", "e");
		$heading = icms_core_DataFilter::checkVar($heading, "html", "input");
		$obj->setVar("index_heading", $heading);
		$footer = $obj->getVar("index_footer", "e");
		$footer = icms_core_DataFilter::checkVar($footer, "html", "input");
		$obj->setVar("index_footer", $footer);
		if ($obj->getVar('index_img_upload') != '') {
			$obj->setVar('index_image', $obj->getVar('index_img_upload') );
			$obj->setVar('index_img_upload', "" );
		}
		return TRUE;
	}

	protected function beforeUpdate(&$obj) {
		$heading = $obj->getVar("index_heading", "e");
		$heading = icms_core_DataFilter::checkVar($heading, "html", "input");
		$obj->setVar("index_heading", $heading);
		$footer = $obj->getVar("index_footer", "e");
		$footer = icms_core_DataFilter::checkVar($footer, "html", "input");
		$obj->setVar("index_footer", $footer);
		if ($obj->getVar('index_img_upload') != '') {
			$obj->setVar('index_image', $obj->getVar('index_img_upload') );
			$obj->setVar('index_img_upload', "" );
		}
		return TRUE;
	}
}
