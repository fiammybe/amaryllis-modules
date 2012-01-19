<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /include/comment.inc.php
 * 
 * Common File of the module included on all pages of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("ARTICLE_URL")) define("ARTICLE_URL", ICMS_URL . '/modules/' . ARTICLE_DIRNAME . '/');

if(!defined("ARTICLE_ROOT_PATH")) define("ARTICLE_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . ARTICLE_DIRNAME . '/');

if(!defined("ARTICLE_IMAGES_URL")) define("ARTICLE_IMAGES_URL", ARTICLE_URL . 'images/');

if(!defined("ARTICLE_ADMIN_URL")) define("ARTICLE_ADMIN_URL", ARTICLE_URL . 'admin/');

if(!defined("ARTICLE_TEMPLATES_URL")) define("ARTICLE_TEMPLATES_URL", ARTICLE_URL . 'templates/');

if(!defined("ARTICLE_IMAGES_ROOT")) define("ARTICLE_IMAGES_ROOT", ARTICLE_ROOT_PATH . 'images/');

if(!defined("ARTICLE_SCRIPT_ROOT")) define("ARTICLE_SCRIPT_ROOT", ARTICLE_ROOT_PATH . 'scripts/');

if(!defined("ARTICLE_UPLOAD_ROOT")) define("ARTICLE_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . ARTICLE_DIRNAME . '/');

if(!defined("ARTICLE_UPLOAD_URL")) define("ARTICLE_UPLOAD_URL", ICMS_URL . '/uploads/' . ARTICLE_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('article', 'common');

include_once ARTICLE_ROOT_PATH . '/include/functions.php';

$articleModule = icms_getModuleInfo( ARTICLE_DIRNAME );
if (is_object($articleModule)) {
	$article_moduleName = $articleModule->getVar('name');
}

$article_isAdmin = icms_userIsAdmin( ARTICLE_DIRNAME );

$articleConfig = icms_getModuleConfig( ARTICLE_DIRNAME );

$icmsPersistableRegistry = icms_ipf_registry_Handler::getInstance();