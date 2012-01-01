<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/indexpage.php
 * 
 * Edit indexpage for frontend
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

/**
 * Edit a Indexpage
 *
 * @param int $indexpage_id Indexpageid to be edited
*/
function editindexpage($indexpage_id = 0) {
	global $article_indexpage_handler, $icmsModule, $icmsAdminTpl;

	$indexpageObj = $article_indexpage_handler->get($indexpage_id);

	if (!$indexpageObj->isNew()){
		$icmsModule->displayAdminMenu(2, _AM_ARTICLE_INDEXPAGES . " > " . _CO_ICMS_EDITING);
		$sform = $indexpageObj->getForm(_AM_ARTICLE_INDEXPAGE_EDIT, "addindexpage");
		$sform->assign($icmsAdminTpl);
	} else {
		$icmsModule->displayAdminMenu(2, _AM_ARTICLE_INDEXPAGES . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $indexpageObj->getForm(_AM_ARTICLE_INDEXPAGE_CREATE, "addindexpage");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:article_admin_indexpage.html");
}

include_once "admin_header.php";

$article_indexpage_handler = icms_getModuleHandler("indexpage", basename(dirname(dirname(__FILE__))), "article");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod", "changedField", "addindexpage", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_indexpage_id = isset($_GET["indexpage_id"]) ? (int)$_GET["indexpage_id"] : 0 ;

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
*/
if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editindexpage($clean_indexpage_id);
			break;

		case "addindexpage":
			$controller = new icms_ipf_Controller($article_indexpage_handler);
			$controller->storeFromDefaultForm(_AM_ARTICLE_INDEXPAGE_CREATED, _AM_ARTICLE_INDEXPAGE_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($article_indexpage_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$indexpageObj = $article_indexpage_handler->get($clean_indexpage_id);
			icms_cp_header();
			$indexpageObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(2, _AM_ARTICLE_INDEXPAGES);
			$objectTable = new icms_ipf_view_Table($article_indexpage_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("index_header"));
			$objectTable->addIntroButton("addindexpage", "indexpage.php?op=mod", _AM_ARTICLE_INDEXPAGE_CREATE);
			$icmsAdminTpl->assign("article_indexpage_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:article_admin_indexpage.html");
			break;
	}
	icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */