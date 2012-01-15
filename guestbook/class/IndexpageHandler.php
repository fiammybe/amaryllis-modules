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

		$this->_uploadPath = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/indeximages/';
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, 2000000, 900, 900);
		
	}
	
	public function getImagePath() {
		$dir = $this->_uploadPath;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	static public function getImageList() {
		$indeximages = array();
		$indeximages = icms_core_Filesystem::getFileList(GUESTBOOK_UPLOAD_ROOT . 'indeximages/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($indeximages) as $i ) {
			$ret[$i] = $indeximages[$i];
		}
		return $ret;
	}
	
	// some related functions for storing
	protected function beforeSave(&$obj) {
		
		if ($obj->getVar('index_img_upload') != '') {
			$obj->setVar('index_image', $obj->getVar('index_img_upload') );
		}
		return true;
	}
	
}
