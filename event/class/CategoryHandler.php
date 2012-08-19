<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /class/CategoryHandler.php
 * 
 * Classes responsible for managing event category objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_event_CategoryHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "category", "category_id", "category_name", "category_dsc", "event");
        $this->addPermission("cat_view", _CO_EVENT_CATEGORY_CAT_VIEW, _CO_EVENT_CATEGORY_CAT_VIEW_DSC);
        $this->addPermission("cat_submit", _CO_EVENT_CATEGORY_CAT_SUBMIT, _CO_EVENT_CATEGORY_CAT_SUBMIT_DSC);
	}
    
    public function getCategoryCriterias($perm = 'cat_submit') {
        $criteria = new icms_db_criteria_Compo();
		$this->setGrantedObjectsCriteria($criteria, $perm);
		return $criteria;
    }
	
	public function getCategories($perm = 'cat_view') {
		$criteria = $this->getCategoryCriterias($perm);
		$categories = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($categories as $category) {
			$ret[$category['id']] = $category;
		}
		return $ret;
	}


}