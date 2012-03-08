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
	$path = ICMS_ROOT_PATH . '/uploads/' . $moddir;
	if(!is_dir($path . '/indexpage')) icms_core_Filesystem::mkdir($path . '/indexpage');
	$image = 'career_indeximage.png';
	icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/' . $image, $path . '/indexpage/' . $image);
	return TRUE;
}

function career_indexpage() {
	$career_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'career' );
	$indexpageObj = $career_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'Career');
	$indexpageObj->setVar('index_heading', 'Here you can search our job offerings.');
	$indexpageObj->setVar('index_footer', '&copy; 2012 | Career module footer');
	$indexpageObj->setVar('index_image', 'career_indeximage.png');
	$career_indexpage_handler -> insert( $indexpageObj, TRUE );
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

	return TRUE;
}