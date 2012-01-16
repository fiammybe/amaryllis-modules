<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /footer.php
 * 
 * front end index view
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


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$icmsTpl->assign("career_company_name", $careerConfig['career_display_company']);
$icmsTpl->assign("career_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_CAREER_ADMIN_PAGE . "</a>");
$icmsTpl->assign("career_is_admin", icms_userIsAdmin(CAREER_DIRNAME));
$icmsTpl->assign('career_url', CAREER_URL);
$icmsTpl->assign('career_module_home', '<a href="' . CAREER_URL . 'index.php" title="' . icms::$module->getVar('name') . '">' . icms::$module->getVar('name') . '</a>');
$icmsTpl->assign('career_images_url', CAREER_IMAGES_URL);

/**
 * force career.js to header
 */
$xoTheme->addScript('/modules/' . CAREER_DIRNAME . '/scripts/career.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';