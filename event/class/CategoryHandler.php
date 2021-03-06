<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/CategoryHandler.php
 *
 * Classes responsible for managing event category objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
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
icms_loadLanguageFile("event", "common");
class mod_event_CategoryHandler extends icms_ipf_Handler {

	private $_calArray;

	public $_moduleID;
	public $_moduleUseMain;

	public $_index_module_status = FALSE;
	public $_index_module_dirname = FALSE;
	public $_index_module_mid = FALSE;

	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $eventConfig;
		parent::__construct($db, "category", "category_id", "category_name", "category_dsc", "event");
        $this->addPermission("cat_view", _CO_EVENT_CATEGORY_CAT_VIEW, _CO_EVENT_CATEGORY_CAT_VIEW_DSC);
        $this->addPermission("cat_submit", _CO_EVENT_CATEGORY_CAT_SUBMIT, _CO_EVENT_CATEGORY_CAT_SUBMIT_DSC);

		$this->_index_module_status = icms_get_module_status("index");
		if($this->_index_module_status) {
			$indexModule = icms_getModuleInfo("index");
			$this->_index_module_dirname = $indexModule->getVar("dirname");
			$this->_index_module_mid = $indexModule->getVar("mid");
			unset($indexModule);
		}
		$eModule = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME);
		$this->_moduleID = $eModule->getVar("mid");
		unset($eModule);

		$this->_moduleUseMain = (($eventConfig['use_main'] == 1) || (isset($GLOBALS['MODULE_'.strtoupper(EVENT_DIRNAME).'_USE_MAIN']) &&
									$GLOBALS['MODULE_'.strtoupper(EVENT_DIRNAME).'_USE_MAIN'] === TRUE)) ? TRUE : FALSE;
		$this->_moduleUrl = ($this->_moduleUseMain) ? ICMS_URL.'/' : ICMS_MODULES_URL.'/'.EVENT_DIRNAME.'/';
		$this->_page = ($this->_moduleUseMain) ? EVENT_DIRNAME.'.php' : "index.php";
	}

	public function getCategoryListForConfig() {
		if(!count($this->_calArray)) {
			$cals = $this->getObjects(FALSE, TRUE, FALSE);
			foreach($cals as $key => $value) {
				$this->_calArray[$value['name']] = $key;
			}
		}
		return $this->_calArray;
	}

    public function getCategoryCriterias($perm = "cat_submit", $approve = TRUE) {
        $criteria = new icms_db_criteria_Compo();
		if($approve) {
			$criteria->add(new icms_db_criteria_Item("category_approve", TRUE));
		}

		$this->setGrantedObjectsCriteria($criteria, $perm);
		return $criteria;
    }

	public function getCategories($perm = "cat_submit", $approve = TRUE) {
		$criteria = $this->getCategoryCriterias($perm, $approve);
		$categories = $this->getObjects($criteria, FALSE, FALSE);
		$ret = array();
		foreach ($categories as $category) {
			$ret[$category['id']] = $category;
		}
		unset ($categories, $criteria);
		return $ret;
	}

	public function getCategoriesCount($perm = "cat_submit", $approve = TRUE) {
		$criteria = $this->getCategoryCriterias($perm, $approve);
		$count = $this->getCount($criteria);
		unset($criteria);
		return $count;
	}

	public function getCategoryBySeo($seo) {
		$criteria = new icms_db_criteria_Item("short_url", trim($seo));
		$cats = $this->getObjects($criteria, FALSE, TRUE);
		if(!$cats) return FALSE;
		return $cats[0];
	}

	public function userSubmit() {
		global $icmsModule;
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$perms = icms::handler('icms_member_groupperm')->getItemIds("cat_submit", $groups, $icmsModule->getVar("mid"));
		return (empty($perms)) ? FALSE : TRUE;
	}

	public function userView() {
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$perms = icms::handler('icms_member_groupperm')->getItemIds("cat_view", $groups, icms::$module->getVar("mid"));
		return $perms;
	}

	public function filterApprove() {
		return array(0 => 'Denied', 1 => 'Approved');
	}

	/**
	 * handling some functions to easily switch some fields
	 */
	public function changeField($category_id, $field) {
		$categoryObj = $this->get($category_id);
		if ($categoryObj->getVar("$field", 'e') == TRUE) {
			$categoryObj->setVar("$field", 0);
			$value = 0;
		} else {
			$categoryObj->setVar("$field", 1);
			$value = 1;
		}
		$categoryObj->_updating = TRUE;
		$this->insert($categoryObj, TRUE);
		return $value;
	}

	protected function beforeInsert(&$obj) {
		if($obj->_updating)
		return TRUE;
		$seo = trim($obj->getVar("short_url", "e"));
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle(trim($obj->title()), FALSE);
		$seo = urldecode($seo);
		$umlaute = array("ä","ö","ü","Ä","Ö","Ü","ß", "%C3%84", "%C3%96", "%C3%9C");
		$replace = array("ae","oe","ue","Ae","Oe","Ue","ss", "Ae", "Oe", "Ue");
		$seo = str_ireplace($umlaute, $replace, $seo);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
		}
		$obj->setVar("short_url", $seo);
		$dsc = $obj->getVar("category_dsc", "e");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$dsc = str_replace("'",'"', $dsc);
		$obj->setVar("category_dsc", $dsc);
		return TRUE;
	}

	protected function afterDelete(&$obj) {
		$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
		$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item("event_cid", $obj->id()));
		$event_handler->deleteAll($crit);
		return TRUE;
	}
}