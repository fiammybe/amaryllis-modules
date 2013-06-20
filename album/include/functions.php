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

defined("ICMS_ROOT_PATH") or die("ICMS Root path not defined");

/**
 * display icon for new albums
 */
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
/**
 * display icon for updated albums
 */
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
/**
 * display icon for popular albums
 */
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
/**
 * get album form
 */
function get_album_form($albumObj = 0, $clean_album_pid = 0) {
	global $album_handler, $icmsTpl, $albumConfig, $album_isAdmin, $album_page;
	if(is_object(icms::$user)) {
		$album_uid = icms::$user->getVar("uid");
	} else {
		$album_uid = 0;
	}
	if (!$albumObj->isNew()){
		if (!$albumObj->userCanEditAndDelete()) {
			redirect_header($albumObj->getItemLink(TRUE), 3, _NOPERM);
		}
		$albumObj->hideFieldFromForm(array('album_pid', 'album_updated', 'meta_description', 'meta_keywords', 'album_uid','album_active', 'album_approve'));
		$albumObj->setVar( 'album_updated_date', (time() - 100) );
		$albumObj->setVar('album_updated', TRUE );
		if($albumConfig['album_needs_approval'] == 1 && !$album_isAdmin) {
			$albumObj->setVar('album_approve', FALSE );
		} else {
			$albumObj->setVar('album_approve', TRUE );
		}
		$sform = $albumObj->getSecureForm(_MD_ALBUM_ALBUM_EDIT, 'addalbum', $album_page."?op=addalbum&album=" . $albumObj->short_url(), _CO_ICMS_SUBMIT, "location.href='$album_page.php'");
		$sform->assign($icmsTpl, 'album_album_form');
		$icmsTpl->assign('album_cat_path', _MD_ALBUM_ALBUM_EDIT." &raquo;".$albumObj->getVar('album_title', 'e')."&laquo;");
	} else {
		if (!$album_handler->userCanSubmit()) {
			redirect_header($albumObj->getItemLink(TRUE), 3, _NOPERM);
		}
		$albumObj->hideFieldFromForm(array('album_pid', 'album_updated', 'meta_description', 'meta_keywords', 'album_uid','album_active', 'album_approve'));
		$albumObj->setVar('album_published_date', (time() - 100) );
		if($albumConfig['album_needs_approval'] == 1) {
			$albumObj->setVar('album_approve', FALSE );
		} else {
			$albumObj->setVar('album_approve', TRUE );
		}
		$albumObj->setVar('album_uid', $album_uid);
		$albumObj->setVar('album_pid', $clean_album_pid);
		$sform = $albumObj->getSecureForm(_MD_ALBUM_ALBUM_CREATE, 'addalbum');
		$sform->assign($icmsTpl, 'album_album_form');
		$icmsTpl->assign('album_cat_path', $album_handler->getBreadcrumbForPid($clean_album_pid, 1) . ' > ' . _MD_ALBUM_ALBUM_CREATE);
	}
}

function get_images_form($imagesObj, $clean_album_id) {
	global $images_handler, $album_handler, $icmsTpl, $albumConfig, $album_isAdmin;
	$album_uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;

	if (!$imagesObj->isNew()){
		if(!$imagesObj->userCanEditAndDelete()) {
			redirect_header(icms_getPreviousPage(), 3, _NOPERM);
		}
		$imagesObj->hideFieldFromForm(array('a_id','meta_description', 'meta_keywords', 'img_publisher', 'img_active', 'img_approve', 'img_published_date', 'img_updated_date' ) );
		$imagesObj->setVar( 'img_updated_date', (time() - 100) );
		if($albumConfig['image_needs_approval'] == 1 && !$album_isAdmin) {
			$imagesObj->setVar('img_approve', FALSE );
		} else {
			$imagesObj->setVar('img_approve', TRUE );
		}
		$sform = $imagesObj->getSecureForm(_MD_ALBUM_IMAGES_EDIT . " &raquo;" . $imagesObj->getVar("img_title", "e"). "&laquo;", 'addimages');
		$sform->assign($icmsTpl, 'album_images_form');
		$icmsTpl->assign('category_path', "<li>".$imagesObj->getVar('img_title').' > '._EDIT.'</li>');
	} else {
		$imagesObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'img_updated','img_active', 'img_publisher', 'img_approve', 'img_published_date', 'img_updated_date' ) );
		$imagesObj->setVar('img_published_date', (time() - 100) );
		$imagesObj->setFieldAsRequired("img_url");
		if($albumConfig['image_needs_approval'] == 1 && !$album_isAdmin) {
			$imagesObj->setVar('img_approve', FALSE );
		} else {
			$imagesObj->setVar('img_approve', TRUE );
		}
		$imagesObj->setVar('img_publisher', $album_uid);
		$imagesObj->setVar('a_id', $clean_album_id);
		$sform = $imagesObj->getSecureForm(_MD_ALBUM_IMAGES_CREATE, 'addimages');
		$sform->assign($icmsTpl, 'album_images_form');
		$icmsTpl->assign('album_cat_path', _SUBMIT);
	}
}