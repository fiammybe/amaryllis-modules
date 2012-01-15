<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * contains install/update informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
icms_loadLanguageFile('career', 'common');
// this needs to be the latest db version
define('CAREER_DB_VERSION', 1);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function career_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$career = ICMS_ROOT_PATH . '/uploads/career';
	if ( !is_dir( $career . '/indeximages' ) ) {
		mkdir( $career . '/indeximages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/' . $moddir . '/indeximages/index.html' );
		$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/career_indeximage.png' );
		$openedfile = fopen( $career . '/indeximages/career_indeximage.png', "w" ); 
		fwrite( $openedfile, $contentx ); 
		fclose( $openedfile );
	}
	
}

function career_indexpage() {
	$career_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'career' );
	$indexpageObj = $career_indexpage_handler -> create(true);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'Career');
	$indexpageObj->setVar('index_heading', 'Here you can search our job offerings.');
	$indexpageObj->setVar('index_footer', '&copy; 2012 | Career module footer');
	$indexpageObj->setVar('index_image', 'career_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('dobr', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$career_indexpage_handler -> insert( $indexpageObj, true );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// UPDATE CAREER MODULE ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function icms_module_update_career($module) {
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_career($module) {
	// check if upload directories exist and make them if not
	career_upload_paths();
	
	//prepare indexpage
	career_indexpage();

	return true;
}