<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /language/english/install.php
 *
 * english install language file
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

define("_MENU_INSTALL_SUCCESS_BLOCK_CREATED", "Block position for Menu created");
define("_MENU_INSTALL_SUCCESS_MOVE_PLUGIN", "Smarty plugin successfully moved to '<b>libraries/smarty/icms_plugins/</b>'");
define("_MENU_INSTALL_SUCCESS_BLOCK_REMOVED", "Block position successfully removed");
define("_MENU_INSTALL_SUCCESS_UPLOADS_REMOVED", "Upload Folder successfully removed..");


define("_MENU_INSTALL_ERROR_BLOCK_CREATED", "Block position for Menu has NOT been created!");
define("_MENU_INSTALL_ERROR_MOVE_PLUGIN", "Attention! Smarty plugin has not been copied to smarty plugin path! Please move the file '<b>".MENU_DIRNAME."/extras/function.menu.php</b>' to '<b>libraries/smarty/icms_plugins/</b>'");
define("_MENU_INSTALL_ERROR_BLOCK_REMOVED", "Menu block position has not been removed..");
define("_MENU_INSTALL_ERROR_UPLOADS_REMOVED", "Upload Folder couldn't be removed..");
