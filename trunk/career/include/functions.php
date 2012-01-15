<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /include/functions.php
 * 
 * some functions
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

//generates the Career admin menu in ACP
function career_adminmenu( $currentoption = 0, $header = '', $menu = '', $extra = '', $scount = 5 ) {
	icms::$module -> displayAdminMenu( $currentoption, icms::$module -> getVar( 'name' ) . ' | ' . $header );
	echo '<h3 style="color: #2F5376;">' . $header . '</h3>';
}

function career_display_new($time) {
	global $careerConfig;
	$new = ( time() - ( 86400 * (int)( $careerConfig['career_daysnew'] ) ) );
	if ( icms::$module->config['career_daysnew'] !== 0) {
		if ( $new > $time ) {
			$new = CAREER_IMAGES_URL . 'new.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $new;
}

function career_display_updated($time) {
	global $careerConfig;
	$updated = ( time() - ( 86400 * (int)( $careerConfig['career_daysupdated'] ) ) );
	if ( icms::$module->config['career_daysupdated'] !== 0) {
		if ( $updated > $time ) {
			$updated = CAREER_IMAGES_URL . 'updated.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $updated;
}