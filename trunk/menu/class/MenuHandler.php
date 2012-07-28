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

class MenuMenuHandler extends icms_ipf_Handler {
	
	public $_menuKinds;
	
	public $_displayArray;
	
	public function __construct(&$db) {
		parent::__construct($db, "menu", "menu_id", "menu_name", "menu_dsc", MENU_DIRNAME);
		$this->enableUpload(array("image/gif", "image/jpeg", "image/pjpeg", "image/png"), 512000, 500, 500);
	}
	
	public function getMenuList($showNull = TRUE) {
		$ret[0] = '-----------';
		$ret = $this->getList();
		return $ret;
	}
	
	public function getMenuKinds() {
		if(!$this->_menuKinds) {
			$this->_menuKinds['horizontal'] = _CO_MENU_MENU_KIND_HORIZONTAL;
			$this->_menuKinds['vertical'] = _CO_MENU_MENU_KIND_VERTICAL;
			if(icms_get_module_status("index")) {
				$this->_menuKinds['dynamic'] = _CO_MENU_MENU_KIND_DYNAMIC;
			}
		}
		return $this->_menuKinds;
	}
	
	public function getDisplayArray() {
		if(!$this->_displayArray) {
			$this->_displayArray[1] = _CO_MENU_MENU_DISPLAY_WITH_IMGS;
			$this->_displayArray[2] = _CO_MENU_MENU_DISPLAY_WITHOUT_IMGS;
			$this->_displayArray[3] = _CO_MENU_MENU_DISPLAY_ONLY_IMGS;
		}
		return $this->_displayArray;
	}


}