<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/notification.inc.php
 * 
 * Notification lookup function
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

/**
 * Notification lookup function
 *
 * This function is called by the notification process to get an array contaning information
 * about the item for which there is a notification
 *
 * @param string $category category of the notification
 * @param int $item_id id f the item related to this notification
 *
 * @return array containing 'name' and 'url' of the related item
 */
function downloads_notify_iteminfo($category, $item_id) {
    $item = array('name' => '', 'url' => '');
	switch ($category) {
		case 'global':
			$item['name'] = '';
        	$item['url'] = '';
			break;
		
		case 'category':
			$downloads_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "downloads");
			$category = $downloads_category_handler->get($item_id);
			$item['name'] = $category->getVar('category_title');
			$item['url'] = $category->getItemLink(TRUE);
			break;
			
		case 'file':
			$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(dirname(__FILE__))), "downloads");
			$file = $downloads_download_handler->get($item_id);
			$item['name'] = $file->getVar('download_title');
			$item['url'] = $file->getItemLink(TRUE);
			break;
	}
	return $item;
}