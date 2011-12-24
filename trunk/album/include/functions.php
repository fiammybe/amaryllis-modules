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

function album_display_new($time) {
	global $albumConfig;
	$new = ( time() - ( 86400 * intval( $albumConfig['album_daysnew'] ) ) );
	if ( icms::$module->config['albums_daysnew'] !== 0) {
		if ( $new > $time ) {
			$new = ALBUM_IMAGES_URL . 'new.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $new;
}

function album_display_updated($time) {
	global $albumConfig;
	$updated = ( time() - ( 86400 * intval( $albumConfig['album_daysupdated'] ) ) );
	if ( icms::$module->config['albums_daysupdated'] !== 0) {
		if ( $updated > $time ) {
			$updated = ALBUM_IMAGES_URL . 'updated.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $updated;
}

function album_display_popular($counter) {
	global $albumConfig;
	$popular = $albumConfig['albums_popular'];
	if ( $popular !== 0) {
		if ( $popular < $counter ) {
			$popular = ALBUM_IMAGES_URL . 'popular.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $popular;
}