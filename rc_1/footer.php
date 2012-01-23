<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /footer.php
 * 
 * Frontend footer
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$icmsTpl->assign("downloads_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_DOWNLOADS_ADMIN_PAGE . "</a>");
$icmsTpl->assign("downloads_is_admin", icms_userIsAdmin(DOWNLOADS_DIRNAME));
$icmsTpl->assign('downloads_url', DOWNLOADS_URL);
$icmsTpl->assign('downloads_module_home', '<a href="' . DOWNLOADS_URL . '" title="' . icms::$module->getVar('name') . '">' . icms::$module->getVar('name') . '</a>');
$icmsTpl->assign('downloads_images_url', DOWNLOADS_IMAGES_URL);

/**
 * force downloads.js to header
 */

$xoTheme->addScript('/modules/' . DOWNLOADS_DIRNAME . '/scripts/jquery.qtip.js', array('type' => 'text/javascript'));
$xoTheme->addStylesheet('/modules/' . DOWNLOADS_DIRNAME . '/scripts/jquery.qtip.css');
$xoTheme->addScript('/modules/' . DOWNLOADS_DIRNAME . '/scripts/downloads.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';