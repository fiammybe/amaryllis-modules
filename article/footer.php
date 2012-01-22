<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /footer.php
 * 
 * fotter included in frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
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

$icmsTpl->assign('thumbnail_width', $articleConfig['thumbnail_width']);
$icmsTpl->assign('thumbnail_height', $articleConfig['thumbnail_height']);
$icmsTpl->assign('display_width', $articleConfig['display_width']);
$icmsTpl->assign('display_height', $articleConfig['display_height']);

$icmsTpl->assign("article_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_ARTICLE_ADMIN_PAGE . "</a>");
$icmsTpl->assign("article_is_admin", icms_userIsAdmin(ARTICLE_DIRNAME));
$icmsTpl->assign('article_url', ARTICLE_URL);
$icmsTpl->assign('article_module_home', '<a href="' . ARTICLE_URL . '" title="' . icms::$module->getVar('name') . '">' . icms::$module->getVar('name') . '</a>');
$icmsTpl->assign('article_images_url', ARTICLE_IMAGES_URL);

/**
 * force article.js to header
 */

$xoTheme->addScript('/modules/' . ARTICLE_DIRNAME . '/scripts/jquery.qtip.js', array('type' => 'text/javascript'));
$xoTheme->addStylesheet('/modules/' . ARTICLE_DIRNAME . '/scripts/jquery.qtip.css');
$xoTheme->addScript('/modules/' . ARTICLE_DIRNAME . '/scripts/article.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';