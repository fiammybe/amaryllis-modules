<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /rss.php
 * 
 * rss feeds for guestbook
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';
include_once ICMS_ROOT_PATH . '/header.php';

if($guestbookConfig['use_rss'] == 1) {
	
	$guestbook_feed = new icms_feeds_Rss();
	$guestbook_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
	$guestbook_feed->url = ICMS_URL;
	$guestbook_feed->description = $icmsConfig['slogan'];
	$guestbook_feed->language = _LANGCODE;
	$guestbook_feed->charset = _CHARSET;
	$guestbook_feed->category = $icmsModule->name();
	
	$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", GUESTBOOK_DIRNAME, "guestbook");
	$postsArray = $guestbook_guestbook_handler->getEntries(TRUE, 0, 0, $guestbookConfig['guestbook_rss_limit'] , 'guestbook_published_date', 'DESC');
	
	foreach($postsArray as $postArray) {
		$guestbook_feed->feeds[] = array (
		  'title' => $postArray['title'],
		  'link' => str_replace('&', '&amp;', $postArray['itemURL']),
		  'author' => $postArray['publisher'],
		  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['teaser']), ENT_QUOTES, _CHARSET),
		  'pubdate' => $postArray['guestbook_published_date'],
		  'guid' => str_replace('&', '&amp;', $postArray['itemURL']),
		  'category' => $postArray['cats'],
		);
	}
	$guestbook_feed->render();
}