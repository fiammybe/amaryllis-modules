<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/functions.php
 * 
 * File holding functions used by the module
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

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

//generates the Downloads admin menu in ACP
function downloads_adminmenu( $currentoption = 0, $header = '', $menu = '', $extra = '', $scount = 5 ) {
	icms::$module -> displayAdminMenu( $currentoption, icms::$module -> getVar( 'name' ) . ' | ' . $header );
	echo '<h3 style="color: #2F5376;">' . $header . '</h3>';
}

function downloads_display_new($time) {
	global $downloadsConfig;
	$new = ( time() - ( 86400 * intval( $downloadsConfig['downloads_daysnew'] ) ) );
	if ( icms::$module->config['downloads_daysnew'] !== 0) {
		if ( $new > $time ) {
			$new = DOWNLOADS_IMAGES_URL . 'new.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $new;
}

function downloads_display_updated($time) {
	global $downloadsConfig;
	$updated = ( time() - ( 86400 * intval( $downloadsConfig['downloads_daysupdated'] ) ) );
	if ( icms::$module->config['downloads_daysupdated'] !== 0) {
		if ( $updated > $time ) {
			$updated = DOWNLOADS_IMAGES_URL . 'updated.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $updated;
}

function downloads_display_popular($counter) {
	global $downloadsConfig;
	$popular = $downloadsConfig['downloads_popular'];
	if ( $popular !== 0) {
		if ( $popular > $counter ) {
			$popular = DOWNLOADS_IMAGES_URL . 'popular.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $popular;
}

function downloadsConvertFileSize( $size, $type = 'byte', $decimal = 2 ) {
	$size = intval( $size );
	switch ($type) {
		case 'kb':
			return round( ($size / pow( 1024, 1 )), $decimal );
			break;
			
		case 'mb':
			return round( ($size / pow( 1024, 2 )), $decimal );
			break;
 
		case 'gb':
			return round( ($size / pow( 1024, 3 )), $decimal );
			break;

		default:
			return $size;
			break;
	}
}

function downloadsFileSizeType ($type) {
	switch ($type) {
		case '1':
			return 'byte';
			break;
			
		case '2':
			return 'kb';
			break;
			
		case '3':
			return 'mb';
			break;
			
		case '4':
			return 'gb';
			break;
	}
}
