<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /polls.php
 * 
 * Add, edit and delete poll objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: polls.php 608 2012-06-26 19:35:55Z St.Flohrer@gmail.com $
 * @package		icmspoll
 *
 */

function editpoll($pollObj = 0) {
	global $polls_handler, $icmsTpl;
	$user_id = is_object(icms::$user) ? icms::$user->getVar("uid", "e") : 0;
	if(!$pollObj->isNew()) {
		if(!$pollObj->userCanEditAndDelete()) redirect_header(ICMSPOLL_URL, 3, _NOPERM);
		$sform = $pollObj->getSecureForm(_MD_ICMSPOLL_POLL_EDIT, 'addpoll');
		$sform->assign($icmsTpl, 'icmspoll_polls_form');
		$icmsTpl->assign('icmspoll_cat_path', _MD_ICMSPOLL_POLL_EDIT . "&raquo;" . $pollObj->getQuestion() . "&laquo;");
	} else {
		if(!$polls_handler->userCanSubmit()) redirect_header(ICMSPOLL_URL, 3, _NOPERM);
		$pollObj->setVar("user_id", $user_id);
		$pollObj->setVar( "start_time", (time() + 1200) );
		$pollObj->setVar("end_time", (time() + (7 * 24 * 60 * 60)));
		$pollObj->setVar("created_on", time());
		$sform = $pollObj->getSecureForm(_MD_ICMSPOLL_POLL_CREATE, 'addpoll', ICMSPOLL_URL . "polls.php?op=addpoll&amp;poll_id=". $pollObj->getVar("poll_id", "e"));
		$sform->assign($icmsTpl, 'icmspoll_polls_form');
		$icmsTpl->assign('icmspoll_cat_path', _MD_ICMSPOLL_POLL_CREATE);
	}
}
 
include_once 'header.php';

$xoopsOption['template_main'] = 'icmspoll_forms.html';

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

$valid_op = array('mod', 'changeField', 'addpoll', 'del', 'changeWeight', '');
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, "poll_id", FILTER_SANITIZE_NUMBER_INT) : 0;
$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changeField':
			$pollObj = $polls_handler->get($clean_poll_id);
			if ($clean_poll_id > 0 && $pollObj->isNew()) {
				redirect_header(ICMSPOLL_URL, 3, _NOPERM);
			}
			editpoll($pollObj);
			break;
		case 'addpoll':
			$redirect_page = ICMSPOLL_URL . "options.php?op=mod&poll_id=" . $clean_poll_id;
			$controller = new icms_ipf_Controller($polls_handler);
			$controller->storeFromDefaultForm(_MD_ICMSPOLL_POLL_CREATED, _MD_ICMSPOLL_POLL_MODIFIED, $redirect_page);
			break;
		case 'del':
			$pollObj = $polls_handler->get($clean_poll_id);
			if (!$pollObj->userCanEditAndDelete()) {
				redirect_header($pollObj->getItemLink(TRUE), 3, _NOPERM);
			}
			$icmsTpl->assign('icmspoll_cat_path', _MD_ICMSPOLL_POLLS_DELETE . " " . $pollObj->getQuestion());
			
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_ICMSPOLL_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($polls_handler);
			$controller->handleObjectDeletionFromUserSide();
			$icmsTpl->assign('icmspoll_cat_path', $pollObj->getQuestion() . " > " . _DELETE);
			break;
		case 'changeWeight':
			foreach ($_POST['IcmspollPolls_objects'] as $key => $value) {
				$changed = FALSE;
				$pollObj = $icmspoll_poll_handler->get($value);

				if ($pollObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$pollObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$icmspoll_poll_handler -> insert($pollObj);
				}
			}
			$ret = 'polls.php';
			redirect_header( ICMSPOLL_URL . $ret, 2, _MD_ICMSPOLL_WEIGHT_UPDATED);
			break;
		default:
			if(!$icmspoll_isAdmin) redirect_header(ICMSPOLL_URL, 3, _NOPERM);
			
			$objectTable = new icms_ipf_view_Table($polls_handler, FALSE, array('edit', 'delete'), TRUE);
			$objectTable->addColumn(new icms_ipf_view_Column("expired", "center", FALSE, "displayExpired"));
			$objectTable->addColumn(new icms_ipf_view_Column("question", FALSE, FALSE, "getPreviewLink"));
			$objectTable->addColumn(new icms_ipf_view_Column("user_id", FALSE, FALSE, "getUser"));
			$objectTable->addColumn(new icms_ipf_view_Column("start_time", FALSE, FALSE, "getStartDate"));
			$objectTable->addColumn(new icms_ipf_view_Column("end_time", FALSE, FALSE, "getEndDate"));
			$objectTable->addColumn(new icms_ipf_view_Column("created_on", FALSE, FALSE, "getCreatedDate"));
			$objectTable->addColumn(new icms_ipf_view_Column("weight", FALSE, FALSE, "getWeightControl"));
			$objectTable->setDefaultOrder("DESC");
			$objectTable->setDefaultSort("created_on");
			
			$objectTable->addFilter("expired", "filterExpired");
			$objectTable->addFilter("user_id", "filterUsers");
			
			$objectTable->addIntroButton( 'addpoll', 'polls.php?op=mod', _MD_ICMSPOLL_POLLS_ADD );
			$objectTable->addActionButton( 'changeWeight', FALSE, _SUBMIT );
			
			$icmsTpl->assign( 'icmspoll_polls_table', $objectTable->fetch() );
			break;
	}
	include_once 'footer.php';
}