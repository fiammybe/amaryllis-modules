<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /include/requirements.php
 *
 * requirements check
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$failed_requirements = array();

if (ICMS_VERSION_BUILD < 50) {
	$failed_requirements[] = _AM_TOOLS_REQUIREMENTS_ICMS_BUILD;
}

if (count($failed_requirements) > 0) {
	icms_cp_header();
	$icmsAdminTpl->assign("failed_requirements", $failed_requirements);
	$icmsAdminTpl->display(TOOLS_ROOT_PATH . "templates/tools_requirements.html");
	icms_cp_footer();
	exit;
}