<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/AlbumHandler.php
 * 
 * Classes responsible for managing album album objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

include 'admin_header.php';

global $path, $dirname;
$path = dirname(dirname(__FILE__));
$dirname = icms::$module->getVar('dirname');

icms_cp_header();
icms::$module->displayAdminMenu( -1, _MI_ALBUM_MENU_MANUAL);
$file = isset($_GET['file']) ? filter_input(INPUT_GET, "file", FILTER_SANITIZE_SPECIAL_CHARS) : "manual.html";
$lang = "language/" . $icmsConfig['language'];
$manual = ALBUM_ROOT_PATH . "$lang/$file";
if (!file_exists($manual)) {
	$lang = 'language/english';
	$manual = ALBUM_ROOT_PATH . "$lang/$file";
}
$icmsAdminTpl->assign("manual_path", $manual);
$icmsAdminTpl->display('db:album_admin.html');
icms_cp_footer();