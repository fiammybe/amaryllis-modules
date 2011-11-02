<?php
/**
 * File containing onUpdate and onInstall functions for the module
 *
 * This file is included by the core in order to trigger onInstall or onUpdate functions when needed.
 * Of course, onUpdate function will be triggered when the module is updated, and onInstall when
 * the module is originally installed. The name of this file needs to be defined in the
 * icms_version.php
 *
 * <code>
 * $modversion['onInstall'] = "include/onupdate.inc.php";
 * $modversion['onUpdate'] = "include/onupdate.inc.php";
 * </code>
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 */

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// DEFINE SOME FOLDERS /////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

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
define('ALBUM_DB_VERSION', 1);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

// AUTHORIZING MOST NEEDED FILETYPES IN SYSTEM
function album_authorise_mimetypes() {
	$dirname = icms::$module -> getVar( 'dirname' );
	$extension_list = array(
		'png',
		'gif',
		'jpg',
	);
	$system_mimetype_handler = icms_getModuleHandler('mimetype', 'system');
	foreach ($extension_list as $extension) {
		$allowed_modules = array();
		$mimetypeObj = '';

		$criteria = new icms_db_criteria_Compo;
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

function album_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$album = ICMS_ROOT_PATH . '/uploads/album';
	if ( !is_dir( $album . '/albumimages' ) ) {
		mkdir( $album . '/albumimages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/album/index.html' );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/album/albumimages/index.html' );
		//Copy images to new folder
		$array = array( 'folder_black', 'folder_blue', 'folder_brown', 'folder_cyan', 'folder_green', 'folder_grey', 'folder_orange', 'folder_red', 'folder_violet', 'folder_yellow' );
		foreach ( $array as $value ) {
			$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/folders/' . $value . '.png' );
			$openedfile = fopen( $album . '/albumimages/' . $value . '.png', "w" ); 
			fwrite( $openedfile, $contentx );
			fclose( $openedfile );
		}
	}
	if ( !is_dir( $album . '/indeximages' ) ) {
		mkdir( $album . '/indeximages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/album/indeximages/index.html' );
		$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/album_indeximage.png' );
		$openedfile = fopen( $album . '/indeximages/album_indeximage.png', "w" ); 
		fwrite( $openedfile, $contentx ); 
		fclose( $openedfile );
	}
}

function album_indexpage() {
	$album_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'album' );
	$indexpageObj = $album_indexpage_handler -> create(true);
	echo '<code>';
	$indexpageObj -> setVar( 'index_header', 'My Photo Albums' );
	$indexpageObj -> setVar( 'index_heading', 'Here you can see my photo Albums' );
	$indexpageObj -> setVar( 'index_footer', '&copy; 2011 | Album module footer');
	$indexpageObj -> setVar( 'index_image', 'album_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('dobr', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$album_indexpage_handler -> insert( $indexpageObj, true );
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// UPDATE CCENTER MODULE ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function icms_module_update_album($module) {
    // check if upload directories exist and make them if not
	album_upload_paths();
	
	$icmsDatabaseUpdater = XoopsDatabaseFactory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module); 
    return TRUE;
}

function icms_module_install_album($module) {
	// check if upload directories exist and make them if not
	album_upload_paths();
	
	// authorise some audio mimetypes for convenience
	album_authorise_mimetypes();
	
	//prepare indexpage
	album_indexpage();

	return true;
}