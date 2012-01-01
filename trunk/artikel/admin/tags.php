<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/tags.php
 * 
 * add, edit and delete tags
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
 * Edit a Tags
 *
 * @param int $tags_id Tagsid to be edited
*/
function edittags($tags_id = 0) {
	global $article_tags_handler, $icmsModule, $icmsAdminTpl;

	$tagsObj = $article_tags_handler->get($tags_id);

	if (!$tagsObj->isNew()){
		$icmsModule->displayAdminMenu(3, _AM_ARTICLE_TAGSS . " > " . _CO_ICMS_EDITING);
		$sform = $tagsObj->getForm(_AM_ARTICLE_TAGS_EDIT, "addtags");
		$sform->assign($icmsAdminTpl);
	} else {
		$icmsModule->displayAdminMenu(3, _AM_ARTICLE_TAGSS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $tagsObj->getForm(_AM_ARTICLE_TAGS_CREATE, "addtags");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:article_admin_tags.html");
}

include_once "admin_header.php";

$article_tags_handler = icms_getModuleHandler("tags", basename(dirname(dirname(__FILE__))), "article");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod", "changedField", "addtags", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_tags_id = isset($_GET["tags_id"]) ? (int)$_GET["tags_id"] : 0 ;

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
			edittags($clean_tags_id);
			break;

		case "addtags":
			$controller = new icms_ipf_Controller($article_tags_handler);
			$controller->storeFromDefaultForm(_AM_ARTICLE_TAGS_CREATED, _AM_ARTICLE_TAGS_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($article_tags_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$tagsObj = $article_tags_handler->get($clean_tags_id);
			icms_cp_header();
			$tagsObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(3, _AM_ARTICLE_TAGSS);
			$objectTable = new icms_ipf_view_Table($article_tags_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("tag_title"));
			$objectTable->addIntroButton("addtags", "tags.php?op=mod", _AM_ARTICLE_TAGS_CREATE);
			$icmsAdminTpl->assign("article_tags_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:article_admin_tags.html");
			break;
	}
	icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */