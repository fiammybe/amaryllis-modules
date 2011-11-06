<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /album.php
 *
 * display a single album and album subs
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

 include_once 'header.php';

$xoopsOption['template_main'] = 'album_album.html';

include_once ICMS_ROOT_PATH . '/header.php';

global $icmsConfig, $albumConfig;

$clean_album_id = $clean_album_pid = $clean_img_id = $clean_start = $albumObj = $album_album_handler = $clean_aid = $imagesObjects = $imagesObj = $album_images_handler = $clean_index_key = $indexpageObj = $album_indexpage_handler = '';
$albumArray = array();
$imagesArray = array();
$indexpageArray = array();

$clean_album_uid = isset($_GET['uid']) ? (int)$_GET['uid'] : false;

$clean_index_key = isset($_GET['index_key']) ? intval($_GET['index_key']) : 1 ;
$clean_album_id = isset($_GET['album_id']) ? intval($_GET['album_id']) : 0 ;
$clean_album_pid = isset($_GET['album_pid']) ? intval($_GET['album_pid']) : 0 ;
$clean_img_id = isset($_GET['img_id']) ? intval($_GET['img_id']) : 0 ;

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$clean_index_key = ($clean_index_key == 0 && isset($_POST['index_key'])) ? filter_input(INPUT_POST, 'index_key', FILTER_SANITIZE_NUMBER_INT) : $clean_index_key;

$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_album_id = ($clean_album_id == 0 && isset($_POST['album_id'])) ? filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT) : $clean_album_id;

$clean_album_pid = isset($_GET['album_pid']) ? filter_input(INPUT_GET, 'album_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_album_pid = ($clean_album_id == 0 && isset($_POST['album_pid'])) ? filter_input(INPUT_POST, 'album_pid', FILTER_SANITIZE_NUMBER_INT) : $clean_album_pid;

$clean_img_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_img_id = ($clean_img_id == 0 && isset($_POST['img_id'])) ? filter_input(INPUT_POST, 'img_id', FILTER_SANITIZE_NUMBER_INT) : $clean_img_id;

$clean_a_id = isset($_GET['a_id']) ? filter_input(INPUT_GET, 'a_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_a_id = ($clean_a_id == 0 && isset($_POST['a_id'])) ? filter_input(INPUT_POST, 'a_id', FILTER_SANITIZE_NUMBER_INT) : $clean_a_id;

// get relative path to document root for this ICMS install
// this is required to call the image correctly if ICMS is installed in a subdirectory
$directory_name = basename( dirname( __FILE__ ) );
$script_name = getenv("SCRIPT_NAME");
$document_root = str_replace('modules/' . $directory_name . '/album.php', '', $script_name);

$album_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'album' );
$album_album_handler = icms_getModuleHandler( 'album', icms::$module -> getVar( 'dirname' ), 'album' );
$album_images_handler = icms_getModuleHandler( 'images', icms::$module -> getVar( 'dirname' ), 'album' );
$criteria = icms_buildCriteria(array('album_active' => '1'));
$albumObj = $album_album_handler->get($clean_album_id, TRUE, FALSE, $criteria);
$criteria = icms_buildCriteria(array('img_active' => '1'));
$imagesObj = $album_images_handler->get($clean_img_id, TRUE, FALSE, $criteria);

$albumModule = icms_getModuleInfo( icms::$module -> getVar( 'dirname' ) );


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	$criteria = icms_buildCriteria(array('index_key' => '1'));
	$indexpageObj = $album_indexpage_handler->get($clean_index_key, TRUE, FALSE, $criteria);
	
	$indexpageArray = prepareIndexpageForDisplay($indexpageObj, true); // with DB overrides
	
	unset($criteria);

	if ( $indexpageArray['index_image'] ) { 
		$album_indexarray['index_image'] = '<div class="album_indeximage"><img src="' . $indexpageObj->get_indeximage_tag() . '" alt="indeximage" /></div>';
	} 
	if ( $indexpageArray['index_heading'] ) {
		$album_indexarray['index_heading'] = '<div class="album_indexheading">' . $indexpageArray['index_heading'] . '</div>';
	}
	if ( $indexpageArray['index_header'] ) {
		$album_indexarray['index_header'] = '<div class="album_indexheader">' . $indexpageArray['index_header'] . '</div>';
	}
	if ( $indexpageArray['index_footer'] ) {
		$album_indexarray['index_footer'] = '<div class="album_indexfooter">' . $indexpageArray['index_footer'] . '</div>';
	}

	$icmsTpl->assign('album_indexarray', $album_indexarray);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// INDEXVIEW ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$image_count = $style = $show_images_per_row = '';
$imagesObjects = $album_images = array();
$albumObj = $album_album_handler->get($clean_album_id);
$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$query1 = "SELECT count(*) FROM " . $album_images_handler->table . " WHERE " . $clean_album_id  . " = `a_id` AND `img_active` = 1 ";
$result = icms::$xoopsDB->query($query1);

if ( !$result ) {
	echo 'Error';
	exit;
} else {
	while ($row = $xoopsDB->fetchArray($result)) {
		foreach ($row as $key => $count) {
			$image_count = $count;
		}
	}
	unset($result);
}

$criteria = new icms_db_criteria_Compo();
$criteria->setStart($clean_start);
$criteria->setLimit($albumConfig['show_images']);
$criteria->setSort('weight');
$criteria->setOrder('ASC');
$criteria->add(new icms_db_criteria_Item('img_active', true));
$criteria->add(new icms_db_criteria_Item('a_id', $clean_album_id));
$show_images_per_row = $albumConfig['show_images_per_row'];
$imagesObjects = $album_images_handler -> getObjects ($criteria, true, true);

foreach ( $imagesObjects as $imagesObj ) {
	$image = $imagesObj -> toArray();
	$image['img_url'] = $document_root . 'uploads/' . $directory_name . '/images/' . $imagesObj->getVar('img_url', 'e');
	$image['show_images_per_row'] = $albumConfig['show_images_per_row'];
	$image['thumbnail_width'] = $albumConfig['thumbnail_width'];
	$image['thumbnail_height'] = $albumConfig['thumbnail_height'];
	$album_images[] = $image;
}

$album_image_rows = array_chunk($album_images, $albumConfig['show_images_per_row']);

$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// SUB ALBUM ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$albumObj = $album_album_handler->get($clean_album_id);
	$album = $albumObj->toArray();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!empty($clean_album_id)) {
		$extra_arg = 'album_id=' . $clean_album_id;
	} else {
		$extra_arg = false;
	}
$pagenav = new icms_view_PageNav($image_count, $albumConfig['show_images'], $clean_start, 'start', $extra_arg);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// BREADCRUMBS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


if ($albumConfig['show_breadcrumbs'] == true) {
	$icmsTpl->assign('album_cat_path', $album_album_handler->getBreadcrumbForPid($albumObj->getVar('album_id', 'e'), 1));
} else {
	$icmsTpl->assign('album_cat_path', false);
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// ASSIGN //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$icmsTpl->assign('album_images', $album_images);
	$icmsTpl->assign('album_image_rows', $album_image_rows);
	$icmsTpl->assign('album_row_margins', $album_row_margins);
	$icmsTpl->assign('album_image_margins', $album_image_margins);
	$icmsTpl->assign('count', $image_count);
	$icmsTpl->assign('album_module_home', album_getModuleName(true, true));
	$icmsTpl->assign('album_show_breadcrumb', $albumConfig['show_breadcrumbs'] == true);
	$icmsTpl->assign('pagenav', $pagenav->renderNav());
	$icmsTpl->assign('dirname', icms::$module -> getVar( 'dirname' ) );
	$icmsTpl->assign('album_album', $album);


include_once 'footer.php';