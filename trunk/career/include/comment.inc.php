<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /include/comment.inc.php
 * 
 * add, edit and delete message objects
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


function career_com_update($item_id, $total_num) {
    $career_message_handler = icms_getModuleHandler("message", basename(dirname(dirname(__FILE__))), "career");
    $career_message_handler->updateComments($item_id, $total_num);
}

function career_com_approve(&$comment) {
    // notification mail here
}