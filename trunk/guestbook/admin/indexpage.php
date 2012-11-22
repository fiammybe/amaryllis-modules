<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /admin/indexpage.php
 * 
 * edit the frontend indexpage
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

function editform($indexkey = 1, $indeximage = TRUE) {

	global $guestbook_indexpage_handler, $icmsAdminTpl;

	$indexpageObj = $guestbook_indexpage_handler->get($indexkey);	
	$sform = $indexpageObj -> getForm(_AM_GUESTBOOK_EDIT, 'addindexpage');
	$sform->assign($icmsAdminTpl);

	$icmsAdminTpl->display('db:guestbook_admin.html');
	
}

include_once "admin_header.php";

$guestbook_indexpage_handler = icms_getModuleHandler('indexpage', basename(dirname(dirname(__FILE__))), "guestbook");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ( 'mod','addindexpage' );

$clean_indexkey = isset($_GET['index_key']) ? (int) $_GET['index_key'] : 1 ;

if ( in_array( $clean_op, $valid_op, TRUE ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		icms::$module->displayAdminMenu( 1, _MI_GUESTBOOK_MENU_INDEXPAGE );
		editform($clean_indexkey, FALSE);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller( $guestbook_indexpage_handler );
  		$controller->storeFromDefaultForm( _AM_GUESTBOOK_MODIFIED );
  		break;
  }
  icms_cp_footer();
}