<?php
/**
 * Footer page included at the end of each page on user side of the mdoule
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		downloads
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$icmsTpl->assign("downloads_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_DOWNLOADS_ADMIN_PAGE . "</a>");
$icmsTpl->assign("downloads_is_admin", icms_userIsAdmin(DOWNLOADS_DIRNAME));
$icmsTpl->assign('downloads_url', DOWNLOADS_URL);
$icmsTpl->assign('downloads_module_home', '<a href="' . DOWNLOADS_URL . '" title="' . icms::$module->getVar('name') . '">' . icms::$module->getVar('name') . '</a>');
$icmsTpl->assign('downloads_images_url', DOWNLOADS_IMAGES_URL);

$xoTheme->addStylesheet(DOWNLOADS_URL . 'module' . ((defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? '_rtl' : '') . '.css');

include_once ICMS_ROOT_PATH . '/footer.php';