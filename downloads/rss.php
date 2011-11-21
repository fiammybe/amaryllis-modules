<?php
/**
 * Generating an RSS feed
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		downloads
 * @version		$Id$
 */

/** Include the module's header for all pages */
include_once 'header.php';
include_once ICMS_ROOT_PATH . '/header.php';

/** To come soon in imBuilding...

$clean_post_uid = isset($_GET['uid']) ? intval($_GET['uid']) : FALSE;

$downloads_feed = new icms_feeds_Rss();

$downloads_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$downloads_feed->url = XOOPS_URL;
$downloads_feed->description = $icmsConfig['slogan'];
$downloads_feed->language = _LANGCODE;
$downloads_feed->charset = _CHARSET;
$downloads_feed->category = $icmsModule->name();

$downloads_post_handler = icms_getModuleHandler("post", basename(dirname(__FILE__)), "downloads");
//DownloadsPostHandler::getPosts($start = 0, $limit = 0, $post_uid = FALSE, $year = FALSE, $month = FALSE
$postsArray = $downloads_post_handler->getPosts(0, 10, $clean_post_uid);

foreach($postsArray as $postArray) {
	$downloads_feed->feeds[] = array (
	  'title' => $postArray['post_title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemUrl']),
	  'description' => htmlspecialchars(str_replace('&', '&amp;', $postArray['post_lead']), ENT_QUOTES),
	  'pubdate' => $postArray['post_published_date_int'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemUrl']),
	);
}

$downloads_feed->render();
*/