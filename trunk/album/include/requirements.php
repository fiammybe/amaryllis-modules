<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /include/requirements.php
 *
 * Checks the requirements of the module
 *
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * 
*/

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

$failed_requirements = array();

if (ICMS_VERSION_BUILD < 50) {
	$failed_requirements[] = _AM_ALBUM_REQUIREMENTS_ICMS_BUILD;
}

/* imBlogging needs imTagging */
$indexModule = icms_get_module_status("index");
if (!$indexModule) {
    $failed_requirements[] = _AM_ALBUM_REQUIREMENTS_INDEXMOD;
}

if (count($failed_requirements) > 0) {
	icms_cp_header();
	$icmsAdminTpl->assign('failed_requirements', $failed_requirements);
	$icmsAdminTpl->display(ALBUM_ROOT_PATH . 'templates/album_requirements.html');
	icms_cp_footer();
	exit;
}