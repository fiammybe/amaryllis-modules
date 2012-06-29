<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /index.php
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

include_once ICMS_ROOT_PATH . '/header.php';

$valid_op = array('vote', 'voteblock' );

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'vote':
			$clean_poll_id = isset($_GET['poll_id']) ? filter_input(INPUT_GET, "poll_id", FILTER_SANITIZE_NUMBER_INT) : 0;
			$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
			$clean_uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
			$pollObj = $polls_handler->get($clean_poll_id);
			if(is_object($pollObj) && !$pollObj->isNew() && $pollObj->viewAccessGranted() && $pollObj->voteAccessGranted()) {
				$vote = $pollObj->vote($_POST['poll_option'], xoops_getenv('REMOTE_ADDR'), $clean_uid);
				if($vote) redirect_header(icms_getPreviousPage(), 4, _MD_ICMSPOLL_POLLS_THANKS_VOTING);
				redirect_header(icms_getPreviousPage(), 4, _MD_ICMSPOLL_POLLS_NOTVOTED);
			} else {
				redirect_header(icms_getPreviousPage(), 4, _NOPERM);
			}
			break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 4, _NOPERM);
}
