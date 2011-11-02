<?php
/**
 * Classes responsible for managing album indexpage objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class AlbumIndexpageHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "indexpage", "index_key", "index_header", "index_heading", "album");

	}
	
	static public function getImageList() {
		$indeximages = array();
		$indeximages = icms_core_Filesystem::getFileList(ALBUM_UPLOAD_ROOT . 'indeximages/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($indeximages) as $i ) {
			$ret[$i] = $indeximages[$i];
		}
		return $ret;
	}


}