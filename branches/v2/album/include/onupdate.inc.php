<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/AlbumHandler.php
 * 
 * File containing onupdate and oninstall functions of album module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: onupdate.inc.php 684 2012-07-07 15:02:21Z st.flohrer $
 * @package		album
 *
 */
 
if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// DEFINE SOME PATHS //////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));


// this needs to be the latest db version
define('ALBUM_DB_VERSION',2);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function album_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$path = ICMS_UPLOAD_PATH . '/album';
	if(!is_dir($path . '/album')) mkdir($path . '/album', 0777);
	$categoryimages = array();
	$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/modules/album/images/folders/', '', array('gif', 'jpg', 'png'));
	foreach($categoryimages as $image) {
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $image, $path . '/album/' . $image);
	}
	if(!is_dir($path . '/batch')) mkdir($path . '/batch', '0777', TRUE);
	return TRUE;
}

function album_indexpage() {
	if(icms_get_module_status("index")) {
		$mid = icms::handler('icms_module')->getByDirname(ALBUM_DIRNAME)->getVar('mid');
	
		$indexModule = icms_getModuleInfo("index");
		$indexpage_handler = icms_getModuleHandler( 'indexpage', $indexModule->getVar("dirname"), 'index' );
		
		$index_path = ICMS_UPLOAD_PATH . '/' . $indexModule->getVar("dirname") . '/' . $indexpage_handler->_itemname;
		$image = 'album_indeximage.png';
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . ALBUM_DIRNAME . '/images/' . $image, $index_path . '/' . $image);
		
		$indexpageObj = $indexpage_handler->create(TRUE);
		$indexpageObj->setVar('index_header', 'My Photo Albums' );
		$indexpageObj->setVar('index_heading', 'Here you can see my photo Albums' );
		$indexpageObj->setVar('index_footer', '&copy; 2012 | Album module footer');
		$indexpageObj->setVar('index_image', 'album_indeximage.png');
		$indexpageObj->setVar('index_mid', $mid);
		$indexpage_handler -> insert($indexpageObj, TRUE);
		echo '<code>';
		echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully created!<br />';
		echo '&nbsp;&nbsp;-- <b> Indeximage </b> successfully moved!<br />';
		echo '</code>';
	}
}

function deleteLinkedModuleItems() {
	$module_handler = icms::handler('icms_module');
	$module = $module_handler->getByDirname(ALBUM_DIRNAME);
	$module_id = $module->getVar('mid');
	$link_handler = icms_getModuleHandler("link", "index");
	$link_handler->deleteAllByMId($module_id);
	unset($link_handler);
	$indexpage_handler = icms_getModuleHandler("indexpage", "index");
	$indexpage_handler->deleteByMid($module_id);
	unset($indexpage_handler);
}

function copySitemapPlugin() {
	$dir = ICMS_ROOT_PATH . '/modules/album/extras/modules/sitemap/';
	$file = 'album.php';
	$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
	if(is_dir($plugin_folder)) {
		icms_core_Filesystem::copyRecursive($dir . $file, $plugin_folder . $file);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// UPDATE ALBUM MODULE /////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function icms_module_update_album($module) {
    // check if upload directories exist and make them if not
	album_upload_paths();
	
	// copy sitemap plugin, if sitemap is installed
	copySitemapPlugin();
	
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_album($module) {
	// check if upload directories exist and make them if not
	album_upload_paths();
	
	//prepare indexpage
	album_indexpage();
	
	// copy sitemap plugin, if sitemap is installed
	//copySitemapPlugin();

	return TRUE;
}

function icms_module_uninstall_album($module) {
	deleteLinkedModuleItems();
	
	return TRUE;
}