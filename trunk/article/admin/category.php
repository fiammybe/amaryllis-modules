<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/category.php
 * 
 * Add, edit, view and delete categories
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

/**
 * Edit a Category
 *
 * @param int $category_id Categoryid to be edited
*/
function editcategory($category_id = 0) {
	global $article_category_handler, $icmsAdminTpl;

	$categoryObj = $article_category_handler->get($category_id);
	
	$article_log_handler = icms_getModuleHandler("log", basename(dirname(dirname(__FILE__))), "article");
	if (!is_object(icms::$user)) {
		$log_uid = 0;
	} else {
		$log_uid = icms::$user->getVar("uid");
	}
	
	if (!$categoryObj->isNew()){
		$categoryObj->hideFieldFromForm(array( 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar( 'category_updated_date', (time() - 100) );
		
		$logObj = $article_log_handler->create();
		$logObj->setVar('log_item_id', $categoryObj->getVar("category_id") );
		$logObj->setVar('log_date', (time()-200) );
		$logObj->setVar('log_uid', $log_uid);
		$logObj->setVar('log_item', 1 );
		$logObj->setVar('log_case', 3 );
		$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
		$logObj->store(TRUE);
		
		article_adminmenu( 2, _MI_ARTICLE_MENU_CATEGORY . ' > ' . _MI_ARTICLE_CATEGORY_EDIT);
		$sform = $categoryObj->getForm(_AM_ARTICLE_EDIT, 'addcategory');
		$sform->assign($icmsAdminTpl);
	} else {
		$categoryObj->hideFieldFromForm(array('category_approve', 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar('category_published_date', (time() - 100) );
		$categoryObj->setVar('category_approve', true );
		$categoryObj->setVar('category_submitter', icms::$user->getVar("uid"));
		
		$logObj = $article_log_handler->create();
		$logObj->setVar('log_item_id', $categoryObj->getVar("category_id") );
		$logObj->setVar('log_date', (time()-200) );
		$logObj->setVar('log_uid', $log_uid);
		$logObj->setVar('log_item', 1 );
		$logObj->setVar('log_case', 1 );
		$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
		$logObj->store(TRUE);
		
		article_adminmenu( 2, _MI_ARTICLE_MENU_CATEGORY . " > " . _MI_ARTICLE_CATEGORY_CREATINGNEW);
		$sform = $categoryObj->getForm(_AM_ARTICLE_CREATE, 'addcategory');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:article_admin.html');
}

include_once 'admin_header.php';

$valid_op = array ('mod', 'changedField', 'addcategory', 'del', 'view', 'visible', 'changeShow','changeApprove', 'changeWeight', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$article_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'article');

$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = ($clean_category_id == 0 && isset($_POST['category_id'])) ? filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT) : $clean_category_id;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editcategory($clean_category_id);
			break;

		case 'addcategory':
			$controller = new icms_ipf_Controller($article_category_handler);
			$controller->storeFromDefaultForm(_AM_ARTICLE_CREATED, _AM_ARTICLE_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($article_category_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$categoryObj = $article_category_handler->get($clean_category_id);
			icms_cp_header();
			$categoryObj->displaySingleObject();
			break;

		case 'visible':
			$visibility = $article_category_handler -> changeVisible( $clean_category_id );
			$ret = 'category.php';
			if ($visibility == 0) {
				redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_OFFLINE );
			} else {
				redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ONLINE );
			}
			break;
			
		case 'changeShow':
			$show = $article_category_handler -> changeShow( $clean_category_id );
			$ret = 'category.php';
			if ($show == 0) {
				redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_INBLOCK_FALSE );
			} else {
				redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_INBLOCK_TRUE );
			}
			break;
		
		case 'changeApprove':
			$approve = $article_category_handler -> changeApprove( $clean_category_id );
			$ret = 'category.php';
			if ($approve == 0) {
				redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_APPROVE_FALSE );
			} else {
				redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_APPROVE_TRUE );
			}
			break;
			
		case "changeWeight":
			foreach ($_POST['ArticleCategory_objects'] as $key => $value) {
				$changed = false;
				$categoryObj = $article_category_handler -> get( $value );

				if ($categoryObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$categoryObj->setVar('weight', intval($_POST['weight'][$key]));
					$changed = true;
				}
				if ($changed) {
					$article_category_handler -> insert($categoryObj);
				}
			}
			$ret = 'category.php';
			redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_CATEGORY_WEIGHTS_UPDATED);
			break;
			
		default:
			icms_cp_header();
			article_adminmenu( 2, _MI_ARTICLE_MENU_CATEGORY );
			$criteria = '';
			if ($clean_category_id) {
				$categoryObj = $article_category_handler->get($clean_category_id);
				if ($categoryObj->id()) {
					$categoryObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create article table
			$objectTable = new icms_ipf_view_Table($article_category_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column( 'category_active','center', 50, 'category_active' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'category_title', false, false, 'getPreviewItemLink' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'category_pid', false, false, 'category_pid' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'counter', 'center', 50));
			$objectTable->addColumn( new icms_ipf_view_Column( 'category_inblocks', 'center', 50, 'category_inblocks' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'category_approve', 'center', 50, 'category_approve' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'category_published_date', 'center', 100, true ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'category_publisher', 'center', true, 'category_publisher' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'weight', 'center', true, 'getCategoryWeightControl' ) );
			
			$objectTable->addFilter( 'category_active', 'category_active_filter' );
			$objectTable->addFilter( 'category_inblocks', 'category_inblocks_filter' );
			$objectTable->addFilter( 'category_pid', 'getCategoryListForPid' );
			
			$objectTable->addIntroButton( 'addcategory', 'category.php?op=mod', _AM_ARTICLE_CATEGORY_ADD );
			$objectTable->addActionButton( 'changeWeight', false, _SUBMIT );
			
			$objectTable->addCustomAction( 'getViewItemLink' );
			
			$icmsAdminTpl->assign( 'article_category_table', $objectTable->fetch() );
			$icmsAdminTpl->display( 'db:article_admin.html' );
			break;
	}
	icms_cp_footer();
}
