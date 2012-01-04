<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('ARTICLE_DB_VERSION', 1);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function article_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$article = ICMS_ROOT_PATH . '/uploads/article';
	if ( !is_dir( $article . '/categoryimages' ) ) {
		mkdir( $article . '/categoryimages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/article/index.html' );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/article/categoryimages/index.html' );
		//Copy images to new folder
		$array = array( 'folder_black', 'folder_blue', 'folder_brown', 'folder_cyan', 'folder_green', 'folder_grey', 'folder_orange', 'folder_red', 'folder_violet', 'folder_yellow' );
		foreach ( $array as $value ) {
			$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $value . '.png' );
			$openedfile = fopen( $article . '/categoryimages/' . $value . '.png', "w" ); 
			fwrite( $openedfile, $contentx );
			fclose( $openedfile );
		}
	}
	if ( !is_dir( $article . '/indeximages' ) ) {
		mkdir( $article . '/indeximages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/' . $moddir . '/indeximages/index.html' );
		$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/article_indeximage.png' );
		$openedfile = fopen( $article . '/indeximages/article_indeximage.png', "w" ); 
		fwrite( $openedfile, $contentx ); 
		fclose( $openedfile );
	}
	
}

function article_indexpage() {
	$article_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'article' );
	$indexpageObj = $article_indexpage_handler -> create(true);
	echo '<code>';
	$indexpageObj -> setVar( 'index_header', 'Articles' );
	$indexpageObj -> setVar( 'index_heading', 'Here you can search our articles. ' );
	$indexpageObj -> setVar( 'index_footer', '&copy; 2011 | Article module footer');
	$indexpageObj -> setVar( 'index_image', 'article_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('dobr', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$article_indexpage_handler -> insert( $indexpageObj, true );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// UPDATE ARTICLE MODULE ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function icms_module_update_article($module) {
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_article($module) {
	// check if upload directories exist and make them if not
	article_upload_paths();
	
	//prepare indexpage
	article_indexpage();

	return true;
}