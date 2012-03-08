<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 * 
 * File holding functions used by the module installation
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
icms_loadLanguageFile('downloads', 'common');
// this needs to be the latest db version
define('DOWNLOADS_DB_VERSION', 1);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function downloads_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$path = ICMS_ROOT_PATH . '/uploads/downloads';
		if(!is_dir($path . '/category')) icms_core_Filesystem::mkdir($path . '/category');
		$categoryimages = array();
		$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/modules/downloads/images/folders/', '', array('gif', 'jpg', 'png'));
		foreach($categoryimages as $image) {
			icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $image, $path . '/category/' . $image);
		}
		if(!is_dir($path . '/indexpage')) icms_core_Filesystem::mkdir($path . '/indexpage');
		$image = 'downloads_indeximage.png';
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/' . $image, $path . '/indexpage/' . $image);
		return TRUE;
}

function downloads_indexpage() {
	$downloads_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'downloads' );
	$indexpageObj = $downloads_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'Shared Files');
	$indexpageObj->setVar('index_heading', 'Here you can search our shared files.');
	$indexpageObj->setVar('index_footer', '&copy; 2012 | Downloads module footer');
	$indexpageObj->setVar('index_image', 'downloads_indeximage.png');
	$downloads_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
}

function copySitemapPlugin() {
	$dir = ICMS_ROOT_PATH . '/modules/downloads/extras/modules/sitemap/';
	$file = 'downloads.php';
	$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
	if(is_dir($plugin_folder)) {
		icms_core_Filesystem::copyRecursive($dir . $file, $plugin_folder . $file);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// UPDATE DOWNLOADS MODULE ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function icms_module_update_downloads($module) {
	// check if upload directories exist and make them if not
	downloads_upload_paths();
	
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_downloads($module) {
	// check if upload directories exist and make them if not
	downloads_upload_paths();
	
	//prepare indexpage
	downloads_indexpage();
	
	//copy sitemap plugin if installed
	copySitemapPlugin();

	return TRUE;
}