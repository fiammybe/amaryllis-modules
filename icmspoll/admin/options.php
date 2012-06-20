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
function editoption($option_id = 0) {
	global $icmspoll_options_handler, $icmsAdminTpl;
	
	$optionObj = $icmspoll_options_handler->get($option_id);
	$user_id = icms::$user->getVar("uid", "e");
	
	if(!$optionObj->isNew()) {
		icms::$module->displayAdminmenu( 1, _MI_ICMSPOLL_MENU_POLLS . ' > ' . _MI_ICMSPOLL_POLLS_EDITING);
		$sform = $optionObj->getForm(_MI_ICMSPOLL_POLLS_EDITING, 'addoption');
		$sform->assign($icmsAdminTpl);
	} else {
		icms::$module->displayAdminmenu( 1, _MI_ICMSPOLL_MENU_POLLS . " > " . _MI_ICMSPOLL_POLLS_CREATINGNEW);
		$sform = $optionObj->getForm(_MI_ICMSPOLL_POLLS_CREATINGNEW, 'addoption');
		$sform->assign($icmsAdminTpl);
	}
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
$valid_op = array("mod", "changeField", "addoption", "del", "changeWeight", "");

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$clean_option_id = isset($_GET['option_id']) ? filter_input(INPUT_GET, 'option_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

$icmspoll_options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
		case 'changeField':
			icms_cp_header();
			editoption($clean_option_id);
			break;
		case 'addoption':
			$controller = new icms_ipf_Controller($icmspoll_options_handler);
			$controller->storeFromDefaultForm(_AM_ICMSPOLL_OPTIONS_OPTION_CREATED, _AM_ICMSPOLL_OPTIONS_OPTION_MODIFIED);
			break;
		case 'del':
			$controller =  new icms_ipf_Controller($icmspoll_options_handler);
			$controller->handleObjectDeletion();
			break;
		case 'changeWeight':
			foreach ($_POST['IcmspollOptions_objects'] as $key => $value) {
				$changed = FALSE;
				$optionObj = $icmspoll_option_handler->get($value);

				if ($optionObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$optionObj->setVar('weight', (int)($_POST['weight'][$key]));
					$changed = TRUE;
				}
				if ($changed) {
					$icmspoll_options_handler -> insert($optionObj);
				}
			}
			$ret = 'options.php';
			redirect_header( ICMSPOLL_ADMIN_URL . $ret, 2, _AM_ICMSPOLL_WEIGHT_UPDATED);
			break;
		default:
			
			break;
	}
}