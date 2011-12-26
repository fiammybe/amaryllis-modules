<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/indexpage.php
 *
 * Edit the indexpage in Frontend
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

function editform($indexkey = 1, $indeximage = true) {
	global $album_indexpage_handler, $icmsAdminTpl;
	$indexpageObj = $album_indexpage_handler->get($indexkey);
	if($indexpageObj->isNew()) {
		redirect_header(ALBUM_ADMIN_URL, 3, _NO_PERM);
	} else {
		$sform = $indexpageObj -> getForm(_AM_ALBUM_INDEXPAGE_EDIT, 'addindexpage');
		$sform->assign($icmsAdminTpl);
	}
	$icmsAdminTpl->display('db:album_admin.html');
	
}

include 'admin_header.php';

if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

$valid_op = array ( 'mod','addindexpage' );

$album_indexpage_handler = icms_getModuleHandler("indexpage", basename(dirname(dirname(__FILE__))), "album");

$clean_indexkey = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1 ;

if ( in_array( $clean_op, $valid_op, TRUE ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		album_adminmenu( 2, _MI_ALBUM_MENU_INDEXPAGE );
		editform($clean_indexkey, FALSE);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller( $album_indexpage_handler );
  		$controller->storeFromDefaultForm( _AM_ALBUM_INDEXPAGE_MODIFIED );
  		break;
  }
  icms_cp_footer();
}