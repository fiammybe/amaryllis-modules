<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /comment_new.php
 * 
 * add comments
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

include_once "header.php";
$com_itemid = isset($_GET["com_itemid"]) ? (int)$_GET["com_itemid"] : 0;
if ($com_itemid > 0) {
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");
	$postObj = $article_article_handler->get($com_itemid);
	if ($postObj && !$postObj->isNew()) {
		$com_replytext = "test...";
		$bodytext = $postObj->getArticleTeaser();
		if ($bodytext != "") {
			$com_replytext .= "<br /><br />".$bodytext;
		}
		$com_replytitle = $postObj->getVar("article_title");
		include_once ICMS_ROOT_PATH . "/include/comment_new.php";
	}
}