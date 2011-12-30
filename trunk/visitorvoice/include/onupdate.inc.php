<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 * 
 * Install and update informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('VISITORVOICE_DB_VERSION', 1);

function visitorvoice_upload_paths() {
	
	//Create folders and set permissions
	$moddir = basename( dirname( dirname( __FILE__ ) ) );
	$visitorvoice = ICMS_ROOT_PATH . '/uploads/visitorvoice';
	if ( !is_dir( $visitorvoice . '/indeximages' ) ) {
		mkdir( $visitorvoice . '/indeximages', 0777, true );
		copy( ICMS_ROOT_PATH . '/uploads/index.html', ICMS_ROOT_PATH . '/uploads/' . $moddir . '/indeximages/index.html' );
		$contentx =@file_get_contents( ICMS_ROOT_PATH . '/modules/' . $moddir . '/images/visitorvoice_indeximage.png' );
		$openedfile = fopen( $visitorvoice . '/indeximages/visitorvoice_indeximage.png', "w" ); 
		fwrite( $openedfile, $contentx ); 
		fclose( $openedfile );
	}
}

function visitorvoice_indexpage() {
	$visitorvoice_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'visitorvoice' );
	$indexpageObj = $visitorvoice_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'My Visitorvoice');
	$indexpageObj->setVar('index_heading', 'Welcome to our Visitorvoice!');
	$indexpageObj->setVar('index_footer', '&copy; 2011 | Visitorvoice module footer');
	$indexpageObj->setVar('index_image', 'visitorvoice_indeximage.png');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$visitorvoice_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b>Visitorvoice Indexpage </b> successfully imported!<br />';
	echo '</code>';
}

function icms_module_update_visitorvoice($module) {
    return TRUE;
}

function icms_module_install_visitorvoice($module) {
	visitorvoice_upload_paths();
	visitorvoice_indexpage();
	return TRUE;
}