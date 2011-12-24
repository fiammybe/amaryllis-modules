<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /index.php
 *
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * @version		$Id$
 * 
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'album_index.html';

include_once ICMS_ROOT_PATH . '/header.php';
/** Use a naming convention that indicates the source of the content of the variable */
$clean_album_start = isset($_GET['album_nav']) ? filter_input(INPUT_GET, 'album_nav') : 0;
$clean_img_start = isset($_GET['img_nav']) ? filter_input(INPUT_GET, 'img_nav') : 0;
$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;
$clean_album_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : false;
$clean_album_pid = isset($_GET['pid']) ? filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT) : ($clean_album_uid ? false : 0);
$clean_img_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_a_id = isset($_GET['a_id']) ? filter_input(INPUT_GET, 'a_id', FILTER_SANITIZE_NUMBER_INT) : 0;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$album_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'album' );
$indexpageObj = $album_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('album_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// ALBUM LIST ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$album_album_handler = icms_getModuleHandler('album', basename(dirname(__FILE__)), 'album');
if ($clean_album_id != 0) {
	$albumObj = $album_album_handler->get($clean_album_id);
} else {
	$albumObj = false;
}
/**
 * retrieve a single album with subalbums and images
 */
if(is_object($albumObj) && $albumObj->accessGranted()){
	$album_album_handler->updateCounter($clean_album_id);
	$album = $album_obj->toArray();
	$icmsTpl->assign('single_album', $album);
	/**
	 * retrieve the images of these album, if there are some
	 */
	$album_images_handler = icms_getModuleHandler('images', basename(dirname(__FILE__)), 'album');
	$images = $album_images_handler->getImages(TRUE, TRUE, $clean_img_start, $albumConfig['show_images'], 'weight', 'ASC', $clean_a_id);
	$icmsTpl->assign('images', $images);
	/**
	 * assign breadcrumb
	 */
	if ($albumConfig['show_breadcrumbs']){
		$icmsTpl->assign('album_cat_path', $album_album_handler->getBreadcrumbForPid($albumObj->getVar('album_id', 'e'), 1));
	}else{
		$icmsTpl->assign('album_cat_path',false);
	}
	if($album_album_handler->userCanSubmit()) {
		$icmsTpl->assign('user_submit', true);
		$icmsTpl->assign('user_submit_link', ALBUM_URL . 'album.php?op=mod&album_id=' . $albumObj->getVar("album_id"));
	} else {
		$icmsTpl->assign('user_submit', false);
	}
/**
 * retrieve album index view
 */
} elseif ($clean_album_id == 0) {
	$album = $album_album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_album_start, $albumConfig['show_albums'], $clean_album_uid, $clean_album_id, $clean_album_pid, 'weight', 'ASC');
	$icmsTpl->assign('album_index', $album);
/**
 * if permissions denied for a single album, redirect to index view
 */
} else {
	redirect_header(ALBUM_URL, 3, _NO_PERM);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$album_count = $album_album_handler->getAlbumsCount(TRUE, TRUE, TRUE, $groups, 'album_grpperm', $clean_album_uid, $clean_album_id, $clean_album_pid);
$images_count = $album_images_handler->getImagesCount (TRUE, TRUE, $clean_album_id);
if (!empty($clean_album_id)) {
	$extra_arg = 'album_id=' . $clean_album_id;
} else {
	$extra_arg = false;
}
$pagenav = new icms_view_PageNav($album_count, $albumConfig['show_albums'], $clean_album_start, 'album_nav', $extra_arg);
$imagesnav = new icms_view_PageNav($images_count, $albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg);
$icmsTpl->assign('pagenav', $pagenav->renderNav());
$icmsTpl->assign('imgnav', $imagenav->renderNav());

include_once 'footer.php';