<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /feeds.php
 * 
 * render events
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

include_once 'header.php';
icms::$logger->disableLogger();
$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, "start") : 0;
$clean_end = isset($_GET['end']) ? filter_input(INPUT_GET, "end") : 0;
$clean_cat = isset($_GET['cat']) ? filter_input(INPUT_GET, "cat", FILTER_SANITIZE_NUMBER_INT) : FALSE;
$clean_catsel = isset($_POST['event_cats']) ? $_POST['event_cats'] : FALSE;
$cats = ($clean_catsel) ? unserialize($clean_catsel) : FALSE;
if($clean_catsel) {
	$ret = array();
	$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
	$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
	foreach ($clean_catsel as $key => $value) {
		$catObj = $category_handler->get($value['value']);
		if(!is_object($catObj) || $catObj->isNew() || !$catObj->accessGranted($uid)) continue;
		$cat = array();
		$cat['feed'] = EVENT_URL."feeds.php?cat=".$value['value']."&uid=".$uid;
		$cat['color'] = $catObj->getColor();
		$cat['txtcolor'] = $catObj->getTextColor();
		$cat['classname'] = "event_cal_".$catObj->id();
		$ret[] = $cat;
	}
	echo json_encode(array("status" => "success", "message" => $ret)); unset($_POST);exit;
}
if($clean_catsel) unset($clean_cat);
if(!$clean_cat == FALSE || $clean_catsel !== FALSE ){
	$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
	$catObj = $category_handler->get($clean_cat);
	if(is_object($catObj) && !$catObj->isNew() && $catObj->accessGranted($clean_uid)) {
		$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
		$events = $event_handler->getEvents($catObj->id(), $clean_start, $clean_end, $clean_uid);
		$feeds = array();
		foreach ($events as $event) {
			$feeds[] = array (
				'id'				=> $event['id'],
				'title'				=> $event['name'],
				'cat'				=> $event['cat'],
				'contact'			=> $event['contact'],
				'street'			=> $event['street'],
				'zip'				=> $event['zip'],
				'city'				=> $event['city'],
				'phone'				=> $event['phone'],
				'start'				=> $event['start'],
				'end'				=> $event['end'],
				'allDay'			=> $event['allDay'],
				'author'			=> $event['submitter'],
				'description'		=> $event['dsc'],
				'pubdate'			=> $event['event_created_on'],
				'editable'			=> $event['canEditAndDelete'],
				'itemURL'			=> $event['itemURL'],
				'seo'				=> $event['seo'],
				'cid'				=> $event['event_cid'],
				'contact_name'		=> $event['event_contact'],
				'contact_mail'		=> $event['event_cemail'],
				'urllink'			=> $event['urllink'],
				'url_url'			=> $event['urlpart']['url'],
				'url_dsc'			=> $event['urlpart']['dsc'],
				'url_cap'			=> $event['urlpart']['cap'],
				'url_tar'			=> $event['urlpart']['tar'],
				'url_mid'			=> $event['urlpart']['mid'],
				'event_public'		=> $event['event_public'],
				'approval'			=> $event['is_approved'],
				'can_joint'			=> $event['can_joint'],
				'event_can_joint'	=> $event['event_can_joint'],
				'event_joiners'		=> $event['event_joiner'],
				'joiner_max'		=> $event['joiner_max'],
				'has_joint'			=> $event['has_joint'],
				'joint_friends'		=> $event['friends'],
				'joiners'			=> $event['joiners']
			);
		}
		echo json_encode($feeds);exit;
	}
} elseif (!$clean_catsel && !$clean_cat) {
	echo json_encode(array("status" => "success", "message" => "nothing to return"));unset($_POST); exit;
}
exit;