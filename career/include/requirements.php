<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * contains requirement informations
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


defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

$failed_requirements = array();

if (ICMS_VERSION_BUILD < 50) {
	$failed_requirements[] = _AM_CAREER_REQUIREMENTS_ICMS_BUILD;
}

if (count($failed_requirements) > 0) {
	icms_cp_header();
	$icmsAdminTpl->assign('failed_requirements', $failed_requirements);
	$icmsAdminTpl->display(CAREER_ROOT_PATH . 'templates/career_requirements.html');
	icms_cp_footer();
	exit;
}