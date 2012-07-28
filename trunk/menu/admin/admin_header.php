<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /admin/admin_header.php
 * 
 * Admin header included throughout the ACP of Menu module
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

include_once "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/include/common.php";
if (!defined("MENU_ADMIN_URL")) define("MENU_ADMIN_URL", MENU_URL . "admin/");
include_once MENU_ROOT_PATH . "include/requirements.php";
icms_loadLanguageFile("menu", "modinfo");