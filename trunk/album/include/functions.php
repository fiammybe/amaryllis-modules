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
	
	$new = ( $timestamp - ( 86400 * intval( $albumConfig['albums_daysnew'] ) ) );
	if ( $albumConfig['albums_daysnew'] != 0) {
		if ( $new < $time ) {
			$new_img = '<img src="' . ALBUM_IMAGES_URL . 'new.png" title="new" alt="new" />';
			
		} else {
			$new_img = false;
		}
	} else {
		$new_img = false;
	}
	return $new_img;
}

function album_display_updated($time, $timestamp) {
	global $albumConfig;
	$updated = ( $timestamp - ( 86400 * intval( $albumConfig['albums_daysupdated'] ) ) );
	if ( $albumConfig['albums_daysupdated'] != 0) {
		if ( $updated < $time ) {
			$updated_img = '<img src="' . ALBUM_IMAGES_URL . 'updated.png" title="updated" alt="updated" />';
			
		} else {
			$updated_img = false;
		}
	} else {
		$updated_img = false;
	}
	return $updated_img;
}

function album_display_popular($counter) {
	global $albumConfig;
	$popular = $albumConfig['albums_popular'];
	if ( $popular != 0) {
		if ( $popular < $counter ) {
			$popular = '<img src="' . ALBUM_IMAGES_URL . 'popular.png" title="popular" alt="popular" />';
			
		} else {
			$popular = false;
		}
	} else {
		$popular = false;
	}
	return $popular;
}