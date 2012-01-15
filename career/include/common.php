<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * common file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("CAREER_DIRNAME")) define("CAREER_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("CAREER_URL")) define("CAREER_URL", ICMS_URL . '/modules/' . CAREER_DIRNAME . '/');

if(!defined("CAREER_ROOT_PATH")) define("CAREER_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . CAREER_DIRNAME . '/');

if(!defined("CAREER_IMAGES_URL")) define("CAREER_IMAGES_URL", CAREER_URL . 'images/');

if(!defined("CAREER_ADMIN_URL")) define("CAREER_ADMIN_URL", CAREER_URL . 'admin/');

if(!defined("CAREER_TEMPLATES_URL")) define("CAREER_TEMPLATES_URL", CAREER_URL . 'templates/');

if(!defined("CAREER_IMAGES_ROOT")) define("CAREER_IMAGES_ROOT", CAREER_ROOT_PATH . 'images/');

if(!defined("CAREER_SCRIPT_ROOT")) define("CAREER_SCRIPT_ROOT", CAREER_ROOT_PATH . 'scripts/');

if(!defined("CAREER_UPLOAD_ROOT")) define("CAREER_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . CAREER_DIRNAME . '/');

if(!defined("CAREER_UPLOAD_URL")) define("CAREER_UPLOAD_URL", ICMS_URL . '/uploads/' . CAREER_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('career', 'common');

include_once CAREER_ROOT_PATH . '/include/functions.php';

$careerModule = icms_getModuleInfo( basename(dirname(dirname(__FILE__))) );
if (is_object($careerModule)) {
	$career_moduleName = $careerModule->getVar('name');
}

$career_isAdmin = icms_userIsAdmin( CAREER_DIRNAME );

$careerConfig = icms_getModuleConfig( CAREER_DIRNAME );

$icmsPersistableRegistry = icms_ipf_registry_Handler::getInstance();