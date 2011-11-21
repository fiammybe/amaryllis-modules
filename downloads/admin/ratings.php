<?php
/**
 * Admin page to manage ratingss
 *
 * List, add, edit and delete ratings objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		downloads
 * @version		$Id$
 */

/**
 * Edit a Ratings
 *
 * @param int $ratings_id Ratingsid to be edited
*/
function editratings($ratings_id = 0) {
	global $downloads_ratings_handler, $icmsModule, $icmsAdminTpl;

	$ratingsObj = $downloads_ratings_handler->get($ratings_id);

	if (!$ratingsObj->isNew()){
		$icmsModule->displayAdminMenu(3, _AM_DOWNLOADS_RATINGSS . " > " . _CO_ICMS_EDITING);
		$sform = $ratingsObj->getForm(_AM_DOWNLOADS_RATINGS_EDIT, "addratings");
		$sform->assign($icmsAdminTpl);
	} else {
		$icmsModule->displayAdminMenu(3, _AM_DOWNLOADS_RATINGSS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $ratingsObj->getForm(_AM_DOWNLOADS_RATINGS_CREATE, "addratings");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:downloads_admin_ratings.html");
}

include_once "admin_header.php";

$downloads_ratings_handler = icms_getModuleHandler("ratings", basename(dirname(dirname(__FILE__))), "downloads");
/** Use a naming convention that indicates the source of the content of the variable */
$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod", "changedField", "addratings", "del", "view", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_ratings_id = isset($_GET["ratings_id"]) ? (int)$_GET["ratings_id"] : 0 ;

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
			editratings($clean_ratings_id);
			break;

		case "addratings":
			$controller = new icms_ipf_Controller($downloads_ratings_handler);
			$controller->storeFromDefaultForm(_AM_DOWNLOADS_RATINGS_CREATED, _AM_DOWNLOADS_RATINGS_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($downloads_ratings_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$ratingsObj = $downloads_ratings_handler->get($clean_ratings_id);
			icms_cp_header();
			$ratingsObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(3, _AM_DOWNLOADS_RATINGSS);
			$objectTable = new icms_ipf_view_Table($downloads_ratings_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("item"));
			$objectTable->addIntroButton("addratings", "ratings.php?op=mod", _AM_DOWNLOADS_RATINGS_CREATE);
			$icmsAdminTpl->assign("downloads_ratings_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:downloads_admin_ratings.html");
			break;
	}
	icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */