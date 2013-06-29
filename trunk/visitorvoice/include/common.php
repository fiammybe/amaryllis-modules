<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * File holding functions used by the module to hook with the comment system of ImpressCMS
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("VISITORVOICE_DIRNAME")) define("VISITORVOICE_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("VISITORVOICE_URL")) define("VISITORVOICE_URL", ICMS_URL . '/modules/' . VISITORVOICE_DIRNAME . '/');

if(!defined("VISITORVOICE_ROOT_PATH")) define("VISITORVOICE_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . VISITORVOICE_DIRNAME . '/');

if(!defined("VISITORVOICE_IMAGES_URL")) define("VISITORVOICE_IMAGES_URL", VISITORVOICE_URL . 'images/');

if(!defined("VISITORVOICE_ADMIN_URL")) define("VISITORVOICE_ADMIN_URL", VISITORVOICE_URL . 'admin/');

if(!defined("VISITORVOICE_TEMPLATES_URL")) define("VISITORVOICE_TEMPLATES_URL", VISITORVOICE_URL . 'templates/');

if(!defined("VISITORVOICE_IMAGES_ROOT")) define("VISITORVOICE_IMAGES_ROOT", VISITORVOICE_ROOT_PATH . 'images/');

if(!defined("VISITORVOICE_UPLOAD_ROOT")) define("VISITORVOICE_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . VISITORVOICE_DIRNAME . '/');

if(!defined("VISITORVOICE_UPLOAD_URL")) define("VISITORVOICE_UPLOAD_URL", ICMS_URL . '/uploads/' . VISITORVOICE_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('visitorvoice', 'common');

$visitorvoiceModule = icms_getModuleInfo( basename(dirname(dirname(__FILE__))) );
if (is_object($visitorvoiceModule)) {
	$visitorvoice_moduleName = $visitorvoiceModule->getVar('name');
}

$visitorvoice_isAdmin = icms_userIsAdmin( VISITORVOICE_DIRNAME );

$visitorvoiceConfig = icms_getModuleConfig( VISITORVOICE_DIRNAME );