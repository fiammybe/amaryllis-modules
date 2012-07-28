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

define('MENU_DB_VERSION', 1);

function create_block_pos() {
	$block_pos_handler = icms::handler("icms_view_block_position");
	$blockposObj = $block_pos_handler->create(TRUE);
	$blockposObj->setVar("pname", "menu_block");
	$blockposObj->setVar("title", "Menu Block");
	$blockposObj->setVar("description", "Menu Block created by Menu module");
	$block_pos_handler->insert($blockposObj, TRUE);
}

function remove_block_pos() {
	$block_pos_handler = icms::handler("icms_view_block_position");
	$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("pname", "menu_block"));
	$sql = "SELECT id FROM " . $block_pos_handler->table . " " . $criteria->renderWhere();
	if (!$result = icms::$xoopsDB->query($sql)) return FALSE;
	list($myrow) = icms::$xoopsDB->fetchRow($result);
	$blockposObj = $block_pos_handler->get($myrow);
	$block_pos_handler->delete($blockposObj);
}

function icms_module_update_menu($module) {
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_menu($module) {
	// create own block position
	create_block_pos();
	return TRUE;
}

function icms_module_uninstall_menu($module) {
	remove_block_pos();
	return TRUE;
}