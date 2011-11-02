<?php
/**
 * Comment include file
 *
 * File holding functions used by the module to hook with the comment system of ImpressCMS
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 */
/**
 * 'Album' is a light weight gallery module
 *
 * File: /header.php
 *
 * File holding functions used by the module to hook with the comment system of ImpressCMS 
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B
 * @version		$Id$
 * @package		album
 * @version		$Id$
 * 
 */
function album_com_update($item_id, $total_num) {
    $album_post_handler = icms_getModuleHandler("post", basename(dirname(dirname(__FILE__))), "album");
    $album_post_handler->updateComments($item_id, $total_num);
}

function album_com_approve(&$comment) {
    // notification mail here
}