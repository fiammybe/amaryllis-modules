<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 * 
 * Common File of the module included on all pages of the module
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('ARTICLE_DB_VERSION', 1);
if(!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", basename(dirname(dirname(__FILE__))));
if(!defined("ARTICLE_ROOT_PATH")) define("ARTICLE_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . ARTICLE_DIRNAME . '/');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function article_upload_paths() {
	$path = ICMS_ROOT_PATH . '/uploads/index/indexpage/';
	$image = 'article_indeximage.png';
	if(!is_file($path . $image)) icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . ARTICLE_DIRNAME . '/images/' . $image, $path . $image);
}

function article_indexpage() {
	$module_handler = icms::handler('icms_module');
	$module = $module_handler->getByDirname(ARTICLE_DIRNAME);
	$module_id = $module->getVar('mid');
	$indexpage_handler = icms_getModuleHandler('indexpage', 'index');
	$indexpageObj = $indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'Articles' );
	$indexpageObj->setVar('index_heading', 'Here you can search our articles. ' );
	$indexpageObj->setVar('index_footer', '&copy; ' . date("Y") . ' | Article module footer');
	$indexpageObj->setVar('index_image', 'article_indeximage.png');
	$indexpageObj->setVar('index_mid', $module_id);
	$indexpage_handler->insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully added!<br />';
	echo '</code>';
	unset($module_handler, $module, $module_id, $indexpage_handler, $indexpageObj);
	
}

function deleteLinkedModuleItems() {
	$module_handler = icms::handler('icms_module');
	$module = $module_handler->getByDirname(ARTICLE_DIRNAME);
	$module_id = $module->getVar('mid');
	$link_handler = icms_getModuleHandler("link", "index");
	$link_handler->deleteAllByMId($module_id);
	unset($link_handler);
	$indexpage_handler = icms_getModuleHandler("indexpage", "index");
	$indexpage_handler->deleteByMid($module_id);
	unset($indexpage_handler);
}

function deleteFiles() {
	icms_core_Filesystem::deleteRecursive(ICMS_UPLOAD_PATH . "/" . ARTICLE_DIRNAME);
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// UPDATE ARTICLE MODULE ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function icms_module_update_article($module) {
	// check if upload directories exist and make them if not
	article_upload_paths();
	
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater->moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_article($module) {
	// check if upload directories exist and make them if not
	article_upload_paths();
	
	//prepare indexpage
	article_indexpage();

	return TRUE;
}

function icms_module_uninstall_article($module) {
	// delete all linked items in index module
	deleteLinkedModuleItems();
	//delete all Files from upload folder, the connection.php in article module and the generated trust path file
	deleteFiles();
	return TRUE;
}