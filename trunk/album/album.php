<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /album.php
 *
 * display a single album
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B
 * @version		$Id$
 * @package		album
 * 
 */

 include_once 'header.php';

$xoopsOption['template_main'] = 'album_album.html';

include_once ICMS_ROOT_PATH . '/header.php';

global $icmsConfig, $albumConfig;

$clean_album_id = $clean_img_id = $clean_start = $albumObj = $album_album_handler = $imagesObject = $album_images_handler = '';
$albumArray = array();
$imagesArray = array();

$clean_album_id = isset($_GET['album_id']) ? intval($_GET['album_id']) : 0 ;
$clean_img_id = isset($_GET['img_id']) ? intval($_GET['img_id']) : 0 ;
$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_album_id = ($clean_album_id == 0 && isset($_POST['album_id'])) ? filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT) : $clean_album_id;
$clean_img_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_img_id = ($clean_img_id == 0 && isset($_POST['img_id'])) ? filter_input(INPUT_POST, 'img_id', FILTER_SANITIZE_NUMBER_INT) : $clean_img_id;

// get relative path to document root for this ICMS install
// this is required to call the image correctly if ICMS is installed in a subdirectory
$directory_name = basename( dirname( __FILE__ ) );
$script_name = getenv("SCRIPT_NAME");
$document_root = str_replace('modules/' . $directory_name . '/album.php', '', $script_name);

$album_album_handler = icms_getModuleHandler( 'album', icms::$module -> getVar( 'dirname' ), 'album' );
$album_images_handler = icms_getModuleHandler( 'images', icms::$module -> getVar( 'dirname' ), 'album' );
$criteria = icms_buildCriteria(array('album_active' => '1'));
$albumObj = $album_album_handler->get($clean_album_id, TRUE, FALSE, $criteria);
$criteria = icms_buildCriteria(array('img_active' => '1'));
$imagesObj = $album_images_handler->get($clean_img_id, TRUE, FALSE, $criteria);

$albumModule = icms_getModuleInfo( icms::$module -> getVar( 'dirname' ) );


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// INDEXVIEW ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$image_count = $style = $show_images_per_row = '';
$imagesObjects = $album_images = array();
$query1 = "SELECT count(*) FROM " . $album_album_handler->table . ", " . $album_images_handler->table . " WHERE `album_id` = `a_id` AND `album_active` = 1 AND `img_active` = 1 ";
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

$query2 = "SELECT * FROM " . $album_album_handler->table . ", " . $album_images_handler->table . " WHERE `album_id` = `a_id` AND `album_active` = 1 AND `img_active` = 1 ORDER BY " . $album_images_handler->table . ".`weight` ASC " . " LIMIT " . $clean_start . ",  " . $albumConfig['show_images'];

$result = icms::$xoopsDB->query($query2);

if ( !$result ) {
	echo 'Error';
	exit;
} else {
	$rows = $album_images_handler -> convertResultSet( $result );
	foreach ($rows as $key => $row) {
		$imagesObjects[$row->getVar('img_id')] = $row;
	}
}

unset($criteria);

foreach ( $imagesObjects as $imagesObj ) {
	$image = $imagesObj -> toArray();
	$image['img_url'] = $document_root . 'uploads/' . $directory_name . '/images/'
				. $imagesObj->getVar('img_url', 'e');
	$image['show_images'] = $albumConfig['show_images'];
	$image['thumbnail_width'] = $albumConfig['thumbnail_width'];
	$image['thumbnail_height'] = $albumConfig['thumbnail_height'];
	$image['image_width'] = $albumConfig['image_width'];
	$image['image_height'] = $albumConfig['image_height'];
	$album_images[] = $image;
}

$album_image_rows = array_chunk($album_images, $albumConfig['show_images_per_row']);

$album_row_margins = 'style="margin:' . $albumConfig['thumbnail_margin_top'] . 'px 0px ' . $albumConfig['thumbnail_margin_bottom'] . 'px 0px;"';
$album_image_margins = 'align="center" style="display:inline-block; margin: 0px ' . $albumConfig['thumbnail_margin_right'] . 'px 0px ' . $albumConfig['thumbnail_margin_left'] . 'px;"';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$pagenav = new icms_view_PageNav($image_count, $albumConfig['show_images'], $clean_start, 'start', false);
	
$icmsTpl->assign('pagenav', $pagenav->renderNav());
$icmsTpl->assign('dirname', icms::$module -> getVar( 'dirname' ) );


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// ASSIGN //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$icmsTpl->assign('album_images', $album_images);
	$icmsTpl->assign('album_image_rows', $album_image_rows);
	$icmsTpl->assign('album_row_margins', $album_row_margins);
	$icmsTpl->assign('album_image_margins', $album_image_margins);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// BREADCRUMBS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// check if the module's breadcrumb should be displayed
if ($albumConfig['show_breadcrumbs'] == true) {
	$icmsTpl->assign('album_show_breadcrumb', $albumConfig['show_breadcrumbs']);
} else {
	$icmsTpl->assign('album_show_breadcrumb', false);
}

$icmsTpl->assign('album_module_home', album_getModuleName(true, true));

include_once 'footer.php';