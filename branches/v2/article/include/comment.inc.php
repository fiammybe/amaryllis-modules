<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /include/comment.inc.php
 * 
 * File holding functions used by the module to hook with the comment system of ImpressCMS
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

function article_com_update($item_id, $total_num) {
    $article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
    $article_article_handler->updateComments($item_id, $total_num);
}

function article_com_approve(&$comment) {
    // notification mail here
}