<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /include/common.php
 *
 * Common file of the module included on all pages of the module
 *
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

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("ALBUM_URL")) define("ALBUM_URL", ICMS_URL . '/modules/' . ALBUM_DIRNAME . '/');

if(!defined("ALBUM_ROOT_PATH")) define("ALBUM_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . ALBUM_DIRNAME . '/');

if(!defined("ALBUM_IMAGES_URL")) define("ALBUM_IMAGES_URL", ALBUM_URL . 'images/');

if(!defined("ALBUM_ADMIN_URL")) define("ALBUM_ADMIN_URL", ALBUM_URL . 'admin/');

if(!defined("ALBUM_TEMPLATES_URL")) define("ALBUM_TEMPLATES_URL", ALBUM_URL . 'templates/');

if(!defined("ALBUM_IMAGES_ROOT")) define("ALBUM_IMAGES_ROOT", ALBUM_ROOT_PATH . 'images/');

if(!defined("ALBUM_UPLOAD_ROOT")) define("ALBUM_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . ALBUM_DIRNAME . '/');

if(!defined("ALBUM_UPLOAD_URL")) define("ALBUM_UPLOAD_URL", ICMS_URL . '/uploads/' . ALBUM_DIRNAME . '/');

if(!defined("ALBUM_SCRIPT_URL")) define("ALBUM_SCRIPT_URL", ALBUM_URL . 'images/');

// Include the common language file of the module
icms_loadLanguageFile('album', 'common');

include_once ALBUM_ROOT_PATH . '/include/functions.php';

$albumModule = icms_getModuleInfo(ALBUM_DIRNAME);
if (is_object($albumModule)) {
	$album_moduleName = $albumModule->getVar('name');
	$albumModule->registerClassPath(TRUE);
}

$album_isAdmin = icms_userIsAdmin(ALBUM_DIRNAME);

$albumConfig = icms_getModuleConfig(ALBUM_DIRNAME);

if(icms_get_module_status("index")) {
	icms_loadLanguageFile('index', 'common');
	$indexModule = icms_getModuleInfo("index");
	include_once ICMS_MODULES_PATH . "/" . $indexModule->getVar("dirname") . "/include/common.php";
}
$real_url = ($albumConfig['use_main'] == 1) ? ICMS_URL.'/' : ALBUM_URL;
if(!defined("ALBUM_REAL_URL")) define("ALBUM_REAL_URL", $real_url);