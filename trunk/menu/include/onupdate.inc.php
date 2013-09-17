<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 *
 * menu update informations
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
define("MENU_DIRNAME", basename(dirname(dirname(__FILE__))));
define("ERROR_SPAN", "<span style='color: red; font-weight:bold;'>%s</span><br />");
define("SUCCESS_SPAN", "<span style='font-weight:normal;'>%s</span><br />");
define('MENU_DB_VERSION', 2);
icms_loadLanguageFile("menu", "install");

function menu_db_upgrade_2() {
	$item_handler = icms_getModuleHandler("item", MENU_DIRNAME, "menu");
	$items = $item_handler->getObjects(NULL, TRUE, TRUE);
	foreach (array_keys($items) as $k) {
		$url = urldecode($items[$k]->getVar('item_url', "e"));
		if(strpos($url, ICMS_MODULES_URL) !== FALSE) {
			$target = 2;
			$url = str_replace(ICMS_MODULES_URL, '', $url);
		} elseif (strpos($url, ICMS_URL) !== FALSE) {
			$target = 1;
			$url = str_replace(ICMS_URL, '', $url);
		} elseif (strpos($url, "%7BMOD_URL%7D") !== FALSE) {
			$target = 2;
			$url = str_replace("%7BMOD_URL%7D", '', $url);
		}  elseif (strpos($url, "{ICMS_URL}") !== FALSE) {
			$target = 1;
			$url = str_replace("{ICMS_URL}", '', $url);
		} else {
			$target = 3;
		}
		$items[$k]->setVar("item_url", $url);
		$items[$k]->setVar("item_target", $target);
		$item_handler->insert($items[$k], TRUE);
	}
	return TRUE;
}

function icms_module_update_menu($module) {
	if(icms_core_Filesystem::copyStream(ICMS_MODULES_PATH.'/'.MENU_DIRNAME.'/extras/function.menu.php', ICMS_LIBRARIES_PATH.'/smarty/icms_plugins/function.menu.php') === FALSE) {
		$module->messages = sprintf(ERROR_SPAN, _MENU_INSTALL_ERROR_MOVE_PLUGIN);
	} else {
		$module->messages = sprintf(SUCCESS_SPAN, _MENU_INSTALL_SUCCESS_MOVE_PLUGIN);
	}
    return TRUE;
}

function icms_module_install_menu($module) {
	// create own block position
	if(create_block_pos()) $module->messages = sprintf(SUCCESS_SPAN, _MENU_INSTALL_SUCCESS_BLOCK_CREATED);
	else $module->messages = sprintf(ERROR_SPAN, _MENU_INSTALL_ERROR_BLOCK_CREATED);
	if(icms_core_Filesystem::copyStream(ICMS_MODULES_PATH.'/'.MENU_DIRNAME.'/extras/function.menu.php', ICMS_LIBRARIES_PATH.'/smarty/icms_plugins/function.menu.php') === FALSE) {
		$module->messages .= sprintf(ERROR_SPAN, _MENU_INSTALL_ERROR_MOVE_PLUGIN);
	} else {
		$module->messages .= sprintf(SUCCESS_SPAN, _MENU_INSTALL_SUCCESS_MOVE_PLUGIN);
	}
	return TRUE;
}

function icms_module_uninstall_menu($module) {
	// remove menu block pos
	if(remove_block_pos()) $module->messages = sprintf(SUCCESS_SPAN, _MENU_INSTALL_SUCCESS_BLOCK_REMOVED);
	else $module->messages = sprintf(ERROR_SPAN, _MENU_INSTALL_ERROR_BLOCK_REMOVED);
	// delete uploaded files
	$path = ICMS_UPLOAD_PATH . "/" . MENU_DIRNAME;
	if(icms_core_Filesystem::deleteRecursive($path) === FALSE) {
		$module->messages .= sprintf(ERROR_SPAN, _MENU_INSTALL_ERROR_UPLOADS_REMOVED);
	} else {
		$module->messages .= sprintf(SUCCESS_SPAN, _MENU_INSTALL_SUCCESS_UPLOADS_REMOVED);
	}
	return TRUE;
}

function create_block_pos() {
	$block_pos_handler = icms::handler("icms_view_block_position");
	$blockposObj = $block_pos_handler->create(TRUE);
	$blockposObj->setVar("pname", "menu_block");
	$blockposObj->setVar("title", "Menu Block");
	$blockposObj->setVar("description", "Menu Block created by Menu module");
	if($block_pos_handler->insert($blockposObj, TRUE)) return TRUE;
	return FALSE;
}

function remove_block_pos() {
	$block_pos_handler = icms::handler("icms_view_block_position");
	$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("pname", "menu_block"));
	$sql = "SELECT id FROM " . $block_pos_handler->table . " " . $criteria->renderWhere();
	if (!$result = icms::$xoopsDB->query($sql)) return FALSE;
	list($myrow) = icms::$xoopsDB->fetchRow($result);
	$blockposObj = $block_pos_handler->get($myrow);
	if($block_pos_handler->delete($blockposObj)) return TRUE;
	return FALSE;
}
