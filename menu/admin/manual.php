<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /admin/manual.php
 * 
 * Module Manual
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

include_once 'admin_header.php';

icms_cp_header();
icms::$module->displayAdminMenu( 0, _MI_ICMSPOLL_MENU_MANUAL);
$file = isset($_GET['file']) ? filter_input(INPUT_GET, "file", FILTER_SANITIZE_SPECIAL_CHARS) : "manual.html";
$lang = "language/" . $icmsConfig['language'];
$manual = ICMSPOLL_ROOT_PATH . "$lang/$file";
if (!file_exists($manual)) {
	$lang = 'language/english';
	$manual = ICMSPOLL_ROOT_PATH . "$lang/$file";
}
$icmsAdminTpl->assign("manual_path", $manual);
$icmsAdminTpl->display('db:icmspoll_admin.html');
icms_cp_footer();