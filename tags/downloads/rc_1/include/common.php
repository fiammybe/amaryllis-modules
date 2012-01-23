<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * File holding functions used by the module to hook with the comment system of ImpressCMS
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("DOWNLOADS_DIRNAME")) define("DOWNLOADS_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("DOWNLOADS_URL")) define("DOWNLOADS_URL", ICMS_URL . '/modules/' . DOWNLOADS_DIRNAME . '/');

if(!defined("DOWNLOADS_ROOT_PATH")) define("DOWNLOADS_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . DOWNLOADS_DIRNAME . '/');

if(!defined("DOWNLOADS_IMAGES_URL")) define("DOWNLOADS_IMAGES_URL", DOWNLOADS_URL . 'images/');

if(!defined("DOWNLOADS_ADMIN_URL")) define("DOWNLOADS_ADMIN_URL", DOWNLOADS_URL . 'admin/');

if(!defined("DOWNLOADS_TEMPLATES_URL")) define("DOWNLOADS_TEMPLATES_URL", DOWNLOADS_URL . 'templates/');

if(!defined("DOWNLOADS_IMAGES_ROOT")) define("DOWNLOADS_IMAGES_ROOT", DOWNLOADS_ROOT_PATH . 'images/');

if(!defined("DOWNLOADS_SCRIPT_ROOT")) define("DOWNLOADS_SCRIPT_ROOT", DOWNLOADS_ROOT_PATH . 'scripts/');

if(!defined("DOWNLOADS_UPLOAD_ROOT")) define("DOWNLOADS_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . DOWNLOADS_DIRNAME . '/');

if(!defined("DOWNLOADS_UPLOAD_URL")) define("DOWNLOADS_UPLOAD_URL", ICMS_URL . '/uploads/' . DOWNLOADS_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('downloads', 'common');

include_once DOWNLOADS_ROOT_PATH . '/include/functions.php';

$downloadsModule = icms_getModuleInfo( basename(dirname(dirname(__FILE__))) );
if (is_object($downloadsModule)) {
	$downloads_moduleName = $downloadsModule->getVar('name');
}

$downloads_isAdmin = icms_userIsAdmin( DOWNLOADS_DIRNAME );

$downloadsConfig = icms_getModuleConfig( DOWNLOADS_DIRNAME );

if($downloadsConfig['use_sprockets'] == 1) {
	icms_loadLanguageFile('sprockets', 'common');
}

$icmsPersistableRegistry = icms_ipf_registry_Handler::getInstance();