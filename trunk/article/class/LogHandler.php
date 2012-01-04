<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/LogHandler.php
 * 
 * Classes responsible for managing Article log objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
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

class ArticleLogHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "log", "log_id", "log_item_id", "log_item", "article");

	}
	
	public function clearLogDB($value='') {
		$time = ( time() - ( 86400 * intval( $articleConfig['downloads_daysnew'] ) ) );
		
	}
	
	
	protected function beforeSafe(&$obj) {
		$item_id = $obj->getVar("log_item_id");
		$item = $obj->getVar("log_item");
		$case = $obj->getVar("log_case");
		
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("log_item_id", $item_id));
		$criteria->add(new icms_db_criteria_Item("log_item", $item));
		$criteria->add(new icms_db_criteria_Item("log_case", $case));
		$log_total = $this->getCount($criteria);
		
	}


}