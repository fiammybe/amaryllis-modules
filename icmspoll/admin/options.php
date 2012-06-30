<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/options.php
 * 
 * Add, edit and delete options objects
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
 * Edit/Create an Option
 *
 * @param int $option_id Optionid to be edited
*/
function editoption($option_id = 0, $poll_id = 0) {
	global $options_handler, $icmsAdminTpl;
	
	$optionObj = $options_handler->get($option_id);
	$user_id = icms::$user->getVar("uid", "e");
	
	if(!$optionObj->isNew()) {
		icms::$module->displayAdminmenu( 2, _MI_ICMSPOLL_MENU_OPTIONS . ' > ' . _MI_ICMSPOLL_MENU_OPTIONS_EDITING);
		$sform = $optionObj->getForm(_MI_ICMSPOLL_MENU_OPTIONS_EDITING, 'addoptions', "options.php?op=addoptions&poll_id=" . $poll_id, _CO_ICMS_SUBMIT, "location.href='options.php'");
		$sform->assign($icmsAdminTpl);
	} else {
		icms::$module->displayAdminmenu( 2, _MI_ICMSPOLL_MENU_OPTIONS . " > " . _MI_ICMSPOLL_MENU_OPTIONS_CREATINGNEW);
		$optionObj->setVar("poll_id", $poll_id);
		$optionObj->setVar("user_id", $user_id);
		$sform = $optionObj->getForm(_MI_ICMSPOLL_MENU_OPTIONS_CREATINGNEW, 'addoptions', "options.php?op=addoptions&poll_id=" . $poll_id, _CO_ICMS_SUBMIT, "location.href='options.php'");
		$sform->addCustomButton("last_submit", _CO_ICMSPOLL_OPTIONS_SUBMIT_NEXT);
		$sform->assign($icmsAdminTpl);
	}
	$icmsAdminTpl->display('db:icmspoll_admin.html');
}

include_once 'admin_header.php';
/**
 * check first, if at least one poll is created
 */
$icmspoll_poll_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
$count = $icmspoll_poll_handler->getCount();
if(!$count > 0) redirect_header(ICMSPOLL_ADMIN_URL . "polls.php", 4, _AM_ICMSPOLL_OPTIONS_NOPOLLS);
unset($icmspoll_poll_handler, $count);
/**
 * Create a whitelist of valid values
 */
$valid_op = array("mod", "changeField", "addoptions", "addoption", "del", "changeFields", "");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$clean_option_id = isset($_GET['option_id']) ? filter_input(INPUT_GET, 'option_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;
$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, 'poll_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changeField':
			icms_cp_header();
			editoption($clean_option_id, $clean_poll_id);
			break;
		case 'addoption':
		case 'addoptions':
			$optionObj = $options_handler->get($clean_option_id);
			if(is_object($optionObj) && !$optionObj->isNew() || $clean_op == 'addoption') {
				$redirect_page = ICMSPOLL_ADMIN_URL . "options.php";
			} else {
				$redirect_page = ICMSPOLL_ADMIN_URL . "options.php?op=mod&poll_id=" . $clean_poll_id;
			}
			$controller = new icms_ipf_Controller($options_handler);
			$controller->storeFromDefaultForm(_AM_ICMSPOLL_OPTIONS_OPTION_CREATED, _AM_ICMSPOLL_OPTIONS_OPTION_MODIFIED, $redirect_page);
			break;
		case 'del':
			$controller =  new icms_ipf_Controller($options_handler);
			$controller->handleObjectDeletion();
			break;
		case 'changeFields':
			foreach ($_POST['IcmspollOptions_objects'] as $key => $value) {
				$changed = FALSE;
				$optionsObj = $options_handler->get($value);
				if($optionsObj->getVar('option_text', 'e') != $_POST['option_text'][$key]) {
					$optionsObj->setVar('option_text', $_POST['option_text'][$key]);
					$changed = TRUE;
				}
				if($optionsObj->getVar('option_color', 'e') != $_POST['option_color'][$key]) {
					$optionsObj->setVar('option_color', $_POST['option_color'][$key]);
					$changed = TRUE;
				}
				if($optionsObj->getVar('poll_id', 'e') != $_POST['poll_id'][$key]) {
					$optionsObj->setVar('poll_id', $_POST['poll_id'][$key]);
					$changed = TRUE;
				}
				if($optionsObj->getVar('option_init', 'e') != $_POST['option_init'][$key]) {
					$optionsObj->setVar('option_init', (int)($_POST['option_init'][$key]));
					$changed = TRUE;
				}
				if($optionsObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$optionsObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if($changed) $options_handler->insert($optionsObj);
			}
			$ret = 'options.php';
			redirect_header( ICMSPOLL_ADMIN_URL . $ret, 4, _AM_ICMSPOLL_OPTIONS_FIELDS_UPDATED);
			break;
		default:
			icms_cp_header();
			icms::$module->displayAdminmenu(2, _MI_ICMSPOLL_MENU_OPTIONS);
			
			$objectTable = new icms_ipf_view_Table($options_handler, NULL);
			$objectTable->addColumn(new icms_ipf_view_Column("poll_id", FALSE, FALSE, "getPollIdControl"));
			$objectTable->addColumn(new icms_ipf_view_Column("option_text", FALSE, FALSE, "getOptionTextControl"));
			$objectTable->addColumn(new icms_ipf_view_Column("option_color", FALSE, FALSE, "getOptionColorControl"));
			if($icmpollConfig['allow_init_value'] == 1) {
				$objectTable->addColumn(new icms_ipf_view_Column("option_init", FALSE, 75, "getOptionInitControl"));
			}
			$objectTable->addColumn(new icms_ipf_view_Column("weight", "center", 50, "getWeightControl"));
			
			$objectTable->addFilter("poll_id", "filterPolls");
			
			$objectTable->addIntroButton('addoptions', 'options.php?op=mod', _AM_ICMSPOLL_OPTIONS_ADD);
			$objectTable->addActionButton('changeFields', FALSE, _SUBMIT);
			
			$icmsAdminTpl->assign('icmspoll_options_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:icmspoll_admin.html');
			break;
	}
	include_once 'admin_footer.php';
}