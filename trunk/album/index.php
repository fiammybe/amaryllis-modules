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

$GLOBALS["MODULE_".strtoupper(ALBUM_DIRNAME)."_USE_MAIN"] = FALSE;

$clean_album_start = isset($_GET['album_nav']) ? filter_input(INPUT_GET, 'album_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_img_start = isset($_GET['img_nav']) ? filter_input(INPUT_GET, 'img_nav', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_limit = isset($_POST['limit']) ? filter_input(INPUT_POST, "limit", FILTER_SANITIZE_NUMBER_INT) : $albumConfig['show_albums'];

$clean_album = isset($_GET['album']) ? StopXSS(filter_input(INPUT_GET, "album", FILTER_SANITIZE_STRING)) : FALSE;
$clean_album_id = "";
if(!$clean_album) $clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;

$album_handler = new mod_album_AlbumHandler(icms::$xoopsDB);
$images_handler = new mod_album_ImagesHandler(icms::$xoopsDB);

$clean_order = isset($_POST['order']) ? StopXSS(filter_input(INPUT_POST, "order", FILTER_SANITIZE_STRING)) : $albumConfig['album_default_order'];
$clean_sort = isset($_POST['sort']) ? StopXSS(filter_input(INPUT_POST, "sort", FILTER_SANITIZE_STRING)) : $albumConfig['album_default_sort'];

$valid_view = array ('batchupload', 'modAlbum','changedField', 'addalbum', 'delAlbum', "modImages", "addimages", "delImages", "byPublisher", "recent", "recentUpdated", "mostCommented", "mostPopular", "byLabel", "");

$clean_view = isset($_GET['view']) ? filter_input(INPUT_GET, 'view', FILTER_SANITIZE_STRING) : '';
$album_page = basename(__FILE__);
if(in_array($clean_view, $valid_view)) {
	switch ($clean_view) {
		case 'modAlbum':
		case 'changedField':
			$parent_id = 0;
			$clean_album_pid = isset($_GET['album_parent']) ? StopXSS(filter_input(INPUT_GET, "album_parent", FILTER_SANITIZE_STRING)) : FALSE;
			if($clean_album_pid) {
				$parent = $album_handler->getAlbumBySeo($clean_album_pid);
				if($parent)
				$parent_id = $parent->id();
			}
			if($clean_album) {
				$albumObj = $album_handler->getAlbumBySeo($clean_album);
				$clean_album_id = $albumObj->id();
			} else {
				$albumObj = $album_handler->create(TRUE);
				$clean_album_id = 0;
			}
			if ($clean_album_id > 0 && $albumObj->isNew()) {
				redirect_header(ALBUM_URL, 3, _NOPERM);
			}
			get_album_form($albumObj, $parent_id);
			$icmsTpl->assign("album_form", TRUE);
			break;
		case 'batchupload':
			include_once ALBUM_ROOT_PATH.'batchupload.php';
			break;
		case 'addalbum':
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($album_handler);
			$controller->storeFromDefaultForm(_MD_ALBUM_ALBUM_CREATED, _MD_ALBUM_ALBUM_MODIFIED, ALBUM_URL.'index.php?album='.$clean_album);
			break;
		case 'delAlbum':
			$albumObj = $album_handler->getAlbumBySeo($clean_album);
			if (!is_object($albumObj) || !$albumObj->userCanEditAndDelete()) {
				redirect_header(icms_getPreviousPage(), 3, _NOPERM);
			}
			$_REQUEST['album_id'] = $albumObj->id();
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header(ALBUM_REAL_URL, 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$icmsTpl->assign("album_form", TRUE);
			$controller = new icms_ipf_Controller($album_handler);
			$controller->handleObjectDeletionFromUserSide(FALSE, $clean_view);
			break;
		case 'modImages':
			$clean_images_id = isset($_GET['images_id']) ? filter_input(INPUT_GET, "images_id", FILTER_SANITIZE_NUMBER_INT) : 0;
			$imagesObj = $images_handler->get($clean_images_id);
			if ($clean_images_id > 0 && $imagesObj->isNew()) {
				redirect_header(ALBUM_REAL_URL, 3, _NOPERM);
			}
			$album = ($clean_album) ? $album_handler->getAlbumBySeo($clean_album) : FALSE;
			$album_id = ($album) ? $album->id() : 0;
			if(!$album_id && is_object($imagesObj) && !$imagesObj->isNew()) {
				$album_id = $imagesObj->getVar("a_id", "e");
			}
			get_images_form($imagesObj, $album_id);
			$icmsTpl->assign("album_form", TRUE);
			break;
		case 'delImages':
			$clean_images_id = isset($_GET['images_id']) ? filter_input(INPUT_GET, "images_id", FILTER_SANITIZE_NUMBER_INT) : 0;
			if(!$clean_images_id) redirect_header(icms_getPreviousPage(), 3, _NOPERM);
			$imagesObj = $images_handler->get($clean_images_id);
			if (!is_object($albumObj) || !$albumObj->userCanEditAndDelete()) {
				redirect_header(icms_getPreviousPage(), 3, _NOPERM);
			}
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header(ALBUM_REAL_URL, 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($images_handler);
			$controller->handleObjectDeletionFromUserSide();
			break;
		case 'addimages':
			if (!icms::$security->check()) {
				redirect_header(ALBUM_URL, 3, _MD_ALBUM_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($album_handler);
			$controller->storeFromDefaultForm(_MD_ALBUM_ALBUM_CREATED, _MD_ALBUM_ALBUM_MODIFIED, ALBUM_URL.'index.php?album='.$clean_album);
			break;
		case 'byLabel':
			if($album_handler->_index_module_status) {
				if($clean_label) {
						$label_handler = icms_getModuleHandler("label", $album_handler->_index_module_dirname, "index");
						$labelObj = ($clean_label !== FALSE) ? $label_handler->getLabelBySeo($clean_label) : FALSE;
						if(!$labelObj || $labelObj->isNew()) redirect_header(ALBUM_URL, 5, _NOPERM);
						$albums = $album_handler->getAlbums(TRUE, TRUE, $clean_uid, FALSE, $labelObj->title(), FALSE, FALSE, $clean_start, $clean_limit, 'pdate', 'DESC', FALSE, $icmsConfig['language']);
						$icmsTpl->assign("labeled_albums", $albums);

						$images = $images_handler->getImages(TRUE, TRUE, FALSE, $labelObj->title(), $clean_uid, $clean_img_start, $albumConfig['show_images'], $clean_order, $clean_sort);
						$icmsTpl->assign("byLabels", TRUE);
						$icmsTpl->assign("album_label", $labelObj->title());
						$albumsCount = $album_handler->getArticlesCount(TRUE, TRUE, $clean_uid, FALSE, trim($labelObj->title()), FALSE, FALSE, $clean_start, $clean_limit, 'pdate', 'DESC', FALSE, $icmsConfig['language']);
						// pagination
						$extra_arg = 'view=byLabel&label=' . $clean_label;
						$album_pagenav = new mod_index_PageNav($albumsCount, $albumConfig['album_limit'], $clean_album, 'start', $extra_arg);
						$icmsTpl->assign('album_pagenav', $album_pagenav->renderNav());
						$icmsTpl->assign('category_path', '<li><a href="'.$album_handler->_moduleUrl.$album_handler->_page.'?view='.$clean_view.'" title="'._MD_ALBUM_LABELED.'">'._MD_ALBUM_LABELED.'</a></li><li>'.$labelObj->getItemLink(FALSE).'</li>');
					} else {
						$label_handler = icms_getModuleHandler("label", $album_handler->_index_module_dirname, "index");
						$link_handler = icms_getModuleHandler("link", $album_handler->_index_module_dirname, "index");

						$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("approved", TRUE));
						$criteria->setSort("title");
						$criteria->setOrder("ASC");
						$lablel_crits = $link_handler->getLabelIdsAsCriteria($album_handler->_moduleID);
						unset($link_handler);

						$criteria->add($lablel_crits);
						$labels = $label_handler->getObjects($criteria, TRUE, FALSE);
						unset($criteria, $critTray, $label_handler);
						$icmsTpl->assign("byLabels", TRUE);
						$icmsTpl->assign("album_labels", $labels);
						$icmsTpl->assign('category_path', '<li><a href="'.$album_handler->_moduleUrl.$album_handler->_page.'?view='.$clean_view.'" title="'._MD_ALBUM_LABELED.'">'._MD_ALBUM_LABELED.'</a></li>');
					}
			}
			break;
		case 'byPublisher':
			if($clean_uid) {
				$images = $images_handler->getImages(TRUE, TRUE, $clean_album_id, FALSE, $clean_uid, $clean_img_start, $albumConfig['show_images'], $albumConfig['img_default_order'], $albumConfig['img_default_sort']);
				$icmsTpl->assign('album_images', $images);
				$icmsTpl->assign('byPublisher', TRUE);

				$publisher = $images_handler->_usersArray[$clean_uid];
				$icmsTpl->assign('publisher', $publisher);

				/** pagination control */
				$images_count = $images_handler->getImagesCount(TRUE, TRUE, $clean_album_id, FALSE, $clean_uid, $clean_img_start, $albumConfig['show_images'], $albumConfig['img_default_order'], $albumConfig['img_default_sort']);
				$extra_arg = 'view=byPublisher&uid='.$clean_uid;
				$imagesnav = new icms_view_PageNav($images_count, $albumConfig['show_images'], $clean_img_start, 'img_nav', $extra_arg);
				$icmsTpl->assign('imgnav', $imagesnav->renderNav());
				/** breadcrumb */
				$cat_path = $album_handler->_moduleUrl.$album_handler->_page.'?view='.$clean_view;
				$view_link = '<li><a href="'.$cat_path.'" title="'._MD_ALBUM_BY_PUBLISHER.'">'._MD_ALBUM_BY_PUBLISHER.'</a></li>';
				$user_link = '<li><a href="'.$cat_path.'&uid='.$clean_uid.'" title="'.$publisher['uname'].'">'.$publisher['uname'].'</a></li>';
				$icmsTpl->assign('category_path', $view_link.$user_link);
			}
			break;
		default:
			$albumObj = ($clean_album != FALSE) ? $album_handler->getAlbumBySeo($clean_album) : FALSE;
			/**
			 * retrieve a single album with subalbums and images
			 */
			if(is_object($albumObj) && !$albumObj->isNew() && $albumObj->accessGranted("album_grpperm")){
				$album_handler->updateCounter($albumObj);
				$salbum = $albumObj->toArray();
				$icmsTpl->assign('single_album', $salbum);
				if($albumObj->hasSubs()) {
					$albums = $album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_uid, FALSE,  $albumObj->id(), $clean_album_start, $albumConfig['show_albums'],
														 $albumConfig['album_default_order'], $albumConfig['album_default_sort']);
					$icmsTpl->assign('subalbums', $albums);
				}
				/**
				 * retrieve the images of these album, if there are some
				 */
				$images = $images_handler->getImages(TRUE, TRUE, $albumObj->id(), FALSE, FALSE, $clean_img_start, $albumConfig['show_images'],
														$albumConfig['img_default_order'], $albumConfig['img_default_sort']);
				$icmsTpl->assign("album_images", $images);

				/**
				 * assign breadcrumb
				 */
				$icmsTpl->assign('category_path', $album_handler->getBreadcrumbForPid($albumObj->id()));
				/**
				 * check, if user can submit
				 */
				if($albumObj->accessGranted("album_uplperm")) {
					$icmsTpl->assign('user_submit_images', TRUE);
				}

				/**
				 * pagination
				 */
				// album pagination
				$album_count = $album_handler->getAlbumsCount(TRUE, TRUE, TRUE, $clean_uid, FALSE, $albumObj->id(), FALSE, $clean_album_start, $albumConfig['show_albums'],
														 $albumConfig['album_default_order'], $albumConfig['album_default_sort']);
				if (!empty($clean_album_id) && !empty($clean_img_start)) {
					$extra_arg = 'album_id=' . $clean_album_id . '&img_nav=' . $clean_img_start;
				} elseif ($clean_album && !empty($clean_img_start)) {
					$extra_arg = 'album=' . $clean_album . '&img_nav=' . $clean_img_start;
				} elseif (!empty($clean_album_id) && empty($clean_img_start)) {
					$extra_arg = 'album_id=' . $clean_album_id;
				} elseif ($clean_album && empty($clean_img_start)) {
					$extra_arg = 'album=' . $clean_album;
				} else {
					$extra_arg = FALSE;
				}
				$pagenav = new icms_view_PageNav($album_count, $albumConfig['show_albums'], $clean_album_start, 'album_nav', $extra_arg);
				$icmsTpl->assign('album_pagenav', $pagenav->renderNav());
				//image pagination
				$images_count = $images_handler->getImagesCount(TRUE, TRUE, $albumObj->id(), FALSE, FALSE, FALSE, FALSE, "weight","ASC");
				if (!empty($clean_album_id) && !empty($clean_album_start)) {
					$extra_arg2 = 'album_id=' . $clean_album_id . '&album_nav=' . $clean_album_start;
				} elseif ($clean_album && !empty($clean_album_start)) {
					$extra_arg2 = 'album=' . $clean_album . '&album_nav=' . $clean_album_start;
				} elseif (!empty($clean_album_id) && empty($clean_album_start)) {
					$extra_arg2 = 'album_id=' . $clean_album_id;
				} elseif ($clean_album && empty($clean_album_start)) {
					$extra_arg2 = 'album=' . $clean_album;
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
					$album = $clean_album;
					$_GET['album_id'] = $albumObj->id();
					include_once ICMS_ROOT_PATH . '/include/comment_view.php';
				}

				// get the meta informations
				$icms_metagen = new icms_ipf_Metagen($albumObj->title(), $albumObj->meta_keywords(), $albumObj->meta_description());
				$icms_metagen->createMetaTags();
			} elseif ($clean_album && (!is_object($albumObj) || $albumObj->isNew())) {
				header("HTTP/1.0 404 Not Found");
				$xoopsOption['pagetype'] = 'error';
				$siteName = $icmsConfig['sitename'];
				icms_loadLanguageFile("core", "error");
				$lang_error_no = sprintf(_ERR_NO, "404");
				$icmsTpl->assign('lang_error_no', $lang_error_no);
				$icmsTpl->assign('lang_error_desc', sprintf(constant('_ERR_404_DESC'), $siteName));
				$icmsTpl->assign('lang_error_title', $lang_error_no.' '.constant('_ERR_404_TITLE'));
				$icmsTpl->assign('icms_pagetitle', $lang_error_no.' '.constant('_ERR_404_TITLE'));
				$icmsTpl->assign('lang_found_contact', sprintf(_ERR_CONTACT, $icmsConfig['adminmail']));
				$icmsTpl->assign('lang_search', _ERR_SEARCH);
				$icmsTpl->assign('lang_advanced_search', _ERR_ADVANCED_SEARCH);
				$icmsTpl->assign('lang_start_again', _ERR_START_AGAIN);
				$icmsTpl->assign('lang_search_our_site', _ERR_SEARCH_OUR_SITE);
				$icmsTpl->assign("album_errors", TRUE);
			} elseif ($clean_album && is_object($albumObj) && !$albumObj->isNew() && !$albumObj->accessGranted("album_grpperm")) {
				header("HTTP/1.0 401 No Permission");
				$xoopsOption['pagetype'] = 'error';
				$siteName = $icmsConfig['sitename'];
				icms_loadLanguageFile("core", "error");
				$lang_error_no = sprintf(_ERR_NO, "401");
				$icmsTpl->assign('lang_error_no', $lang_error_no);
				$icmsTpl->assign('lang_error_desc', sprintf(constant('_ERR_401_DESC'), $siteName));
				$icmsTpl->assign('lang_error_title', $lang_error_no.' '.constant('_ERR_401_TITLE'));
				$icmsTpl->assign('icms_pagetitle', $lang_error_no.' '.constant('_ERR_401_TITLE'));
				$icmsTpl->assign('lang_found_contact', sprintf(_ERR_CONTACT, $icmsConfig['adminmail']));
				$icmsTpl->assign('lang_search', _ERR_SEARCH);
				$icmsTpl->assign('lang_advanced_search', _ERR_ADVANCED_SEARCH);
				$icmsTpl->assign('lang_start_again', _ERR_START_AGAIN);
				$icmsTpl->assign('lang_search_our_site', _ERR_SEARCH_OUR_SITE);
				$icmsTpl->assign("album_errors", TRUE);
			} else {
				$albums = $album_handler->getAlbums(TRUE, TRUE, TRUE, $clean_uid, FALSE,  NULL, FALSE, $clean_album_start, $albumConfig['show_albums'],
														 $clean_order, $clean_sort);
				$icmsTpl->assign('albums', $albums);

				/**
				 * pagination
				 */
				$album_count = $album_handler->getAlbumsCount(TRUE, TRUE, TRUE, $clean_uid, FALSE,  NULL, FALSE, $clean_album_start, $albumConfig['show_albums'],
														 $albumConfig['album_default_order'], $albumConfig['album_default_sort']);

				$extra_arg = FALSE;
				$pagenav = new icms_view_PageNav($album_count, $albumConfig['show_albums'], $clean_album_start, 'album_nav', $extra_arg);
			}
			break;
	}

	/**
	 * fetch the requested indexpage
	 */
	if($album_handler->_index_module_status) {
		$indexpage_handler = new mod_index_IndexpageHandler(icms::$xoopsDB);
		$indexpageObj = $indexpage_handler->getIndexByMid(icms::$module->getVar("mid", "e"));
		if(is_object($indexpageObj)) $icmsTpl->assign('index_index', $indexpageObj->toArray());
	} else {
		$indexpage_handler = icms_getModuleHandler( 'indexpage', ALBUM_DIRNAME, 'album' );
		$indexpageObj = $indexpage_handler->get(1);
		$icmsTpl->assign('index_index', $indexpageObj->toArray());
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
		$icmsTpl->assign('user_submit_link', ALBUM_REAL_URL .$album_page.'?view=modAlbum');
	}
	include_once 'footer.php';
} else {
	redirect_header(ALBUM_REAL_URL, 3, _NOPERM);
}