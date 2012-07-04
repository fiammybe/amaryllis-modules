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
			$version = number_format(icms::$module->getVar('version')/100, 2);
			$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
			$powered_by = "Powered by &nbsp;<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Icmspoll</a>";
			$options = $options_handler->getAllByPollId($clean_poll_id);
			$icmsTpl->assign('printtitle', $printtitle);
			$icmsTpl->assign('printlogourl', ICMS_URL . "/" .  $icmspollConfig['icmspoll_print_logo']);
			$icmsTpl->assign('printfooter', icms_core_DataFilter::undoHtmlSpecialChars($icmspollConfig['icmspoll_print_footer'] . $powered_by . "&nbsp;" . $version));
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
			$version = number_format(icms::$module->getVar('version')/100, 2);
			$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
			$powered_by = "Powered by &nbsp;<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Icmspoll</a>";
			//icms_view_Printerfriendly::generate($content, $title, FALSE, $title);
			$icmsTpl = new icms_view_Tpl();
			$icmsTpl->assign('printtitle', $title);
			$icmsTpl->assign('printlogourl', ICMS_URL . "/" . $icmspollConfig['icmspoll_print_logo']);
			$icmsTpl->assign('printfooter', icms_core_DataFilter::undoHtmlSpecialChars($icmspollConfig['icmspoll_print_footer'] . $powered_by . "&nbsp;" . $version));
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
			global $icmsConfig;
			require_once ICMS_PDF_LIB_PATH.'/tcpdf.php';
			icms_loadLanguageFile('core', 'pdf');
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
			define ('K_PATH_IMAGES', ICMS_ROOT_PATH);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor(PDF_AUTHOR);
			$pdf->SetTitle($title);
			$pdf->SetSubject($title);
			$keywords = $icmsConfig['meta_keywords'];
			$pdf->SetKeywords($keywords);
			$sitename = $icmsConfig['sitename'];
			$siteslogan = $icmsConfig['slogan'];
			$pdfheader = icms_core_DataFilter::undoHtmlSpecialChars($sitename.' - '.$siteslogan);
			$pdf->SetHeaderData($icmspollConfig['icmspoll_print_logo'], PDF_HEADER_LOGO_WIDTH, $pdfheader, ICMS_URL);
		
			//set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor
		
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
			$pdf->setLanguageArray($l); //set language items
			// set font
			$TextFont = (@_PDF_LOCAL_FONT && file_exists(ICMS_PDF_LIB_PATH.'/fonts/'._PDF_LOCAL_FONT.'.php')) ? _PDF_LOCAL_FONT : 'dejavusans';
			$pdf -> SetFont($TextFont);
		
			//initialize document
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->writeHTML($content, true, 0);
			return $pdf->Output();
			break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}