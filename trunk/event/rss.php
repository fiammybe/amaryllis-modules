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

/** Include the module's header for all pages */
include_once 'header.php';
include_once ICMS_ROOT_PATH . '/header.php';

/** To come soon in imBuilding...

$clean_post_uid = isset($_GET['uid']) ? intval($_GET['uid']) : FALSE;

$event_feed = new icms_feeds_Rss();

$event_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$event_feed->url = XOOPS_URL;
$event_feed->description = $icmsConfig['slogan'];
$event_feed->language = _LANGCODE;
$event_feed->charset = _CHARSET;
$event_feed->category = $icmsModule->name();

$event_post_handler = icms_getModuleHandler("post", basename(dirname(__FILE__)), "event");
//EventPostHandler::getPosts($start = 0, $limit = 0, $post_uid = FALSE, $year = FALSE, $month = FALSE
$postsArray = $event_post_handler->getPosts(0, 10, $clean_post_uid);

foreach($postsArray as $postArray) {
	$event_feed->feeds[] = array (
	  'title' => $postArray['post_title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemUrl']),
	  'description' => htmlspecialchars(str_replace('&', '&amp;', $postArray['post_lead']), ENT_QUOTES),
	  'pubdate' => $postArray['post_published_date_int'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemUrl']),
	);
}

$event_feed->render();
*/