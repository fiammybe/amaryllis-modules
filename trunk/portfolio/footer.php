<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /footer.php
 * 
 * front end index view
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

/**
 * check, if rss feeds are enabled. if so, display link
 */
if($portfolioConfig['use_rss'] == 1) {
	$icmsTpl->assign("portfolio_show_rss", TRUE);
}

/**
 * check, if breadcrumb should be displayed
 */
if( $portfolioConfig['show_breadcrumbs'] == TRUE ) {
	$icmsTpl->assign('portfolio_show_breadcrumb', TRUE);
} else {
	$icmsTpl->assign('portfolio_show_breadcrumb', FALSE);
}

$icmsTpl->assign('thumbnail_width', $portfolioConfig['thumbnail_width']);
$icmsTpl->assign('thumbnail_height', $portfolioConfig['thumbnail_height']);
$icmsTpl->assign('display_width', $portfolioConfig['display_width']);
$icmsTpl->assign('display_height', $portfolioConfig['display_height']);

$icmsTpl->assign("portfolio_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_PORTFOLIO_ADMIN_PAGE . "</a>");
$icmsTpl->assign("portfolio_contacts", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/contact.php'>" ._MD_PORTFOLIO_CONTACT_LINK . "</a>");
$icmsTpl->assign("portfolio_is_admin", icms_userIsAdmin(PORTFOLIO_DIRNAME));
$icmsTpl->assign('portfolio_url', PORTFOLIO_URL);
$icmsTpl->assign('portfolio_module_home', '<a href="' . PORTFOLIO_URL . 'index.php" title="' . icms::$module->getVar('name') . '">' . icms::$module->getVar('name') . '</a>');
$icmsTpl->assign('portfolio_images_url', PORTFOLIO_IMAGES_URL);

/**
 * force portfolio.js to header
 */
/**
 * force portfolio.js to header
 */
$xoTheme->addScript('/modules/' . PORTFOLIO_DIRNAME . '/scripts/jquery.qtip.min.js', array('type' => 'text/javascript'));
$xoTheme->addStylesheet('/modules/' . PORTFOLIO_DIRNAME . '/scripts/jquery.qtip.min.css');
$xoTheme->addScript('/modules/' . PORTFOLIO_DIRNAME . '/scripts/portfolio.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';