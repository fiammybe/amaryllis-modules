<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * File holding functions used by the module to hook with the comment system of ImpressCMS
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("GUESTBOOK_DIRNAME")) define("GUESTBOOK_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("GUESTBOOK_URL")) define("GUESTBOOK_URL", ICMS_URL . '/modules/' . GUESTBOOK_DIRNAME . '/');

if(!defined("GUESTBOOK_ROOT_PATH")) define("GUESTBOOK_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . GUESTBOOK_DIRNAME . '/');

if(!defined("GUESTBOOK_IMAGES_URL")) define("GUESTBOOK_IMAGES_URL", GUESTBOOK_URL . 'images/');

if(!defined("GUESTBOOK_ADMIN_URL")) define("GUESTBOOK_ADMIN_URL", GUESTBOOK_URL . 'admin/');

if(!defined("GUESTBOOK_TEMPLATES_URL")) define("GUESTBOOK_TEMPLATES_URL", GUESTBOOK_URL . 'templates/');

if(!defined("GUESTBOOK_IMAGES_ROOT")) define("GUESTBOOK_IMAGES_ROOT", GUESTBOOK_ROOT_PATH . 'images/');

if(!defined("GUESTBOOK_UPLOAD_ROOT")) define("GUESTBOOK_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . GUESTBOOK_DIRNAME . '/');

if(!defined("GUESTBOOK_UPLOAD_URL")) define("GUESTBOOK_UPLOAD_URL", ICMS_URL . '/uploads/' . GUESTBOOK_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('guestbook', 'common');

$guestbookModule = icms_getModuleInfo( basename(dirname(dirname(__FILE__))) );
if (is_object($guestbookModule)) {
	$guestbook_moduleName = $guestbookModule->getVar('name');
}

$guestbook_isAdmin = icms_userIsAdmin( GUESTBOOK_DIRNAME );

$guestbookConfig = icms_getModuleConfig( GUESTBOOK_DIRNAME );

$icmsPersistableRegistry = icms_ipf_registry_Handler::getInstance();