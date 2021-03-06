<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/IndexpageHandler.php
 *
 * Classes responsible for managing album indexpage objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_album_IndexpageHandler extends icms_ipf_Handler {

	public $_moduleName;

	public $_uploadPath;

	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "indexpage", "index_key", "index_header", "index_heading", ALBUM_DIRNAME);
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, 2000000, 500, 500);

	}

	public function getImagePath() {
		$dir = $this->_uploadPath.$this->_itemname;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir."/";
	}

	static public function getImageList() {
		$indeximages = array();
		$indeximages = icms_core_Filesystem::getFileList(ALBUM_UPLOAD_ROOT . 'indexpage/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($indeximages) as $i ) {
			$ret[$i] = $indeximages[$i];
		}
		return $ret;
	}

	protected function beforeInsert(&$obj) {
		if ($obj->getVar('index_img_upload') != '') {
			$obj->setVar('index_image', $obj->getVar('index_img_upload') );
			$obj->setVar('index_img_upload', "" );
		}
		return TRUE;
	}

	protected function beforeUpdate(&$obj) {
		if ($obj->getVar('index_img_upload') != '') {
			$obj->setVar('index_image', $obj->getVar('index_img_upload') );
			$obj->setVar('index_img_upload', "" );
		}
		return TRUE;
	}
}