<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /include/comment.inc.php
 * 
 * File holding functions used by the module to hook with the comment system of ImpressCMS
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


function downloads_com_update($item_id, $total_num) {
    $downloads_download_handler = icms_getModuleHandler("download", basename(dirname(dirname(__FILE__))), "downloads");
    $downloads_download_handler->updateComments($item_id, $total_num);
}

function downloads_com_approve(&$comment) {
    // notification mail here
}