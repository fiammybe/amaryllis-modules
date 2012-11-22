<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /admin/category.php
 * 
 * add, edit and delete category objects
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

function editcategory($category_id = 0) {
	global $portfolio_category_handler, $icmsAdminTpl;

	$categoryObj = $portfolio_category_handler->get($category_id);
	
	if (!$categoryObj->isNew()){
		$categoryObj->setVar( 'category_u_date', (time() - 100) );
		$categoryObj->setVar('category_updater', icms::$user->getVar("uid"));
		$categoryObj->makeFieldReadOnly("short_url");
		icms::$module->displayAdminMenu( 1, _MI_PORTFOLIO_MENU_CATEGORY . ' > ' . _MI_PORTFOLIO_CATEGORY_EDIT);
		$sform = $categoryObj->getForm(_MI_PORTFOLIO_CATEGORY_EDIT, 'addcategory');
		$sform->assign($icmsAdminTpl);
	} else {
		$categoryObj->setVar('category_p_date', (time() - 100) );
		$categoryObj->setVar('category_submitter', icms::$user->getVar("uid"));
		icms::$module->displayAdminMenu( 1, _MI_PORTFOLIO_MENU_CATEGORY . " > " . _MI_PORTFOLIO_CATEGORY_CREATINGNEW);
		$sform = $categoryObj->getForm(_MI_PORTFOLIO_CATEGORY_CREATINGNEW, 'addcategory');
		$sform->assign($icmsAdminTpl);
	}
	$icmsAdminTpl->display('db:portfolio_admin.html');
}

include_once 'admin_header.php';

$valid_op = array ('mod', 'changedField', 'addcategory', 'del', 'view', 'visible', 'changeWeight', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
$clean_op = (isset($_POST['op'])) ? filter_input(INPUT_POST, 'op') : $clean_op;

$portfolio_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'portfolio');

$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = (isset($_POST['category_id'])) ? filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT) : $clean_category_id;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editcategory($clean_category_id);
			break;

		case 'addcategory':
			$controller = new icms_ipf_Controller($portfolio_category_handler);
			$controller->storeFromDefaultForm(_AM_PORTFOLIO_CATEGORY_CREATED, _AM_PORTFOLIO_CATEGORY_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($portfolio_category_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$categoryObj = $portfolio_category_handler->get($clean_category_id);
			icms_cp_header();
			icms::$module->displayAdminMenu( 1, _MI_PORTFOLIO_MENU_CATEGORY );
			$categoryObj->displaySingleObject();
			break;

		case 'visible':
			$visibility = $portfolio_category_handler -> changeVisible( $clean_category_id );
			$ret = 'category.php';
			if ($visibility == 0) {
				redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _AM_PORTFOLIO_CATEGORY_OFFLINE );
			} else {
				redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _AM_PORTFOLIO_CATEGORY_ONLINE );
			}
			break;
			
		case "changeWeight":
			foreach ($_POST['mod_portfolio_Category_objects'] as $key => $value) {
				$changed = FALSE;
				$categoryObj = $portfolio_category_handler -> get( $value );

				if ($categoryObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$categoryObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$portfolio_category_handler -> insert($categoryObj);
				}
			}
			$ret = 'category.php';
			redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _AM_PORTFOLIO_CATEGORY_WEIGHTS_UPDATED);
			break;
			
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu( 1, _MI_PORTFOLIO_MENU_CATEGORY );
			$criteria = '';
			if ($clean_category_id) {
				$categoryObj = $portfolio_category_handler->get($clean_category_id);
				if ($categoryObj->id()) {
					$categoryObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create category table
			$objectTable = new icms_ipf_view_Table($portfolio_category_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column('category_active','center', 50, 'category_active'));
			$objectTable->addColumn( new icms_ipf_view_Column('category_title', FALSE, FALSE, 'getPreviewItemLink'));
			$objectTable->addColumn( new icms_ipf_view_Column('counter', 'center', 50));
			$objectTable->addColumn( new icms_ipf_view_Column('category_p_date', 'center', 100, TRUE));
			$objectTable->addColumn( new icms_ipf_view_Column('category_submitter', 'center', TRUE, 'getCategorySubmitter'));
			$objectTable->addColumn( new icms_ipf_view_Column('weight', 'center', TRUE, 'getCategoryWeightControl'));
			
			$objectTable->addFilter('category_active', 'category_active_filter');
			
			$objectTable->addIntroButton('addcategory', 'category.php?op=mod', _AM_PORTFOLIO_CATEGORY_ADD);
			$objectTable->addActionButton('changeWeight', FALSE, _SUBMIT );
			
			$objectTable->addCustomAction('getViewItemLink');
			
			$icmsAdminTpl->assign('portfolio_category_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:portfolio_admin.html');
			break;
	}
	include_once 'admin_footer.php';
}