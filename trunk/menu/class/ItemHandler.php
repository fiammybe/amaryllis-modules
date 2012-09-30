<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /class/ItemHandler.php
 * 
 * Classes responsible for managing menu items objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */
 
defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("MENU_DIRNAME")) define("MENU_DIRNAME", basename(dirname(dirname(__FILE__))));

class MenuItemHandler extends icms_ipf_Handler {
	
	private $_targets;
	
	private $_items;
	
	private $_menusForItem;
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $MENU_ITEM_ORDER, $MENU_ITEM_SORT;
		parent::__construct($db, "item", "item_id", "item_name", "item_dsc", MENU_DIRNAME);
		$this->enableUpload(array("image/gif", "image/jpeg", "image/pjpeg", "image/png"), 512000, 500, 500);
		$this->addPermission("item_view", _CO_MENU_ITEM_PERM_VIEW, _CO_MENU_ITEM_PERM_VIEW_DSC);
	}
	
	public function getItemCriterias($act = FALSE, $item_pid = NULL, $menu_id = FALSE, $start=0,$limit=0,$perm="item_view" ) {
		global $MENU_ITEM_ORDER, $MENU_ITEM_SORT;
		$criteria = new icms_db_criteria_Compo();
		if($start) $criteria->setStart((int)$start);
		if($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($MENU_ITEM_ORDER);
		$criteria->setOrder($MENU_ITEM_SORT);
		if($act) $criteria->add(new icms_db_criteria_Item('item_active', TRUE));
		if (is_null($item_pid)) $item_pid = 0;
		$criteria->add(new icms_db_criteria_Item('item_pid', $item_pid));
		if($menu_id) $criteria->add(new icms_db_criteria_Item('item_menu', $menu_id));
		$this->setGrantedObjectsCriteria($criteria, $perm);
		return $criteria;
	}
	
	public function getTargets() {
		if(!count($this->_targets)) {
			$this->_targets["_blank"] = "_blank";
			$this->_targets["_self"] = "_self";
		}
		return $this->_targets;
	}
	
	public function getMenuList() {
		if (!count($this->_menusForItem)) {
			$menus = $this->getMenuArray();
			foreach ($menus as $key => $value) {
				$this->_menusForItem[$key] = $value;
			}
		}
		return $this->_menusForItem;
	}
	
	public function getMenuArray() {
		$menu_handler = icms_getModuleHandler("menu", MENU_DIRNAME, "menu");
		return $menu_handler->getMenuList();
	}
	
	public function getItemListForPid($act=FALSE, $item_id=NULL, $menu_id = MENU_MENU_ID, $start=0,$limit=0,$perm="item_view",$showNull = TRUE) {
		$menu_handler = icms_getModuleHandler("menu", MENU_DIRNAME, "menu");
		$criteria = $this->getItemCriterias($act, $item_id, $menu_id, $start, $limit, $order, $sort, $perm);
		//$criteria->setGroupby("item_menu");
		$items = & $this->getObjects($criteria, TRUE);
		$ret = array();
		if($showNull) {
			$ret[0] = '-----------------------';
		}
		foreach(array_keys($items) as $i) {
			$menu = $menu_handler->get($items[$i]->getVar("item_menu"))->title();
			$ret[$i] = $items[$i]->title() . " (" . $menu . ") ";
			$subitems = $this->getItemListForPid($act, $items[$i]->id(), $menu_id, $start, $limit, $order, $sort, $perm, FALSE);
			if($subitems) {
				foreach(array_keys($subitems) as $j) {
					$ret[$j] = '-' . $subitems[$j];
				}
			}
		}
		return $ret;
	}
	
	public function getItems($act = FALSE, $item_pid = NULL, $menu_id = FALSE, $start=0,$limit=0,$perm="item_view") {
		global $MENU_ITEM_ORDER, $MENU_ITEM_SORT;
		$criteria = $this->getItemCriterias($act, $item_pid, $menu_id, $start, $limit, $perm);
		$items = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($items as $item){
			$ret[$item['item_id']] = $item;
		}
		return $ret;
	}
	
	public function getItemsCount ($act = FALSE, $item_pid = NULL, $menu_id = FALSE, $start=0,$limit=0,$order='item_name',$sort='ASC',$perm="item_view") {
		$criteria = $this->getItemCriterias($act, $item_pid, $menu_id, $start, $limit, $order, $sort, $perm);
		return $this->getCount($criteria);
	}
	
	public function changeField($item_id, $field) {
		$itemObj = $this->get($item_id);
		if ($itemObj->getVar("$field", 'e') == TRUE) {
			$itemObj->setVar("$field", 0);
			$value = 0;
		} else {
			$itemObj->setVar("$field", 1);
			$value = 1;
		}
		$itemObj->_updating = TRUE;
		$this->insert($itemObj, TRUE);
		return $value;
	}
	
	public function filterMenu() {
		$menu_handler = icms_getModuleHandler("menu", MENU_DIRNAME, "menu");
		return $menu_handler->getMenuList(TRUE);
	}
	
	public function filterActive() {
		return array(1 => "Active", 2 => "Inactive");
	}
	
	protected function beforeInsert(&$obj) {
		if($obj->_updating == TRUE) return TRUE;
		$pid = $obj->getVar("item_pid", "e");
		if($pid > 0) {
			$parent = $this->get($pid);
			if(!$parent->getVar("item_menu") == $obj->getVar("item_menu")) {
				$obj->setErrors(_CO_MENU_ITEM_WRONG_MENU);
				return FALSE;
			}
		}
		if($pid == $obj->id()) {
			$obj->setVar("item_pid", 0);
		}
		$dsc = $obj->getVar("item_dsc", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$obj->setVar("item_dsc", $dsc);
		return TRUE;
	}
	
	protected function afterSave(&$obj) {
		if($obj->_updating == TRUE) return TRUE;
		$pid = $obj->getVar("item_pid", "e");
		if($pid > 0 && $obj->getVar("item_active", "e") == 1) {
			$item = $this->get($pid);
			$item->setVar("item_hassub", TRUE);
			$item->_updating = TRUE;
			$this->insert($item, TRUE);
		}
		return TRUE;
	}
	
	protected function afterDelete(&$obj) {
		$image = $this->getVar("item_image", "e");
		if(($image != "") && ($image != "0")) {
			$path = $this->handler->_uploadUrl . 'item/' . $image;
			icms_core_Filesystem::deleteFile($path);
		}
		return TRUE;
	}
}