<?php
/**
 * Generating an RSS feed
 *
 * @copyright	
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		event
 * @version		$Id$
 */


//include_once 'header.php';

//include_once ICMS_ROOT_PATH . '/header.php';
include_once dirname(__FILE__) . '/include/common.php';
//if($eventConfig['use_rss'] == 1) {
	
	$clean_post_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
	$clean_date = isset($_GET['date']) ? filter_input(INPUT_GET, "date") : FALSE;
	$clean_start = isset($_GET['startDate']) ? filter_input(INPUT_GET, "startDate") : FALSE;
	$clean_start = isset($_GET['endDate']) ? filter_input(INPUT_GET, "endDate") : FALSE;
	
	$eventModule = icms_getModuleInfo(EVENT_DIRNAME);
	$event_feed = new icms_feeds_Rss();
	$event_feed->title = $icmsConfig['sitename'] . ' - ' . $eventModule->getVar("name");
	$event_feed->url = ICMS_URL;
	$event_feed->description = $icmsConfig['slogan'];
	$event_feed->language = _LANGCODE;
	$event_feed->charset = _CHARSET;
	$event_feed->category = $eventModule->getVar("name");
	
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	$postsArray = $event_handler->getEvents();
	
	foreach($postsArray as $postArray) {
		$event_feed->feeds[] = array (
		  'title' => $postArray['name'],
		  'link' => str_replace('&', '&amp;', $postArray['itemURL']),
		  'author' => $postArray['submitter'],
		  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['dsc']), ENT_QUOTES, _CHARSET),
		  'pubdate' => $postArray['event_created_on'],
		  'guid' => str_replace('&', '&amp;', $postArray['itemURL']),
		  'category' => $postArray['cat'],
		);
	}
	$event_feed->render();
//}