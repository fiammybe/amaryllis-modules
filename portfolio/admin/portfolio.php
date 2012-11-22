<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /admin/portfolio.php
 * 
 * add, edit, clone and delete portfolio objects
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

function editportfolio($portfolio_id = 0) {
	global $portfolio_handler, $icmsAdminTpl;
	
	$category_handler = icms_getModuleHandler('category', PORTFOLIO_DIRNAME, 'portfolio');
	if(!$category_handler->getCount(FALSE)) redirect_header(PORTFOLIO_ADMIN_URL."category.php?op=mod", 5, _AM_PORTFOLIO_NO_CATEGORY_FOUND);
	
	$portfolioObj = $portfolio_handler->get($portfolio_id);
	$portfolioObj->setVar("dobr", $portfolioObj->needDobr());
	if (!$portfolioObj->isNew()){
		$portfolioObj->setVar( 'portfolio_u_date', (time() - 100) );
		$portfolioObj->setVar('portfolio_updater', icms::$user->getVar("uid"));
		$portfolioObj->makeFieldReadOnly("short_url");
		icms::$module->displayAdminMenu( 0, _MI_PORTFOLIO_MENU_PORTFOLIO . ' > ' . _MI_PORTFOLIO_PORTFOLIO_EDIT);
		$sform = $portfolioObj->getForm(_MI_PORTFOLIO_PORTFOLIO_EDIT, 'addportfolio');
		$sform->assign($icmsAdminTpl);
	} else {
		$portfolioObj->setVar('portfolio_p_date', (time() - 100) );
		$portfolioObj->setVar('portfolio_submitter', icms::$user->getVar("uid"));
		
		icms::$module->displayAdminMenu( 0, _MI_PORTFOLIO_MENU_PORTFOLIO . " > " . _MI_PORTFOLIO_PORTFOLIO_CREATINGNEW);
		$sform = $portfolioObj->getForm(_MI_PORTFOLIO_PORTFOLIO_CREATINGNEW, 'addportfolio');
		$sform->assign($icmsAdminTpl);
	}
	$icmsAdminTpl->display('db:portfolio_admin.html');
}

include_once 'admin_header.php';

$valid_op = array ('mod', 'changedField', 'addportfolio', 'del', 'view', 'visible', 'changeWeight', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
$clean_op = (isset($_POST['op'])) ? filter_input(INPUT_POST, 'op') : $clean_op;

$portfolio_handler = icms_getModuleHandler('portfolio', PORTFOLIO_DIRNAME, 'portfolio');

$clean_portfolio_id = isset($_GET['portfolio_id']) ? filter_input(INPUT_GET, 'portfolio_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_portfolio_id = ($clean_portfolio_id == 0 && isset($_POST['portfolio_id'])) ? filter_input(INPUT_POST, 'portfolio_id', FILTER_SANITIZE_NUMBER_INT) : $clean_portfolio_id;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editportfolio($clean_portfolio_id);
			break;

		case 'addportfolio':
			$controller = new icms_ipf_Controller($portfolio_handler);
			$controller->storeFromDefaultForm(_AM_PORTFOLIO_CREATED, _AM_PORTFOLIO_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($portfolio_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$portfolioObj = $portfolio_handler->get($clean_portfolio_id);
			icms_cp_header();
			icms::$module->displayAdminMenu(0, _MI_PORTFOLIO_MENU_PORTFOLIO);
			$portfolioObj->displaySingleObject();
			break;

		case 'visible':
			$visibility = $portfolio_handler->changeVisible($clean_portfolio_id);
			$ret = 'portfolio.php';
			if ($visibility == 0) {
				redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _AM_PORTFOLIO_OFFLINE );
			} else {
				redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _AM_PORTFOLIO_ONLINE );
			}
			break;
			
		case "changeWeight":
			foreach ($_POST['mod_portfolio_Portfolio_objects'] as $key => $value) {
				$changed = FALSE;
				$portfolioObj = $portfolio_handler->get($value);
				if ($portfolioObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$portfolioObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$portfolio_handler->insert($portfolioObj);
				}
			}
			$ret = 'portfolio.php';
			redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _AM_PORTFOLIO_WEIGHTS_UPDATED);
			break;
			
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu( 0, _MI_PORTFOLIO_MENU_PORTFOLIO );
			$criteria = '';
			if ($clean_portfolio_id) {
				$portfolioObj = $portfolio_handler->get($clean_portfolio_id);
				if ($portfolioObj->id()) {
					$portfolioObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create portfolio table
			$objectTable = new icms_ipf_view_Table($portfolio_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column('portfolio_active','center', 50, 'portfolio_active'));
			$objectTable->addColumn( new icms_ipf_view_Column('portfolio_title', FALSE, FALSE, 'getPreviewItemLink'));
			$objectTable->addColumn( new icms_ipf_view_Column('portfolio_cid', FALSE, FALSE, 'getPortfolioCid'));
			$objectTable->addColumn( new icms_ipf_view_Column('counter', 'center', 50));
			$objectTable->addColumn( new icms_ipf_view_Column('portfolio_p_date', 'center', 100, TRUE));
			$objectTable->addColumn( new icms_ipf_view_Column('portfolio_submitter', 'center', TRUE, 'getPortfolioSubmitter'));
			$objectTable->addColumn( new icms_ipf_view_Column('weight', 'center', TRUE, 'getPortfolioWeightControl'));
			
			$objectTable->addFilter('portfolio_active', 'portfolio_active_filter');
			$objectTable->addFilter('portfolio_cid', 'getCategoryList');
			
			$objectTable->addIntroButton('addportfolio', 'portfolio.php?op=mod', _AM_PORTFOLIO_ADD);
			$objectTable->addActionButton('changeWeight', FALSE, _SUBMIT );
			
			$objectTable->addCustomAction('getViewItemLink');
			
			$icmsAdminTpl->assign('portfolio_portfolio_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:portfolio_admin.html');
			break;
	}
	include_once 'admin_footer.php';
}