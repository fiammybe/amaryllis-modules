<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /include/comments.inc.php
 * 
 * handle comments
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

function icmspoll_com_update($item_id, $total_num) {
    $icmspoll_poll_handler = icms_getModuleHandler("polls", basename(dirname(dirname(__FILE__))), "icmspoll");
    $icmspoll_poll_handler->updateComments($item_id, $total_num);
}

function icmspoll_com_approve(&$comment) {
    // notification mail here
}