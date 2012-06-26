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
 * @version		$Id: options.php 608 2012-06-26 19:35:55Z St.Flohrer@gmail.com $
 * @package		icmspoll
 *
 */

function editoption($optionObj = 0, $poll_id = 0) {
	global $polls_handler, $options_handler, $icmsTpl;
	$user_id = is_object(icms::$user) ? icms::$user->getVar("uid", "e") : 0;
	$pollObj = $polls_handler->get($poll_id);
	if(!$optionObj->isNew()) {
		if(!$pollObj->userCanEditAndDelete()) redirect_header(ICMSPOLL_URL, 3, _NOPERM);
		$sform = $optionObj->getForm(_MD_ICMSPOLL_OPTION_EDIT, 'addoption');
		$sform->assign($icmsTpl, 'icmspoll_options_form');
		$icmsTpl->assign('icmspoll_cat_path', _MD_ICMSPOLL_OPTION_EDIT . $optionObj->getOptionText());
	} else {
		if(!$polls_handler->userCanSubmit()) redirect_header(ICMSPOLL_URL, 3, _NOPERM);
		$optionObj->setVar("poll_id", $poll_id);
		$sform = $optionObj->getForm(_MD_ICMSPOLL_OPTION_CREATE, 'addoption');
		$sform->assign($icmsTpl, 'icmspoll_options_form');
		$icmsTpl->assign('icmspoll_cat_path', _MD_ICMSPOLL_OPTION_CREATE);
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

$valid_op = array('mod', 'changeField', 'addoption', 'del', 'changeFields', '');
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, "poll_id", FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_option_id = isset($_GET['option_id']) ? filter_input(INPUT_GET, "option_id", FILTER_SANITIZE_NUMBER_INT) : 0;
$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changeField':
			$optionObj = $options_handler->get($clean_option_id);
			if ($clean_option_id > 0 && $optionObj->isNew()) {
				redirect_header(ICMSPOLL_URL, 3, _NOPERM);
			}
			editoption($optionObj, $clean_poll_id);
			break;
		case 'addoption':
			$redirect_page = ICMSPOLL_URL . "options.php?op=mod&poll_id=" . $_POST['poll_id'];
			$controller = new icms_ipf_Controller($options_handler);
			$controller->storeFromDefaultForm(_MD_ICMSPOLL_OPTION_CREATED, _MD_ICMSPOLL_OPTION_MODIFIED, $redirect_page);
			break;
		case 'del':
			$pollObj = $polls_handler->get($clean_poll_id);
			if (!$pollObj->userCanEditAndDelete()) {
				redirect_header($pollObj->getItemLink(TRUE), 3, _NOPERM);
			}
			$icmsTpl->assign('icmspoll_cat_path', _MD_ICMSPOLL_OPTIONS_DELETE . " " . $pollObj->getQuestion());
			
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_ICMSPOLL_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($options_handler);
			$controller->handleObjectDeletionFromUserSide();
			$icmsTpl->assign('icmspoll_cat_path', $pollObj->getQuestion() . " > " . _DELETE);
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
					if($optionsObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
						$optionsObj->setVar('weight', (int)($_POST['weight'][$key]));
						$changed = TRUE;
					}
					if($changed) $options_handler->insert($optionsObj);
				}
				$ret = 'options.php';
				redirect_header( ICMSPOLL_URL . $ret, 4, _MD_ICMSPOLL_OPTIONS_FIELDS_UPDATED);
				break;
		default:
			if(!$icmspoll_isAdmin) redirect_header(ICMSPOLL_URL, 3, _NOPERM);
			
			$objectTable = new icms_ipf_view_Table($options_handler, NULL, array("edit", "delete"), TRUE);
			$objectTable->addColumn(new icms_ipf_view_Column("poll_id", FALSE, FALSE, "getPollIdControl"));
			$objectTable->addColumn(new icms_ipf_view_Column("option_text", FALSE, FALSE, "getOptionTextControl"));
			$objectTable->addColumn(new icms_ipf_view_Column("option_color", FALSE, FALSE, "getOptionColorControl"));
			$objectTable->addColumn(new icms_ipf_view_Column("weight", "center", 50, "getWeightControl"));
			
			$objectTable->addFilter("poll_id", "filterPolls");
			
			$objectTable->addIntroButton('addoptions', 'options.php?op=mod', _MD_ICMSPOLL_OPTIONS_ADD);
			$objectTable->addActionButton('changeFields', FALSE, _SUBMIT);
			
			$icmsTpl->assign('icmspoll_options_table', $objectTable->fetch());
			break;
	}
	include_once 'footer.php';
}