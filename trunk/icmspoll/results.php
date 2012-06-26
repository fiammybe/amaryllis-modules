<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /results.php
 * 
 * main index file
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

$xoopsOption['template_main'] = 'icmspoll_index.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$icmspoll_indexpage_handler = icms_getModuleHandler( 'indexpage', ICMSPOLL_DIRNAME, 'icmspoll' );
$indexpageObj = $icmspoll_indexpage_handler->get(1);
$index = $indexpageObj->toArray();
$icmsTpl->assign('icmspoll_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$valid_op = array("");
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, "op", FILTER_SANITIZE_SPECIAL_CHARS) : "";

$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, "start", FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, "uid", FILTER_SANITIZE_NUMBER_INT) : FALSE;
$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, "poll_id", FILTER_SANITIZE_NUMBER_INT) : 0;

if(in_array($clean_op, $valid_op, TRUE)) {

	$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
	$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
	$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");

	switch ($clean_op) {
		case 'getResultsByUid':
			$polls = $polls_handler->getPolls($clean_start, $icmspollConfig['show_polls'], $icmspollConfig['polls_default_order'], $icmspollConfig['polls_default_sort'], $clean_uid, TRUE, FALSE);
			$icmsTpl->assign('polls_by_user', $polls);
			/**
			 * pagination control
			 */
			$polls_count = $polls_handler->getPollsCount(TRUE, FALSE);
			$polls_pagenav = new icms_view_PageNav($polls_count, $icmspollConfig['show_polls'], $clean_start, 'start', FALSE);
			$icmsTpl->assign('polls_pagenav', $polls_pagenav->renderNav());
			break;
		
		default:
			/**
			 * check, if a single poll is requested and retrieve Object, if so
			 */
			if($clean_poll_id != 0) {
				$pollObj = $polls_handler->get($clean_poll_id);
			} else {
				$pollObj = FALSE;
			}
			if(is_object($pollObj) && !$pollObj->isNew() && $pollObj->viewAccessGranted()) {
				$poll = $pollObj->toArray();
				$totalVotes = $log_handler->getTotalVotesByPollId($clean_poll_id);
				$totalVoters = $log_handler->getTotalVoters($clean_poll_id);
				$totalAnons = $log_handler->getTotalAnonymousVoters($clean_poll_id);
				$totalUserVotes = $log_handler->getTotalRegistredVoters($clean_poll_id);
				$icmsTpl->assign("poll", $poll);
				$icmsTpl->assign("total_votes", $totalVotes);
				$icmsTpl->assign("total_voters", $totalVoters);
				$icmsTpl->assign("total_anonymous", $totalAnons);
				$icmsTpl->assign("total_registred", $totalUserVotes);
				
				$options = $options_handler->getAllByPollId($clean_poll_id, "weight", "ASC");
				$icmsTpl->assign("options", $options);
				$user_id = (is_object(icms::$user)) ? icms::$user->getVar("uid", "e") : 0;
				$icmsTpl->assign("user_id", $user_id);
				
				
				
			} elseif ($clean_poll_id == 0) {
				$polls = $polls_handler->getPolls($clean_start, $icmspollConfig['show_polls'], $icmspollConfig['polls_default_order'], $icmspollConfig['polls_default_sort'], FALSE, TRUE, FALSE);
				$icmsTpl->assign('polllist', $polls);
				/**
				 * pagination control
				 */
				$polls_count = $polls_handler->getPollsCount(TRUE, FALSE);
				$polls_pagenav = new icms_view_PageNav($polls_count, $icmspollConfig['show_polls'], $clean_start, 'start', FALSE);
				$icmsTpl->assign('polls_pagenav', $polls_pagenav->renderNav());
			} else {
				redirect_header(ICMSPOLL_URL . "results.php", 3, _NOPERM);
			}
			break;
	}
	include_once 'footer.php';
}