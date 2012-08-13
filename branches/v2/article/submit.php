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


include_once "header.php";

$valid_op = array ('report_broken', 'addtags');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'report_broken':
			$article_id = (int)filter_input(INPUT_GET, 'article_id');
			$category_id = (int)filter_input(INPUT_GET, 'category_id');
			if ($article_id <= 0) return FALSE;
			$article_handler = icms_getModuleHandler('article', ARTICLE_DIRNAME,'article');
			$articleObj = $article_handler->get($article_id);
			if ($articleObj->isNew()) return FALSE;
			
			$articleObj->setVar('article_broken_file', TRUE);
			$articleObj->store(TRUE);
			
			$articleObj->sendMessageBroken();
			//$articleObj->sendArticleNotification('article_file_broken');
			
			return redirect_header(ARTICLE_URL . 'singlearticle.php?article_id=' . $article_id . '&category_id=' . $category_id, 5, _MD_ARTICLE_BROKEN_REPORTED);
			break;
		
		case 'addtags':
			global $articleConfig;
			$article_id = (int)filter_input(INPUT_GET, 'article_id', FILTER_SANITIZE_NUMBER_INT);
			if ($article_id <= 0) return FALSE;
			
			$article_handler = icms_getModuleHandler('article', ARTICLE_DIRNAME,'article');
			$articleObj = $article_handler->get($article_id);
			if ($articleObj->isNew()) return FALSE;
			$articleModule = icms_getModuleInfo("article");
			$article_modid = $articleModule->getVar("mid");
			$indexModule = icms::handler('icms_module')->getByDirname("index");
            $tag_handler = icms_getModuleHandler("tag", $indexModule->getVar("dirname"), "index");
            $uid = (is_object(icms::$user)) ? icms::$user->getVar("uid", "e") : 0;
            $tag_names = $_POST['tag_names'];
            $tags = explode(",", $tag_names);
            $article_tags = explode(",", $articleObj->getVar("article_tags", "e"));
			foreach ($tags as $key => $tag) {
				$tag_id = $tag_handler->addTag($tag, FALSE, $articleObj, $articleObj->getVar("article_published_date", "e"), $articleObj->getVar("article_submitter", "e"), "article_teaser", $articleObj->getVar("article_img", "e"));
                $article_tags[] = $tag_id;
			}
            $articleObj->setVar("article_tags", implode(",", $article_tags));
            $articleObj->setVar("article_tags", $articleObj->getArticleTags(TRUE));
            $article_handler->insert($articleObj, TRUE);
            redirect_header(ARTICLE_URL . 'singlearticle.php?article_id=' . $article_id . '#article_tags', 4, _THANKS_SUBMISSION_TAG);
			break;
	}
} else {
	return redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}