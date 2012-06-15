<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/IndexpageHandler.php
 * 
 * Classes responsible for managing Article indexpage objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
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

class ArticleIndexpageHandler extends icms_ipf_Handler {
	
	public $_moduleName;
	
	public $_uploadPath;
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "indexpage", "index_id", "index_header", "index_heading", "article");
		$this->enableUpload(array("image/gif", "image/jpeg", "image/pjpeg", "image/png"), 512000, 800, 600);
	}

	static public function getImageList() {
		$indeximages = array();
		$indeximages = icms_core_Filesystem::getFileList(ARTICLE_UPLOAD_ROOT . 'indexpage/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($indeximages) as $i ) {
			$ret[$i] = $indeximages[$i];
		}
		return $ret;
	}
	
	public function beforeInsert(&$obj)	{
		if ($obj->getVar("index_img_upload", "e") != "") {
			$obj->setVar("index_img", $obj->getVar("index_img_upload"));
		}
		$indexfooter = $obj->getVar("index_footer", "s");
		$indexfooter = icms_core_DataFilter::checkVar($indexfooter, "html", "input");
		$obj->setVar("index_footer", $indexfooter);
		
		return TRUE;
	}
}