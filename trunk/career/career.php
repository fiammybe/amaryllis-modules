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

function addmessage($clean_message_id = 0, $clean_career_id = 0){
	global $career_message_handler, $careerConfig, $icmsTpl;
	$career_career_handler = icms_getModuleHandler("career", basename(dirname(__FILE__)), "career");
	$careerObj = $career_career_handler->get($clean_career_id);
	$career_message_handler = icms_getModuleHandler("message", basename(dirname(__FILE__)), "career");
	$messageObj = $career_message_handler->get($clean_message_id);
	if(is_object(icms::$user)){
		$message_uid = icms::$user->getVar("uid");
	} else {
		$message_uid = 0;
	}
	if ($messageObj->isNew()){
		$messageObj->setVar("message_date", (time()-200));
		$messageObj->setVar("message_cid", $clean_career_id);
		$messageObj->setVar('message_did', $careerObj->getVar("career_did", "e"));
		$messageObj->setVar('message_submitter', $message_uid);
		$sform = $messageObj->getSecureForm(_MD_CAREER_MESSAGE, 'addmessage', CAREER_URL . "submit.php?op=addmessage&career_id=" . $careerObj->getVar("career_id", "e") , 'OK', TRUE, TRUE);
		$sform->assign($icmsTpl, 'career_message_form');
	} else {
		exit;
	}
}

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
$clean_department_id = isset($_GET['department_id']) ? filter_input(INPUT_GET, 'department_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$career_department_handler = icms_getModuleHandler( "department", icms::$module->getVar('dirname'), "career");
$career_career_handler = icms_getModuleHandler( "career", icms::$module->getVar('dirname'), "career");

$careerObj = $career_career_handler->get($clean_career_id);

if(is_object($careerObj) && !$careerObj->isNew() && $careerObj->accessGranted()) {
	$career_career_handler->updateCounter($clean_career_id);
	$career = $careerObj->toArray();
	$icmsTpl->assign("career", $career);
	$departmentObj = $career_department_handler->get($careerObj->getVar("career_did", "e"));
	$department = $departmentObj->toArray();
	$icmsTpl->assign("department", $department);
	
	/**
	 * message form
	 */
	
	if($careerConfig['guest_apply'] == 1) {
		$icmsTpl->assign("message_link", CAREER_URL . "submit.php?op=addmessage&amp;career_id=" . $careerObj->getVar("career_id") );
		addmessage(0, $clean_career_id);
	} else {
		if(is_object(icms::$user)){
			addmessage(0, $clean_career_id);
			$icmsTpl->assign("message_link", CAREER_URL . "submit.php?op=addmessage&amp;career_id=" . $careerObj->getVar("career_id") );
			$icmsTpl->assign("message_perm_denied", FALSE);
		} else {
			$icmsTpl->assign("message_link", ICMS_URL . "/user.php");
			$icmsTpl->assign("message_perm_denied", TRUE);
		}
	}
	
	if ($careerConfig['show_breadcrumbs']){
		$icmsTpl->assign('career_cat_path', $departmentObj->getItemLink(FALSE));
	}else{
		$icmsTpl->assign('career_cat_path',FALSE);
	}
}
include_once 'footer.php';