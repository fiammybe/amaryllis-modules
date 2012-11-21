<?php
/**
 * 'Event' is an comment/comment module for ImpressCMS, which can display google events, too
 *
 * File: /admin/comment.php
 * 
 * list and delete comment Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.2
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

include_once "admin_header.php";

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
$clean_op = isset($_POST['op']) ? filter_input(INPUT_POST, 'op') : $clean_op;

$valid_op = array ("del", "changeApprove", "");

$comment_handler = icms_getModuleHandler("comment", EVENT_DIRNAME, "event");

$clean_comment_id = isset($_GET["comment_id"]) ? filter_input(INPUT_GET, "comment_id", FILTER_SANITIZE_NUMBER_INT) : 0;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "del":
			$controller = new icms_ipf_Controller($comment_handler);
			$controller->handleObjectDeletion();
			break;
		case 'changeApprove':
			$approve = $comment_handler->changeField($clean_comment_id, "comment_approve");
			if($approve == 1) {
				$commentObj = $comment_handler->get($clean_comment_id);
				//$commentObj->sendMessageApproved();
			}
			$red_message = ($approve == 0) ? _AM_EVENT_EVENT_DENIED : _AM_EVENT_EVENT_APPROVED;
			redirect_header(EVENT_ADMIN_URL . 'comment.php', 2, $red_message);
			break;

		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(3, _AM_EVENT_COMMENTS);
			
			$objectTable = new icms_ipf_view_Table($comment_handler, NULL, array("delete"));
			$objectTable->addColumn(new icms_ipf_view_Column("comment_approve", "center", 50, "comment_approve"));
			$objectTable->addColumn(new icms_ipf_view_Column("comment_body", FALSE, FALSE, "summary"));
			$objectTable->addColumn(new icms_ipf_view_Column("comment_uid", FALSE, FALSE, ""));
			$objectTable->addColumn(new icms_ipf_view_Column("comment_eid", FALSE, FALSE));
			$objectTable->addColumn(new icms_ipf_view_Column("comment_pdate", FALSE, FALSE));
			$objectTable->addColumn(new icms_ipf_view_Column("comment_ip", FALSE, FALSE));
			$objectTable->addColumn(new icms_ipf_view_Column("comment_fprint", FALSE, FALSE, ""));
			$objectTable->setDefaultOrder("DESC");
			$objectTable->setDefaultSort("comment_pdate");
			$objectTable->addFilter("comment_eid", "filterEid");
			$objectTable->addFilter("comment_uid", "filterUser");
			$objectTable->addFilter("comment_approve", "filterApprove");
			$icmsAdminTpl->assign("event_comment_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:event_admin.html");
			break;
	}
	include_once 'admin_footer.php';
}