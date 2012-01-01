<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /footer.php
 * 
 * fotter included in frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$icmsTpl->assign("article_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_ARTICLE_ADMIN_PAGE . "</a>");
$icmsTpl->assign("article_is_admin", icms_userIsAdmin(ARTICLE_DIRNAME));
$icmsTpl->assign('article_url', ARTICLE_URL);
$icmsTpl->assign('article_images_url', ARTICLE_IMAGES_URL);

$xoTheme->addStylesheet(ARTICLE_URL . 'module' . ((defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? '_rtl' : '') . '.css');

include_once ICMS_ROOT_PATH . '/footer.php';