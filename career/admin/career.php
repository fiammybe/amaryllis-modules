<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /admin/career.php
 * 
 * add, edit, clone and delete career objects
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

function editcareer($career_id = 0) {
	global $career_career_handler, $icmsAdminTpl;

	$careerObj = $career_career_handler->get($career_id);
	
	if (!$careerObj->isNew()){
		$careerObj->setVar( 'career_u_date', (time() - 100) );
		$careerObj->setVar('career_updater', icms::$user->getVar("uid"));
		
		career_adminmenu( 0, _MI_CAREER_MENU_CAREER . ' > ' . _MI_CAREER_CAREER_EDIT);
		$sform = $careerObj->getForm(_MI_CAREER_CAREER_EDIT, 'addcareer');
		$sform->assign($icmsAdminTpl);
	} else {
		$careerObj->setVar('career_p_date', (time() - 100) );
		$careerObj->setVar('career_submitter', icms::$user->getVar("uid"));
		
		career_adminmenu( 0, _MI_CAREER_MENU_CAREER . " > " . _MI_CAREER_CAREER_CREATINGNEW);
		$sform = $careerObj->getForm(_MI_CAREER_CAREER_CREATINGNEW, 'addcareer');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:career_admin.html');
}

include_once 'admin_header.php';

$valid_op = array ('mod', 'changedField', 'addcareer', 'del', 'view', 'visible', 'changeWeight', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$career_career_handler = icms_getModuleHandler('career', basename(dirname(dirname(__FILE__))), 'career');

$clean_career_id = isset($_GET['career_id']) ? filter_input(INPUT_GET, 'career_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_career_id = ($clean_career_id == 0 && isset($_POST['career_id'])) ? filter_input(INPUT_POST, 'career_id', FILTER_SANITIZE_NUMBER_INT) : $clean_career_id;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editcareer($clean_career_id);
			break;

		case 'addcareer':
			$controller = new icms_ipf_Controller($career_career_handler);
			$controller->storeFromDefaultForm(_AM_CAREER_CREATED, _AM_CAREER_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($career_career_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$careerObj = $career_career_handler->get($clean_career_id);
			icms_cp_header();
			$careerObj->displaySingleObject();
			break;

		case 'visible':
			$visibility = $career_career_handler -> changeVisible( $clean_career_id );
			$ret = 'career.php';
			if ($visibility == 0) {
				redirect_header( CAREER_ADMIN_URL . $ret, 2, _AM_CAREER_OFFLINE );
			} else {
				redirect_header( CAREER_ADMIN_URL . $ret, 2, _AM_CAREER_ONLINE );
			}
			break;
			
		case "changeWeight":
			foreach ($_POST['CareerCareer_objects'] as $key => $value) {
				$changed = FALSE;
				$careerObj = $career_career_handler -> get( $value );

				if ($careerObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$careerObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$career_career_handler -> insert($careerObj);
				}
			}
			$ret = 'career.php';
			redirect_header( CAREER_ADMIN_URL . $ret, 2, _AM_CAREER_WEIGHTS_UPDATED);
			break;
			
		default:
			icms_cp_header();
			career_adminmenu( 0, _MI_CAREER_MENU_CAREER );
			$criteria = '';
			if ($clean_career_id) {
				$careerObj = $career_career_handler->get($clean_career_id);
				if ($careerObj->id()) {
					$careerObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create career table
			$objectTable = new icms_ipf_view_Table($career_career_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column('career_active','center', 50, 'career_active'));
			$objectTable->addColumn( new icms_ipf_view_Column('career_did', FALSE, FALSE, 'getCareerDid'));
			$objectTable->addColumn( new icms_ipf_view_Column('career_title', FALSE, FALSE, 'getPreviewItemLink'));
			$objectTable->addColumn( new icms_ipf_view_Column('counter', 'center', 50));
			$objectTable->addColumn( new icms_ipf_view_Column('career_p_date', 'center', 100, TRUE));
			$objectTable->addColumn( new icms_ipf_view_Column('career_submitter', 'center', TRUE, 'getCareerSubmitter'));
			$objectTable->addColumn( new icms_ipf_view_Column('weight', 'center', TRUE, 'getCareerWeightControl'));
			
			$objectTable->addFilter('career_active', 'career_active_filter');
			$objectTable->addFilter('career_did', 'getDepartmentList');
			
			$objectTable->addIntroButton('addcareer', 'career.php?op=mod', _AM_CAREER_CAREER_ADD);
			$objectTable->addActionButton('changeWeight', FALSE, _SUBMIT );
			
			$objectTable->addCustomAction('getViewItemLink');
			
			$icmsAdminTpl->assign('career_career_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:career_admin.html');
			break;
	}
	icms_cp_footer();
}