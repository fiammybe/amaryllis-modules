<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/indexpage.php
 * 
 * Edit indexpage for frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

function editform($indexkey = 1, $indeximage = true) {

	global $article_indexpage_handler, $icmsAdminTpl;

	$indexpageObj = $article_indexpage_handler->get($indexkey);	
	$sform = $indexpageObj -> getForm(_AM_ARTICLE_INDEXPAGE_EDIT, 'addindexpage');
	$sform->assign($icmsAdminTpl);

	$icmsAdminTpl->display('db:article_admin.html');
	
}

include_once "admin_header.php";

$clean_indexkey = $clean_op = $valid_op = '';

$article_indexpage_handler = icms_getModuleHandler("indexpage", basename(dirname(dirname(__FILE__))), "article");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$valid_op = array ( 'mod','addindexpage' );

$clean_indexkey = isset($_GET['index_id']) ? (int) $_GET['index_id'] : 1 ;

if ( in_array( $clean_op, $valid_op, true ) ) {
  switch ($clean_op) {
  	case "mod":
		icms_cp_header();
		icms::$module->displayAdminMenu( 3, _MI_ARTICLE_MENU_INDEXPAGE );
		editform($clean_indexkey, false);
		break;
  	case "addindexpage":
		$controller = new icms_ipf_Controller( $article_indexpage_handler );
  		$controller->storeFromDefaultForm( _AM_ARTICLE_INDEXPAGE_MODIFIED, _AM_ARTICLE_INDEXPAGE_MODIFIED );
  		break;
  }
  icms_cp_footer();
}