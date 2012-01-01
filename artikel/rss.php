<?php
/**
 * Generating an RSS feed
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		article
 * @version		$Id$
 */

/** Include the module's header for all pages */
include_once 'header.php';
include_once ICMS_ROOT_PATH . '/header.php';

/** To come soon in imBuilding...

$clean_post_uid = isset($_GET['uid']) ? intval($_GET['uid']) : FALSE;

$article_feed = new icms_feeds_Rss();

$article_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$article_feed->url = XOOPS_URL;
$article_feed->description = $icmsConfig['slogan'];
$article_feed->language = _LANGCODE;
$article_feed->charset = _CHARSET;
$article_feed->category = $icmsModule->name();

$article_post_handler = icms_getModuleHandler("post", basename(dirname(__FILE__)), "article");
//ArticlePostHandler::getPosts($start = 0, $limit = 0, $post_uid = FALSE, $year = FALSE, $month = FALSE
$postsArray = $article_post_handler->getPosts(0, 10, $clean_post_uid);

foreach($postsArray as $postArray) {
	$article_feed->feeds[] = array (
	  'title' => $postArray['post_title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemUrl']),
	  'description' => htmlspecialchars(str_replace('&', '&amp;', $postArray['post_lead']), ENT_QUOTES),
	  'pubdate' => $postArray['post_published_date_int'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemUrl']),
	);
}

$article_feed->render();
*/