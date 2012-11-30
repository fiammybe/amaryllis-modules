<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /include/onupdate.inc.php
 * 
 * additional informations for install/uninstall/update icmspoll module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('ICMSPOLL_DB_VERSION', 1);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function icmspoll_upload_paths() {
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$path = ICMS_UPLOAD_PATH . '/' . $moddir;
	if(!is_dir($path . "/indexpage")) icms_core_Filesystem::mkdir($path . '/indexpage', 0777, TRUE);
	$image2 = 'icmspoll_indeximage.png';
	icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/' . $image2, $path . '/indexpage/' . $image2);
}

function icmspoll_remove_paths(){
	$moddir = basename(dirname(dirname(__FILE__)));
	$filename = ICMS_ROOT_PATH . '/uploads/' . $moddir . '/indexpage';
	if(is_dir($filename)) icms_core_Filesystem::deleteRecursive($filename);
}

function copySitemapPlugin() {
	$moddir = basename(dirname(dirname(__FILE__)));
	$dir = ICMS_ROOT_PATH . '/modules/' . $moddir . '/extras/modules/sitemap/';
	$file = 'icmspoll.php';
	$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
	if(is_dir($plugin_folder) && !is_file($plugin_folder . $file)) {
		icms_core_Filesystem::copyRecursive($dir . $file, $plugin_folder . $file);
		echo '<code>&nbsp;&nbsp;-- <b> Sitemap plugin </b> successfully copied!<br /></code>';
	}
}

function deleteSitemapPlugin() {
	$plugin = ICMS_ROOT_PATH . '/modules/sitemap/plugins/icmspoll.php';
	if(is_file($plugin)) icms_core_Filesystem::deleteFile($plugin);
}

function icmspoll_indexpage() {
	$icmspoll_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'icmspoll' );
	$indexpageObj = $icmspoll_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj -> setVar( 'index_header', 'Polls' );
	$indexpageObj -> setVar( 'index_heading', 'We need your feedback! Search our polls and vote your mind!' );
	$indexpageObj -> setVar( 'index_footer', '&copy; 2012 | Icmspoll module footer');
	$indexpageObj -> setVar( 'index_image', 'icmspoll_indeximage.png');
	$icmspoll_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully created!<br />';
	echo '</code>';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// UPDATE ICMSPOLL MODULE ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * update icmspoll
 */
function icms_module_update_icmspoll($module) {
	// check if upload directories exist and make them if not
	icmspoll_upload_paths();
	// if sitemap is installed now, copy plugin
	copySitemapPlugin();
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}
/**
 * install icmspoll
 */
function icms_module_install_icmspoll($module) {
	// check if upload directories exist and make them if not
	icmspoll_upload_paths();
	//prepare indexpage
	icmspoll_indexpage();
	// copy sitemap plugin
	copySitemapPlugin();
	return TRUE;
}
/**
 * uninstall icmspoll
 */
function icms_module_uninstall_icmspoll($module) {
	//remove sitemap plugin
	deleteSitemapPlugin();
	//remove indexpage directory
	icmspoll_remove_paths();
	return TRUE;
}