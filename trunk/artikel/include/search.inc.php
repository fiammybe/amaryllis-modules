<?php
/**
 * Article version infomation
 *
 * This file holds the configuration information of this module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		article
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

function article_search($queryarray, $andor, $limit, $offset, $userid) {
/** To come soon in imBuilding...

	$article_post_handler = icms_getModuleHandler("post", basename(dirname(dirname(__FILE__))), "article");
	$postsArray = $article_post_handler->getPostsForSearch($queryarray, $andor, $limit, $offset, $userid);

	$ret = array();

	foreach ($postsArray as $postArray) {
		$item['image'] = "images/post.png";
		$item['link'] = str_replace(ARTICLE_URL, '', $postArray['itemUrl']);
		$item['title'] = $postArray['post_title'];
		$item['time'] = strtotime($postArray['post_published_date']);
		$item['uid'] = $postArray['post_posterid'];
		$ret[] = $item;
		unset($item);
	}

	return $ret;
*/
}