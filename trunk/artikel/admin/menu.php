<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/menu.php
 * 
 * ACP Menu of the module
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

$adminmenu[] = array(
	"title" => _MI_ARTICLE_CATEGORYS,
	"link" => "admin/category.php");
$adminmenu[] = array(
	"title" => _MI_ARTICLE_ARTICLES,
	"link" => "admin/article.php");
$adminmenu[] = array(
	"title" => _MI_ARTICLE_INDEXPAGES,
	"link" => "admin/indexpage.php");
$adminmenu[] = array(
	"title" => _MI_ARTICLE_TAGSS,
	"link" => "admin/tags.php");
$adminmenu[] = array(
	"title" => _MI_ARTICLE_LOGS,
	"link" => "admin/log.php");


$module = icms::handler("icms_module")->getByDirname(basename(dirname(dirname(__FILE__))));

$headermenu[] = array(
	"title" => _PREFERENCES,
	"link" => "../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $module->getVar("mid"));
$headermenu[] = array(
	"title" => _CO_ICMS_GOTOMODULE,
	"link" => ICMS_URL . "/modules/article/");
$headermenu[] = array(
	"title" => _CO_ICMS_UPDATE_MODULE,
	"link" => ICMS_URL . "/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=" . basename(dirname(dirname(__FILE__))));
$headermenu[] = array(
	"title" => _MODABOUT_ABOUT,
	"link" => ICMS_URL . "/modules/article/admin/about.php");

unset($module_handler);