<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/manual.php
 *
 * Module Manual
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

include_once 'admin_header.php';

icms_cp_header();
icms::$module->displayAdminMenu( 0, _MI_TOOLS_MENU_TOOLS);

$file = isset($_GET['file']) ? filter_input(INPUT_GET, "file", FILTER_SANITIZE_SPECIAL_CHARS) : "manual.html";
$lang = "language/" . $icmsConfig['language'];
$manual = TOOLS_ROOT_PATH . "$lang/$file";
if (!file_exists($manual)) {
	$lang = 'language/english';
	$manual = TOOLS_ROOT_PATH . "$lang/$file";
}
$man = file_get_contents($manual);
$icmsAdminTpl->assign("tools_manual", $man);
$icmsAdminTpl->assign("manual_path", TOOLS_ROOT_PATH.'templates/tools_manual.html');

$icmsAdminTpl->display('db:tools_admin.html');

icms_cp_footer();