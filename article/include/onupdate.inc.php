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
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$path = ICMS_ROOT_PATH . '/uploads/' . $moddir;
		if(!is_dir($path . '/category')) icms_core_Filesystem::mkdir($path . '/category');
		$categoryimages = array();
		$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/modules/' . $moddir .'/images/folders/', '', array('gif', 'jpg', 'png'));
		foreach($categoryimages as $image) {
			icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $image, $path . '/category/' . $image);
		}
		icms_core_Filesystem::mkdir($path . '/indexpage');
		$image2 = 'article_indeximage.png';
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/' . $image2, $path . '/indexpage/' . $image2);
}

function copySitemapPlugin() {
	$dir = ICMS_ROOT_PATH . '/modules/article/extras/modules/sitemap/';
	$file = 'article.php';
	$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
	if(is_dir($plugin_folder)) {
		icms_core_Filesystem::copyRecursive($dir . $file, $plugin_folder . $file);
	}
}

function article_indexpage() {
	$article_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'article' );
	$indexpageObj = $article_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj -> setVar( 'index_header', 'Articles' );
	$indexpageObj -> setVar( 'index_heading', 'Here you can search our articles. ' );
	$indexpageObj -> setVar( 'index_footer', '&copy; 2012 | Article module footer');
	$indexpageObj -> setVar( 'index_image', 'article_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('dobr', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$article_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
}

function createPWSalt() {
	$filename = 'article_' . substr(md5(uniqid(rand())), 27);
	$connfile = "conn.php";
	$content = file_get_contents(ARTICLE_ROOT_PATH . "extras/conn.php");
	$content .= "//define path to Article Connections /n";
	$content .= "define( 'ARTICLE_CONNECTION_PATH', ICMS_TRUST_PATH . '/' . " . $filename . " ); /n";
	icms_core_Filesystem::writeFile($content, $filename, "php", ARTICLE_ROOT_PATH);
	chmod(ARTICLE_ROOT_PATH . $conn, 0444);
	return $filename;
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
	
	// copy sitemap plugin
	copySitemapPlugin();

	return TRUE;
}