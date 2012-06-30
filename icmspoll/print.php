<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /print.php
 * 
 * print poll results
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

include_once 'header.php';

icms::$logger->disableLogger();

$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, 'poll_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_print = isset($_GET['print']) ? filter_input(INPUT_GET, 'print') : 'result';

$valid_print = array("result", "log", "pdf");

if(in_array($clean_print, $valid_print, TRUE)) {
	$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
	$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
	$pollObj = $polls_handler->get($clean_poll_id);
	if (!$pollObj || !is_object($pollObj) || $pollObj->isNew()) {
		redirect_header(icms_getPreviousPage(), 2, _MD_ICMSPOLL_PRINT_NO_POLL);
	}
	if (!$pollObj->viewAccessGranted()){
		redirect_header(icms_getPreviousPage(), 3, _NOPERM);
	}
	switch ($clean_print) {
		case 'result':
			$icmsTpl = new icms_view_Tpl();
			global $icmsConfig;
			$poll = $pollObj->toArray();
			$printtitle = $icmsConfig['sitename']." - ". strip_tags($pollObj->getVar('question','n' ));
			$options = $options_handler->getAllByPollId($clean_poll_id);
			$icmsTpl->assign('printtitle', $printtitle);
			$icmsTpl->assign('printlogourl', ICMS_URL . "/" .  $icmspollConfig['icmspoll_print_logo']);
			$icmsTpl->assign('printfooter', icms_core_DataFilter::undoHtmlSpecialChars($icmspollConfig['icmspoll_print_footer']));
			$icmsTpl->assign('poll', $poll);
			$icmsTpl->assign('options', $options);
			$icmsTpl->assign('icmspoll_is_admin', $icmspoll_isAdmin);
			$icmsTpl->assign("icmspoll_result_layout", TRUE);
			$icmsTpl->display('db:icmspoll_print.html');
			break;
		
		case 'log':
			if(!$icmspoll_isAdmin) {
				redirect_header(icms_getPreviousPage(), 3, _NOPERM);
			}
			$poll = $pollObj->toArray();
			$options = $options_handler->getAllByPollId($clean_poll_id);
			$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
			$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("poll_id", $clean_poll_id));
			$criteria->setLimit(0);
			$objectTable = new icms_ipf_view_Table($log_handler, $criteria, array(), TRUE);
			$objectTable->addColumn(new icms_ipf_view_Column("log_id", "center", 50));
			$objectTable->addColumn(new icms_ipf_view_Column("poll_id", FALSE, FALSE, "getPollName"));
			$objectTable->addColumn(new icms_ipf_view_Column("option_id", FALSE, FALSE, "getOptionText"));
			$objectTable->addColumn(new icms_ipf_view_Column("user_id", "center", 100, "getUser"));
			$objectTable->addColumn(new icms_ipf_view_Column("ip", "center", 100, "getLogIP"));
			$objectTable->addColumn(new icms_ipf_view_Column("session_id", FALSE, 100));
			$objectTable->addColumn(new icms_ipf_view_Column("time", "center", 50, "getTime"));
			$objectTable->setDefaultOrder("ASC");
			$objectTable->setDefaultSort("time");
			$objectTable->_limitsel = "all";
			
			$time = time();
			$print_date = date('d/m/Y H:i:s', $time);
			$user = icms_member_user_Object::getUnameFromId(icms::$user->getVar("uid", "e"));
			
			$title = _MD_ICMSPOLL_LOGPRINT_TITLE . "&nbsp&raquo;" . $poll['question'] . "&laquo;";
			
			$content = _MD_ICMSPOLL_LOGPRINT_USER . " : " . $user . "<br />";
			$content .= _MD_ICMSPOLL_LOGPRINT_TIME . " : " . $print_date . "<br /><br />";
			$content .= _MD_ICMSPOLL_CREATED_ON . " : " . $poll['created_on'] . "<br />";
			$content .= _MD_ICMSPOLL_PUBLISHER . " : " . icms_member_user_Object::getUnameFromId($poll['user_id']) . "<br />";
			$content .= _MD_ICMSPOLL_START_ON . " : " . $poll['start_time'] . "<br />";
			$content .= _MD_ICMSPOLL_END_ON . " : " . $poll['end_time'] . "<br />";
			$content .= _CO_ICMSPOLL_POLLS_DESCRIPTION . " : " . $poll['dsc'] . "<br /><br />";
			$content .= _MD_ICMSPOLL_RESULTS_TOTALVOTES . " : " . $log_handler->getTotalVotesByPollId($clean_poll_id) . "<br />";
			$content .= _MD_ICMSPOLL_RESULTS_TOTALVOTES_REGISTERED . " : " . $log_handler->getTotalRegistredVoters($clean_poll_id) . "<br />";
			$content .= _MD_ICMSPOLL_RESULTS_TOTALVOTES_ANONS . " : " . $log_handler->getTotalAnonymousVoters($clean_poll_id) . "<br /><br />";
			foreach ($options as $option) {
				$content .= $option['text'] . "<br />";
				$content .= _MD_ICMSPOLL_RESULTS_BY_OPTION_TOTAL . " : " . $option['total_votes'] . "(" . $option['endresult'] . ")" . "<br />";
				$content .= _MD_ICMSPOLL_RESULTS_BY_OPTION_USERS . " : " . $option['user_votes'] . "<br />";
				$content .= _MD_ICMSPOLL_RESULTS_BY_OPTION_ANON . " : " . $option['anon_votes'] . "<br /><br />";
			}
			
			//icms_view_Printerfriendly::generate($content, $title, FALSE, $title);
			$icmsTpl = new icms_view_Tpl();
			$icmsTpl->assign('printtitle', $title);
			$icmsTpl->assign('printlogourl', ICMS_URL . "/" . $icmspollConfig['icmspoll_print_logo']);
			$icmsTpl->assign('printfooter', icms_core_DataFilter::undoHtmlSpecialChars($icmspollConfig['icmspoll_print_footer'], "str", "encodehigh"));
			$icmsTpl->assign("options", $options);
			$icmsTpl->assign('poll', $poll);
			$icmsTpl->assign("content", $content);
			$icmsTpl->assign("log_table", $objectTable->fetch());
			$icmsTpl->assign("icmspoll_log_layout", TRUE);
			$icmsTpl->display('db:icmspoll_print.html');
			break;
		case 'pdf':
			$poll = $pollObj->toArray();
			$options = $options_handler->getAllByPollId($clean_poll_id);
			if($icmspoll_isAdmin) {
				$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
				$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("poll_id", $clean_poll_id));
				$criteria->setLimit((int)"0");
				$objectTable = new icms_ipf_view_Table($log_handler, $criteria, array(), TRUE);
				$objectTable->addColumn(new icms_ipf_view_Column("log_id", "center", 50));
				$objectTable->addColumn(new icms_ipf_view_Column("poll_id", FALSE, FALSE, "getPollName"));
				$objectTable->addColumn(new icms_ipf_view_Column("option_id", FALSE, FALSE, "getOptionText"));
				$objectTable->addColumn(new icms_ipf_view_Column("user_id", "center", 100, "getUser"));
				$objectTable->addColumn(new icms_ipf_view_Column("ip", "center", 100, "getLogIP"));
				$objectTable->addColumn(new icms_ipf_view_Column("session_id", FALSE, 100));
				$objectTable->addColumn(new icms_ipf_view_Column("time", "center", 50, "getTime"));
				$objectTable->setDefaultOrder("ASC");
				$objectTable->setDefaultSort("time");
			}
			$time = time();
			$print_date = date('d/m/Y H:i:s', $time);
			$user = icms_member_user_Object::getUnameFromId(icms::$user->getVar("uid", "e"));
			
			$title = _MD_ICMSPOLL_LOGPRINT_TITLE . "&nbsp&raquo;" . $poll['question'] . "&laquo;<br /> <br />";
			
			$content = _MD_ICMSPOLL_LOGPRINT_USER . " : " . $user . "<br />";
			$content .= _MD_ICMSPOLL_LOGPRINT_TIME . " : " . $print_date . "<br /><br />";
			$content .= _MD_ICMSPOLL_CREATED_ON . " : " . $poll['created_on'] . "<br />";
			$content .= _MD_ICMSPOLL_PUBLISHER . " : " . icms_member_user_Object::getUnameFromId($poll['user_id']) . "<br />";
			$content .= _MD_ICMSPOLL_START_ON . " : " . $poll['start_time'] . "<br />";
			$content .= _MD_ICMSPOLL_END_ON . " : " . $poll['end_time'] . "<br />";
			$content .= _CO_ICMSPOLL_POLLS_DESCRIPTION . " : " . $poll['dsc'] . "<br /><br />";
			$content .= _MD_ICMSPOLL_RESULTS_TOTALVOTES . " : " . $log_handler->getTotalVotesByPollId($clean_poll_id) . "<br />";
			$content .= _MD_ICMSPOLL_RESULTS_TOTALVOTES_REGISTERED . " : " . $log_handler->getTotalRegistredVoters($clean_poll_id) . "<br />";
			$content .= _MD_ICMSPOLL_RESULTS_TOTALVOTES_ANONS . " : " . $log_handler->getTotalAnonymousVoters($clean_poll_id) . "<br /><br />";
			foreach ($options as $option) {
				$content .= _MD_ICMSPOLL_RESULTS_BY_OPTION_TOTAL . " : " . $option['total_votes'] . "(" . $option['endresult'] . ")" . "<br />";
				$content .= _MD_ICMSPOLL_RESULTS_BY_OPTION_USERS . " : " . $option['user_votes'] . "<br />";
				$content .= _MD_ICMSPOLL_RESULTS_BY_OPTION_ANON . " : " . $option['anon_votes'] . "<br /><br />";
			}
			
			if($icmspoll_isAdmin) $content .= $objectTable->fetch();
			
			break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}