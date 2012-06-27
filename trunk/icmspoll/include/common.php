<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /include/common.php
 * 
 * defined constants, included in all pages
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: common.php 11 2012-06-27 12:30:05Z qm-b $
 * @package		icmspoll
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("ICMSPOLL_DIRNAME")) define("ICMSPOLL_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("ICMSPOLL_URL")) define("ICMSPOLL_URL", ICMS_URL . '/modules/' . ICMSPOLL_DIRNAME . '/');

if(!defined("ICMSPOLL_ROOT_PATH")) define("ICMSPOLL_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . ICMSPOLL_DIRNAME . '/');

if(!defined("ICMSPOLL_IMAGES_URL")) define("ICMSPOLL_IMAGES_URL", ICMSPOLL_URL . 'images/');

if(!defined("ICMSPOLL_ADMIN_URL")) define("ICMSPOLL_ADMIN_URL", ICMSPOLL_URL . 'admin/');

if(!defined("ICMSPOLL_TEMPLATES_URL")) define("ICMSPOLL_TEMPLATES_URL", ICMSPOLL_URL . 'templates/');

if(!defined("ICMSPOLL_IMAGES_ROOT")) define("ICMSPOLL_IMAGES_ROOT", ICMSPOLL_ROOT_PATH . 'images/');

if(!defined("ICMSPOLL_UPLOAD_ROOT")) define("ICMSPOLL_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . ICMSPOLL_DIRNAME . '/');

if(!defined("ICMSPOLL_UPLOAD_URL")) define("ICMSPOLL_UPLOAD_URL", ICMS_URL . '/uploads/' . ICMSPOLL_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('icmspoll', 'common');

include_once ICMSPOLL_ROOT_PATH . '/include/functions.php';

$icmspollModule = icms_getModuleInfo( ICMSPOLL_DIRNAME );
if (is_object($icmspollModule)) {
	$icmspoll_moduleName = $icmspollModule->getVar('name');
}

$icmspoll_isAdmin = icms_userIsAdmin( ICMSPOLL_DIRNAME );

$icmspollConfig = icms_getModuleConfig( ICMSPOLL_DIRNAME );

$icmsPersistableRegistry = icms_ipf_registry_Handler::getInstance();