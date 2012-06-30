<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /rss.php
 * 
 * rss feeds for started poll
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

include_once 'header.php';

include_once ICMS_ROOT_PATH . '/header.php';

if($icmspollConfig['use_rss'] == 1) {
	
	$clean_post_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
	
	$poll_feed = new icms_feeds_Rss();
	$poll_feed->title = $icmsConfig['sitename'] . ' - ' . icms::$module->getVar("name");
	$poll_feed->url = ICMS_URL;
	$poll_feed->description = $icmsConfig['slogan'];
	$poll_feed->language = _LANGCODE;
	$poll_feed->charset = _CHARSET;
	$poll_feed->category = icms::$module->getVar("name");
	
	$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
	$postsArray = $polls_handler->getPolls(0, $icmspollConfig['rss_limit'], $icmspollConfig['polls_default_order'], $icmspollConfig['polls_default_sort'], $clean_post_uid, FALSE, FALSE);
	
	foreach($postsArray as $postArray) {
		$poll_feed->feeds[] = array (
		  'title' 		=> $postArray['question'],
		  'link' 		=> str_replace('&', '&amp;', $postArray['itemURL']),
		  'author' 		=> $postArray['user'],
		  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['dsc']), ENT_QUOTES, _CHARSET),
		  'pubdate' 	=> $postArray['start_time'],
		  'guid' 		=> str_replace('&', '&amp;', $postArray['itemURL']),
		);
	}
	$poll_feed->render();
}