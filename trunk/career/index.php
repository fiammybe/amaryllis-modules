<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /index.php
 * 
 * front end index view
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

include_once 'header.php';

$xoopsOption['template_main'] = 'career_index.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$career_indexpage_handler = icms_getModuleHandler( "indexpage", icms::$module -> getVar( 'dirname' ), "career" );

$indexpageObj = $career_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('career_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_department_id = isset($_GET['department_id']) ? filter_input(INPUT_GET, 'department_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$career_department_handler = icms_getModuleHandler( "department", icms::$module->getVar('dirname'), "career");
$career_career_handler = icms_getModuleHandler( "career", icms::$module->getVar('dirname'), "career");

if($clean_department_id != 0) {
	$departmentObj = $career_department_handler->get($clean_department_id);
} else {
	$departmentObj = FALSE;
}

if(is_object($departmentObj)) {
	$career_department_handler->updateCounter($clean_department_id);
	$department = $departmentObj->toArray();
	$icmsTpl->assign("single_department", $department);
	$careers = $career_career_handler->getCareers(TRUE, "weight", "ASC", FALSE, FALSE, $clean_department_id);
	$icmsTpl->assign("careers", $careers);
	if ($careerConfig['show_breadcrumbs']){
		$icmsTpl->assign('career_cat_path', $departmentObj->getItemLink(FALSE));
	}else{
		$icmsTpl->assign('career_cat_path',FALSE);
	}
/**
 * if there's no valid department, retrieve a list of all primary departments
 */
} elseif ($clean_department_id == 0) {
	$departments = $career_department_handler->getDepartments(TRUE);
	$icmsTpl->assign('departments', $departments);
	
/**
 * if not valid single department or no permissions -> redirect to module home
 */
} else {
	redirect_header(CAREER_URL, 3, _NO_PERM);
}

if( $careerConfig['show_breadcrumbs'] == TRUE ) {
	$icmsTpl->assign('career_show_breadcrumb', TRUE);
} else {
	$icmsTpl->assign('career_show_breadcrumb', FALSE);
}

include_once 'footer.php';