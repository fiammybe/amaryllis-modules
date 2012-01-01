<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /article.php
 * 
 * add edit and delete articles
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


include_once "header.php";

$xoopsOption["template_main"] = "article_article.html";
include_once ICMS_ROOT_PATH . "/header.php";

$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_article_id = isset($_GET["article_id"]) ? (int)$_GET["article_id"] : 0 ;
$articleObj = $article_article_handler->get($clean_article_id);

if($articleObj && !$articleObj->isNew()) {
	$icmsTpl->assign("article_article", $articleObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($articleObj->getVar("article_title"), $articleObj->getVar("meta_keywords", "n"), $articleObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("article_title", _MD_ARTICLE_ALL_ARTICLES);

	$objectTable = new icms_ipf_view_Table($article_article_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("article_title"));
	$icmsTpl->assign("article_article_table", $objectTable->fetch());
}

$icmsTpl->assign("article_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";