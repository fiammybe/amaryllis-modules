<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/manual.php
 * 
 * manual for article module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */


include 'admin_header.php';

global $path, $dirname;
$path = dirname(dirname(__FILE__));
$dirname = icms::$module -> getVar( 'dirname' );

icms_cp_header();
icms::$module->displayAdminMenu( 0, _MI_ARTICLE_MENU_MANUAL);
$file = isset($_GET['file']) ? filter_input(INPUT_GET, "file", FILTER_SANITIZE_SPECIAL_CHARS) : "manual.html";
$lang = "language/" . $icmsConfig['language'];
$manual = ARTICLE_ROOT_PATH . "$lang/$file";
if (!file_exists($manual)) {
	$lang = 'language/english';
	$manual = ARTICLE_ROOT_PATH . "$lang/$file";
}
$icmsAdminTpl->assign("manual_path", $manual);
$icmsAdminTpl->display('db:article_admin.html');
icms_cp_footer();