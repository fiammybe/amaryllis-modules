<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /include/comment.inc.php
 * 
 * comment callback
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */
defined("ICMS_ROOT_PATH") or die("ICMS Root Path not defined");
function event_com_update($item_id, $total_num) {
    $event_handler = icms_getModuleHandler("event", basename(dirname(dirname(__FILE__))), "event");
    $event_handler->updateComments($item_id, $total_num);
}

function event_com_approve(&$comment) {
    // notification mail here
}