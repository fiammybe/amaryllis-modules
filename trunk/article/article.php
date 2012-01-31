<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /article.php
 * 
 * add edit and delete articles
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

function editarticle($articleObj) {
	global $article_article_handler, $icmsTpl, $articleConfig;
	
	if (!$articleObj->isNew()){
		$articleObj->hideFieldFromForm(array('article_updated', 'article_broken_file','article_approve', 'meta_description', 'meta_keywords', 'article_additionals', 'article_updated', 'article_submitter', 'article_inblocks', 'article_active', 'article_published_date', 'article_updated_date' ) );
		$articleObj->setVar( 'article_updated_date', (time() - 100) );
		$articleObj->setVar('article_updated', TRUE );
		
		$sform = $articleObj->getSecureForm(_MD_ARTICLE_ARTICLE_EDIT, 'addarticle');
		$sform->assign($icmsTpl, 'article_article_form');
		$icmsTpl->assign('article_cat_path', $articleObj->getVar('article_title') . ' > ' . _MD_ARTICLE_ARTICLE_EDIT);
	} else {
		$articleObj->hideFieldFromForm(array('article_updated', 'article_broken_file','article_approve', 'meta_description', 'meta_keywords', 'article_additionals', 'article_updated', 'article_submitter', 'article_inblocks', 'article_active', 'article_published_date', 'article_updated_date' ) );
		$articleObj->setVar('article_published_date', (time() - 100) );
		if($articleConfig['article_needs_approval'] == 1) {
			$articleObj->setVar('article_approve', FALSE );
		} else {
			$articleObj->setVar('article_approve', TRUE );
		}
		$articleObj->setVar('article_submitter', icms::$user->getVar("uid"));
		
		$sform = $articleObj->getSecureForm(_MD_ARTICLE_ARTICLE_CREATE, 'addarticle');
		$sform->assign($icmsTpl, 'article_article_form');
		$icmsTpl->assign('article_cat_path', _MD_ARTICLE_ARTICLE_CREATE);
	}
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


$article_article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");

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
			if($articleObj->isNew()) {
				$articleObj->sendArticleNotification('article_submitted');
			} else {
				$articleObj->sendArticleNotification('article_modified');
			}
			$controller = new icms_ipf_Controller($article_article_handler);
			$controller->storeFromDefaultForm(_MD_ARTICLE_ARTICLE_CREATED, _MD_ARTICLE_ARTICLE_MODIFIED);
			break;
		case('del'):
			$articleObj = $article_article_handler->get($clean_article_id);
			if (!$articleObj->userCanEditAndDelete()) {
				redirect_header($articleObj->getItemLink(TRUE), 3, _NO_PERM);
			}
			$icmsTpl->assign('article_cat_path', _MD_ARTICLE_ARTICLE_DELETE);
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
	redirect_header(ARTICLE_URL, 3, _NO_PERM);
}
include_once "footer.php";