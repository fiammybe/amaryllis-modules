<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /article.php
 * 
 * add edit and delete articles
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


include_once "header.php";

$xoopsOption["template_main"] = "article_article.html";
include_once ICMS_ROOT_PATH . "/header.php";

$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_article_id = isset($_GET["article_id"]) ? (int)$_GET["article_id"] : 0 ;
$articleObj = $article_article_handler->get($clean_article_id);

if($articleObj && !$articleObj->isNew()) {
	$icmsTpl->assign("article_article", $articleObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($articleObj->getVar("article_title"), $articleObj->getVar("meta_keywords", "n"), $articleObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("article_title", _MD_ARTICLE_ALL_ARTICLES);

	$objectTable = new icms_ipf_view_Table($article_article_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("article_title"));
	$icmsTpl->assign("article_article_table", $objectTable->fetch());
}


include_once 'header.php';

$xoopsOption['template_main'] = 'article_forms.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = $indexpageObj = $article_indexpage_handler = $indexpageObj = '';
$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$article_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'article' );

$indexpageObj = $article_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('article_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_article_id = isset($_GET['article_id']) ? filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT) : 0;

$valid_op = array ('mod', 'addarticle', 'del');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');


$article_article_handler = icms_getModuleHandler("article", basename(dirname(__FILE__)), "article");

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case('mod'):
			$articleObj = $article_article_handler->get($clean_article_id);
			if ($clean_article_id > 0 && $articleObj->isNew()) {
				redirect_header(ARTICLE_URL, 3, _NO_PERM);
			}
			editarticle($articleObj);
			break;
		
		case('addarticle'):
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_ARTICLE_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$articleObj = $article_article_handler->get($clean_article_id);
			$articleObj->sendDownloadNotification('file_submitted');
			$controller = new icms_ipf_Controller($article_article_handler);
			$controller->storeFromDefaultForm(_MD_ARTICLE_DOWNLOAD_CREATED, _MD_ARTICLE_DOWNLOAD_MODIFIED);
			break;
		case('del'):
			$articleObj = $article_article_handler->get($clean_article_id);
			if (!$articleObj->userCanEditAndDelete()) {
				redirect_header($categoryObj->getItemLink(true), 3, _NOPERM);
			}
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_ARTICLE_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($article_article_handler);
			$controller->handleObjectDeletionFromUserSide();
			break;
	}
} else {
	redirect_header(ARTICLE_URL, 3, _NOPERM);
}

if( $articleConfig['show_breadcrumbs'] == true ) {
	$icmsTpl->assign('article_show_breadcrumb', true);
} else {
	$icmsTpl->assign('article_show_breadcrumb', false);
}

include_once "footer.php";