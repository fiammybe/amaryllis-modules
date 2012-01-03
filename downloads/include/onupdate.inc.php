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

// AUTHORIZING MOST NEEDED FILETYPES IN SYSTEM
function downloads_authorise_mimetypes() {
	$dirname = icms::$module -> getVar( 'dirname' );
	$extension_list = array(
		"png",
		"gif",
		"jpg",
		"zip",
		"jpeg",
		"pdf",
		"bmp"
		
	);
	$system_mimetype_handler = icms_getModuleHandler('mimetype', 'system');
	foreach ($extension_list as $extension) {
		$allowed_modules = array();
		$mimetypeObj = '';

		$criteria = new icms_db_criteria_Compo();
		$criteria->add( new icms_db_criteria_Item('extension', $extension));
		$mimetypeObj = array_shift($system_mimetype_handler->getObjects($criteria));

		if ($mimetypeObj) {
			$allowed_modules = $mimetypeObj->getVar('dirname');
			if (empty($allowed_modules)) {
				$mimetypeObj->setVar('dirname', $dirname);
				$mimetypeObj->store();
			} else {
				if (!in_array($dirname, $allowed_modules)) {
					$allowed_modules[] = $dirname;
					$mimetypeObj->setVar('dirname', $allowed_modules);
					$mimetypeObj->store();
				}
			}
		}
	}
}

function downloads_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$downloads = ICMS_ROOT_PATH . '/uploads/downloads';
	if ( !is_dir( $downloads . '/categoryimages' ) ) {
		mkdir( $downloads . '/categoryimages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/downloads/index.html' );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/downloads/categoryimages/index.html' );
		//Copy images to new folder
		$array = array( 'folder_black', 'folder_blue', 'folder_brown', 'folder_cyan', 'folder_green', 'folder_grey', 'folder_orange', 'folder_red', 'folder_violet', 'folder_yellow' );
		foreach ( $array as $value ) {
			$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $value . '.png' );
			$openedfile = fopen( $downloads . '/categoryimages/' . $value . '.png', "w" ); 
			fwrite( $openedfile, $contentx );
			fclose( $openedfile );
		}
	}
	if ( !is_dir( $downloads . '/indeximages' ) ) {
		mkdir( $downloads . '/indeximages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/' . $moddir . '/indeximages/index.html' );
		$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/downloads_indeximage.png' );
		$openedfile = fopen( $downloads . '/indeximages/downloads_indeximage.png', "w" ); 
		fwrite( $openedfile, $contentx ); 
		fclose( $openedfile );
	}
	
}

function downloads_indexpage() {
	$downloads_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'downloads' );
	$indexpageObj = $downloads_indexpage_handler -> create(true);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'Shared Files');
	$indexpageObj->setVar('index_heading', 'Here you can search our shared files.');
	$indexpageObj->setVar('index_footer', '&copy; 2011 | Downloads module footer');
	$indexpageObj->setVar('index_image', 'downloads_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('dobr', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$downloads_indexpage_handler -> insert( $indexpageObj, true );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// UPDATE DOWNLOADS MODULE ///////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function icms_module_update_downloads($module) {
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_downloads($module) {
	// check if upload directories exist and make them if not
	downloads_upload_paths();
	
	// authorise some audio mimetypes for convenience
	downloads_authorise_mimetypes();
	
	//prepare indexpage
	downloads_indexpage();

	return true;
}