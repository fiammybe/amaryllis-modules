<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /include/notification.inc.php
 * 
 * comment callback
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */
defined("ICMS_ROOT_PATH") or die("ICMS Root Path not defined");

function event_notify_iteminfo($category, $item_id){
    global $icmsModuleConfig, $icmsConfig;

    if ($category == 'global') {
        $item['name'] = '';
        $item['url'] = '';
        return $item;
    }
}