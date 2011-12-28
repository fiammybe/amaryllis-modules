<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /submit.php
 * 
 * submit entries
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

function editmessage($clean_guestbook_id = 0, $guestbook_pid = FALSE) {
	global $icmsConfig, $guestbook_guestbook_handler, $icmsTpl, $guestbookConfig;
	$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(dirname(__FILE__))), "guestbook");
	$guestbookObj = $guestbook_guestbook_handler->get($clean_guestbook_id);
	if(is_object(icms::$user)){
		$guestbook_uid = icms::$user->getVar("uid");
	} else {
		$guestbook_uid = 0;
	}
	if ($guestbookObj->isNew()) {
		$guestbookObj->setVar("guestbook_uid", $guestbook_uid);
		$guestbookObj->setVar("guestbook_published_date", time() - 200);
		$guestbookObj->setVar("guestbook_ip", xoops_getenv('REMOTE_ADDR'));
		if($guestbookConfig["needs_approval"] == 1) {
			if(icms_userIsAdmin(GUESTBOOK_DIRNAME)){
				$guestbookObj->setVar("guestbook_approve", TRUE);
			} else {
				$guestbookObj->setVar("guestbook_approve", FALSE);
			}
		} else {
			$guestbookObj->setVar("guestbook_approve", TRUE);
		}
		if($guestbook_pid) {
			$guestbookObj->setVar("guestbook_pid", $guestbook_pid);
		}
		$sform = $guestbookObj->getSecureForm(_MD_GUESTBOOK_CREATE, 'addentry', 'submit.php?op=addentry&guestbook_id=' . $clean_guestbook_id, FALSE, TRUE);
		//$sform->addElement();
		if($guestbook_pid) {
			$sform->assign($icmsTpl, 'guestbook_reply_form');
		} else {
			$sform->assign($icmsTpl, 'guestbook_form');
		}
	} else {
		exit;
	}
}

$moddir = basename(dirname(__FILE__));
include_once "../../mainfile.php";
include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';

$valid_op = array ('addentry', 'addreply', );
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');
if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addentry':
			global $guestbookConfig;
			$guestbook_pid = isset($_POST['guestbook_pid']) ? filter_input(INPUT_POST, 'guestbook_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$guestbook_id = isset($_GET['guestbook_id']) ? filter_input(INPUT_GET, 'guestbook_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(__FILE__)), "guestbook");
			$guestbookObj = $guestbook_guestbook_handler->get($guestbook_id);
			if($guestbookObj->isNew() ) {
				if (!icms::$security->check()) {
					redirect_header(GUESTBOOK_URL, 3, _MD_GUESTBOOK_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
				$guestbookObj->setVar("guestbook_pid", $guestbook_pid);
				$controller = new icms_ipf_Controller($guestbook_guestbook_handler);
				$controller->storeFromDefaultForm(_MD_GUESTBOOK_CREATED, _MD_GUESTBOOK_MODIFIED, GUESTBOOK_URL);
				return redirect_header(GUESTBOOK_URL, 3, _THANKS_SUBMISSION);
			} else {
				redirect_header(GUESTBOOK_URL, 3, _NO_PERM);
			}
			break;
		
		case 'addreply':
			$xoopsOption["template_main"] = "guestbook_guestbook.html";
			include_once ICMS_ROOT_PATH . '/header.php';
			$guestbook_id = isset($_GET['guestbook_id']) ? filter_input(INPUT_GET, 'guestbook_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$guestbook_pid = isset($_GET['guestbook_pid']) ? filter_input(INPUT_GET, 'guestbook_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(__FILE__)), "guestbook");
			editmessage($clean_guestbook_id, $guestbook_pid);
			include_once ICMS_ROOT_PATH . '/footer.php';
			break;
	}
} else {
	redirect_header(GUESTBOOK_URL, 3, _NO_PERM);
}