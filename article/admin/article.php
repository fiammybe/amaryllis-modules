<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/article.php
 * 
 * add, edit, view and delete articles
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

/**
 * Edit a Article
 *
 * @param int $article_id Articleid to be edited
*/
function editarticle($article_id = 0) {
	global $article_article_handler, $icmsModule, $icmsAdminTpl;

	$articleObj = $article_article_handler->get($article_id);
	$article_uid = icms::$user->getVar("uid");
	if (!$articleObj->isNew()){
		
		$icmsModule->displayAdminMenu(1, _MI_ARTICLE_MENU_ARTICLE . " > " . _MI_ARTICLE_ARTICLE_EDIT);
		
		$articleObj->setVar("article_updated_date", (time() - 200));
		$articleObj->setVar("article_updater", $article_uid);
		$sform = $articleObj->getForm(_AM_ARTICLE_ARTICLE_EDIT, "addarticle");
		$sform->assign($icmsAdminTpl);
	} else {
		$articleObj->setVar("article_published_date", (time() - 600));
		$articleObj->setVar("article_submitter", $article_uid);
		$icmsModule->displayAdminMenu(1, _MI_ARTICLE_MENU_ARTICLE . " > " . _MI_ARTICLE_ARTICLE_CREATINGNEW);
		$sform = $articleObj->getForm(_AM_ARTICLE_ARTICLE_CREATE, "addarticle");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:article_admin.html");
}

include_once "admin_header.php";

$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
$categories = $article_category_handler->getCount();
if($categories > 0) {
	
	$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
	if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');
	
	$valid_op = array ('mod', 'changedField', 'addarticle', 'del', 'view', 'visible', 'changeShow', 'changeBroken', 'changeApprove', 'changeWeight', '');
	
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
	$clean_article_id = isset($_GET["article_id"]) ? filter_input(INPUT_GET, "article_id", FILTER_SANITIZE_NUMBER_INT) : 0 ;
	
	if (in_array($clean_op, $valid_op, TRUE)) {
		switch ($clean_op) {
			case "mod":
			case "changedField":
				icms_cp_header();
				editarticle($clean_article_id);
				break;
	
			case "addarticle":
				$articleObj = $article_article_handler->get($clean_article_id);
				if($articleObj->isNew()) {
					$articleObj->sendArticleNotification('article_submitted');
				} else {
					$articleObj->sendArticleNotification('article_modified');
				}
				$controller = new icms_ipf_Controller($article_article_handler);
				$controller->storeFromDefaultForm(_AM_ARTICLE_ARTICLE_CREATED, _AM_ARTICLE_ARTICLE_MODIFIED);
				break;
	
			case "del":
				$controller = new icms_ipf_Controller($article_article_handler);
				$controller->handleObjectDeletion();
				break;
	
			case "view" :
				$articleObj = $article_article_handler->get($clean_article_id);
				icms_cp_header();
				$articleObj->displaySingleObject();
				break;
				
			case 'visible':
				$visibility = $article_article_handler -> changeVisible( $clean_article_id );
				$ret = 'article.php';
				if ($visibility == 0) {
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_OFFLINE );
				} else {
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_ONLINE );
				}
				break;
			
			case 'changeShow':
				$show = $article_article_handler -> changeShow( $clean_article_id );
				$ret = 'article.php';
				if ($show == 0) {
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_INBLOCK_FALSE );
				} else {
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_INBLOCK_TRUE );
				}
				break;
			
			case 'changeBroken':
				$show = $article_article_handler -> changeBroken( $clean_article_id );
				$ret = 'article.php';
				if ($show == 0) {
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_OFFLINE );
				} else {
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_ONLINE );
				}
				break;
			
			case 'changeApprove':
				$approve = $article_article_handler -> changeApprove( $clean_article_id );
				$ret = 'article.php';
				if ($approve == 0) {
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_APPROVE_FALSE );
				} else {
					$articleObj = $article_article_handler->get($clean_article_id);
					$articleObj->sendArticleNotification('article_approved');
					redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_APPROVE_TRUE );
				}
				break;
				
			case "changeWeight":
				foreach ($_POST['ArticleArticle_objects'] as $key => $value) {
					$changed = false;
					$articleObj = $article_article_handler -> get( $value );
	
					if ($articleObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
						$articleObj->setVar('weight', intval($_POST['weight'][$key]));
						$changed = true;
					}
					if ($changed) {
						$article_article_handler -> insert($articleObj);
					}
				}
				$ret = 'article.php';
				redirect_header( ARTICLE_ADMIN_URL . $ret, 2, _AM_ARTICLE_ARTICLE_WEIGHTS_UPDATED);
				break;
		
			default:
				icms_cp_header();
				icms::$module->displayAdminMenu( 1, _MI_ARTICLE_MENU_ARTICLE );
				$criteria = '';
				if ($clean_article_id) {
					$articleObj = $article_article_handler->get($clean_article_id);
					if ($articleObj->id()) {
						$articleObj->displaySingleObject();
					}
				}
				if (empty($criteria)) {
					$criteria = null;
				}
				// create article table
				$objectTable = new icms_ipf_view_Table($article_article_handler, $criteria);
				$objectTable->addColumn( new icms_ipf_view_Column( 'article_active', 'center', 50, 'article_active' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'article_title', false, false, 'getPreviewItemLink' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'article_cid', false, false, 'getArticleCid' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'counter', 'center', 50));
				$objectTable->addColumn( new icms_ipf_view_Column( 'article_inblocks', 'center', 50, 'article_inblocks' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'article_approve', 'center', 50, 'article_approve' ) );
				if($articleConfig['need_attachments'] == 1) {
					$objectTable->addColumn( new icms_ipf_view_Column( 'article_broken_file', 'center', 50, 'article_broken_file' ) );
				}
				$objectTable->addColumn( new icms_ipf_view_Column( 'article_published_date', 'center', 100, 'getArticlePublishedDate' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'article_publisher', 'center', true, 'getArticlePublishers' ) );
				$objectTable->addColumn( new icms_ipf_view_Column( 'weight', 'center', true, 'getArticleWeightControl' ) );
				
				$objectTable->addFilter('article_active', 'article_active_filter');
				$objectTable->addFilter('article_inblocks', 'article_inblocks_filter');
				$objectTable->addFilter('article_approve', 'article_approve_filter');
				if($articleConfig['need_attachments'] == 1) {
					$objectTable->addFilter('article_broken_file', 'article_broken_filter');
				}
				
				$objectTable->addQuickSearch(array('article_title', 'article_teaser', 'article_history', 'article_body', 'article_steps', 'article_tips'));
				
				$objectTable->addIntroButton( 'addarticle', 'article.php?op=mod', _AM_ARTICLE_ARTICLE_ADD );
				$objectTable->addActionButton( 'changeWeight', false, _SUBMIT );
				
				$objectTable->addCustomAction( 'getViewItemLink' );
				
				$icmsAdminTpl->assign( 'article_article_table', $objectTable->fetch() );
				$icmsAdminTpl->display( 'db:article_admin.html' );
				break;
		}
		icms_cp_footer();
	}
} else {
	redirect_header(ARTICLE_ADMIN_URL . "category.php", 3,_AM_ARTICLE_NO_CAT_FOUND);
}