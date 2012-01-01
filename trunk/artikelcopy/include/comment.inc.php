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
 * @package		artikel
 * @version		$Id$
 */

function artikel_com_update($item_id, $total_num) {
    $artikel_post_handler = icms_getModuleHandler("post", basename(dirname(dirname(__FILE__))), "artikel");
    $artikel_post_handler->updateComments($item_id, $total_num);
}

function artikel_com_approve(&$comment) {
    // notification mail here
}