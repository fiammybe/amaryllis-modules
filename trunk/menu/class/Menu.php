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

class mod_menu_Menu extends icms_ipf_Object {
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
		//$this->quickInitVar("menu_kind", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("menu_home", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("menu_home_txt", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("menu_home_img", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("menu_images", XOBJ_DTYPE_INT, FALSE);
		//$this->quickInitVar("menu_images_width", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("menu_items_dsc", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("menu_ulid", XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE, "mainmenu");
		$this->quickInitVar("classes", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("item_order", XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE, "weight");
		$this->quickInitVar("item_sort", XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE, "ASC");

		$this->setControl("menu_dsc", array("name" => "textarea", "form_editor" => "htmlarea"));
		//$this->setControl("menu_kind", array("name" => "select", "itemHandler" => "menu", "method" => "getMenuKinds", "module" => "menu"));
		$this->setControl("menu_images", array("name" => "select", "itemHandler" => "menu", "method" => "getDisplayArray", "module" => "menu"));
		$this->setControl("item_sort", array("name" => "select", "itemHandler" => "menu", "method" => "getSortArray", "module" => "menu"));
		$this->setControl("item_order", array("name" => "select", "itemHandler" => "menu", "method" => "getOrderArray", "module" => "menu"));
		$this->setControl("menu_home_img", array("name" => "image", "nourl" => TRUE));
		$this->setControl("menu_home", "yesno");
		$this->setControl("menu_items_dsc", "yesno");
	}

	public function getMenuImgDisplay() {
		$menu_img = $this->getVar("menu_images", "e");
		$arr = $this->handler->getDisplayArray();
		return $arr[$menu_img];
	}

	public function getSmarty() {
		$title = $this->title();
		return "<{menu name='$title'}>";
	}

	public function displayHomeLink() {
		$display = $this->getVar("menu_home", "e");
		return ($display == 1) ? TRUE : FALSE;
	}

	public function getOrder() {
		return $this->getVar("item_order");
	}

	public function getSort() {
		return $this->getVar("item_sort");
	}

	public function getHomeImagePath() {
		$img_display = $this->getVar("menu_images", "e");
		if($img_display == 1 || $img_display == 3) {
			$image = $this->getVar("menu_home_img", "e");
			if(($image != "") && ($image != "0")) {
				$path = $this->handler->_uploadUrl . 'menu/' . $image;
				return $path;
			} else return FALSE;
		} else return FALSE;
	}

	public function renderHome() {
		$home_text = $this->getVar("menu_home_txt") == "" ? THEME_HOME : $this->getVar("menu_home_txt");
		$ret = '<li class="first"><a href="'.ICMS_URL.'" title="'.$home_text.'">';
		if($this->getHomeImagePath() !== FALSE) {
			$ret .= '<img class="item-image" src="'.$this->getHomeImagePath().'" title="'.THEME_HOME.'" alt="'.THEME_HOME.'" />';
		}
		if($this->getVar("menu_images", "e") == 1 || $this->getVar("menu_images", "e") == 2)
			$ret .= '<span class="item-title">'.$home_text.'</span>';
		$ret .= '</a></li>';
	}

	public function displayDsc() {
		$display_dsc = $this->getVar("menu_items_dsc", "e");
		return ($display_dsc == 1) ? TRUE : FALSE;
	}

	public function toArray() {
		$ret = parent::toArray();
		$ret['home_img'] = $this->getHomeImagePath();
	}
}