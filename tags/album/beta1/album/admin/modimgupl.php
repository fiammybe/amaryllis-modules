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
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * 
 */

 include_once 'admin_header.php';
 
 $clean_op = $valdid_op = '';

 $valid_op = array ('mod', 'upload', 'albumimageupload', 'formSelect', '');

 if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
 if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

 if(in_array($clean_op, $valid_op, true)) {
 	switch ($clean_op) {
		case 'delete':
			 
			 break;
		case 'albumimageupload':
			if ( $_FILES['albumimage']['name'] != '' ) {
				$allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
				$maxfilesize = 100000;
				$maxfilewidth = 500;
				$maxfileheight = 500;
				$url = ALBUM_UPLOAD_ROOT . 'albumimages';
			
				$uploader = new icms_file_MediaUploadHandler($url, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
				if($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {		//if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
					$uploader->setPrefix('album');
					if(!$uploader->upload()) {
						icms_cp_header();
						album_adminmenu( 3, _MI_ALBUM_MENU_IMAGEUPLOAD );
						echo $uploader->getErrors();
					} else {
						icms_cp_header();
						album_adminmenu( 3, _MI_ALBUM_MENU_IMAGEUPLOAD );
						echo '<h4>File uploaded successfully!</h4>';
						echo 'Saved as: ' . $uploader->getSavedFileName() . '<br />';
						echo 'Full path: ' . $uploader->getSavedDestination();
					}
				} else {
					icms_cp_header();
					album_adminmenu( 3, _MI_ALBUM_MENU_IMAGEUPLOAD );
					echo $uploader->getErrors();
				}
			} else {
				redirect_header( 'modimgupl.php', 2 , _AM_ALBUM_ALBUM_NOIMAGEEXIST );
				exit();
			} 
			 
			break;
		case 'indeximageupload':
			if ( $_FILES['indeximage']['name'] != '' ) {
				$allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
				$maxfilesize = 100000;
				$maxfilewidth = 500;
				$maxfileheight = 500;
				$url = ALBUM_UPLOAD_ROOT . 'indeximages';
			
				$uploader = new icms_file_MediaUploadHandler($url, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
				if($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {		//if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
					$uploader->setPrefix('indeximage');
					if(!$uploader->upload()) {
						icms_cp_header();
						album_adminmenu( 3, _MI_ALBUM_MENU_IMAGEUPLOAD );
						echo $uploader->getErrors();
					} else {
						icms_cp_header();
						album_adminmenu( 3, _MI_ALBUM_MENU_IMAGEUPLOAD );
						echo '<h4>File uploaded successfully!</h4>';
						echo 'Saved as: ' . $uploader->getSavedFileName() . '<br />';
						echo 'Full path: ' . $uploader->getSavedDestination();
					}
				} else {
					icms_cp_header();
					album_adminmenu( 3, _MI_ALBUM_MENU_IMAGEUPLOAD );
					echo $uploader->getErrors();
				}
			} else {
				redirect_header( 'modimgupl.php', 2 , _AM_ALBUM_ALBUM_NOIMAGEEXIST );
				exit();
			} 
			break;
		 
		 default:
			icms_cp_header();
			album_adminmenu( 3, _MI_ALBUM_MENU_IMAGEUPLOAD );
			// upload albumimages
			$sform = new icms_form_Theme(_AM_ALBUM_MODIMGUPLOAD, 'op', ALBUM_ADMIN_URL . 'modimgupl.php', 'post', true);
			$sform->setExtra('enctype="multipart/form-data"');
			$sform->addElement(new icms_form_elements_File(_AM_ALBUM_FUPLOAD, 'albumimage', 0), true);
			$sform->addElement(new icms_form_elements_Hidden('op', 'albumimageupload'));
			$sform->addElement(new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit'));
			$sform->display();
			// upload indeximages
			$sform = new icms_form_Theme(_AM_ALBUM_MODIMGUPLOAD, 'op', ALBUM_ADMIN_URL . 'modimgupl.php', 'post', true);
			$sform->setExtra('enctype="multipart/form-data"');
			$sform->addElement(new icms_form_elements_File(_AM_ALBUM_FUPLOAD, 'indeximage', 0), true);
			$sform->addElement(new icms_form_elements_Hidden('op', 'indeximageupload'));
			$sform->addElement(new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit'));
			$sform->display();
			break;
	}
	icms_cp_footer();
 
}
 