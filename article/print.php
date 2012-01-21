<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /print.php
 * 
 * print single article
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

include_once 'header.php';

$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");

$clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_short_url = isset($_GET['article'] ) ? filter_input(INPUT_GET, 'article') : '';

if ($clean_short_url != '' && $clean_article_id == 0) {
	$criteria = new icms_db_criteria_Compo();
	$criteria->add(new icms_db_criteria_Item("short_url", urlencode($clean_short_url)));
	$articleObj = $article_article_handler->getObjects($criteria);
	$articleObj = $articleObj [0];
	$clean_article_id = $articleObj->getVar("article_id", "e");
} else {
	$articleObj = $article_article_handler->get($clean_article_id);
}

if (!$articleObj || !is_object($articleObj) || $articleObj->isNew()) {
	redirect_header(icms_getPreviousPage(), 2, _MD_ARTICLE_NO_ARTICLE);
}

if (!$articleObj->accessGranted()){
	redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
}

$categories = $articleObj->getArticleCid(FALSE);

$icmsTpl = new icms_view_Tpl();
global $icmsConfig;

$article = $articleObj->toArray();
$printtitle = $icmsConfig['sitename']." - ". $categories . ' > ' . strip_tags($articleObj->getVar('article_title','n' ));

$icmsTpl->assign('printtitle', $printtitle);
$icmsTpl->assign('printlogourl', $articleConfig['article_print_logo']);
$icmsTpl->assign('printfooter', $articleConfig['article_print_footer']);
$icmsTpl->assign('article', $article);

$icmsTpl->display('db:article_print.html');