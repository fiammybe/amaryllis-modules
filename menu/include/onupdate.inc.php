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

// this needs to be the latest db version
define('MENU_DB_VERSION', 1);

/**
 * it is possible to define custom functions which will be call when the module is updating at the
 * correct time in update incrementation. Simpy define a function named <direname_db_upgrade_db_version>
 */
/*
function menu_db_upgrade_1() {
}
function menu_db_upgrade_2() {
}
*/

function icms_module_update_menu($module) {
    return TRUE;
}

function icms_module_install_menu($module) {
	return TRUE;
}