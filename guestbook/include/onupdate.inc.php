<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 * 
 * Install and update informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('GUESTBOOK_DB_VERSION', 1);

function guestbook_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$path = ICMS_ROOT_PATH . '/uploads/' . $moddir;
	if(!is_dir($path . '/indexpage')) icms_core_Filesystem::mkdir($path . '/indexpage');
	$image = 'guestbook_indeximage.png';
	icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/' . $image, $path . '/indexpage/' . $image);
	return TRUE;
}

function guestbook_indexpage() {
	$guestbook_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'guestbook' );
	$indexpageObj = $guestbook_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'My Guestbook');
	$indexpageObj->setVar('index_heading', 'Welcome to our Guestbook!');
	$indexpageObj->setVar('index_footer', '&copy; 2012 | Guestbook module footer');
	$indexpageObj->setVar('index_image', 'guestbook_indeximage.png');
	$guestbook_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b>Guestbook Indexpage </b> successfully imported!<br />';
	echo '</code>';
}

function icms_module_update_guestbook($module) {
    return TRUE;
}

function icms_module_install_guestbook($module) {
	guestbook_upload_paths();
	guestbook_indexpage();
	return TRUE;
}