<?php
/**
 * Article version infomation
 *
 * This file holds the configuration information of this module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		article
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
include_once ICMS_ROOT_PATH . '/modules/article/include/common.php';
function article_search($queryarray, $andor, $limit, $offset, $userid) {
	$article_article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');
	$articleArray = $article_article_handler->getArticlesForSearch($queryarray, $andor, $limit, $offset, $userid);

	$ret = array();

	foreach ($articleArray as $articleArray) {
		$item['image'] = "images/article_icon_big.png";
		$item['link'] = $articleArray['itemURL'];
		$item['title'] = $articleArray['article_title'];
		$item['time'] = strtotime($articleArray['article_published_date']);
		$item['uid'] = $articleArray['article_publisher'];
		$ret[] = $item;
		unset($item);
	}
	return $ret;
}