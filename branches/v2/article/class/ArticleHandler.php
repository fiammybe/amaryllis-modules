<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/ArticleHandler.php
 * 
 * Classes responsible for managing Article article objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: ArticleHandler.php 670 2012-07-04 12:55:18Z st.flohrer $
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", basename(dirname(dirname(__FILE__))));
icms_loadLanguageFile("article", "common");

class ArticleArticleHandler extends icms_ipf_Handler {
	
	private $_article_related = array();
	public $_articleCatArray;
	
	public $_article_cache_path;
	public $_article_thumbs_path;
	public $_article_images_path;
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $articleConfig;
		parent::__construct($db, "article", "article_id", "article_title", "article_teaser", "article");
		$this->addPermission('article_grpperm', _CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM, _CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM_DSC);
		$mimetypes = icms_file_MediaUploadHandler::checkMimeType();
		$this->enableUpload($mimetypes, $articleConfig['upload_file_size'], $articleConfig['image_upload_width'], $articleConfig['image_upload_height']);
		$this->_article_cache_path = ICMS_CACHE_PATH . "/" . $this->_moduleName . "/" . $this->_itemname;
		$this->_article_thumbs_path = $this->_article_cache_path . "/thumbs";
		$this->_article_images_path = $this->_article_cache_path . "/images";
	}

	public function getArticleThumbsPath() {
		$dir = $this->_article_thumbs_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	public function getArticleImagesPath() {
		$dir = $this->_article_images_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	static public function getImageList() {
		$articleimages = array();
		$articleimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/uploads/' . icms::$module -> getVar( 'dirname' ) . '/article/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($articleimages) as $i ) {
			$ret[$i] = $articleimages[$i];
		}
		return $ret;
	}
	
	public function getArticleCategoryArray() {
		global $indexModule;
		if(!count($this->_articleCatArray)) {
			if(icms_get_module_status("index")) {
			    $indexModule = icms_getModuleInfo("index");
				$category_handler = icms_getModuleHandler("category", $indexModule->getVar("dirname"),  "index");
				$this->_articleCatArray = $category_handler->getCategoryListForPid(FALSE,FALSE,FALSE,FALSE,FALSE,'category_title','ASC',0,FALSE,FALSE,"cat_submit",FALSE);
			}
		} return $this->_articleCatArray;
	}
	
	/**
	 * some ways to retrieve articles
	 */
	public function getArticleList($active = null, $approve = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) $criteria->add(new icms_db_criteria_Item("article_approve", TRUE));
		if($active) $criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		$this->setGrantedObjectsCriteria($criteria, "article_grpperm");
		$articles = $this->getObjects($criteria, TRUE);
		$ret[0] = '-----------';
		foreach(array_keys($articles) as $i) {
			$ret[$i] = $articles[$i]->getVar('article_title');
		}
		return $ret;
	}
	
	public function getArticleCriterias($approve = FALSE, $active = FALSE, $publisher = FALSE, $article_id = FALSE, $article_cid = FALSE, $tag = FALSE, $updated = FALSE, 
										$popular = FALSE, $start = 0, $limit = 0, $order= 'weight', $sort = 'ASC', $inblocks = FALSE, $img_req = FALSE) {
		global $articleConfig;
		$criteria = new icms_db_criteria_Compo();
		if($start) $criteria->setStart($start);
		if($limit) $criteria->setLimit((int)$limit);
		if($order) $criteria->setSort($order);
		if($sort) $criteria->setOrder($sort);
		if($approve) $criteria->add(new icms_db_criteria_Item("article_approve", TRUE));
		if($active) $criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		if($publisher) $criteria->add(new icms_db_criteria_Compo(new icms_db_criteria_Item("article_publisher", '%:"' . $publisher . '";%', "LIKE")));
		if ($article_id) {
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('short_url', $article_id,'LIKE'));
			$crit->add(new icms_db_criteria_Item('short_url', $article_id),'OR');
			$crit->add(new icms_db_criteria_Item('article_id', $article_id),'OR');
			$criteria->add($crit);
		}
		if ($article_cid) $criteria->add(new icms_db_criteria_Compo(new icms_db_criteria_Item("article_cid", '%:"' . $article_cid . '";%', "LIKE")));
		if($tag) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_tags", $tag . ',%', "LIKE"), 'OR');
			$critTray->add(new icms_db_criteria_Item("article_tags", '%,' . $tag . ',%', "LIKE"), 'OR');
			$critTray->add(new icms_db_criteria_Item("article_tags", '%,' . $tag, "LIKE"), 'OR');
			$criteria->add($critTray);
		}
		if($updated) $criteria->add(new icms_db_criteria_Item('article_updated', TRUE));
		if($popular) {
			$pop = $articleConfig['article_popular'];
			$criteria->add(new icms_db_criteria_Compo(new icms_db_criteria_Item("counter", $pop, ">=")));
		}
		if($inblocks) $criteria->add(new icms_db_criteria_Item('article_inblocks', TRUE));
		if($img_req) $criteria->add(new icms_db_criteria_Item("article_img", "0", "!="));
		$this->setGrantedObjectsCriteria($criteria, "article_grpperm");
		return $criteria;
	}
	
	public function getArticleBySeo($seo) {
		$article = FALSE;
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", trim($seo)));
		$articles = $this->getObjects($criteria, FALSE, FALSE);
		if($articles) $article = $this->get($articles[0]['article_id']);
		return $article;
	}
	
	public function getArticles($approve = FALSE, $active = FALSE, $publisher = FALSE, $article_id = FALSE, $article_cid = FALSE, $tag = FALSE, $updated = FALSE, $popular = FALSE,
										$start = 0, $limit = 0, $order= 'weight', $sort = 'ASC', $inblocks = FALSE, $img_req = FALSE) {
		$criteria = $this->getArticleCriterias($approve, $active, $publisher, $article_id, $article_cid, $tag, $updated, $popular, $start, $limit, $order, $sort, $inblocks, $img_req);
		$articles = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($articles as $article){
			$ret[$article['article_id']] = $article;
		}
		return $ret;
	}
	
	public function getArticlesCount($approve = FALSE, $active = FALSE, $publisher = FALSE, $article_id = FALSE, $article_cid = FALSE, $tag = FALSE, $updated = FALSE, $popular = FALSE,
										$start = 0, $limit = 0, $order= 'weight', $sort = 'ASC', $inblocks = FALSE, $img_req = FALSE) {
		$criteria = $this->getArticleCriterias($approve, $active, $publisher, $article_id, $article_cid, $tag, $updated, $popular, $start, $limit, $order, $sort, $inblocks, $img_req);
		return $this->getCount($criteria);
	}
	/**
	 * handling some functions to easily switch some fields
	 */
	public function changeField($article_id, $field) {
		$articleObj = $this->get($article_id);
		if ($articleObj->getVar("$field", 'e') == TRUE) {
			$articleObj->setVar("$field", 0);
			$value = 0;
		} else {
			$articleObj->setVar("$field", 1);
			$value = 1;
		}
		$articleObj->updating_counter = TRUE;
		$this->insert($articleObj, TRUE);
		return $value;
	}

	/**
	 * Adding some filters for object table in ACP
	 */
	public function filterActive() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function filterInblocks() {
		return array(0 => 'Hidden', 1 => 'Visible');
	}
	
	public function filterApprove() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	public function filterBroken() {
		return array(0 => 'Online', 1 => 'Broken');
	}
	
	public function filterCid() {
		global $indexModule;
		$category_handler = icms_getModuleHandler("category", $indexModule->getVar("dirname"), "index");
		return $category_handler->getCategoryListForPid();
	}
	
	public function getLink($article_id = NULL) {
		$file = $this->get($article_id);
		$link = $file->getItemLink(FALSE);
		return $link;
	}
	
	public function getRelated() {
		if(!count($this->_article_related)) {
			$this->_article_related = $this->getArticleList(TRUE, TRUE);
		}
		return $this->_article_related;
	}
	
	//update hit-counter
	public function updateCounter($article_id) {
		global $article_isAdmin;
		$articleObj = $this->get($article_id);
		if (!is_object($articleObj) && $articleObj->isNew()) return FALSE;
		if(!is_object(icms::$user) || (!$article_isAdmin && $articleObj->getVar('article_submitter', 'e') != icms::$user->getVar("uid")) ) {
			$new_counter = $articleObj->getVar('counter') + 1;
			$articleObj->setVar("counter", $new_counter);
			$articleObj->updating_counter = TRUE;
			$this->insert($articleObj, TRUE);
		}
		return TRUE;
	}
	
	// some fuctions related to icms core functions
	public function getArticlesForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart($offset);
		$criteria->setLimit($limit);
		if ($userid != 0){
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_publisher", '%:"' . $userid . '";%', "LIKE"));
			$criteria->add($critTray);
		}

		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('article_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('article_body', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('article_teaser', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('article_conclusion', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		$criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
		$this->setGrantedObjectsCriteria($criteria, "article_grpperm");
		return $this->getObjects($criteria, TRUE, FALSE);
	}

	public function updateComments($article_id, $total_num) {
		$articleObj = $this->get($article_id);
		if ($articleObj && !$articleObj->isNew()) {
			$articleObj->setVar('article_comments', $total_num);
			$this->insert($articleObj, TRUE);
		}
	}
	
	protected function beforeInsert(&$obj) {
		if ($obj->updating_counter) 
		return TRUE;
		$teaser = $obj->getVar("article_teaser", "s");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "input");
		$obj->setVar("article_teaser", $teaser);
		$seo = trim($obj->getVar("short_url", "e"));
		$title = $obj->title();
		if(!$seo == "") {
			$seotitle = str_replace(" ", "_", $seo);
			$seotitle = icms_ipf_Metagen::generateSeoTitle($seo, FALSE);
		} else {
			$seotitle = icms_ipf_Metagen::generateSeoTitle($title, FALSE);
		}
		$obj->setVar("short_url", $seotitle);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seotitle));
		if($this->getCount($criteria) > 0) {
			$obj->setErrors(_CO_INDEX_ERRORS_TAG_SEO_EXISTS);
			return FALSE;
		}
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		if ($obj->updating_counter)
		return TRUE;
		$tags = trim($obj->getVar("article_tags"));
		if($tags != "" && $tags != "0" && icms_get_module_status("index")) {
			$indexModule = icms_getModuleInfo("index");
			$tag_handler = icms_getModuleHandler("tag", $indexModule->getVar("dirname"), "index");
			$tagarray = explode(",", $tags);
			$tagarray = array_map('strtolower', $tagarray);
			$newArray = array();
			foreach ($tagarray as $key => $tag) {
				$intersection = array_intersect($tagarray, array($tag));
				$count = count($intersection);
				if($count > 1) {
					unset($tagarray[$key]);
				} else {
					$tag_id = $tag_handler->addTag($tag, FALSE, $obj, $obj->getVar("article_published_date", "e"), $obj->getVar("article_submitter", "e"), "article_teaser", $obj->getVar("article_img", "e"));
					$newArray[] = $tag_id;
				}
				unset($intersection, $count);
			}
			$obj->setVar("article_tags", implode(",", $newArray));
			unset($tags, $indexModule, $tag_handler, $tags, $tagarray);
		}
		$body = $obj->getVar("article_body", "s");
		$body_parts = explode('[pagebreak]', $body);
		$obj->setVar("article_pagescount", count($body_parts));
		if (!$obj->getVar('article_img_upl') == "") {
			$obj->setVar('article_img', $obj->getVar('article_img_upl') );
		}
		return TRUE;
	}
	
	protected function afterSave(&$obj) {
		global $articleConfig, $indexModule;
		if ($obj->updating_counter)
		return TRUE;
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("article_id", $obj->id()));
		$sql = "SELECT (article_cid) FROM " . $this->table . " " . $criteria->renderWhere();
		$result = $this->db->query($sql);
		list($myrow) = $this->db->fetchRow($result);
		$cats = unserialize($myrow);
		$link_handler = icms_getModuleHandler("link", $indexModule->getVar("dirname"), "index");
		foreach ($cats as $key => $value) {
			$link_handler->addLink($value, 1, icms::$module->getVar("mid"), $this->_itemname, $obj->id(), $obj->getVar("article_img", "e"), $obj->getVar("article_published_date", "e"),
									 $obj->getVar("article_submitter", "e"), "article_teaser");
		}
		
		if (!$obj->notifSent() && $obj->isActive() && $obj->isApproved()) {
			if($obj->isNew()) {
				$obj->sendArticleNotification('article_published');
			} else {
				$obj->sendArticleNotification('article_modified');
			}
			$obj->setVar('article_notification_sent', TRUE);
			$obj->updating_counter = TRUE;
			$this->insert($obj, TRUE);
		}
		if($articleConfig['article_autopost_twitter'] == 1 && icms_get_module_status("index") && $obj->isNew()) {
			IndexAutopublisher::sendTwitterPost($obj);
		}
		
		return TRUE;
	}
	
	protected function afterDelete(& $obj) {
		$notification_handler = icms::handler( 'icms_data_notification' );
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname(ARTICLE_DIRNAME);
		$module_id = $module->getVar('mid');
		$category = 'global';
		$article_id = $obj->id();
		// delete global notifications
		$notification_handler->unsubscribeByItem($module_id, $category, $article_id);
		//delete all linked categories and tags
		$link_handler = icms_getModuleHandler("link", "index");
		$link_handler->deleteAllByCriteria(FALSE, FALSE, $module_id, $this->_itemname, $obj->id());
		unset($notification_handler, $module_handler, $module, $link_handler);
		return TRUE;
	}

}