<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /include/comment.inc.php
 *
 * File holding functions used by the module to hook with the comment system of ImpressCMS 
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

function album_com_update($item_id, $total_num) {
    $album_album_handler = icms_getModuleHandler("album", basename(dirname(dirname(__FILE__))), "album");
    $album_album_handler->updateComments($item_id, $total_num);
}

function album_com_approve(&$comment) {
    // notification mail here
}