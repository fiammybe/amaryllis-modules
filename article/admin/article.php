<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /admin/article.php
 * 
 * add, edit, view and delete articles
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

/**
 * Edit a Article
 *
 * @param int $article_id Articleid to be edited
*/
function editarticle($article_id = 0) {
	global $artikel_article_handler, $icmsModule, $icmsAdminTpl;

	$articleObj = $artikel_article_handler->get($article_id);

	if (!$articleObj->isNew()){
		$icmsModule->displayAdminMenu(1, _AM_ARTIKEL_ARTICLES . " > " . _CO_ICMS_EDITING);
		$sform = $articleObj->getForm(_AM_ARTIKEL_ARTICLE_EDIT, "addarticle");
		$sform->assign($icmsAdminTpl);
	} else {
		$icmsModule->displayAdminMenu(1, _AM_ARTIKEL_ARTICLES . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $articleObj->getForm(_AM_ARTIKEL_ARTICLE_CREATE, "addarticle");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:artikel_admin_article.html");
}

include_once "admin_header.php";

$artikel_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "artikel");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod", "changedField", "addarticle", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_article_id = isset($_GET["article_id"]) ? (int)$_GET["article_id"] : 0 ;

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
			editarticle($clean_article_id);
			break;

		case "addarticle":
			$controller = new icms_ipf_Controller($artikel_article_handler);
			$controller->storeFromDefaultForm(_AM_ARTIKEL_ARTICLE_CREATED, _AM_ARTIKEL_ARTICLE_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($artikel_article_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$articleObj = $artikel_article_handler->get($clean_article_id);
			icms_cp_header();
			$articleObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(1, _AM_ARTIKEL_ARTICLES);
			$objectTable = new icms_ipf_view_Table($artikel_article_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("article_title"));
			$objectTable->addIntroButton("addarticle", "article.php?op=mod", _AM_ARTIKEL_ARTICLE_CREATE);
			$icmsAdminTpl->assign("artikel_article_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:artikel_admin_article.html");
			break;
	}
	icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */