<?php
/**
 * 'Article' is an article management module for ImpressCMS
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
 * @package		article
 *
 */

include_once 'header.php';

include_once ICMS_ROOT_PATH . '/header.php';

$clean_post_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;

$article_feed = new icms_feeds_Rss();

$article_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$article_feed->url = ICMS_URL;
$article_feed->description = $icmsConfig['slogan'];
$article_feed->language = _LANGCODE;
$article_feed->charset = _CHARSET;
$article_feed->category = $icmsModule->name();

$article_article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
$postsArray = $article_article_handler->getArticles(0, $articleConfig['article_rss_limit'], FALSE, $clean_post_uid, FALSE, FALSE, "article_published_date", "DESC");

foreach($postsArray as $postArray) {
	
	$article_feed->feeds[] = array (
	  'title' => $postArray['title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'author' => $postArray['publisher'],
	  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['teaser']), ENT_QUOTES, _CHARSET),
	  'pubdate' => $postArray['article_published_date'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'category' => $postArray['cats'],
	);
}
$article_feed->render();