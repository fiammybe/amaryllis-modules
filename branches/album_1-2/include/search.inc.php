<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/Album.php
 * 
 * This file holds the search information of this module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */
 
defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");


include_once ICMS_ROOT_PATH . '/modules/' . basename(dirname(dirname(__FILE__))) . '/include/common.php';

function album_search($queryarray, $andor, $limit, $offset, $userid) {
	$album_album_handler = icms_getModuleHandler('album', basename(dirname(dirname(__FILE__))), 'album');
	$albumsArray = $album_album_handler->getAlbumsForSearch($queryarray, $andor, $limit, $offset, $userid);

	$ret = array();

	foreach ($albumsArray as $albumArray) {
		$item['image'] = "images/album_icon.png";
		$item['link'] = $albumArray['itemURL'];
		$item['title'] = $albumArray['album_title'];
		$item['time'] = strtotime($albumArray['album_published_date']);
		$item['uid'] = $albumArray['album_uid'];
		$ret[] = $item;
		unset($item);
	}
	return $ret;
}