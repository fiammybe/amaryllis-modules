<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /include/requirements.php
 * 
 * check module requirements
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: requirements.php 11 2012-06-27 12:30:05Z qm-b $
 * @package		icmspoll
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

$failed_requirements = array();

if (ICMS_VERSION_BUILD < 50) {
	$failed_requirements[] = _AM_ICMSPOLL_REQUIREMENTS_ICMS_BUILD;
}

if (count($failed_requirements) > 0) {
	icms_cp_header();
	$icmsAdminTpl->assign('failed_requirements', $failed_requirements);
	$icmsAdminTpl->display(ICMSPOLL_ROOT_PATH . 'templates/icmspoll_requirements.html');
	icms_cp_footer();
	exit;
}