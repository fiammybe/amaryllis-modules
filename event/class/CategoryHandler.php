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
    
    public function getCategoryCriterias($perm = "cat_submit", $cat_ids = FALSE) {
        $criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("category_approve", TRUE));
		if($cat_ids && is_array($cat_ids)) {
			$critTray = new icms_db_criteria_Compo();
			foreach ($cat_ids as $key => $value) {
				$critTray->add(new icms_db_criteria_Item("category_id", (int)$value), 'OR');
			}
			$criteria->add($critTray);
		} elseif($cat_ids && !is_array($cat_ids)) {
			$criteria->add(new icms_db_criteria_Item("category_id", (int)$cat_ids));
		} else {
			$cat_ids = $this->userView();
			$critTray = new icms_db_criteria_Compo();
			foreach ($cat_ids as $key => $value) {
				$critTray->add(new icms_db_criteria_Item("category_id", (int)$value), 'OR');
			}
			$criteria->add($critTray);
		}
		$this->setGrantedObjectsCriteria($criteria, "$perm");
		return $criteria;
    }
	
	public function getCategories($perm = "cat_submit", $cat_ids = FALSE) {
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$criteria = $this->getCategoryCriterias($perm, $cat_ids);
		$categories = $this->getObjects($criteria, FALSE, FALSE);
		$ret = array();
		foreach ($categories as $category) {
			$ret[$category['id']] = $category;
		}
		return $ret;
	}
	
	public function userSubmit() {
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$perms = icms::handler('icms_member_groupperm')->getItemIds("cat_submit", $groups, icms::$module->getVar("mid"));
		return (empty($perms)) ? FALSE : TRUE;
	}
	
	public function userView() {
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$perms = icms::handler('icms_member_groupperm')->getItemIds("cat_view", $groups, icms::$module->getVar("mid"));
		return $perms;
	}

	protected function beforeInsert(&$obj) {
		if($obj->_updating)
		return TRUE;
		$seo = $obj->short_url();
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle($obj->title(), FALSE);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
			$obj->setVar("short_url", $seo);
		}
		return TRUE;
	}
}