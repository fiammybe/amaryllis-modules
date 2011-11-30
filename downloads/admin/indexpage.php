<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /admin/indexpage.php
 * 
 * edit the frontend indexpage
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

include_once "admin_header.php";

function editform($indexkey = 1, $indeximage = true) {

	global $downloads_indexpage_handler, $icmsAdminTpl;

	$indexpageObj = $downloads_indexpage_handler->get($indexkey);	
	$sform = $indexpageObj -> getForm(_AM_DOWNLOADS_INDEXPAGE_EDIT, 'addindexpage');
	$sform->assign($icmsAdminTpl);

	$icmsAdminTpl->display('db:downloads_admin.html');
	
}

include 'admin_header.php';

$clean_indexkey = $clean_op = $valid_op = '';

$downloads_indexpage_handler = icms_getModuleHandler('indexpage', basename(dirname(dirname(__FILE__))), "downloads");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ( 'mod','addindexpage' );

if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

$clean_indexkey = isset($_GET['indexkey']) ? (int) $_GET['indexkey'] : 1 ;

if ( in_array( $clean_op, $valid_op, true ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		downloads_adminmenu( 3, _MI_DOWNLOADS_MENU_INDEXPAGE );
		editform($indexkey=1, false);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller( $downloads_indexpage_handler );
  		$controller->storeFromDefaultForm( _AM_DOWNLOADS_INDEXPAGE_MODIFIED );
  		break;
  }
  icms_cp_footer();
}