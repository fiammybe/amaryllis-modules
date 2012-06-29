<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/polls.php
 * 
 * Add, edit and delete poll objects
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

/**
 * Edit/Create a Poll
 *
 * @param int $poll_id Pollid to be edited
*/
function editpoll($poll_id = 0) {
	global $polls_handler, $icmsAdminTpl, $clean_op;
	
	$pollObj = $polls_handler->get($poll_id);
	$user_id = icms::$user->getVar("uid", "e");
	
	if(!$pollObj->isNew()) {
		if($clean_op == "reset") {
			$pollObj->setVar( "start_time", (time() + 1200) );
        	$pollObj->setVar("end_time", (time() + (7 * 24 * 60 * 60)));
			$pollObj->setVar("started", 0);
			$pollObj->setVar("expired", 0);
		}
		icms::$module->displayAdminmenu( 1, _MI_ICMSPOLL_MENU_POLLS . ' > ' . _MI_ICMSPOLL_MENU_POLLS_EDITING);
		$sform = $pollObj->getForm(_MI_ICMSPOLL_MENU_POLLS_EDITING, 'addpoll');
		$sform->assign($icmsAdminTpl);
	} else {
		icms::$module->displayAdminmenu( 1, _MI_ICMSPOLL_MENU_POLLS . " > " . _MI_ICMSPOLL_MENU_POLLS_CREATINGNEW);
        $pollObj->setVar("user_id", $user_id);
        $pollObj->setVar( "start_time", (time() + 1200) );
        $pollObj->setVar("end_time", (time() + (7 * 24 * 60 * 60)));
        $pollObj->setVar("created_on", time());
		$sform = $pollObj->getForm(_MI_ICMSPOLL_MENU_POLLS_CREATINGNEW, 'addpoll');
		$sform->assign($icmsAdminTpl);
	}
	$icmsAdminTpl->display('db:icmspoll_admin.html');
}

include_once 'admin_header.php';

/**
 * Create a whitelist of valid values
 */
$valid_op = array("mod", "changeField", "reset", "addpoll", "del", "view", "changeWeight", "");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, 'poll_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;
if (isset($_POST['poll_id'])) $clean_poll_id = filter_input(INPUT_POST, 'poll_id', FILTER_SANITIZE_NUMBER_INT);

$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changeField':
		case 'reset':
			if($clean_op == "reset") {
				$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");
				$log_handler = icms_getModuleHandler("log", ICMSPOLL_DIRNAME, "icmspoll");
				$options_handler->resetCountByPollId($clean_poll_id);
				$polls_handler->resetCountByPollId($clean_poll_id);
				$log_handler->deleteByPollId($clean_poll_id);
				unset($options_handler, $log_handler);
			}
			icms_cp_header();
			editpoll($clean_poll_id);
			break;
		case 'addpoll':
			$sql = "SHOW TABLE STATUS WHERE name='" . icms::$xoopsDB->prefix('icmspoll_polls') . "'";
			$result = icms::$xoopsDB->queryF($sql);
			$row = icms::$xoopsDB->fetchBoth($result);
			$poll_id = $row['Auto_increment'];
			if(!empty($clean_poll_id)) {
				$poll_id = $clean_poll_id;
			}
			$pollObj = $polls_handler->get($poll_id);
			if(is_object($pollObj) && !$pollObj->isNew()) {
				$redirect_page = ICMSPOLL_ADMIN_URL . "polls.php";
			} else {
				$redirect_page = ICMSPOLL_ADMIN_URL . "options.php?op=mod&poll_id=" . $poll_id;
			}
			$controller = new icms_ipf_Controller($polls_handler);
			$controller->storeFromDefaultForm(_AM_ICMSPOLL_POLLS_CREATED, _AM_ICMSPOLL_POLLS_MODIFIED, $redirect_page);
			break;
		case 'del':
			$controller = new icms_ipf_Controller($polls_handler);
			$controller->handleObjectDeletion();
			break;
		case 'view':
			icms_cp_header();
			icms::$module->displayAdminMenu(1, _MI_ICMSPOLL_MENU_POLLS);
			$pollObj = $polls_handler->get($clean_poll_id);
			$pollObj->displaySingleObject();
			break;
		case 'changeWeight':
			foreach ($_POST['IcmspollPolls_objects'] as $key => $value) {
				$changed = FALSE;
				$pollObj = $polls_handler->get($value);

				if ($pollObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$pollObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$polls_handler -> insert($pollObj);
				}
			}
			$ret = 'polls.php';
			redirect_header( ICMSPOLL_ADMIN_URL . $ret, 2, _AM_ICMSPOLL_WEIGHT_UPDATED);
			break;
		default:
			icms_cp_header();
			icms::$module->displayAdminmenu( 1, _MI_ICMSPOLL_MENU_POLLS );
			
			$objectTable = new icms_ipf_view_Table($polls_handler, FALSE);
			$objectTable->addColumn(new icms_ipf_view_Column("expired", "center", FALSE, "displayExpired"));
			$objectTable->addColumn(new icms_ipf_view_Column("started", "center", FALSE, "displayStarted"));
			$objectTable->addColumn(new icms_ipf_view_Column("question", FALSE, FALSE, "getPreviewLink"));
			$objectTable->addColumn(new icms_ipf_view_Column("user_id", FALSE, FALSE, "getUser"));
			$objectTable->addColumn(new icms_ipf_view_Column("start_time", FALSE, FALSE, "getStartDate"));
			$objectTable->addColumn(new icms_ipf_view_Column("end_time", FALSE, FALSE, "getEndDate"));
			$objectTable->addColumn(new icms_ipf_view_Column("created_on", FALSE, FALSE, "getCreatedDate"));
			$objectTable->addColumn(new icms_ipf_view_Column("weight", FALSE, FALSE, "getWeightControl"));
			$objectTable->setDefaultOrder("DESC");
			$objectTable->setDefaultSort("created_on");
			
			$objectTable->addCustomAction( 'getResetItemLink' );
			
			$objectTable->addFilter("expired", "filterExpired");
			$objectTable->addFilter("started", "filterStarted");
			$objectTable->addFilter("user_id", "filterUsers");
			
			$objectTable->addIntroButton( 'addpoll', 'polls.php?op=mod', _AM_ICMSPOLL_POLLS_ADD );
			$objectTable->addActionButton( 'changeWeight', FALSE, _SUBMIT );
			$icmsAdminTpl->assign( 'icmspoll_polls_table', $objectTable->fetch() );
			
			$icmsAdminTpl->display( 'db:icmspoll_admin.html' );
			break;
	}
	include_once 'admin_footer.php';
} else {
	redirect_header(icms_getPreviousPage(), 5, _NOPERM);
}