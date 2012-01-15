<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /admin/department.php
 * 
 * add, edit and delete department objects
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

function editdepartment($department_id = 0) {
	global $career_department_handler, $icmsAdminTpl;

	$departmentObj = $career_department_handler->get($department_id);
	
	if (!$departmentObj->isNew()){
		$departmentObj->setVar( 'department_u_date', (time() - 100) );
		$departmentObj->setVar('department_updater', icms::$user->getVar("uid"));
		
		career_adminmenu( 1, _MI_CAREER_MENU_DEPARTMENT . ' > ' . _MI_CAREER_DEPARTMENT_EDIT);
		$sform = $departmentObj->getForm(_MI_CAREER_DEPARTMENT_EDIT, 'adddepartment');
		$sform->assign($icmsAdminTpl);
	} else {
		$departmentObj->setVar('department_p_date', (time() - 100) );
		$departmentObj->setVar('department_submitter', icms::$user->getVar("uid"));
		
		career_adminmenu( 1, _MI_CAREER_MENU_DEPARTMENT . " > " . _MI_CAREER_DEPARTMENT_CREATINGNEW);
		$sform = $departmentObj->getForm(_MI_CAREER_DEPARTMENT_CREATINGNEW, 'adddepartment');
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display('db:career_admin.html');
}

include_once 'admin_header.php';

$valid_op = array ('mod', 'changedField', 'adddepartment', 'del', 'view', 'visible', 'changeWeight', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$career_department_handler = icms_getModuleHandler('department', basename(dirname(dirname(__FILE__))), 'career');

$clean_department_id = isset($_GET['department_id']) ? filter_input(INPUT_GET, 'department_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_department_id = ($clean_department_id == 0 && isset($_POST['department_id'])) ? filter_input(INPUT_POST, 'department_id', FILTER_SANITIZE_NUMBER_INT) : $clean_department_id;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changedField':
			icms_cp_header();
			editdepartment($clean_department_id);
			break;

		case 'adddepartment':
			$controller = new icms_ipf_Controller($career_department_handler);
			$controller->storeFromDefaultForm(_AM_CAREER_DEPARTMENT_CREATED, _AM_CAREER_DEPARTMENT_MODIFIED);
			break;

		case 'del':
			$controller = new icms_ipf_Controller($career_department_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$departmentObj = $career_department_handler->get($clean_department_id);
			icms_cp_header();
			career_adminmenu( 1, _MI_CAREER_MENU_DEPARTMENT );
			$departmentObj->displaySingleObject();
			break;

		case 'visible':
			$visibility = $career_department_handler -> changeVisible( $clean_department_id );
			$ret = 'department.php';
			if ($visibility == 0) {
				redirect_header( CAREER_ADMIN_URL . $ret, 2, _AM_CAREER_OFFLINE );
			} else {
				redirect_header( CAREER_ADMIN_URL . $ret, 2, _AM_CAREER_ONLINE );
			}
			break;
			
		case "changeWeight":
			foreach ($_POST['CareerDepartment_objects'] as $key => $value) {
				$changed = FALSE;
				$departmentObj = $career_department_handler -> get( $value );

				if ($departmentObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$departmentObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$career_department_handler -> insert($departmentObj);
				}
			}
			$ret = 'department.php';
			redirect_header( CAREER_ADMIN_URL . $ret, 2, _AM_CAREER_WEIGHTS_UPDATED);
			break;
			
		default:
			icms_cp_header();
			career_adminmenu( 1, _MI_CAREER_MENU_DEPARTMENT );
			$criteria = '';
			if ($clean_department_id) {
				$departmentObj = $career_department_handler->get($clean_department_id);
				if ($departmentObj->id()) {
					$departmentObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create department table
			$objectTable = new icms_ipf_view_Table($career_department_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column('department_active','center', 50, 'department_active'));
			$objectTable->addColumn( new icms_ipf_view_Column('department_title', FALSE, FALSE, 'getPreviewItemLink'));
			$objectTable->addColumn( new icms_ipf_view_Column('counter', 'center', 50));
			$objectTable->addColumn( new icms_ipf_view_Column('department_p_date', 'center', 100, TRUE));
			$objectTable->addColumn( new icms_ipf_view_Column('department_submitter', 'center', TRUE, 'department_submitter'));
			$objectTable->addColumn( new icms_ipf_view_Column('weight', 'center', TRUE, 'getDepartmentWeightControl'));
			
			$objectTable->addFilter('department_active', 'department_active_filter');
			
			$objectTable->addIntroButton('adddepartment', 'department.php?op=mod', _AM_CAREER_DEPARTMENT_ADD);
			$objectTable->addActionButton('changeWeight', FALSE, _SUBMIT );
			
			$objectTable->addCustomAction('getViewItemLink');
			
			$icmsAdminTpl->assign('career_department_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:career_admin.html');
			break;
	}
	icms_cp_footer();
}