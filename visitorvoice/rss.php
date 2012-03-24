<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /rss.php
 * 
 * rss feeds for visitorvoice
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';
include_once ICMS_ROOT_PATH . '/header.php';

if($visitorvoiceConfig['use_rss'] == 1) {
	
	$clean_post_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
	
	$visitorvoice_feed = new icms_feeds_Rss();
	$visitorvoice_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
	$visitorvoice_feed->url = ICMS_URL;
	$visitorvoice_feed->description = $icmsConfig['slogan'];
	$visitorvoice_feed->language = _LANGCODE;
	$visitorvoice_feed->charset = _CHARSET;
	$visitorvoice_feed->category = $icmsModule->name();
	
	$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", VISITORVOICE_DIRNAME, "visitorvoice");
	$postsArray = $visitorvoice_visitorvoice_handler->getEntries(TRUE, 0, 0, $visitorvoiceConfig['visitorvoice_rss_limit'] , 'visitorvoice_published_date', 'DESC');
	
	foreach($postsArray as $postArray) {
		$visitorvoice_feed->feeds[] = array (
		  'title' => $postArray['title'],
		  'link' => str_replace('&', '&amp;', $postArray['itemURL']),
		  'author' => $postArray['published_by'],
		  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['teaser']), ENT_QUOTES, _CHARSET),
		  'pubdate' => $postArray['visitorvoice_published_date'],
		  'guid' => str_replace('&', '&amp;', $postArray['itemURL']),
		  'category' => $postArray['cats'],
		);
	}
	$visitorvoice_feed->render();
}