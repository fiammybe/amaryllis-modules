<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /class/MenuHandler.php
 *
 * Classes responsible for managing menu menu objects
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

class mod_menu_MenuHandler extends icms_ipf_Handler {

	public $_menuKinds;
	public $_displayArray;

	private $_menuList;
	private $_orderArray;
	private $_sortArray;
	private $_itemObjects;
	private $_subItemObjects = NULL;
	private $_iHandler;

	public function __construct(&$db) {
		parent::__construct($db, "menu", "menu_id", "menu_name", "menu_dsc", MENU_DIRNAME);
		$this->enableUpload(array("image/gif", "image/jpeg", "image/pjpeg", "image/png"), 512000, 250, 250);
	}

	public function getMenuList($showNull = FALSE) {
		if(!count($this->_menuList)) {
			$criteria = new icms_db_criteria_Compo();
			$criteria->setSort('menu_name');
			$criteria->setOrder('ASC');
			$menus = $this->getObjects($criteria);
			if($showNull) {
				$this->_menuList[0] = "---------------";
			}
			foreach ($menus as $menu) {
				$this->_menuList[$menu->getVar("menu_id")] = $menu->title();
			}
		}
		return $this->_menuList;
	}

	public function getOrderArray() {
		if(!count($this->_orderArray)) {
			$this->_orderArray["weight"] = _CO_ICMS_WEIGHT_FORM_CAPTION;
			$this->_orderArray["item_name"] = _CO_MENU_ITEM_ITEM_NAME;
		}
		return $this->_orderArray;
	}

	public function getSortArray() {
		if(!count($this->_sortArray)) {
			$this->_sortArray['ASC'] = _ASCENDING;
			$this->_sortArray['DESC'] = _DESCENDING;
		}
		return $this->_sortArray;
	}

	public function getDisplayArray() {
		if(!$this->_displayArray) {
			$this->_displayArray[1] = _CO_MENU_MENU_DISPLAY_WITH_IMGS;
			$this->_displayArray[2] = _CO_MENU_MENU_DISPLAY_WITHOUT_IMGS;
			$this->_displayArray[3] = _CO_MENU_MENU_DISPLAY_ONLY_IMGS;
		}
		return $this->_displayArray;
	}

	public function getByName($name) {
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("menu_name", trim($name)));
		$menus = $this->getObjects($criteria, FALSE, TRUE);
		unset($criteria);
		if($menus) return $menus[0];
		return FALSE;
	}



	public function render($params) {
		$menu = $this->getByName($params['name']);
		if($menu === FALSE) return;
		$this->_iHandler = new mod_menu_ItemHandler(icms::$xoopsDB);
		$criteria = $this->_iHandler->getItemCriterias(TRUE, 0, $menu->id(), 0, 0, "item_view", $menu->getVar("item_order"), $menu->getVar("item_sort"), $icmsConfig['language']);
		$this->_itemObjects = $this->_iHandler->getObjects($criteria, TRUE, TRUE);
		unset($criteria);
		$id = (isset($params['id']) && $params['id'] !== "") ? $params['id'] : $menu->getVar("menu_ulid");
		$menuClasses = ($menu->getVar("classes") !== "") ? ' class="'.$menu->getVar("classes").'"' : '';
		$ret = '<ul id="'.$id.'"'.$menuClasses.'>';
		if($menu->displayHomeLink()) {
			$ret .= $menu->renderHome();
		}
		foreach ($this->_itemObjects as $i) {
			if($i->getVar("item_pid", "e") == 0){
				$class = array();
				if ($i === reset($this->_itemObjects) && !$menu->displayHomeLink())
					$class[] = 'first';
			    if ($i === end($this->_itemObjects))
					$class[] = 'last';
				if($i->isCurrent())
					$class[] = "active";
				if(!empty($class)) $class = ' class="'.implode(" ", $class).'"';
				else $class = '';
				$ret .= '<li'.$class.'>'. $i->render($menu->getVar("menu_images", "e"), $menu->displayDsc());
				if($i->hasSubs())
					$ret .= $this->renderSubItems($menu, $i->id(), $menu->getVar("menu_images", "e"), $menu->displayDsc());
				$ret .= '</li>';
				unset($i);
			}
		}
		unset($this->_itemObjects, $this->_iHandler, $this->_subItemObjects);
		$ret .= '</ul>';
		return $ret;
	}

	private function renderSubItems(&$menu, $pid = NULL, $withImages, $dsc) {
		if(!count($this->_subItemObjects)) {
			$criteria2 = $this->_iHandler->getItemCriterias(TRUE, FALSE, $menu->id(), 0, 0, "item_view", $menu->getVar("item_order"), $menu->getVar("item_sort"), $icmsConfig['language']);
			$criteria2->add(new icms_db_criteria_Item("item_pid", 0, '>='));
			$this->_subItemObjects = $this->_iHandler->getObjects($criteria2, TRUE, TRUE);
			unset($criteria2);
		}
		$ret = "<ul class='submenu'>";
		foreach ($this->_subItemObjects as $j) {
			if($j->getVar("item_pid", "e") == $pid) {
				$ret .= '<li>'. $j->render($withImages, $dsc);
				if($j->hasSubs())
					$ret .= $this->renderSubItems($menu, $j->id(),$withImages,$dsc);
				$ret .= '</li>';
			}
		}
		$ret .= '</ul>';
		return $ret;
	}

	protected function afterDelete(&$obj) {
		$item_handler = icms_getModuleHandler("item", MENU_DIRNAME, "menu");
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("item_menu", $obj->id()));
		$item_handler->deleteAll($criteria);
		return TRUE;
	}
}