<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /article.php
 * 
 * add edit and delete tags
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

$xoopsOption["template_main"] = "article_tags.html";
include_once ICMS_ROOT_PATH . "/header.php";

$article_tags_handler = icms_getModuleHandler("tags", basename(dirname(__FILE__)), "article");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_tags_id = isset($_GET["tags_id"]) ? (int)$_GET["tags_id"] : 0 ;
$tagsObj = $article_tags_handler->get($clean_tags_id);

if ($tagsObj && !$tagsObj->isNew()) {
	$icmsTpl->assign("article_tags", $tagsObj->toArray());
} else {
	$icmsTpl->assign("article_title", _MD_ARTICLE_ALL_TAGSS);

	$objectTable = new icms_ipf_view_Table($article_tags_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("tag_title"));
	$icmsTpl->assign("article_tags_table", $objectTable->fetch());
}

$icmsTpl->assign("article_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";