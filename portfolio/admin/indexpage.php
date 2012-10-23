<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /admin/indexpage.php
 * 
 * edit indexpage object
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */


function editform($indexkey = 1) {

	global $portfolio_indexpage_handler, $icmsAdminTpl;

	$indexpageObj = $portfolio_indexpage_handler->get($indexkey);	
	$sform = $indexpageObj -> getForm(_MI_PORTFOLIO_INDEXPAGE_EDIT, 'addindexpage');
	$sform->assign($icmsAdminTpl);

	$icmsAdminTpl->display('db:portfolio_admin.html');
	
}

include_once "admin_header.php";

$clean_indexkey = $clean_op = $valid_op = '';

$portfolio_indexpage_handler = icms_getModuleHandler('indexpage', basename(dirname(dirname(__FILE__))), "portfolio");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ( 'mod','addindexpage' );

$clean_indexkey = isset($_GET['index_id']) ? (int) $_GET['index_id'] : 1 ;

if ( in_array( $clean_op, $valid_op, TRUE ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		icms::$module->displayAdminMenu( 3, _MI_PORTFOLIO_MENU_INDEXPAGE );
		editform($indexkey=1);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller( $portfolio_indexpage_handler );
  		$controller->storeFromDefaultForm( _AM_PORTFOLIO_INDEXPAGE_MODIFIED, _AM_PORTFOLIO_INDEXPAGE_MODIFIED );
  		break;
  }
  include_once 'admin_footer.php';
}