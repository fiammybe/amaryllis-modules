<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /class/Menu.php
 * 
 * Class representing menu menu objects
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

class MenuMenu extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_menu_Menu $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("menu_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("menu_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("menu_dsc", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("menu_kind", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("menu_home", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("menu_home_txt", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("menu_home_img", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("menu_images", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("menu_images_width", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("menu_items_dsc", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("menu_ulid", XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE, "accordion");
		
		$this->setControl("menu_dsc", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("menu_kind", array("name" => "select", "itemHandler" => "menu", "method" => "getMenuKinds", "module" => "menu"));
		$this->setControl("menu_images", array("name" => "select", "itemHandler" => "menu", "method" => "getDisplayArray", "module" => "menu"));
		$this->setControl("menu_home_img", "image");
		$this->setControl("menu_home", "yesno");
		$this->setControl("menu_items_dsc", "yesno");
	}

	public function getMenuImgDisplay() {
		$menu_img = $this->getVar("menu_images", "e");
		switch ($menu_img) {
			case '1':
				return _CO_MENU_MENU_DISPLAY_WITH_IMGS;
				break;
			case '2':
				return _CO_MENU_MENU_DISPLAY_WITHOUT_IMGS;
				break;
			case '3':
				return _CO_MENU_MENU_DISPLAY_ONLY_IMGS;
				break;
			
		}
	}
	
	public function getMenuKind() {
		$menu_img = $this->getVar("menu_kind", "e");
		switch ($menu_img) {
			case 'horizontal':
				return _CO_MENU_MENU_KIND_HORIZONTAL;
				break;
			case 'vertical':
				return _CO_MENU_MENU_KIND_VERTICAL;
				break;
			case 'dynamic':
				return _CO_MENU_MENU_KIND_DYNAMIC;
				break;
			
		}
	}

	public function displayHomeLink() {
		$display = $this->getVar("menu_home", "e");
		return ($display == 1) ? TRUE : FALSE;
	}
	
	public function getHomeImagePath() {
		$img_display = $this->getVar("menu_images", "e");
		if($img_display == 1 || $img_display == 3) {
			$image = $this->getVar("menu_home_img", "e");
			if(($image != "") && ($image != "0")) {
				$path = $this->handler->_uploadUrl . 'menu/' . $image;
				return $path;
			}
		}
	}
	
	public function displayDsc() {
		$display_dsc = $this->getVar("menu_items_dsc", "e");
		return ($display_dsc == 1) ? TRUE : FALSE;
	}
	
	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['name'] = $this->title();
		$ret['kind'] = $this->getVar("menu_kind", "e");
		$ret['display_home'] = $this->displayHomeLink();
		$ret['home_title'] = $this->getVar("menu_home_txt", "e");
		$ret['home_img'] = $this->getHomeImagePath();
		$ret['display_img'] = $this->getVar("menu_images", "e");
		$ret['img_width'] = $this->getVar("menu_images_width", "e");
		$ret['display_dsc'] = $this->displayDsc();
		$ret['ul_id'] = $this->getVar("menu_ulid", "e");
		return $ret;
	}
}