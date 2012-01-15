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

$xoopsOption['template_main'] = 'career_career.html';

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

$clean_career_id = isset($_GET['career_id']) ? filter_input(INPUT_GET, 'career_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$career_department_handler = icms_getModuleHandler( "department", icms::$module->getVar('dirname'), "career");
$career_career_handler = icms_getModuleHandler( "career", icms::$module->getVar('dirname'), "career");

$careerObj = $career_career_handler->get($clean_career_id);

if(is_object($careerObj) && !$careerObj->isNew()) {
	$career_career_handler->updateCounter($clean_department_id);
	$career = $careerObj->toArray();
	$icmsTpl->assign("career", $career);
	$departmentObj = $career_department_handler->get($careerObj->getVar("career_did", "e"));
	$department = $departmentObj->toArray();
	$icmsTpl->assign("department", $department);
	if ($careerConfig['show_breadcrumbs']){
		$icmsTpl->assign('career_cat_path', $departmentObj->getItemLink(TRUE));
	}else{
		$icmsTpl->assign('career_cat_path',FALSE);
	}
}

if( $careerConfig['show_breadcrumbs'] == TRUE ) {
	$icmsTpl->assign('career_show_breadcrumb', TRUE);
} else {
	$icmsTpl->assign('career_show_breadcrumb', FALSE);
}

include_once 'footer.php';