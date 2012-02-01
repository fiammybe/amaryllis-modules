<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /visitorvoice.php
 * 
 * view, add, moderate visitorvoice entries
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
 
function editmessage($clean_visitorvoice_id = 0) {
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
		$sform = $visitorvoiceObj->getSecureForm(_MD_VISITORVOICE_CREATE, 'addentry', 'submit.php?op=addentry&visitorvoice_id=' . $clean_visitorvoice_id, FALSE, TRUE);
		//$sform->addElement();
		$sform->assign($icmsTpl, 'visitorvoice_form');
	} else {
		exit;
	}
}

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';
$xoopsOption["template_main"] = "visitorvoice_visitorvoice.html";
include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$visitorvoice_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'visitorvoice' );

$indexpageObj = $visitorvoice_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('visitorvoice_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start') : 0;
$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", basename(dirname(__FILE__)), "visitorvoice");
$clean_visitorvoice_id = isset($_GET['visitorvoice_id']) ? filter_input(INPUT_GET, 'visitorvoice_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$entries = $visitorvoice_visitorvoice_handler -> getEntries(TRUE ,$clean_visitorvoice_id, $clean_start, $visitorvoiceConfig["show_entries"], 'visitorvoice_published_date', 'DESC');
$icmsTpl->assign("entries", $entries);
if($visitorvoiceConfig['use_moderation'] == 1) {
		$icmsTpl->assign("reply_link", TRUE);
}
if($visitorvoiceConfig["show_avatar"] == 1) {
	$icmsTpl->assign("show_avatar", TRUE);
}
if($guestbookConfig["guest_entry"] == 1) {
	$icmsTpl->assign("link_class", TRUE);
	$icmsTpl->assign("submit_link", VISITORVOICE_URL . "submit.php?op=addentry");
} else {
	if(is_object(icms::$user)) {
		$icmsTpl->assign("link_class", TRUE);
		$icmsTpl->assign("submit_link", VISITORVOICE_URL . "submit.php?op=addentry");
	} else {
		$icmsTpl->assign("link_class", FALSE);
		$icmsTpl->assign("submit_link", ICMS_URL . "/user.php");
	}
}
editmessage();
$icmsTpl->assign("visitorvoice_module_home", '<a href="' . ICMS_URL . '/modules/' . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . '</a>');
$icmsTpl->assign("visitorvoice_adminpage", '<a href="' . VISITORVOICE_ADMIN_URL . 'visitorvoice.php">' . _MD_VISITORVOICE_ADMIN_PAGE . '</a>');
$icmsTpl->assign("visitorvoice_is_admin", icms_userIsAdmin(VISITORVOICE_DIRNAME));
$icmsTpl->assign('visitorvoice_url', VISITORVOICE_URL);
$icmsTpl->assign('visitorvoice_images_url', VISITORVOICE_IMAGES_URL);
$xoTheme->addScript('/modules/' . VISITORVOICE_DIRNAME . '/scripts/visitorvoice.js', array('type' => 'text/javascript'));
$xoTheme->addScript('/modules/' . VISITORVOICE_DIRNAME . '/scripts/jquery.curvycorners.packed.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';