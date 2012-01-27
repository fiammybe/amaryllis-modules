<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /rss.php
 * 
 * rss feeds
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

include_once 'header.php';

include_once ICMS_ROOT_PATH . '/header.php';

$clean_post_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;

$portfolio_feed = new icms_feeds_Rss();

$portfolio_feed->title = $icmsConfig['sitename'] . ' - ' . $icmsModule->name();
$portfolio_feed->url = ICMS_URL;
$portfolio_feed->description = $icmsConfig['slogan'];
$portfolio_feed->language = _LANGCODE;
$portfolio_feed->charset = _CHARSET;
$portfolio_feed->category = $icmsModule->name();

$portfolio_portfolio_handler = icms_getModuleHandler("portfolio", basename(dirname(__FILE__)), "portfolio");
$postsArray = $portfolio_portfolio_handler->getPortfolios(TRUE, "portfolio_p_date", "DESC", 0, 10, FALSE);

foreach($postsArray as $postArray) {
	
	$portfolio_feed->feeds[] = array (
	  'title' => $postArray['title'],
	  'link' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'author' => $postArray['submitter'],
	  'description' => icms_core_DataFilter::htmlSpecialChars(str_replace('&', '&amp;', $postArray['summary']), ENT_QUOTES, _CHARSET),
	  'pubdate' => $postArray['portfolio_p_date'],
	  'guid' => str_replace('&', '&amp;', $postArray['itemURL']),
	  'category' => $postArray['cat'],
	  
	);
}
$portfolio_feed->render();