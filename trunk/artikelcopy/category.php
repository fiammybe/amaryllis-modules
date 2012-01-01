<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /category.php
 * 
 * add edit and delete categories
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

include_once "header.php";

$xoopsOption["template_main"] = "artikel_category.html";
include_once ICMS_ROOT_PATH . "/header.php";

$artikel_category_handler = icms_getModuleHandler("category", basename(dirname(__FILE__)), "artikel");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_category_id = isset($_GET["category_id"]) ? (int)$_GET["category_id"] : 0 ;
$categoryObj = $artikel_category_handler->get($clean_category_id);

if($categoryObj && !$categoryObj->isNew()) {
	$icmsTpl->assign("artikel_category", $categoryObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($categoryObj->getVar("category_title"), $categoryObj->getVar("meta_keywords", "n"), $categoryObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("artikel_title", _MD_ARTIKEL_ALL_CATEGORYS);

	$objectTable = new icms_ipf_view_Table($artikel_category_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("category_title"));
	$icmsTpl->assign("artikel_category_table", $objectTable->fetch());
}

$icmsTpl->assign("artikel_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";