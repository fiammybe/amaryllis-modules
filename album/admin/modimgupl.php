<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/modimgupl.php
 *
 * To upload new indeximages or new folderimages
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B
 * @version		$Id$
 * @package		album
 * @version		$Id$
 */

 include_once("admin_header.php");
 
 
 $allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');
 $maxfilesize = 100000;
 $maxfilewidth = 500;
 $maxfileheight = 500;
 $url = ALBUM_UPLOAD_ROOT . 'albumimages';
 $uploader = new icms_file_MediaUploadHandler($url, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
 if($uploader->fetchMedia($_POST['uploade_file_name'])) {
 	if(!$uploader->upload()) {
		echo $uploader->getErrors();
	} else {
		echo '<h4>File uploaded successfully!</h4>';
		echo 'Saved as: ' . $uploader->getSavedFileName() . '<br />';
    	echo 'Full path: ' . $uploader->getSavedDestination();
	}
 } else {
	echo $uploader->getErrors();
 }
 $icmsAdminTpl->assign( 'album_media_uploader_folder', $uploader );
 $icmsAdminTpl->display( 'db:album_admin_form.html' );
 
 $allowed_mimetypes2 = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');
 $maxfilesize2 = 100000;
 $maxfilewidth2 = 500;
 $maxfileheight2 = 500;
 $url2 = ALBUM_UPLOAD_ROOT . 'indeximages';
 $uploader2 = new icms_file_MediaUploadHandler($url2, $allowed_mimetypes2, $maxfilesize2, $maxfilewidth2, $maxfileheight2);
 if($uploader2->fetchMedia($_POST['uploade_file_name'])) {
 	if(!$uploader2->upload()) {
		echo $uploader2->getErrors();
	} else {
		echo '<h4>File uploaded successfully!</h4>';
		echo 'Saved as: ' . $uploader2->getSavedFileName() . '<br />';
    	echo 'Full path: ' . $uploader2->getSavedDestination();
	}
 } else {
	echo $uploader2->getErrors();
 }
 $icmsAdminTpl->assign( 'album_media_uploader_index', $uploader2 );
 $icmsAdminTpl->display( 'db:album_admin_form.html' );
