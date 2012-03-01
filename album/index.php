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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$album_indexpage_handler = icms_getModuleHandler( 'indexpage', ALBUM_DIRNAME, 'album' );
$indexpageObj = $album_indexpage_handler->get(1);
$index = $indexpageObj->toArray();
$icmsTpl->assign('album_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// ALBUM LIST ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/** Use a naming convention that indicates the source of the content of the variable */
$clean_album_start = isset($_GET['album_nav']) ? (int)($_GET['album_nav']) : 0;
$clean_img_start = isset($_GET['img_nav']) ? (int)($_GET['img_nav']) : 0;
$clean_short_url = isset($_GET['album']) ? filter_input(INPUT_GET, 'album') : FALSE;
$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

$clean_img_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_a_id = isset($_GET['a_id']) ? filter_input(INPUT_GET, 'a_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$album_album_handler = icms_getModuleHandler('album', basename(dirname(__FILE__)), 'album');
$album_images_handler = icms_getModuleHandler('images', basename(dirname(__FILE__)), 'album');

$valid_op = array ('getByTags', 'getByPublisher', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if(in_array($clean_op, $valid_op)) {
	switch ($clean_op) {
		case 'getByTags':
			$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
			if($albumConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
				$clean_tag_id = isset($_GET['tag']) ? filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_NUMBER_INT) : 0;
				$images = $album_images_handler->getImages(TRUE, TRUE, $clean_img_start, $albumConfig['show_images'], 'weight', 'ASC', FALSE, $clean_tag_id);
				$album_image_rows = array_chunk($images, $albumConfig['show_images_per_row']);
				$icmsTpl->assign('album_image_rows', $album_image_rows);
				$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
				$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';
				$icmsTpl->assign('album_row_margins', $album_row_margins);
				$icmsTpl->assign('album_image_margins', $album_image_margins);
				$icmsTpl->assign('byTags', TRUE);
				$icmsTpl->assign('tag_id', $clean_tag_id);
				$icmsTpl->assign("sprockets_module", TRUE);
				/**
				 * pagination control
				 */
				$images_count = $album_images_handler->getImagesCount(TRUE, TRUE, FALSE, $clean_tag_id, FALSE);
				$extra_arg = 'op=getByTags&tag=' . $clean_tag_id;
				$imagesnav = new icms_view_PageNav($images_count, $albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg);
				$icmsTpl->assign('imgnav', $imagesnav->renderNav());
				/**
				 * breadcrumb
				 */
				$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname"), "sprockets");
				$tagObj = $sprockets_tag_handler->get($clean_tag_id);
				if ($albumConfig['show_breadcrumbs']){
					$icmsTpl->assign('album_cat_path', $tagObj->getVar("title", "e"));
				} else{
					$icmsTpl->assign('album_cat_path',FALSE);
				}
			}
			break;
		case 'getByPublisher':
			$clean_album_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
			$images = $album_images_handler->getImages(TRUE, TRUE, $clean_img_start, $albumConfig['show_images'], 'weight', 'ASC', FALSE, FALSE, $clean_album_uid);
			$album_image_rows = array_chunk($images, $albumConfig['show_images_per_row']);
			$icmsTpl->assign('album_image_rows', $album_image_rows);
			$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
			$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';
			$icmsTpl->assign('album_row_margins', $album_row_margins);
			$icmsTpl->assign('album_image_margins', $album_image_margins);
			$icmsTpl->assign('byPublisher', TRUE);
			
			$userObj = icms::handler('icms_member')->getUser($clean_album_uid);
			$pname = $userObj->getVar("uname");
			$icmsTpl->assign('pname', $pname);
			/**
			 * check, if sprockets can be used
			 */
			if($albumConfig['use_sprockets'] == 1) {
				$icmsTpl->assign("sprockets_module", TRUE);
			}
			/**
			 * pagination control
			 */
			$images_count = $album_images_handler->getImagesCount(TRUE, TRUE, FALSE, FALSE, $clean_album_uid);
			$extra_arg = 'op=getByPublisher&uid=' . $clean_album_uid;
			$imagesnav = new icms_view_PageNav($images_count, $albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg);
			$icmsTpl->assign('imgnav', $imagesnav->renderNav());
			/**
			 * breadcrumb
			 */
			if ($albumConfig['show_breadcrumbs']){
				$icmsTpl->assign('album_cat_path', _MD_ALBUM_BY_PUBLISHER . '&nbsp;' . $pname);
			} else{
				$icmsTpl->assign('album_cat_path',FALSE);
			}
			break;
		default:
			if ($clean_album_id != 0) {
				$albumObj = $album_album_handler->get($clean_album_id);
			} else {
				$albumObj = FALSE;
			}
			/**
			 * retrieve a single album with subalbums and images
			 */
			if(is_object($albumObj) && $albumObj->accessGranted()){
				$album_album_handler->updateCounter($clean_album_id);
				$album = $albumObj->toArray();
				$icmsTpl->assign('single_album', $album);
				
					$albums = $album_album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_album_start, $albumConfig['show_albums'], FALSE, FALSE, $album['id'], 'weight', 'ASC');
					$subalbum_columns = array_chunk($albums, $albumConfig['show_album_columns']);
					$icmsTpl->assign('subalbum_columns', $subalbum_columns);
				
				/**
				 * retrieve the images of these album, if there are some
				 */
				$images = $album_images_handler->getImages(TRUE, TRUE, $clean_img_start, $albumConfig['show_images'], 'weight', 'ASC', $clean_album_id);
				$album_image_rows = array_chunk($images, $albumConfig['show_images_per_row']);
				$icmsTpl->assign('album_image_rows', $album_image_rows);
				$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
				$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';
				$icmsTpl->assign('album_row_margins', $album_row_margins);
				$icmsTpl->assign('album_image_margins', $album_image_margins);
				/**
				 * check if Sprockets Module can be used and if it's available
				 */
				$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
				if($albumConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
					$icmsTpl->assign("sprockets_module", TRUE);
				}
				/**
				 * assign breadcrumb
				 */
				if ($albumConfig['show_breadcrumbs']){
					$icmsTpl->assign('album_cat_path', $album_album_handler->getBreadcrumbForPid($albumObj->getVar('album_id', 'e'), 1));
				} else{
					$icmsTpl->assign('album_cat_path',FALSE);
				}
				/**
				 * check, if user can submit
				 */
				if($album_album_handler->userCanSubmit()) {
					$icmsTpl->assign('user_submit', TRUE);
					$icmsTpl->assign('user_submit_link', ALBUM_URL . 'album.php?op=mod&album_id=' . $albumObj->getVar("album_id"));
				} else {
					$icmsTpl->assign('user_submit', FALSE);
				}
				
				/**
				 * include the comment rules
				 */
				$images_count = $album_images_handler->getImagesCount (TRUE, TRUE, $clean_album_id);
				if ($albumConfig['com_rule'] && $images_count > 0) {
					$icmsTpl->assign('album_album_comment', TRUE);
					include_once ICMS_ROOT_PATH . '/include/comment_view.php';
				}	
			/**
			 * retrieve album index view
			 */
			} elseif ($clean_album_id == 0) {
				$albums = $album_album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_album_start, $albumConfig['show_albums'], FALSE, $clean_album_id, 0, 'weight', 'ASC');
				$album_columns = array_chunk($albums, $albumConfig['show_album_columns']);
				$icmsTpl->assign('album_columns', $album_columns);
			/**
			 * if permissions denied for a single album, redirect to index view
			 */
			} else {
				redirect_header(ALBUM_URL, 3, _NO_PERM);
			}
			/**
			 * check, if upload disclaimer is necessary and retrieve the link
			 */
			if($albumConfig['album_show_upl_disclaimer'] == 1) {
				$icmsTpl->assign('album_upl_disclaimer', TRUE );
				$icmsTpl->assign('up_disclaimer', $albumConfig['album_upl_disclaimer']);
			} else {
				$icmsTpl->assign('album_upl_disclaimer', FALSE);
			}
			/**
			 * check, if user can submit
			 */
			if($album_album_handler->userCanSubmit()) {
				$icmsTpl->assign('user_submit', TRUE);
				$icmsTpl->assign('user_submit_link', ALBUM_URL . 'album.php?op=mod&amp;album_id=' . $clean_album_id);
			} else {
				$icmsTpl->assign('user_submit', FALSE);
			}
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$album_count = $album_album_handler->getAlbumsCount(TRUE, TRUE, TRUE, $clean_album_id, FALSE);
			$icmsTpl->assign('album_count', $album_count);
			$images_count = $album_images_handler->getImagesCount (TRUE, TRUE, $clean_album_id);
			if (!empty($clean_album_id) && !empty($clean_img_start)) {
				$extra_arg = 'album_id=' . $clean_album_id . '&img_nav=' . $clean_img_start;
			} elseif (!empty($clean_album_id) && empty($clean_img_start)) {
				$extra_arg = 'album_id=' . $clean_album_id;
			} else {
				$extra_arg = FALSE;
			}
			if (!empty($clean_album_id) && !empty($clean_album_start)) {
				$extra_arg2 = 'album_id=' . $clean_album_id . '&album_nav=' . $clean_album_start;
			} elseif (!empty($clean_album_id) && empty($clean_album_start)) {
				$extra_arg2 = 'album_id=' . $clean_album_id;
			} else {
				$extra_arg2 = FALSE;
			}
			$pagenav = new icms_view_PageNav($album_count, $albumConfig['show_albums'], $clean_album_start, 'album_nav', $extra_arg);
			$imagesnav = new icms_view_PageNav($images_count, $albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg2);
			$icmsTpl->assign('album_pagenav', $pagenav->renderNav());
			$icmsTpl->assign('imgnav', $imagesnav->renderNav());
			break;
	}
	include_once 'footer.php';
}