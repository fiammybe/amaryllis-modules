<?php
/**
 * Comment include file
 *
 * File holding functions used by the module to hook with the comment system of ImpressCMS
 *
 * @copyright	
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		event
 * @version		$Id$
 */

function event_com_update($item_id, $total_num) {
    $event_post_handler = icms_getModuleHandler("post", basename(dirname(dirname(__FILE__))), "event");
    $event_post_handler->updateComments($item_id, $total_num);
}

function event_com_approve(&$comment) {
    // notification mail here
}