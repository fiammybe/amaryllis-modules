<?php
/**
 * "Article" is an article management module for ImpressCMS
 *
 * File: /class/Category.php
 * 
 * Class representing Article category Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

function article_display_new($time) {
	global $articleConfig;
	$new = ( time() - ( 86400 * intval( $articleConfig['article_daysnew'] ) ) );
	if ( icms::$module->config['article_daysnew'] !== 0) {
		if ( $new > $time ) {
			$new = ARTICLE_IMAGES_URL . 'new.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $new;
}

function article_display_updated($time) {
	global $articleConfig;
	$updated = ( time() - ( 86400 * intval( $articleConfig['article_daysupdated'] ) ) );
	if ( icms::$module->config['article_daysupdated'] !== 0) {
		if ( $updated > $time ) {
			$updated = ARTICLE_IMAGES_URL . 'updated.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $updated;
}

function article_display_popular($counter) {
	global $articleConfig;
	$popular = $articleConfig['article_popular'];
	if ( $popular !== 0) {
		if ( $popular < $counter ) {
			$popular = ARTICLE_IMAGES_URL . 'popular.png';
			
		} else {
			return false;
		}
	} else {
		return false;
	}
	return $popular;
}

function articleConvertFileSize( $size, $type = 'byte', $decimal = 2 ) {
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

function articleFileSizeType ($type) {
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
