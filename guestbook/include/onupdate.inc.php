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
	$guestbook = ICMS_ROOT_PATH . '/uploads/guestbook';
	if ( !is_dir( $guestbook . '/indeximages' ) ) {
		mkdir( $guestbook . '/indeximages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/' . $moddir . '/indeximages/index.html' );
		$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/guestbook_indeximage.png' );
		$openedfile = fopen( $guestbook . '/indeximages/guestbook_indeximage.png', "w" ); 
		fwrite( $openedfile, $contentx ); 
		fclose( $openedfile );
	}
}

function guestbook_indexpage() {
	$guestbook_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'guestbook' );
	$indexpageObj = $guestbook_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'My Guestbook');
	$indexpageObj->setVar('index_heading', 'Welcome to our Guestbook!');
	$indexpageObj->setVar('index_footer', '&copy; 2011 | Guestbook module footer');
	$indexpageObj->setVar('index_image', 'guestbook_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
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