<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /visitorvoice.php
 *
 * view, add, moderate visitorvoice entries
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';
$xoopsOption["template_main"] = "visitorvoice_visitorvoice.html";
include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$visitorvoice_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'visitorvoice' );
$indexpageObj = $visitorvoice_indexpage_handler->get(1);
$icmsTpl->assign('visitorvoice_index', $indexpageObj->toArray());

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_limit = isset($_GET['end']) ? filter_input(INPUT_GET, 'end', FILTER_SANITIZE_NUMBER_INT) : $visitorvoiceConfig['show_entries'];
$visitorvoice_handler = icms_getModuleHandler("visitorvoice", basename(dirname(__FILE__)), "visitorvoice");
$clean_visitorvoice_id = isset($_GET['visitorvoice_id']) ? filter_input(INPUT_GET, 'visitorvoice_id', FILTER_SANITIZE_NUMBER_INT) : 0;

$name = (is_object(icms::$user)) ? icms::$user->getVar("uname") : "";
$email = (is_object(icms::$user)) ? icms::$user->getVar("email") : "";
$url = (is_object(icms::$user)) ? icms::$user->getVar("url") : "http://";
$form = new icms_form_Theme("", "addentry", VISITORVOICE_URL."submit.php");
$form->setExtra('name="addentry"');
if($visitorvoiceConfig['allow_imageupload']) $form->setExtra('enctype="multipart/form-data"');
$form->addElement(new icms_form_elements_Text(_CO_VISITORVOICE_VISITORVOICE_VISITORVOICE_TITLE, "visitorvoice_title", 75, 255), TRUE);
$form->addElement(new icms_form_elements_Text(_CO_VISITORVOICE_VISITORVOICE_VISITORVOICE_NAME, "visitorvoice_name", 75, 255, $name, TRUE), TRUE);
$form->addElement(new icms_form_elements_Text(_CO_VISITORVOICE_VISITORVOICE_VISITORVOICE_EMAIL, "visitorvoice_email", 75, 255, $email, TRUE), TRUE);
$form->addElement(new icms_form_elements_Text(_CO_VISITORVOICE_VISITORVOICE_VISITORVOICE_URL, "visitorvoice_url", 75, 255, $url));
$form->addElement(new icms_form_elements_Textarea(_CO_VISITORVOICE_VISITORVOICE_VISITORVOICE_ENTRY, "visitorvoice_entry", "", 5, 50), TRUE);
if($visitorvoice_handler->canUpload())
$form->addElement(new icms_form_elements_File(_CO_VISITORVOICE_VISITORVOICE_VISITORVOICE_IMAGE, "visitorvoice_image", $visitorvoiceConfig['image_file_size']));
$form->addElement(new icms_form_elements_Hidden("visitorvoice_pid", 0));
//$form->addElement(new icms_form_elements_Captcha());
$form->addElement(new icms_form_elements_Hidden("op", "addentry"));

if($visitorvoiceConfig["guest_entry"] == 1) {
	$form->assign($icmsTpl);
	$icmsTpl->assign("link_class", TRUE);
	$icmsTpl->assign("submit_link", VISITORVOICE_URL . "submit.php");
} else {
	if(is_object(icms::$user)) {
		$form->assign($icmsTpl);
		$icmsTpl->assign("link_class", TRUE);
		$icmsTpl->assign("submit_link", VISITORVOICE_URL . "submit.php");
	} else {
		$icmsTpl->assign("link_class", FALSE);
		$icmsTpl->assign("submit_link", ICMS_URL . "/user.php");
	}
}

/**
 * pagination
 */
$criteria = $visitorvoice_handler->getEntryCriterias(TRUE, 0, $clean_start, $clean_limit, 'visitorvoice_published_date', 'DESC');
$count = $visitorvoice_handler->getCount($criteria);
$pagenav = new icms_view_PageNav($count, $visitorvoiceConfig['show_entries'], $clean_start, 'start', FALSE);
$icmsTpl->assign('pagenav', $pagenav->renderNav());
/**
 * breadcrumb
 */
if($visitorvoiceConfig['show_breadcrumbs']) {
	$icmsTpl->assign("visitorvoice_show_breadcrumb", TRUE);
}
/**
 * rss feeds
 */
if($visitorvoiceConfig['use_rss']) {
	$icmsTpl->assign("visitorvoice_show_rss", TRUE);
}
$icmsTpl->assign("visitorvoice_module_home", '<a href="' . ICMS_URL . '/modules/' . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . '</a>');
$icmsTpl->assign("visitorvoice_adminpage", '<a href="' . VISITORVOICE_ADMIN_URL . 'visitorvoice.php">' . _MD_VISITORVOICE_ADMIN_PAGE . '</a>');
$icmsTpl->assign("visitorvoice_is_admin", icms_userIsAdmin(VISITORVOICE_DIRNAME));
$icmsTpl->assign('visitorvoice_url', VISITORVOICE_URL);
$icmsTpl->assign('visitorvoice_images_url', VISITORVOICE_IMAGES_URL);
$icmsTpl->assign('show_entries', $visitorvoiceConfig['show_entries']);
$xoTheme->addScript('/modules/' . VISITORVOICE_DIRNAME . '/scripts/visitorvoice.js', array('type' => 'text/javascript'));
$xoTheme->addScript('/modules/' . VISITORVOICE_DIRNAME . '/scripts/jquery.curvycorners.packed.js', array('type' => 'text/javascript'));

include_once ICMS_ROOT_PATH . '/footer.php';