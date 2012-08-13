<?php
/**
 * "Article" is an article management module for ImpressCMS
 *
 * File: /extras/plugins/waiting/article.php
 * 
 * plugin file for waiting block
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

define("_MOD_ARTICLE_CATEGORY_APPROVE", "Waiting categories for approval");
define("_MOD_ARTICLE_ARTICLE_APPROVE", "Waiting articles for approval");
define("_MOD_ARTICLE_BROKEN_FILES", "Waiting broken files");

function b_waiting_article() {
	$module_handler = icms::handler('icms_module')->getByDirname("article");
	$category_handler = icms_getModuleHandler("category", "index");
	$article_article_handler = icms_getModuleHandler("article", "article");
	
	$ret = array();
	
	// category approval
	$block = array();
	$approved = new icms_db_criteria_Compo();
	$approved->add(new icms_db_criteria_Item("category_approve", 0));
	$result = $category_handler->getCount($approved);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/article/admin/category.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_ARTICLE_CATEGORY_APPROVE ;
		$ret[] = $block;
	}
	
	// file approval
	$block = array();
	$approve = new icms_db_criteria_Compo();
	$approve->add(new icms_db_criteria_Item("article_approve", 0));
	$result = $article_article_handler->getCount($approve);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/article/admin/article.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_ARTICLE_ARTICLE_APPROVE;
		$ret[] = $block;
	}
	
	// broken attachments
	$block = array();
	$broken = "";
	$broken = new icms_db_criteria_Compo();
	$broken->add(new icms_db_criteria_Item("article_broken_file", TRUE));
	$result = $article_article_handler->getCount($broken);
	if ($result) {
		$block['adminlink'] = ICMS_URL."/modules/article/admin/article.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_ARTICLE_BROKEN_FILES ;
		$ret[] = $block;
	}
	
	return $ret;
}
