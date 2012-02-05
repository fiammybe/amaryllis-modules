<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /admin/indexpage.php
 * 
 * edit indexpage object
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */


function editform($indexkey = 1, $indeximage = TRUE) {

	global $career_indexpage_handler, $icmsAdminTpl;

	$indexpageObj = $career_indexpage_handler->get($indexkey);	
	$sform = $indexpageObj -> getForm(_AM_CAREER_INDEXPAGE_EDIT, 'addindexpage');
	$sform->assign($icmsAdminTpl);

	$icmsAdminTpl->display('db:career_admin.html');
	
}

include_once "admin_header.php";

$clean_indexkey = $clean_op = $valid_op = '';

$career_indexpage_handler = icms_getModuleHandler('indexpage', basename(dirname(dirname(__FILE__))), "career");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ( 'mod','addindexpage' );

$clean_indexkey = isset($_GET['index_id']) ? (int) $_GET['index_id'] : 1 ;

if ( in_array( $clean_op, $valid_op, TRUE ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		career_adminmenu( 3, _MI_CAREER_MENU_INDEXPAGE );
		editform($indexkey=1, FALSE);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller( $career_indexpage_handler );
  		$controller->storeFromDefaultForm( _AM_CAREER_INDEXPAGE_MODIFIED, _AM_CAREER_INDEXPAGE_MODIFIED );
  		break;
  }
  icms_cp_footer();
}