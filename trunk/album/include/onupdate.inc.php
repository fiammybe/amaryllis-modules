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
 * @version		$Id$
 * @package		album
 *
 */
 
if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// DEFINE SOME PATHS //////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("ALBUM_URL")) define("ALBUM_URL", ICMS_URL . '/modules/' . ALBUM_DIRNAME . '/');

if(!defined("ALBUM_ROOT_PATH")) define("ALBUM_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . ALBUM_DIRNAME . '/');

if(!defined("ALBUM_IMAGES_URL")) define("ALBUM_IMAGES_URL", ALBUM_URL . 'images/');

if(!defined("ALBUM_ADMIN_URL")) define("ALBUM_ADMIN_URL", ALBUM_URL . 'admin/');

if(!defined("ALBUM_TEMPLATES_URL")) define("ALBUM_TEMPLATES_URL", ALBUM_URL . 'templates/');

if(!defined("ALBUM_IMAGES_ROOT")) define("ALBUM_IMAGES_ROOT", ALBUM_ROOT_PATH . 'images/');

if(!defined("ALBUM_UPLOAD_ROOT")) define("ALBUM_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . ALBUM_DIRNAME . '/');

if(!defined("ALBUM_UPLOAD_URL")) define("ALBUM_UPLOAD_URL", ICMS_URL . '/uploads/' . ALBUM_DIRNAME . '/');



// this needs to be the latest db version
define('ALBUM_DB_VERSION',2);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function album_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$path = ICMS_UPLOAD_PATH . '/album';
	if(!is_dir($path . '/album')) icms_core_Filesystem::mkdir($path . '/album');
	$categoryimages = array();
	$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/modules/album/images/folders/', '', array('gif', 'jpg', 'png'));
	foreach($categoryimages as $image) {
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $image, $path . '/album/' . $image);
	}
	if(!is_dir($path . '/indexpage')) icms_core_Filesystem::mkdir($path . '/indexpage');
	$image = 'album_indeximage.png';
	icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/' . $image, $path . '/indexpage/' . $image);
	if(!is_dir($path . '/batch')) icms_core_Filesystem::mkdir($path . '/batch');
	return TRUE;
}

function album_indexpage() {
	$album_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'album' );
	$indexpageObj = $album_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar( 'index_header', 'My Photo Albums' );
	$indexpageObj->setVar( 'index_heading', 'Here you can see my photo Albums' );
	$indexpageObj->setVar( 'index_footer', '&copy; 2012 | Album module footer');
	$indexpageObj->setVar( 'index_image', 'album_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('dobr', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$album_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
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
	copySitemapPlugin();

	return TRUE;
}

function icms_module_uninstall_album($module) {
	
	return TRUE;
}