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

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';
$xoopsOption["template_main"] = "guestbook_guestbook.html";
include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$guestbook_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'guestbook' );
$indexpageObj = $guestbook_indexpage_handler->get(1);
$icmsTpl->assign('guestbook_index', $indexpageObj->toArray());

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start') : 0;
$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(__FILE__)), "guestbook");
$clean_guestbook_id = isset($_GET['guestbook_id']) ? filter_input(INPUT_GET, 'guestbook_id', FILTER_SANITIZE_NUMBER_INT) : 0;
//$entries = $guestbook_guestbook_handler->getEntries(TRUE ,$clean_guestbook_id, $clean_start, $guestbookConfig["show_entries"], 'guestbook_published_date', 'DESC');
$icmsTpl->assign("entries", TRUE);

$name = (is_object(icms::$user)) ? icms::$user->getVar("name") : "";
$email = (is_object(icms::$user)) ? icms::$user->getVar("email") : "";

$form = new icms_form_Theme("", "addentry", "submit.php");
$form->setExtra('enctype="multipart/form-data"');
$form->addElement(new icms_form_elements_Text(_CO_GUESTBOOK_GUESTBOOK_GUESTBOOK_TITLE, "guestbook_title", 75, 255));
$form->addElement(new icms_form_elements_Text(_CO_GUESTBOOK_GUESTBOOK_GUESTBOOK_NAME, "guestbook_name", 75, 255, $name, TRUE));
$form->addElement(new icms_form_elements_Text(_CO_GUESTBOOK_GUESTBOOK_GUESTBOOK_EMAIL, "guestbook_email", 75, 255, $email, TRUE));
$form->addElement(new icms_form_elements_Text(_CO_GUESTBOOK_GUESTBOOK_GUESTBOOK_URL, "guestbook_url", 75, 255));
$form->addElement(new icms_form_elements_Textarea(_CO_GUESTBOOK_GUESTBOOK_GUESTBOOK_ENTRY, "guestbook_entry", "", 5, 50));
if($guestbookConfig['allow_imageupload'])
$form->addElement(new icms_form_elements_File(_CO_GUESTBOOK_GUESTBOOK_GUESTBOOK_IMAGE, "guestbook_image", $guestbookConfig['image_file_size']));
$form->addElement(new icms_form_elements_Hidden("guestbook_pid", 0));
$form->addElement(new icms_form_elements_Captcha());
$form->addElement(new icms_form_elements_Hidden("op", "addentry"));

if($guestbookConfig["guest_entry"] == 1) {
	$form->assign($icmsTpl);
	$icmsTpl->assign("link_class", TRUE);
	$icmsTpl->assign("submit_link", GUESTBOOK_URL . "submit.php");
} else {
	if(is_object(icms::$user)) {
		$form->assign($icmsTpl);
		$icmsTpl->assign("link_class", TRUE);
		$icmsTpl->assign("submit_link", GUESTBOOK_URL . "submit.php");
	} else {
		$icmsTpl->assign("link_class", FALSE);
		$icmsTpl->assign("submit_link", ICMS_URL . "/user.php");
	}
}

/**
 * pagination
 */
$criteria = new icms_db_criteria_Item("guestbook_approve", TRUE);
$count = $guestbook_guestbook_handler->getCount($criteria);
$pagenav = new icms_view_PageNav($count, $guestbookConfig['show_entries'], $clean_start, 'start', FALSE);
$icmsTpl->assign('pagenav', $pagenav->renderNav());
/**
 * breadcrumb
 */
if($guestbookConfig['show_breadcrumbs']) {
	$icmsTpl->assign("guestbook_show_breadcrumb", TRUE);
}
/**
 * rss feeds
 */
if($guestbookConfig['use_rss']) {
	$icmsTpl->assign("guestbook_show_rss", TRUE);
}
$icmsTpl->assign("guestbook_module_home", '<a href="' . ICMS_URL . '/modules/' . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . '</a>');
$icmsTpl->assign("guestbook_adminpage", '<a href="' . GUESTBOOK_ADMIN_URL . 'guestbook.php">' . _MD_GUESTBOOK_ADMIN_PAGE . '</a>');
$icmsTpl->assign("guestbook_is_admin", icms_userIsAdmin(GUESTBOOK_DIRNAME));
$icmsTpl->assign('guestbook_url', GUESTBOOK_URL);
$icmsTpl->assign('guestbook_images_url', GUESTBOOK_IMAGES_URL);
$xoTheme->addScript('/modules/' . GUESTBOOK_DIRNAME . '/scripts/guestbook.js', array('type' => 'text/javascript'));
$xoTheme->addScript('/modules/' . GUESTBOOK_DIRNAME . '/scripts/jquery.curvycorners.packed.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';