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
	$sform = $indexpageObj -> getForm(_AM_ALBUM_INDEXPAGE_EDIT, 'addindexpage');
	$sform->assign($icmsAdminTpl);

	$icmsAdminTpl->display('db:album_admin.html');
	
}

include_once "admin_header.php";

$clean_indexkey = $clean_op = $valid_op = '';

$album_indexpage_handler = icms_getModuleHandler('indexpage', basename(dirname(dirname(__FILE__))), "album");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ( 'mod','addindexpage' );

$clean_indexkey = isset($_GET['indexkey']) ? (int) $_GET['indexkey'] : 1 ;

if ( in_array( $clean_op, $valid_op, true ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		album_adminmenu( 3, _MI_ALBUM_MENU_INDEXPAGE );
		editform($indexkey=1, false);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller( $album_indexpage_handler );
  		$controller->storeFromDefaultForm( _AM_ALBUM_INDEXPAGE_MODIFIED );
  		break;
  }
  icms_cp_footer();
}