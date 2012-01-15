<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /rss.php
 * 
 * module rss feeds
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

include_once 'header.php';

include_once ICMS_ROOT_PATH . '/header.php';

$clean_post_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;

$downloads_feed = new icms_feeds_Rss();

$downloads_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$downloads_feed->url = ICMS_URL;
$downloads_feed->description = $icmsConfig['slogan'];
$downloads_feed->language = _LANGCODE;
$downloads_feed->charset = _CHARSET;
$downloads_feed->category = $icmsModule->name();

$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");
$postsArray = $downloads_download_handler->getDownloads(0, 10, FALSE, $clean_post_uid);

foreach($postsArray as $postArray) {
	
	$downloads_feed->feeds[] = array (
	  'title' => $postArray['title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'author' => $postArray['publisher'],
	  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['teaser']), ENT_QUOTES, _CHARSET),
	  'pubdate' => $postArray['download_published_date'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'category' => $postArray['cats_title'],
	  
	);
}
$downloads_feed->render();