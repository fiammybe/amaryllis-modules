<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * menu common file
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

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("MENU_DIRNAME")) define("MENU_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("MENU_URL")) define("MENU_URL", ICMS_URL . '/modules/' . MENU_DIRNAME . '/');

if(!defined("MENU_ROOT_PATH")) define("MENU_ROOT_PATH", ICMS_MODULES_PATH.'/' . MENU_DIRNAME . '/');

if(!defined("MENU_IMAGES_URL")) define("MENU_IMAGES_URL", MENU_URL . 'images/');

if(!defined("MENU_ADMIN_URL")) define("MENU_ADMIN_URL", MENU_URL . 'admin/');

if(!defined("MENU_IMAGES_ROOT")) define("MENU_IMAGES_ROOT", MENU_ROOT_PATH . 'images/');

if(!defined("MENU_UPLOAD_ROOT")) define("MENU_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . MENU_DIRNAME . '/');

if(!defined("MENU_UPLOAD_URL")) define("MENU_UPLOAD_URL", ICMS_URL . '/uploads/' . MENU_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('menu', 'common');

$menuModule = icms_getModuleInfo( MENU_DIRNAME );
if (is_object($menuModule)) {
	$menul_moduleName = $menuModule->getVar('name');
}

$menu_isAdmin = icms_userIsAdmin( MENU_DIRNAME );

$menuConfig = icms_getModuleConfig( MENU_DIRNAME );

$icmsPersistableRegistry = icms_ipf_registry_Handler::getInstance();