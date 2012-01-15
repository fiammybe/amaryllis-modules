<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /include/notifications.inc.php
 * 
 * notifications handling
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
function career_notify_iteminfo($category, $item_id) {
    $item = array('name' => '', 'url' => '');
	switch ($category) {
		case 'global':
			$item['name'] = '';
        	$item['url'] = '';
			break;
		
		case 'category':
			$career_department_handler = icms_getModuleHandler("department", basename(dirname(dirname(__FILE__))), "career");
			$department = $career_department_handler->get($item_id);
			$item['name'] = $department->getVar('department_title');
			$item['url'] = $department->getItemLink(TRUE);
			break;
			
		case 'career':
			$career_career_handler = icms_getModuleHandler("career", basename(dirname(dirname(__FILE__))), "career");
			$career = $career_career_handler->get($item_id);
			$item['name'] = $file->getVar('career_title');
			$item['url'] = $file->getItemLink(TRUE);
			break;
	}
	return $item;
}