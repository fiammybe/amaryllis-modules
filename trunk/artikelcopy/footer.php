<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /footer.php
 * 
 * fotter included in frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Artikel
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		artikel
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$icmsTpl->assign("artikel_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_ARTIKEL_ADMIN_PAGE . "</a>");
$icmsTpl->assign("artikel_is_admin", icms_userIsAdmin(ARTIKEL_DIRNAME));
$icmsTpl->assign('artikel_url', ARTIKEL_URL);
$icmsTpl->assign('artikel_images_url', ARTIKEL_IMAGES_URL);

$xoTheme->addStylesheet(ARTIKEL_URL . 'module' . ((defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? '_rtl' : '') . '.css');

include_once ICMS_ROOT_PATH . '/footer.php';