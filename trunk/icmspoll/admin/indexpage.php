<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/indexpage.php
 * 
 * edit indexpage object
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

function editform($indexkey = 1, $indeximage = TRUE) {

	global $icmspoll_indexpage_handler, $icmsAdminTpl;

	$indexpageObj = $icmspoll_indexpage_handler->get($indexkey);	
	$sform = $indexpageObj -> getForm(_MI_ICMSPOLL_MENU_INDEXPAGE_EDIT, 'addindexpage');
	$sform->assign($icmsAdminTpl);

	$icmsAdminTpl->display('db:icmspoll_admin.html');
	
}

include_once "admin_header.php";

$icmspoll_indexpage_handler = icms_getModuleHandler('indexpage', ICMSPOLL_DIRNAME, "icmspoll");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ( 'mod','addindexpage' );

$clean_indexkey = isset($_GET['indexkey']) ? (int) $_GET['indexkey'] : 1 ;

if ( in_array( $clean_op, $valid_op, TRUE ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		icms::$module->displayAdminmenu(4, _MI_ICMSPOLL_MENU_INDEXPAGE);
		editform($indexkey=1, FALSE);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller($icmspoll_indexpage_handler);
  		$controller->storeFromDefaultForm( _AM_ICMSPOLL_INDEXPAGE_MODIFIED, _AM_ICMSPOLL_INDEXPAGE_MODIFIED);
  		break;
  }
  icms_cp_footer();
}