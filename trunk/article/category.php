<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /category.php
 * 
 * add edit and delete categories
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

function editcategory($categoryObj = 0) {
	global $article_category_handler, $icmsTpl, $articleConfig;
	
	if (!$categoryObj->isNew()){
		$categoryObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'category_updated', 'category_publisher', 'category_submitter', 'category_active', 'category_inblocks', 'category_approve', 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar('category_updated_date', (time() - 200) );
		$categoryObj->setVar('category_updater', icms::$user->getVar("uid"));
		$sform = $categoryObj->getSecureForm(_MD_ARTICLE_CATEGORY_EDIT, 'addcategory');
		$sform->assign($icmsTpl, 'article_category_form');
		$icmsTpl->assign('article_cat_path', $categoryObj->getVar('category_title') . ' : ' . _MD_ARTICLE_CATEGORY_EDIT);
	} else {
		$categoryObj->hideFieldFromForm(array('meta_description', 'meta_keywords', 'category_updated', 'category_publisher', 'category_submitter', 'category_active', 'category_inblocks', 'category_approve', 'category_published_date', 'category_updated_date' ) );
		$categoryObj->setVar('category_published_date', (time() - 100) );
		if($articleConfig['category_needs_approval'] == 1) {
			$categoryObj->setVar('category_approve', FALSE );
		} else {
			$categoryObj->setVar('category_approve', TRUE );
		}
		$categoryObj->setVar('category_submitter', icms::$user->getVar("uid"));
		$categoryObj->setVar('category_publisher', icms::$user->getVar("uid"));
		$categoryObj->setVar('category_published_date', (time() - 200));
		$sform = $categoryObj->getSecureForm(_MD_ARTICLE_CATEGORY_CREATE, 'addcategory');
		$sform->assign($icmsTpl, 'article_category_form');
		$icmsTpl->assign('article_cat_path', _MD_ARTICLE_CATEGORY_CREATE);
	}
} 

include_once 'header.php';

$xoopsOption['template_main'] = 'article_forms.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$article_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'article' );

$indexpageObj = $article_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('article_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category_id = ($clean_category_id == 0 && isset($_POST['category_id'])) ? filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT) : $clean_category_id;
$clean_category_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : FALSE;
$clean_category_pid = isset($_GET['category_pid']) ? filter_input(INPUT_GET, 'category_pid', FILTER_SANITIZE_NUMBER_INT) : ($clean_category_uid ? FALSE : 0);

$article_category_handler = icms_getModuleHandler( 'category', icms::$module -> getVar( 'dirname' ), 'article' );

/**
 * Get a whitelist of valid op's
 */
$valid_op = array ('mod', 'addcategory', 'del');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

/**
 * Only proceed if the supplied operation is a valid operation
 */
if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'mod':
			$categoryObj = $article_category_handler->get($clean_category_id);
			if ($clean_category_id > 0 && $categoryObj->isNew()) {
				redirect_header(ARTICLE_URL, 3, _NO_PERM);
			}
			editcategory($categoryObj);
			
			break;
			
		case 'addcategory':
			
			$categoryObj = $article_category_handler->get($clean_category_id);
			if($categoryObj->isNew()) {
				$categoryObj->sendCategoryNotification('category_submitted');
			} else {
				$categoryObj->sendCategoryNotification('category_modified');
			}
			$controller = new icms_ipf_Controller($article_category_handler);
			$controller->storeFromDefaultForm(_MD_ARTICLE_CATEGORY_CREATED, _MD_ARTICLE_CATEGORY_MODIFIED);
			break;
		
		case 'del':
			$categoryObj = $article_category_handler->get($clean_category_id);
			if (!$categoryObj->userCanEditAndDelete()) {
				redirect_header($categoryObj->getItemLink(TRUE), 3, _NO_PERM);
			}
			$icmsTpl->assign('article_cat_path', _MD_ARTICLE_CATEGORY_DELETE);
			
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_ARTICLE_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($article_category_handler);
			$controller->handleObjectDeletionFromUserSide();
			$icmsTpl->assign('article_cat_path', $article_category_handler->getBreadcrumbForPid($categoryObj->getVar('category_id', 'e'), 1) . ' > ' . _DELETE);
			break;
	}
}

include_once 'footer.php';