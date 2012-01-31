<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /submit.php
 * 
 * some submitting actions
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


include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';

$valid_op = array ('report_broken', 'addtags');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'report_broken':
			$article_id = (int)filter_input(INPUT_GET, 'article_id');
			$category_id = (int)filter_input(INPUT_GET, 'category_id');
			if ($article_id <= 0) return FALSE;
			$article_article_handler = icms_getModuleHandler('article', basename(dirname(__FILE__)),'article');
			$articleObj = $article_article_handler->get($article_id);
			if ($articleObj->isNew()) return FALSE;
			
			$articleObj->setVar('article_broken_file', TRUE);
			$articleObj->store(TRUE);
			
			$articleObj->sendMessageBroken();
			//$articleObj->sendArticleNotification('article_file_broken');
			
			return redirect_header(ARTICLE_URL . 'singlearticle.php?article_id=' . $article_id . '&category_id=' . $category_id, 5, _MD_ARTICLE_BROKEN_REPORTED);
			break;
		
		case 'addtags':
			global $articleConfig;
			$article_id = (int)filter_input(INPUT_GET, 'article_id');
			if ($article_id <= 0) return FALSE;
			$article_article_handler = icms_getModuleHandler('article', basename(dirname(__FILE__)),'article');
			$articleObj = $article_article_handler->get($article_id);
			if ($articleObj->isNew()) return FALSE;
			$articleModule = icms_getModuleInfo("article");
			$article_modid = $articleModule->getVar("mid");
			$clean_tag_id = isset($_GET['tag_id']) ? filter_input(INPUT_GET, 'tag_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
			if(icms_get_module_status("sprockets")) {
			$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname"), "sprockets");
			$tagObj = $sprockets_tag_handler->get($clean_tag_id);
			if($tagObj->isNew() ) {
				$tagObj->setVar('label_type', 0);
				$tagObj->setVar('navigation_element', 0);
				
				$sprockets_taglink_handler = icms_getModuleHandler('taglink', $sprocketsModule->getVar("dirname"),'sprockets');
				$taglinkObj = $sprockets_taglink_handler->create();
				$tagObjects = $sprockets_tag_handler->getCount(FALSE);
				$tag_id = (int)($tagObjects) + 1;
				$taglinkObj->setVar('tid', $tag_id );
				$taglinkObj->setVar('mid', $article_modid );
				$taglinkObj->setVar('item', $articleObj->getVar("article_title"));
				$taglinkObj->setVar('iid', $article_id);
				$taglinkObj->store(TRUE);
				
				$mytags = $articleObj->getVar("article_tags", "s");
				$newtag = $tag_id;
				$merge = array_merge($mytags, array($tag_id));
				$articleObj->setVar("article_tags", $merge);
				$articleObj->store(TRUE);
				
				if (!icms::$security->check()) {
					redirect_header('singlearticle.php?article_id=' . $article_id, 3, _MD_ARTICLE_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
				$controller = new icms_ipf_Controller($sprockets_tag_handler);
				$controller->storeFromDefaultForm(_THANKS_SUBMISSION_TAG, _THANKS_SUBMISSION_TAG, ARTICLE_URL . 'singlearticle.php?article_id=' . $article_id);
				return redirect_header (ARTICLE_URL . 'singlearticle.php?article_id=' . $article_id, 3, _THANKS_SUBMISSION);
				}
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
			}
			break;
	}
} else {
	return redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
}