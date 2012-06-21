<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /footer.php
 * 
 * Footer file included in all files in frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */
defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
/**
 * check, if breadcrumb should be displayed
 */
if($icmspollConfig['show_breadcrumbs'] == 1) {
	$icmsTpl->assign('icmspoll_show_breadcrumb', TRUE);
}
/**
 * assign additional variables
 */
$icmsTpl->assign('icmspoll_adminpage', '<a href="' . ICMSPOLL_ADMIN_URL . 'index.php" title="admin-link" class="icmspoll_admin_link" >' . _MD_ICMSPOLL_ADMIN_PAGE . '</a>' );
$icmsTpl->assign('icmspoll_is_admin', $icmspoll_isAdmin);
$icmsTpl->assign('icmspoll_url', ICMSPOLL_URL);
$icmsTpl->assign('icmspoll_module_home', '<a href="' . ICMSPOLL_URL . '" title="' . $icmspoll_moduleName . '">' . $icmspoll_moduleName . '</a>');
$icmsTpl->assign('icmspoll_images_url', ICMSPOLL_IMAGES_URL);
$icmsTpl->assign('dirname', icms::$module->getVar('dirname'));


include_once ICMS_ROOT_PATH . 'footer.php';