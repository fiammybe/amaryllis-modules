<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /submit.php
 * 
 * submit entries
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

function editmessage($clean_visitorvoice_id = 0, $visitorvoice_pid = FALSE) {
	global $icmsConfig, $visitorvoice_visitorvoice_handler, $icmsTpl, $visitorvoiceConfig;
	$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", basename(dirname(dirname(__FILE__))), "visitorvoice");
	$visitorvoiceObj = $visitorvoice_visitorvoice_handler->get($clean_visitorvoice_id);
	if(is_object(icms::$user)){
		$visitorvoice_uid = icms::$user->getVar("uid");
	} else {
		$visitorvoice_uid = 0;
	}
	if ($visitorvoiceObj->isNew()) {
		$visitorvoiceObj->setVar("visitorvoice_uid", $visitorvoice_uid);
		$visitorvoiceObj->setVar("visitorvoice_published_date", time() - 200);
		$visitorvoiceObj->setVar("visitorvoice_ip", xoops_getenv('REMOTE_ADDR'));
		if($visitorvoiceConfig["needs_approval"] == 1) {
			if(icms_userIsAdmin(VISITORVOICE_DIRNAME)){
				$visitorvoiceObj->setVar("visitorvoice_approve", TRUE);
			} else {
				$visitorvoiceObj->setVar("visitorvoice_approve", FALSE);
			}
		} else {
			$visitorvoiceObj->setVar("visitorvoice_approve", TRUE);
		}
		if($visitorvoice_pid) {
			$visitorvoiceObj->setVar("visitorvoice_pid", $visitorvoice_pid);
		}
		$sform = $visitorvoiceObj->getSecureForm(_MD_VISITORVOICE_CREATE, 'addentry', 'submit.php?op=addentry&visitorvoice_id=' . $clean_visitorvoice_id, FALSE, TRUE);
		//$sform->addElement();
		if($visitorvoice_pid) {
			$sform->assign($icmsTpl, 'visitorvoice_reply_form');
		} else {
			$sform->assign($icmsTpl, 'visitorvoice_form');
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
			global $visitorvoiceConfig;
			$visitorvoice_pid = isset($_POST['visitorvoice_pid']) ? filter_input(INPUT_POST, 'visitorvoice_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$visitorvoice_id = isset($_GET['visitorvoice_id']) ? filter_input(INPUT_GET, 'visitorvoice_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", basename(dirname(__FILE__)), "visitorvoice");
			$visitorvoiceObj = $visitorvoice_visitorvoice_handler->get($visitorvoice_id);
			if($visitorvoiceObj->isNew() ) {
				if (!icms::$security->check()) {
					redirect_header(VISITORVOICE_URL, 3, _MD_VISITORVOICE_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
				$visitorvoiceObj->setVar("visitorvoice_pid", $visitorvoice_pid);
				$controller = new icms_ipf_Controller($visitorvoice_visitorvoice_handler);
				$controller->storeFromDefaultForm(_MD_VISITORVOICE_CREATED, _MD_VISITORVOICE_MODIFIED, VISITORVOICE_URL);
				return redirect_header(VISITORVOICE_URL, 3, _THANKS_SUBMISSION);
			} else {
				redirect_header(VISITORVOICE_URL, 3, _NO_PERM);
			}
			break;
		
		case 'addreply':
			$xoopsOption["template_main"] = "visitorvoice_visitorvoice.html";
			include_once ICMS_ROOT_PATH . '/header.php';
			$visitorvoice_id = isset($_GET['visitorvoice_id']) ? filter_input(INPUT_GET, 'visitorvoice_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$visitorvoice_pid = isset($_GET['visitorvoice_pid']) ? filter_input(INPUT_GET, 'visitorvoice_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", basename(dirname(__FILE__)), "visitorvoice");
			editmessage($clean_visitorvoice_id, $visitorvoice_pid);
			include_once ICMS_ROOT_PATH . '/footer.php';
			break;
	}
} else {
	redirect_header(VISITORVOICE_URL, 3, _NO_PERM);
}