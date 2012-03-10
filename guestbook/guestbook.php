<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /guestbook.php
 * 
 * view, add, moderate guestbook entries
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

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';
$xoopsOption["template_main"] = "guestbook_guestbook.html";
include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$guestbook_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'guestbook' );

$indexpageObj = $guestbook_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('guestbook_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start') : 0;
$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(__FILE__)), "guestbook");
$clean_guestbook_id = isset($_GET['guestbook_id']) ? filter_input(INPUT_GET, 'guestbook_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$entries = $guestbook_guestbook_handler -> getEntries(TRUE ,$clean_guestbook_id, $clean_start, $guestbookConfig["show_entries"], 'guestbook_published_date', 'DESC');
$icmsTpl->assign("entries", $entries);
if($guestbookConfig['use_moderation'] == 1) {
	$icmsTpl->assign("reply_link", TRUE);
}
if($guestbookConfig["guest_entry"] == 1) {
	$icmsTpl->assign("link_class", TRUE);
	$icmsTpl->assign("submit_link", GUESTBOOK_URL . "submit.php?op=addentry");
} else {
	if(is_object(icms::$user)) {
		$icmsTpl->assign("link_class", TRUE);
		$icmsTpl->assign("submit_link", GUESTBOOK_URL . "submit.php?op=addentry");
	} else {
		$icmsTpl->assign("link_class", FALSE);
		$icmsTpl->assign("submit_link", ICMS_URL . "/user.php");
	}
}
editmessage($clean_guestbook_id);
$icmsTpl->assign("guestbook_module_home", '<a href="' . ICMS_URL . '/modules/' . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . '</a>');
$icmsTpl->assign("guestbook_adminpage", '<a href="' . GUESTBOOK_ADMIN_URL . 'guestbook.php">' . _MD_GUESTBOOK_ADMIN_PAGE . '</a>');
$icmsTpl->assign("guestbook_is_admin", icms_userIsAdmin(GUESTBOOK_DIRNAME));
$icmsTpl->assign('guestbook_url', GUESTBOOK_URL);
$icmsTpl->assign('guestbook_images_url', GUESTBOOK_IMAGES_URL);
$xoTheme->addScript('/modules/' . GUESTBOOK_DIRNAME . '/scripts/guestbook.js', array('type' => 'text/javascript'));
$xoTheme->addScript('/modules/' . GUESTBOOK_DIRNAME . '/scripts/jquery.curvycorners.packed.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';