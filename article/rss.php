<?php
/**
 * Generating an RSS feed
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		artikel
 * @version		$Id$
 */

/** Include the module's header for all pages */
include_once 'header.php';
include_once ICMS_ROOT_PATH . '/header.php';

/** To come soon in imBuilding...

$clean_post_uid = isset($_GET['uid']) ? intval($_GET['uid']) : FALSE;

$artikel_feed = new icms_feeds_Rss();

$artikel_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$artikel_feed->url = XOOPS_URL;
$artikel_feed->description = $icmsConfig['slogan'];
$artikel_feed->language = _LANGCODE;
$artikel_feed->charset = _CHARSET;
$artikel_feed->category = $icmsModule->name();

$artikel_post_handler = icms_getModuleHandler("post", basename(dirname(__FILE__)), "artikel");
//ArtikelPostHandler::getPosts($start = 0, $limit = 0, $post_uid = FALSE, $year = FALSE, $month = FALSE
$postsArray = $artikel_post_handler->getPosts(0, 10, $clean_post_uid);

foreach($postsArray as $postArray) {
	$artikel_feed->feeds[] = array (
	  'title' => $postArray['post_title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemUrl']),
	  'description' => htmlspecialchars(str_replace('&', '&amp;', $postArray['post_lead']), ENT_QUOTES),
	  'pubdate' => $postArray['post_published_date_int'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemUrl']),
	);
}

$artikel_feed->render();
*/