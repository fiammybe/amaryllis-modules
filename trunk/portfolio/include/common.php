<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * common file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("PORTFOLIO_DIRNAME")) define("PORTFOLIO_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("PORTFOLIO_URL")) define("PORTFOLIO_URL", ICMS_URL . '/modules/' . PORTFOLIO_DIRNAME . '/');

if(!defined("PORTFOLIO_ROOT_PATH")) define("PORTFOLIO_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . PORTFOLIO_DIRNAME . '/');

if(!defined("PORTFOLIO_IMAGES_URL")) define("PORTFOLIO_IMAGES_URL", PORTFOLIO_URL . 'images/');

if(!defined("PORTFOLIO_ADMIN_URL")) define("PORTFOLIO_ADMIN_URL", PORTFOLIO_URL . 'admin/');

if(!defined("PORTFOLIO_TEMPLATES_URL")) define("PORTFOLIO_TEMPLATES_URL", PORTFOLIO_URL . 'templates/');

if(!defined("PORTFOLIO_IMAGES_ROOT")) define("PORTFOLIO_IMAGES_ROOT", PORTFOLIO_ROOT_PATH . 'images/');

if(!defined("PORTFOLIO_SCRIPT_ROOT")) define("PORTFOLIO_SCRIPT_ROOT", PORTFOLIO_ROOT_PATH . 'scripts/');

if(!defined("PORTFOLIO_UPLOAD_ROOT")) define("PORTFOLIO_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . PORTFOLIO_DIRNAME . '/');

if(!defined("PORTFOLIO_UPLOAD_URL")) define("PORTFOLIO_UPLOAD_URL", ICMS_URL . '/uploads/' . PORTFOLIO_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('portfolio', 'common');

include_once PORTFOLIO_ROOT_PATH . '/include/functions.php';

$portfolioModule = icms_getModuleInfo( basename(dirname(dirname(__FILE__))) );
if (is_object($portfolioModule)) {
	$portfolio_moduleName = $portfolioModule->getVar('name');
}

$portfolio_isAdmin = icms_userIsAdmin( PORTFOLIO_DIRNAME );

$portfolioConfig = icms_getModuleConfig( PORTFOLIO_DIRNAME );

$icmsPersistableRegistry = icms_ipf_registry_Handler::getInstance();