<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/index.php
 *
 * admin file
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
//header("Location: tools.php");
//exit;
icms_cp_header();
icms::$module->displayAdminMenu( 0, _MI_TOOLS_MENU_INDEX);
icms::$module->setVar("ipf", TRUE);
icms::$module->registerClassPath(TRUE);
$logPath = TOOLS_TRUST_PATH.'logs/';
$toolsConfig = icms_getModuleConfig(TOOLS_DIRNAME);
$icmsAdminTpl->display("db:tools_admin.html");
$extensions = get_loaded_extensions();
echo "<div class=\"tools_information\">";
echo "<h2>"._AM_TOOLS_INDEX_SYS_INFO."</h2>";
echo "<ul>";
echo "<li>ICMS ROOT: ".ICMS_ROOT_PATH."</li>";
if(is_writable(TOOLS_TRUST_PATH)) {
	echo "<li>"._AM_TOOLS_INDEX_TRUST_WRITABLE."</li>";
} elseif(!is_writable(TOOLS_TRUST_PATH)) {
	echo "<li class=\"tools_error\">"._AM_TOOLS_INDEX_TRUST_NOT_WRITABLE."</li>";
}
if(in_array("ftp", $extensions)) {
	echo "<li>"._AM_TOOLS_INDEX_FTP_LOADED."</li>";
} else {
	echo "<li class=\"tools_error\">"._AM_TOOLS_INDEX_FTP_NOT_LOADED."</li>";
}
if(in_array("zip", $extensions)) {
	echo "<li>"._AM_TOOLS_INDEX_ZIP_LOADED."</li>";
} else {
	echo "<li class=\"tools_error\">"._AM_TOOLS_INDEX_ZIP_NOT_LOADED."</li>";
}
echo "<li>"."DB-Type: ".ucfirst(XOOPS_DB_TYPE)."</li>";

echo "</ul>";
echo "</div>";
include_once 'admin_footer.php';