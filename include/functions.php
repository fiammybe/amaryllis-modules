<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /include/functions.php
 *
 * several functions used by album module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * 
 */

//generates the Album admin menu in ACP
function album_adminmenu( $currentoption = 0, $header = '', $menu = '', $extra = '', $scount = 5 ) {
	icms::$module -> displayAdminMenu( $currentoption, icms::$module -> getVar( 'name' ) . ' | ' . $header );
	echo '<h3 style="color: #2F5376;">' . $header . '</h3>';
}

function album_display_new($time, $timestamp) {
	global $albumConfig;
	
	$new = ( $timestamp - ( 86400 * (int)( $albumConfig['albums_daysnew'] ) ) );
	if ( $albumConfig['albums_daysnew'] != 0) {
		if ( $new < $time ) {
			$new_img = ALBUM_IMAGES_URL . 'new.png';
			
		} else {
			$new_img = FALSE;
		}
	} else {
		$new_img = FALSE;
	}
	return $new_img;
}

function album_display_updated($time, $timestamp) {
	global $albumConfig;
	$updated = ( $timestamp - ( 86400 * (int)( $albumConfig['albums_daysupdated'] ) ) );
	if ( $albumConfig['albums_daysupdated'] != 0) {
		if ( $updated < $time ) {
			$updated_img = ALBUM_IMAGES_URL . 'updated.png';
			
		} else {
			$updated_img = FALSE;
		}
	} else {
		$updated_img = FALSE;
	}
	return $updated_img;
}

function album_display_popular($counter) {
	global $albumConfig;
	$popular = (int)$albumConfig['albums_popular'];
	if ( $popular != 0) {
		if ( $popular < (int)$counter ) {
			$popular_img = ALBUM_IMAGES_URL . 'popular.png';
			
		} else {
			$popular_img = FALSE;
		}
	} else {
		$popular_img = FALSE;
	}
	return $popular_img;
}