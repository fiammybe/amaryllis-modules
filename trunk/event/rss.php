<?php
/**
 * 'Article' is an event management module for ImpressCMS
 *
 * File: /rss.php
 * 
 * hold the configuration information about the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

include_once 'header.php';

include_once ICMS_ROOT_PATH . '/header.php';
include_once dirname(__FILE__) . '/include/common.php';

$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
$eventModule = icms_getModuleInfo(EVENT_DIRNAME);
$event_feed = new icms_feeds_Rss();
$event_feed->title = $icmsConfig['sitename'] . ' - ' . $eventModule->getVar("name");
$event_feed->url = ICMS_URL;
$event_feed->description = $icmsConfig['slogan'];
$event_feed->language = _LANGCODE;
$event_feed->charset = _CHARSET;
$event_feed->category = $eventModule->getVar("name");

$category_handler = icms_getModuleHandler("category", EVENT_DIRNAME, "event");
$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
$cat_ids = $category_handler->userView();
$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
$events = $event_handler->getEvents($cat_ids, 0, 0, $uid, "event_created_on", "DESC");

foreach($events as $event) {
	$event_feed->feeds[] = array (
	  'title' => $event['name'],
	  'link' => str_replace('&', '&amp;', $event['itemURL']),
	  'author' => icms_member_user_Handler::getUserLink($event['event_submitter']),
	  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $event['dsc'])),
	  'pubdate' => $event['event_created_on'],
	  'guid' => str_replace('&', '&amp;', $event['itemURL']),
	  'category' => $event['cat'],
	);
}
$event_feed->render();