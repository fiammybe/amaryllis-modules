<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /rss.php
 * 
 * rss feeds
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

include_once 'header.php';

include_once ICMS_ROOT_PATH . '/header.php';

$clean_post_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;

$career_feed = new icms_feeds_Rss();

$career_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$career_feed->url = ICMS_URL;
$career_feed->description = $icmsConfig['slogan'];
$career_feed->language = _LANGCODE;
$career_feed->charset = _CHARSET;
$career_feed->category = $icmsModule->name();

$career_career_handler = icms_getModuleHandler("career", basename(dirname(__FILE__)), "career");
$postsArray = $career_career_handler->getCareers(TRUE, "career_pdate", "DESC", 0, 10, FALSE);

foreach($postsArray as $postArray) {
	
	$career_feed->feeds[] = array (
	  'title' => $postArray['title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'author' => $postArray['submitter'],
	  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['summary']), ENT_QUOTES, _CHARSET),
	  'pubdate' => $postArray['career_p_date'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'category' => $postArray['department'],
	  
	);
}
$career_feed->render();