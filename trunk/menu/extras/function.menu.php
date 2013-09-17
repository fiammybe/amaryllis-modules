<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /extras/function.menu.php
 *
 * smarty plugin for menu module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.2
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */

defined("ICMS_ROOT_PATH") or die("Access denied");

/**
 * construct the html code to display a menu
 *
 * @param array $params
 * @param object $smarty
 * @return string html code for the menu
 */
function smarty_function_menu($params, &$smarty) {
	if(!isset($params['name']) || $params['name'] == "") {
		icms_core_Debug::message("No menu Selected. You need to give the parameter 'name' as short url of the menu.");
		return;
	}
	$module = icms::handler("icms_module")->getByDirname('menu');
	if(!is_object($module) || !$module->getVar("isactive")) return;

	$menu_handler = icms_getModuleHandler("menu", $module->getVar("dirname"), "menu");
	$ret = $menu_handler->render($params);
	//unset($menu_handler, $module);
	return $ret;
}