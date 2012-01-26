<?php
/**
 * 'Article' is an career management module for ImpressCMS
 *
 * File: /print.php
 * 
 * print single career
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

include_once 'header.php';

$career_career_handler = icms_getModuleHandler("career", basename(dirname(__FILE__)), "career");

$clean_career_id = isset($_GET['career_id']) ? filter_input(INPUT_GET, 'career_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_short_url = isset($_GET['career'] ) ? filter_input(INPUT_GET, 'career') : '';

if ($clean_short_url != '' && $clean_career_id == 0) {
	$criteria = new icms_db_criteria_Compo();
	$criteria->add(new icms_db_criteria_Item("short_url", urlencode($clean_short_url)));
	$careerObj = $career_career_handler->getObjects($criteria);
	$careerObj = $careerObj [0];
	$clean_career_id = $careerObj->getVar("career_id", "e");
} else {
	$careerObj = $career_career_handler->get($clean_career_id);
}

if (!$careerObj || !is_object($careerObj) || $careerObj->isNew()) {
	redirect_header(icms_getPreviousPage(), 2, _MD_CAREER_NO_CAREERS);
}

if (!$careerObj->accessGranted()){
	redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
}

$categories = $careerObj->getCareerDid(FALSE);

$icmsTpl = new icms_view_Tpl();
global $icmsConfig;

$career = $careerObj->toArray();
$printtitle = $icmsConfig['sitename']." - ". $categories . ' > ' . strip_tags($careerObj->getVar('career_title','n' ));

$icmsTpl->assign('printtitle', $printtitle);
$icmsTpl->assign('printlogourl', $careerConfig['career_print_logo']);
$icmsTpl->assign('printfooter', $careerConfig['career_print_footer']);
$icmsTpl->assign('career', $career);

$icmsTpl->display('db:career_print.html');