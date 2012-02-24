<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /download.php
 * 
 * single Downloads download object
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

function addreview($clean_review_id = 0, $clean_download_id = 0){
	global $downloads_review_handler, $downloadsConfig, $icmsTpl;
	$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");
	$downloadObj = $downloads_download_handler->get($clean_download_id);
	$downloads_review_handler = icms_getModuleHandler("review", basename(dirname(__FILE__)), "downloads");
	$reviewObj = $downloads_review_handler->get($clean_review_id);
	if(is_object(icms::$user)){
		$review_uid = icms::$user->getVar("uid");
	} else {
		$review_uid = 0;
	}
	if ($reviewObj->isNew()){
		$reviewObj->setVar("review_date", (time()-200));
		$reviewObj->setVar("review_item_id", $clean_download_id);
		$reviewObj->setVar('review_ip', xoops_getenv('REMOTE_ADDR') );
		$reviewObj->setVar('review_uid', $review_uid);
		$sform = $reviewObj->getSecureForm(_MD_DOWNLOADS_REVIEW_ADD, 'addreview', DOWNLOADS_URL . "ajax.php?op=addreview&download_id=" . $downloadObj->id() , 'OK', TRUE, TRUE);
		$sform->assign($icmsTpl, 'downloads_review_form');
	} else {
		exit;
	}
}

function addtags($clean_tag_id = 0, $clean_download_id = 0){
	global $sprockets_tag_handler, $downloadsConfig, $icmsTpl;
	$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");
	$downloadObj = $downloads_download_handler->get($clean_download_id);
	$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
	if(icms_get_module_status("sprockets")) {
		$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname"), "sprockets");
		$tagObj = $sprockets_tag_handler->get($clean_tag_id);
		$tagObj->hideFieldFromForm(array("label_type", "parent_id", "navigation_element", "rss", "short_url", "meta_description", "meta_keywords"));
		if ($tagObj->isNew()){
			$tagObj->setVar("label_type", 0);
			$tagObj->setVar("navigation_element", 0);
			$tagObj = $tagObj->getSecureForm(_MD_DOWNLOADS_TAG_ADD, 'addtags', DOWNLOADS_URL . "ajax.php?op=addtags&download_id=" . $downloadObj->id() , 'OK', TRUE, TRUE);
			$tagObj->assign($icmsTpl, 'downloads_tag_form');
		} else {
			exit;
		}
	}
}

include_once "header.php";

$xoopsOption["template_main"] = "downloads_singledownload.html";

include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$downloads_indexpage_handler = icms_getModuleHandler("indexpage", DOWNLOADS_DIRNAME, "downloads");
$indexpageObj = $downloads_indexpage_handler->get(1);
$index = $indexpageObj->toArray();
$icmsTpl->assign('downloads_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$valid_op = array ('downfile', 'downfileMirror', '');
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case('downfile'):
			$clean_download_id = isset($_GET['download_id']) ? filter_input(INPUT_GET, 'download_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");
			$downloadObj = $downloads_download_handler->get($clean_download_id);
			if($downloadObj && !$downloadObj->isNew() && $downloadObj->accessGranted() ) {
				$url = $downloadObj->getDownloadTag();
				$icmsTpl->assign("download_get_link", $url);
				$icmsTpl->assign("download_file", TRUE);
				// force header
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header("Cache-Control: post-check=0, pre-check=0", FALSE);
				header("Pragma: no-cache");
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				header("Refresh: 3; url=$url");
			}
			$icmsTpl->assign('downloads_show_breadcrumb', $downloadsConfig['show_breadcrumbs'] == TRUE);
			break;
			
		case('downfileMirror'):
			$clean_download_id = isset($_GET['download_id']) ? filter_input(INPUT_GET, 'download_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");
			$downloadObj = $downloads_download_handler->get($clean_download_id);
			if($downloadObj && !$downloadObj->isNew() && $downloadObj->accessGranted() ) {
				$url = $downloadObj->getMirrorLink();
				$icmsTpl->assign("download_get_link", $url);
				$icmsTpl->assign("download_file", TRUE);
				// force header
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header("Cache-Control: post-check=0, pre-check=0", FALSE);
				header("Pragma: no-cache");
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				header("Refresh: 3; url=$url");
			}
			$icmsTpl->assign('downloads_show_breadcrumb', $downloadsConfig['show_breadcrumbs'] == TRUE);	
			break;
			
		default:
			$clean_download_id = isset($_GET['download_id']) ? filter_input(INPUT_GET, 'download_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_category_id = isset($_GET['cid']) ? filter_input(INPUT_GET, 'cid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_review_start = isset($_GET['rev_nav']) ? filter_input(INPUT_GET, 'rev_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
			$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");
			$downloadObj = $downloads_download_handler->get($clean_download_id);
			$downloads_download_handler->updateCounter($clean_download_id);
			if(is_object($downloadObj) && !$downloadObj->isNew() && $downloadObj->accessGranted()) {
				/**
				 * Get the requested file and send it to Array
				 */	
				$file = $downloadObj->toArray();
				$icmsTpl->assign("file", $file);
				/**
				 * forwarding download_requests to ajax.php
				 */
				$down_link = DOWNLOADS_URL . 'ajax.php?op=getFile&download_id=' . $downloadObj->getVar("download_id");
				$icmsTpl->assign('down_link', $down_link);
				/**
				 * forwarding new reports for broken links
				 */
				$icmsTpl->assign("broken_link", DOWNLOADS_URL . "ajax.php?op=report_broken&download_id=" . $downloadObj->id() );
				/**
				 * mirror yes/no?
				 */
				if($downloadsConfig['use_mirror'] == 1 && !$downloadObj->getVar("download_mirror_url", "e") == 0 ) {
					$icmsTpl->assign('show_mirror', TRUE);
					$icmsTpl->assign('down_mirror_link', DOWNLOADS_URL . 'ajax.php?op=getFileMirror&download_id=' . $downloadObj->getVar("download_id") );
				} else {
					$icmsTpl->assign('show_mirror', FALSE);
				}
				/**
				 * display disclaimer yes/no?
				 */
				if($downloadsConfig['downloads_show_down_disclaimer'] == 1) {
					$icmsTpl->assign('show_down_disclaimer', TRUE );
					$icmsTpl->assign('down_disclaimer', $downloadsConfig['downloads_down_disclaimer']);
				} else {
					$icmsTpl->assign('show_down_disclaimer', FALSE);
				}
				/**
				 * check, if album module is used
				 */
				$albumModule = icms_getModuleInfo('album');
				if ($downloadsConfig['use_album'] == 1 && icms_get_module_status("album")){
					$album_id = $downloadObj-> getVar("download_album");
					if($album_id > 0){
						$icmsTpl->assign('album_module', TRUE);
						$directory_name = basename(dirname( __FILE__ ) );
						$script_name = getenv("SCRIPT_NAME");
						$document_root = str_replace('modules/' . $directory_name . '/singledownload.php', '', $script_name);
						$albumConfig = icms_getModuleConfig ($albumModule->getVar('name') );
						$album_id = $downloadObj->getVar('download_album');
						$album_images_handler = icms_getModuleHandler( 'images', $albumModule -> getVar( 'dirname' ), 'album' );
						$criteria = new icms_db_criteria_Compo();
						$criteria->add(new icms_db_criteria_Item('img_active', 1));
						$criteria->add(new icms_db_criteria_Item('a_id', $album_id ));
						$imagesObjects = $album_images_handler->getObjects($criteria, TRUE, TRUE);
						$album_images = array();
						foreach ( $imagesObjects as $imagesObj ) {
							$image = $imagesObj -> toArray();
							$image['img_url'] = $document_root . 'uploads/' . $albumModule->getVar('dirname') . '/images/' . $imagesObj->getVar('img_url', 'e');
							$image['show_images_per_row'] = $albumConfig['show_images_per_row'];
							$image['thumbnail_width'] = $albumConfig['thumbnail_width'];
							$image['thumbnail_height'] = $albumConfig['thumbnail_height'];
							$album_images[] = $image;
						}
						$album_image_rows = array_chunk($album_images, $albumConfig['show_images_per_row']);
						$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
						$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';
						$icmsTpl->assign('album_images', $album_images);
						$icmsTpl->assign('album_image_rows', $album_image_rows);
						$icmsTpl->assign('album_row_margins', $album_row_margins);
						$icmsTpl->assign('album_image_margins', $album_image_margins);
					}
				} else {
					$icmsTpl->assign('album_module', FALSE );
				}
				/**
				 * check if Sprockets Module can be used and if it's available
				 */
				$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
				if($downloadsConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
					$icmsTpl->assign("sprockets_module", TRUE);
					if(is_object(icms::$user)) {
						$icmsTpl->assign("tag_link", DOWNLOADS_URL . "ajax.php?op=addtags&amp;download_id=" . $downloadObj->getVar("download_id") );
						$icmsTpl->assign("tag_perm_denied", FALSE);
						addtags(0, $clean_download_id);
					} else {
						$icmsTpl->assign("tag_link", ICMS_URL . "/user.php");
						$icmsTpl->assign("tag_perm_denied", TRUE);
					}
				}
				/**
				 * check if catalogue module is installed and link to item
				 */
				$catalogueModule = icms_getModuleInfo('catalogue');
				if ($downloadsConfig['use_catalogue'] == 1 && icms_get_module_status("catalogue")){
					$item_id = $downloadObj->getVar('catalogue_item');
					if (!$item_id == 0) {
						$icmsTpl->assign('catalogue_module', TRUE);
						$catalogueConfig = icms_getModuleConfig ($catalogueModule->getVar('dirname') );
						$catalogue_item_handler = icms_getModuleHandler ('item', $catalogueModule->getVar('dirname'), 'catalogue');
						$catalogueObj = $catalogue_item_handler->get($item_id);
						$item_price = $catalogueObj->getVar('price');
						$base_currency = $catalogueConfig['base_currency'];
						if($catalogueConfig['show_prices'] == 1) {
							$icmsTpl->assign('show_price', TRUE);
							$icmsTpl->assign('base_currency', $base_currency);
							$icmsTpl->assign('item_price', $item_price);
						} else {
							$icmsTpl->assign('show_price', FALSE);
						}
						$catalogue_item_link = ICMS_URL . "/modules/" . $catalogueModule->getVar('dirname') . "/item.php?item_id=" . $catalogueObj->id();
						$icmsTpl->assign('item_link', $catalogue_item_link);
					}
				}

				/**
				 * review form
				 */
				
				if($downloadsConfig['guest_review'] == 1) {
					addreview(0, $clean_download_id);
					$icmsTpl->assign("review_link", DOWNLOADS_URL . "ajax.php?op=addreview&amp;download_id=" . $downloadObj->getVar("download_id") );
				} else {
					if(is_object(icms::$user)){
						addreview(0, $clean_download_id);
						$icmsTpl->assign("review_link", DOWNLOADS_URL . "ajax.php?op=addreview&amp;download_id=" . $downloadObj->getVar("download_id") );
						$icmsTpl->assign("review_perm_denied", FALSE);
					} else {
						$icmsTpl->assign("review_link", ICMS_URL . "/user.php");
						$icmsTpl->assign("review_perm_denied", TRUE);
					}
				}
				/**
				 * include the comment rules
				 */
				if ($downloadsConfig['com_rule']) {
					$icmsTpl->assign('downloads_download_comment', TRUE);
					include_once ICMS_ROOT_PATH . '/include/comment_view.php';
				}
				/**
				 * fetch reviews to display
				 */
				if($downloadsConfig['show_reviews'] == 1) {
					$downloads_review_handler = icms_getModuleHandler("review", basename(dirname(__FILE__)), "downloads");
					$reviews = $downloads_review_handler->getReviews($clean_review_start, $downloadsConfig['show_reviews_count'], 'review_date', $downloadsConfig['review_order'], $downloadObj->getVar("download_id") );
					$icmsTpl->assign("show_reviews", TRUE);
					$icmsTpl->assign('file_reviews', $reviews);
					if($downloadsConfig['show_reviews_email'] == 1) {
						$icmsTpl->assign("show_reviews_email", TRUE);
					}
					if($downloadsConfig['show_reviews_avatar'] == 1) {
						$icmsTpl->assign("show_reviews_avatar", TRUE);
					}
					/**
					 * Reviews Page navigation
					 * 
					 */
					$criteria = new icms_db_criteria_Compo();
					$criteria->add(new icms_db_criteria_Item('review_item_id', $downloadObj->getVar("download_id")));
					$review_count = $downloads_review_handler->getCount($criteria);
					$extra_arg = 'download_id=' . $clean_download_id . '&amp;file=' . $downloadObj->getVar("short_url");
					$review_pagenav = new icms_view_PageNav($review_count, $downloadsConfig['show_reviews_count'], $clean_review_start, 'rev_nav', $extra_arg);
					$icmsTpl->assign('review_pagenav', $review_pagenav->renderNav());
				} else {
					$icmsTpl->assign("show_reviews", FALSE);
				}
				/**
				 * voting -> can vote?
				 */
				if($downloadsConfig['guest_vote'] == 1){
					$icmsTpl->assign("can_vote", TRUE);
				} else {
					if(is_object(icms::$user)){
						$icmsTpl->assign("can_vote", TRUE);
					} else {
						$icmsTpl->assign("can_vote", FALSE);
						$icmsTpl->assign("register_link", ICMS_URL . "/user.php");
					}
				}
				/**
				 * 
				 */
				if ($downloadsConfig['show_breadcrumbs'] == TRUE) {
					$downloads_category_handler = icms_getModuleHandler("category", DOWNLOADS_DIRNAME, "downloads");
					$icmsTpl->assign('downloads_show_breadcrumb', TRUE);
					$icmsTpl->assign('downloads_cat_path', $downloads_category_handler->getBreadcrumbForPid($clean_category_id, 1));
				} else {
					$icmsTpl->assign('downloads_cat_path', FALSE);
				}
				/**
				 * get the meta informations
				 */
				$icms_metagen = new icms_ipf_Metagen($downloadObj->getVar("download_title"), $downloadObj->getVar("meta_keywords", "n"), $downloadObj->getVar("meta_description", "n"));
				$icms_metagen->createMetaTags();
			} else {
				redirect_header (DOWNLOADS_URL, 3, _NO_PERM);
			}
	}
} else {
	redirect_header (DOWNLOADS_URL, 3, _NO_PERM);
}
$xoTheme->addScript('/modules/' . DOWNLOADS_DIRNAME . '/scripts/jquery.curvycorners.packed.js', array('type' => 'text/javascript'));
include_once "footer.php";