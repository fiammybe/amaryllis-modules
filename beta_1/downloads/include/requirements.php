<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/requirements.php
 * 
 * check requirements
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */


defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

$failed_requirements = array();

if (ICMS_VERSION_BUILD < 50) {
	$failed_requirements[] = _AM_DOWNLOADS_REQUIREMENTS_ICMS_BUILD;
}

if (count($failed_requirements) > 0) {
	icms_cp_header();
	$icmsAdminTpl->assign('failed_requirements', $failed_requirements);
	$icmsAdminTpl->display(DOWNLOADS_ROOT_PATH . 'templates/album_requirements.html');
	icms_cp_footer();
	exit;
}