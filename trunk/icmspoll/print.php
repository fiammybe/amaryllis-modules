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

$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
$options_handler = icms_getModuleHandler("options", ICMSPOLL_DIRNAME, "icmspoll");

$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, 'poll_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$pollObj = $polls_handler->get($clean_poll_id);

if (!$pollObj || !is_object($pollObj) || $pollObj->isNew()) {
	redirect_header(icms_getPreviousPage(), 2, _MD_ICMSPOLL_PRINT_NO_POLL);
}

if (!$pollObj->viewAccessGranted()){
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}

$icmsTpl = new icms_view_Tpl();
global $icmsConfig;


$poll = $pollObj->toArray();
$printtitle = $icmsConfig['sitename']." - ". strip_tags($pollObj->getVar('question','n' ));

$options = $options_handler->getAllByPollId($clean_poll_id);

$icmsTpl->assign('printtitle', $printtitle);
$icmsTpl->assign('printlogourl', $icmspollConfig['icmspoll_print_logo']);
$icmsTpl->assign('printfooter', $icmspollConfig['icmspoll_print_footer']);
$icmsTpl->assign('poll', $poll);
$icmsTpl->assign('options', $options);

$icmsTpl->display('db:icmspoll_print.html');