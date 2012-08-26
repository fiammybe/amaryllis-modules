<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /index.php
 * 
 * module home
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

function addEvent($event_id = 0) {
	global $event_handler,$icmsTpl;
	$eventObj = $event_handler->get($event_id);
	$uname = (is_object(icms::$user)) ? icms::$user->getVar("uname") : " ";
	$mail = (is_object(icms::$user)) ? icms::$user->getVar("email") : " ";
	if($eventObj->isNew()) {
		$form = new icms_form_Theme(_MD_EVENT_ADDEVENT, "addevent", "submit.php?op=addevent", "post");
		$form->addElement(new icms_form_elements_Hidden("event_id", $event_id));
		$form->addElement(new icms_form_elements_Hidden("event_name", ""));
		$form->addElement(new icms_form_elements_Hidden("event_startdate", ""));
		$form->addElement(new icms_form_elements_Hidden("event_enddate", ""));
		$form->addElement(new icms_form_elements_Hidden("event_allday", ""));
		
		$catselect = new icms_form_elements_Select(_CO_EVENT_EVENT_EVENT_CID, "event_cid", "1");
		$catselect->addOptionArray($event_handler->getCategoryList());
		$form->addElement($catselect);
		
		$desc = new icms_form_elements_Textarea(_CO_EVENT_EVENT_EVENT_DSC, "event_dsc", "", 7, 50);
		$desc->setRequired();
		$form->addElement($desc);
		
		$form->addElement(new icms_form_elements_Text(_CO_EVENT_EVENT_EVENT_CONTACT, "event_contact", 50, 255, $uname));
		
		$form->addElement(new icms_form_elements_Text(_CO_EVENT_EVENT_EVENT_CEMAIL, "event_cemail", 50, 255, $mail));
		
		$tray = new icms_form_elements_Tray(_CO_EVENT_EVENT_EVENT_URL, "<br />", "event_url");
		$mid = new icms_form_elements_Hidden("mid_event_url", icms::$module->getVar("mid"));
		$cap = new icms_form_elements_Text(_MD_EVENT_ADDEVENT_URL_CAP, "caption_event_url", 50, 255);
		$dsc = new icms_form_elements_Text(_MD_EVENT_ADDEVENT_URL_DSC, "desc_event_url", 50, 255);
		$url = new icms_form_elements_Text(_MD_EVENT_ADDEVENT_URL_URL, "url_event_url", 50, 255);
		$tar = new icms_form_elements_Radio(_MD_EVENT_ADDEVENT_URL_TARGET, "target_event_url", "_blank");
		$tar->addOption("_blank", "_blank");
		$tar->addOption("_self", "_self");
		$tray->addElement($cap);
		$tray->addElement($dsc);
		$tray->addElement($url);
		$tray->addElement($tar);
		$tray->addElement($mid);
		$form->addElement($tray);
		
		$form->addElement(new icms_form_elements_Text(_CO_EVENT_EVENT_EVENT_PHONE, "event_phone", 50, 255));
		$form->addElement(new icms_form_elements_Text(_CO_EVENT_EVENT_EVENT_STREET, "event_street", 50, 255));
		$form->addElement(new icms_form_elements_Text(_CO_EVENT_EVENT_EVENT_ZIP, "event_zip", 10, 10));
		$form->addElement(new icms_form_elements_Text(_CO_EVENT_EVENT_EVENT_CITY, "event_city", 50, 255));
		
		$form->addElement(new icms_form_elements_Radioyn(_CO_EVENT_EVENT_EVENT_PUBLIC, "event_public", 1));
			
		if(icms_get_module_status("index")) {
			$form->addElement(new icms_form_elements_Text(_CO_EVENT_EVENT_EVENT_TAGS, "event_tags", 75, 255));
		}
		
		$form->assign($icmsTpl);
	}
}

include_once "header.php";

$xoopsOption["template_main"] = "event_index.html";

include_once ICMS_ROOT_PATH . "/header.php";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(icms_get_module_status("index")) {
	$indexpage_handler = icms_getModuleHandler( 'indexpage', INDEX_DIRNAME, 'index' );
	$indexpageObj = $indexpage_handler->getIndexByMid(icms::$module->getVar("mid"));
	if(is_object($indexpageObj)) $icmsTpl->assign('index_index', $indexpageObj->toArray());
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_view = isset($_GET['view']) ? filter_input(INPUT_GET, "view") : $eventConfig['default_view'];
$clean_cat = isset($_GET['cat']) ? filter_input(INPUT_GET, "cat") : FALSE;
$clean_date = isset($_GET['date']) ? filter_input(INPUT_GET, "date") : FALSE;
$clean_time = isset($_GET['time']) ? filter_input(INPUT_GET, "time", FILTER_SANITIZE_NUMBER_INT) : $eventConfig['agenda_start'];

$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
$calendar_handler = icms_getModuleHandler("calendar", EVENT_DIRNAME, "event");

$categories = $category_handler->getCategories("cat_view");
$icmsTpl->assign("categories", $categories);

// default view 
$icmsTpl->assign("default_view", $clean_view);
// default "firstTime"
$icmsTpl->assign("agenda_start", $clean_time);
if($clean_date) {
	$date = explode("-", $clean_date);
	$icmsTpl->assign("gotoDate", $date[0] .",". ($date[1] - 1) .",". $date[2]);
}
// checking for submit permissions for the current user and assign form
if($category_handler->userSubmit()) {
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	$icmsTpl->assign("cat_submit", TRUE);
	addEvent(0);
}
// fetch the calendars for legend and event sources
$calendars = $calendar_handler->getObjects(FALSE, TRUE, FALSE);
$icmsTpl->assign("calendars", $calendars);

include_once 'footer.php';