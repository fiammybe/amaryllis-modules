<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /include/comment.inc.php
 * 
 * add, edit and delete portfolio objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */


function portfolio_com_update($item_id, $total_num) {
    $portfolio_portfolio_handler = icms_getModuleHandler("portfolio", basename(dirname(dirname(__FILE__))), "portfolio");
    $portfolio_portfolio_handler->updateComments($item_id, $total_num);
}

function portfolio_com_approve(&$comment) {
    // notification mail here
}