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
 * @author		QM-B
 * @version		$Id$
 * @package		album
 * @version		$Id$
 * 
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'album_index.html';

include_once ICMS_ROOT_PATH . '/header.php';

global $icmsConfig, $albumConfig;

$clean_index_key = $clean_start = $indexpageObj = $album_indexpage_handler = '';
$indexpageArray = array();

/** Use a naming convention that indicates the source of the content of the variable */
$clean_index_key = isset($_GET['index_key']) ? intval($_GET['index_key']) : 1 ;
$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$clean_index_key = ($clean_index_key == 0 && isset($_POST['index_key'])) ? filter_input(INPUT_POST, 'index_key', FILTER_SANITIZE_NUMBER_INT) : $clean_index_key;

// get relative path to document root for this ICMS install
// this is required to call the image correctly if ICMS is installed in a subdirectory
$directory_name = basename( dirname( __FILE__ ) );
$script_name = getenv("SCRIPT_NAME");
$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);

$album_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'album' );
$criteria = icms_buildCriteria(array('index_key' => '1'));
$indexpageObj = $album_indexpage_handler->get($clean_index_key, TRUE, FALSE, $criteria);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$indexpageArray = prepareIndexpageForDisplay($indexpageObj, true); // with DB overrides

if ( $indexpageArray['index_image'] ) { 
	$album_indexarray['index_image'] = '<div class="album_indeximage"><img src="' . $indexpageObj->get_indeximage_tag() . '" class="index_image"></div>';
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
////////////////////////////////////////////// ALBUM LIST ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$clean_album_id = $clean_start = $albumObj = $album_album_handler = $clean_album_pid = $clean_album_uid = '';
	$albumArray = array();

	$clean_album_id = isset($_GET['album_id']) ? intval($_GET['album_id']) : 0 ;
	$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;
	$clean_album_uid = isset($_GET['uid']) ? (int)$_GET['uid'] : false;
	$clean_album_pid = isset($_GET['pid']) ? (int)$_GET['pid'] : ($clean_album_uid ? false : 0);

	$album_album_handler = icms_getModuleHandler('album', basename(dirname(__FILE__)), 'album');
/**	
	$album_object_array = array();
	
	$criteria = new icms_db_criteria_Compo();

	$criteria->setStart($clean_start);
	$criteria->setLimit($albumConfig['show_albums']);
	$criteria->setSort('weight');
	$criteria->setOrder('ASC');
	$criteria->add(new icms_db_criteria_Item('album_active', true));
	
	$album_object_array = $album_album_handler->getObjects($criteria, true, true);


	unset($criteria);
	
	// prepare articles for display
	if (!empty($album_object_array)) {

		foreach($album_object_array as &$album) {
			$album = prepareAlbumsForDisplay($album, true); // without DB overrides
		}
	}

	$icmsTpl->assign('album_array', $album_object_array);
	**/
	
	
	$album = $album_album_handler->getAlbums($clean_start, icms::$module->config['show_albums'], $clean_album_uid,  false, $clean_album_pid);
	$icmsTpl->assign('album_album', $album);
	
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// PAGINATION ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
$criteria = new icms_db_criteria_Compo();
$criteria->add(new icms_db_criteria_Item('album_active', true));
// adjust for tag, if present
$album_count = $album_album_handler->getCount($criteria);
	
$pagenav = new icms_view_PageNav($album_count, $albumConfig['show_albums'], $clean_start, 'start', false);
	
$icmsTpl->assign('pagenav', $pagenav->renderNav());
$icmsTpl->assign('dirname', icms::$module -> getVar( 'dirname' ) );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////// BREADCRUMBS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// check if the module's breadcrumb should be displayed
if ($albumConfig['show_breadcrumbs'] == true) {
	$icmsTpl->assign('album_show_breadcrumb', $albumConfig['show_breadcrumbs']);
} else {
	$icmsTpl->assign('album_show_breadcrumb', false);
}

$icmsTpl->assign('album_url', ALBUM_URL);

include_once 'footer.php';