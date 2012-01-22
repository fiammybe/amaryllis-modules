<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /include/notification.inc.php
 * 
 * Notification lookup function
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
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
function article_notify_iteminfo($category, $item_id){
    global $icmsModule, $icmsModuleConfig, $icmsConfig;

    $item = array('name' => '', 'url' => '');
	switch ($category) {
		case 'global':
			$item['name'] = '';
        	$item['url'] = '';
			break;
		
		case 'category':
			$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
			$category = $article_category_handler->get($item_id);
			$item['name'] = $category->getVar('category_title');
			$item['url'] = $category->getItemLink(TRUE);
			break;
			
		case 'article':
			$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
			$file = $article_article_handler->get($item_id);
			$item['name'] = $file->getVar('article_title');
			$item['url'] = $file->getItemLink(TRUE);
			break;
	}
	return $item;
}