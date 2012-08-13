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
 * @version		$Id: index.php 677 2012-07-05 18:10:29Z st.flohrer $
 * @package		album
 * @version		$Id: index.php 677 2012-07-05 18:10:29Z st.flohrer $
 * 
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'album_index.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(icms_get_module_status("index")) {
	$indexpage_handler = icms_getModuleHandler( 'indexpage', INDEX_DIRNAME, 'index' );
	$indexpageObj = $indexpage_handler->getIndexByMid(icms::$module->getVar("mid", "e"));
	$icmsTpl->assign('index_index', $indexpageObj->toArray());
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// ALBUM LIST ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/** Use a naming convention that indicates the source of the content of the variable */
$clean_album_start = isset($_GET['album_nav']) ? filter_input(INPUT_GET, 'album_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_img_start = isset($_GET['img_nav']) ? filter_input(INPUT_GET, 'img_nav', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_tag_seo = isset($_GET['tag']) ? filter_input(INPUT_GET, "tag") : FALSE;
$clean_tag = "";
if(!$clean_tag_seo) $clean_tag = isset($_GET['tag_id']) ? filter_input(INPUT_GET, 'tag_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_album_seo = isset($_GET['album']) ? filter_input(INPUT_GET, "album") : FALSE;
$clean_album_id = "";
if(!$clean_album_seo) $clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;

$album_handler = icms_getModuleHandler('album', ALBUM_DIRNAME, 'album');
$images_handler = icms_getModuleHandler('images', ALBUM_DIRNAME, 'album');

$valid_op = array ('getByTag', 'getByPublisher', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if(in_array($clean_op, $valid_op)) {
	switch ($clean_op) {
		case 'getByTag':
			if(icms_get_module_status("index")) {
				$tag_handler = icms_getModuleHandler("tag", $indexDirname, "index");
				$tagObj = ($clean_tag_seo) ? $tag_handler->getTagBySeo($clean_tag_seo) : FALSE;
				if(!$tagObj) $tagObj = ($clean_tag > 0) ? $tag_handler->get($clean_tag) : FALSE;
				if(!is_object($tagObj) || $tagObj->isNew() && !$tagObj->accessGranted()) {redirect_header(ALBUM_URL, 3 , _NOPERM);}
				/**
				 * get images
				 */ 
				$images = $images_handler->getImages(TRUE, TRUE, FALSE, $tagObj->id(), $clean_uid, $clean_img_start, $albumConfig['show_images'], $albumConfig['img_default_order'],$albumConfig['img_default_sort']);
				$album_image_rows = array_chunk($images, $albumConfig['show_images_per_row']);
				$icmsTpl->assign('album_image_rows', $album_image_rows);
				$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
				$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';
				$icmsTpl->assign('album_row_margins', $album_row_margins);
				$icmsTpl->assign('album_image_margins', $album_image_margins);
				$icmsTpl->assign('byTags', TRUE);
				$icmsTpl->assign('tag', $tagObj->toArray());
				$icmsTpl->assign("need_tags", TRUE);
				
				/**
				 * get albums
				 */
				$albums = $album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_uid, FALSE, FALSE, $tagObj->id(), $clean_album_start, $albumConfig['show_albums'], $albumConfig['img_default_order'], $albumConfig['img_default_sort']);
				//$icmsTpl->assign("albums", $albums);
				$album_columns = array_chunk($albums, $albumConfig['show_album_columns']);
				$icmsTpl->assign('album_column', $album_columns);
				/**
				 * pagination control
				 */
				$images_count = $images_handler->getImagesCount(TRUE, TRUE, FALSE, $clean_tag, $clean_uid, $clean_img_start, $albumConfig['show_images'], $albumConfig['img_default_order'], $albumConfig['img_default_sort']);
				$extra_arg = 'op=getByTag&tag=' . $tagObj->id();
				$imagesnav = new icms_view_PageNav($images_count, $albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg);
				$icmsTpl->assign('imgnav', $imagesnav->renderNav());
				/**
				 * breadcrumb
				 */
				if ($indexConfig['show_breadcrumbs']){
					$icmsTpl->assign('index_cat_path', $tagObj->title());
				}
			}
			break;
		case 'getByPublisher':
			$images = $images_handler->getImages(TRUE, TRUE, $clean_album_id, $clean_tag, $clean_uid, $clean_img_start, $albumConfig['show_images'], $albumConfig['img_default_order'], $albumConfig['img_default_sort']);
			$album_image_rows = array_chunk($images, $albumConfig['show_images_per_row']);
			$icmsTpl->assign('album_image_rows', $album_image_rows);
			$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
			$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';
			$icmsTpl->assign('album_row_margins', $album_row_margins);
			$icmsTpl->assign('album_image_margins', $album_image_margins);
			$icmsTpl->assign('byPublisher', TRUE);
			
			$userObj = icms::handler('icms_member')->getUser($clean_uid);
			$pname = $userObj->getVar("uname");
			$icmsTpl->assign('pname', $pname);
			/**
			 * check, if sprockets can be used
			 */
			if($albumConfig['need_tags'] == 1 && icms_get_module_status("index")) {
				$icmsTpl->assign("use_tags", TRUE);
			}
			/**
			 * pagination control
			 */
			$images_count = $images_handler->getImagesCount(TRUE, TRUE, $clean_album_id, $clean_tag, $clean_uid, $clean_img_start, $albumConfig['show_images'], $albumConfig['img_default_order'], $albumConfig['img_default_sort']);
			$extra_arg = 'op=getByPublisher&uid=' . $clean_uid;
			$imagesnav = new icms_view_PageNav($images_count, $albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg);
			$icmsTpl->assign('imgnav', $imagesnav->renderNav());
			/**
			 * breadcrumb
			 */
			if ($indexConfig['show_breadcrumbs']){
				$icmsTpl->assign('album_cat_path', _MD_ALBUM_BY_PUBLISHER . '&nbsp;' . $pname);
			} else{
				$icmsTpl->assign('album_cat_path',FALSE);
			}
			break;
		default:
			$albumObj = ($clean_album_seo != FALSE) ? $album_handler->getAlbumBySeo($clean_album_seo) : FALSE; 
			if(!$albumObj) $albumObj = ($clean_album_id != 0) ? $album_handler->get($clean_album_id) : FALSE;
			/**
			 * retrieve a single album with subalbums and images
			 */
			if(is_object($albumObj) && !$albumObj->isNew() && $albumObj->accessGranted()){
				$album_handler->updateCounter($albumObj->id());
				$album = $albumObj->toArray();
				$icmsTpl->assign('single_album', $album);
				if($albumObj->hasSubs()) {
					$albums = $album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_uid, FALSE,  $albumObj->id(), $clean_album_start, $albumConfig['show_albums'],
														 $albumConfig['album_default_order'], $albumConfig['album_default_sort']);
					$subalbum_columns = array_chunk($albums, $albumConfig['show_album_columns']);
					$icmsTpl->assign('subalbum_columns', $subalbum_columns);
				}
				/**
				 * retrieve the images of these album, if there are some
				 */
				$images = $images_handler->getImages(TRUE, TRUE, $albumObj->id(), FALSE, FALSE, $clean_img_start, $albumConfig['show_images'], 
														$albumConfig['img_default_order'], $albumConfig['img_default_sort']);
				$album_image_rows = array_chunk($images, $albumConfig['show_images_per_row']);
				$icmsTpl->assign('album_image_rows', $album_image_rows);
				$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
				$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';
				$icmsTpl->assign('album_row_margins', $album_row_margins);
				$icmsTpl->assign('album_image_margins', $album_image_margins);
				
				/**
				 * assign breadcrumb
				 */
				if ($indexConfig['show_breadcrumbs']){
					$icmsTpl->assign('album_cat_path', $album_handler->getBreadcrumbForPid($albumObj->getVar('album_id', 'e'), 1));
				}
				/**
				 * check, if user can submit
				 */
				if($album_handler->userCanSubmit()) {
					$icmsTpl->assign('user_submit', TRUE);
					$icmsTpl->assign('user_submit_link', ALBUM_URL . 'album.php?op=mod&album_id=' . $albumObj->id());
				}
				
				/**
				 * pagination
				 */
				// album pagination
				$album_count = $album_handler->getAlbumsCount(TRUE, TRUE, TRUE, $clean_uid, FALSE, $albumObj->id(), FALSE, $clean_album_start, $albumConfig['show_albums'],
														 $albumConfig['album_default_order'], $albumConfig['album_default_sort']);
				if (!empty($clean_album_id) && !empty($clean_img_start)) {
					$extra_arg = 'album_id=' . $clean_album_id . '&img_nav=' . $clean_img_start;
				} elseif ($clean_album_seo && !empty($clean_img_start)) {
					$extra_arg = 'album=' . $clean_album_seo . '&img_nav=' . $clean_img_start;
				} elseif (!empty($clean_album_id) && empty($clean_img_start)) {
					$extra_arg = 'album_id=' . $clean_album_id;
				} elseif ($clean_album_seo && empty($clean_img_start)) {
					$extra_arg = 'album=' . $clean_album_seo;
				} else {
					$extra_arg = FALSE;
				}
				$pagenav = new icms_view_PageNav($album_count, $albumConfig['show_albums'], $clean_album_start, 'album_nav', $extra_arg);
				$icmsTpl->assign('album_pagenav', $pagenav->renderNav());
				//image pagination
				$images_count = $images_handler->getImagesCount(TRUE, TRUE, $albumObj->id(), FALSE, FALSE, FALSE, FALSE, "weight","ASC");
				if (!empty($clean_album_id) && !empty($clean_album_start)) {
					$extra_arg2 = 'album_id=' . $clean_album_id . '&album_nav=' . $clean_album_start;
				} elseif ($clean_album_seo && !empty($clean_album_start)) {
					$extra_arg2 = 'album=' . $clean_album_seo . '&album_nav=' . $clean_album_start;
				} elseif (!empty($clean_album_id) && empty($clean_album_start)) {
					$extra_arg2 = 'album_id=' . $clean_album_id;
				} elseif ($clean_album_seo && empty($clean_album_start)) {
					$extra_arg2 = 'album=' . $clean_album_seo;
				} else {
					$extra_arg2 = FALSE;
				}
				$imagesnav = new icms_view_PageNav($images_count, (int)$albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg2);
				$icmsTpl->assign('imgnav', $imagesnav->renderNav());
				/**
				 * include the comment rules
				 */
				if ($albumConfig['com_rule'] && $images_count > 0) {
					$icmsTpl->assign('album_album_comment', TRUE);
					include_once ICMS_ROOT_PATH . '/include/comment_view.php';
				}
			/**
			 * retrieve album index view
			 */
			} elseif ($clean_album_id == 0 && !$clean_album_seo) {
				$albums = $album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_uid, FALSE,  NULL, FALSE, $clean_album_start, $albumConfig['show_albums'],
														 $albumConfig['album_default_order'], $albumConfig['album_default_sort']);
				$album_columns = array_chunk($albums, $albumConfig['show_album_columns']);
				$icmsTpl->assign('album_columns', $album_columns);
				
				/**
				 * pagination
				 */
				$album_count = $album_handler->getAlbumsCount(TRUE, TRUE, TRUE, $clean_uid, FALSE,  NULL, FALSE, $clean_album_start, $albumConfig['show_albums'],
														 $albumConfig['album_default_order'], $albumConfig['album_default_sort']);
				if(!empty($clean_album_id) && empty($clean_img_start)) {
					$extra_arg = 'album_id=' . $clean_album_id;
				} elseif ($clean_album_seo && empty($clean_img_start)) {
					$extra_arg = 'album=' . $clean_album_seo;
				} else {
					$extra_arg = FALSE;
				}
				$pagenav = new icms_view_PageNav($album_count, $albumConfig['show_albums'], $clean_album_start, 'album_nav', $extra_arg);
				
			/**
			 * if permissions denied for a single album, redirect to index view
			 */
			} else {
				redirect_header(ALBUM_URL, 3, _NOPERM);
			}
			break;
	}

	/**
	 * check, if upload disclaimer is necessary and retrieve the link
	 */
	if($albumConfig['album_show_upl_disclaimer'] == 1) {
		$discl = str_replace('{X_SITENAME}', $icmsConfig['sitename'], $albumConfig['album_upl_disclaimer']);
		$icmsTpl->assign('album_upl_disclaimer', TRUE );
		$icmsTpl->assign('up_disclaimer', $discl);
	}
	/**
	 * check, if user can submit
	 */
	if($album_handler->userCanSubmit()) {
		$icmsTpl->assign('user_submit', TRUE);
		$icmsTpl->assign('user_submit_link', ALBUM_URL . 'album.php?op=mod&amp;album_id=');
	}
	include_once 'footer.php';
} else {
	redirect_header(ALBUM_URL, 3, _NOPERM);
}