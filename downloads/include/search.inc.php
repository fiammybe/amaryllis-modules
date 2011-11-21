<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/search.inc.php
 * 
 * File holding functions used by the module to hook with the search system of ImpressCMS
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");


include_once ICMS_ROOT_PATH . '/modules/' . basename(dirname(dirname(__FILE__))) . '/include/common.php';

function downloads_search($queryarray, $andor, $limit, $offset, $userid) {
	$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');
	$downloadssArray = $downloads_download_handler->getDownloadsForSearch($queryarray, $andor, $limit, $offset, $userid);

	$ret = array();

	foreach ($downloadsArray as $downloadArray) {
		$item['image'] = "images/downloads_icon.png";
		$item['link'] = $downloadArray['itemUrl'];
		$item['title'] = $downloadArray['download_title'];
		$item['time'] = strtotime($downloadArray['download_published_date']);
		$item['uid'] = $downloadArray['download_publisher'];
		$ret[] = $item;
		unset($item);
	}
	return $ret;
}