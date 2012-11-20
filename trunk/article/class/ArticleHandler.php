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
 * @version		$Id$
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", basename(dirname(dirname(__FILE__))));
icms_loadLanguageFile("article", "common");

class ArticleArticleHandler extends icms_ipf_Handler {
	
	private $_article_related = array();
	private $_articleCatArray;
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $articleConfig;
		parent::__construct($db, "article", "article_id", "article_title", "article_teaser", "article");
		$this->addPermission('article_grpperm', _CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM, _CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM_DSC);
		$mimetypes = $this->checkMimeType();
		$this->enableUpload($mimetypes, $articleConfig['upload_file_size'], $articleConfig['image_upload_width'], $articleConfig['image_upload_height']);
	}

	/**
	 * check enabled mime types in system
	 */
	public function checkMimeType() {
		global $icmsModule;
		$mimetypeHandler = icms_getModulehandler('mimetype', 'system');
		$modulename = basename(dirname(dirname(__FILE__)));
		if (empty($this->mediaRealType) && empty($this->allowUnknownTypes)) {
			icms_file_MediaUploadHandler::setErrors(_ER_UP_UNKNOWNFILETYPEREJECTED);
			return FALSE;
		}
		$AllowedMimeTypes = $mimetypeHandler->AllowedModules($this->mediaRealType, $modulename);
		if ((!empty($this->allowedMimeTypes) && !in_array($this->mediaRealType, $this->allowedMimeTypes))
				|| (!empty($this->deniedMimeTypes) && in_array($this->mediaRealType, $this->deniedMimeTypes))
				|| (empty($this->allowedMimeTypes) && !$AllowedMimeTypes))
			{
			icms_file_MediaUploadHandler::setErrors(sprintf(_ER_UP_MIMETYPENOTALLOWED, $this->mediaType));
			return FALSE;
		}
		return TRUE;
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
		if(!count($this->_articleCatArray)) {
			$category_handler = icms_getModuleHandler("category", ARTICLE_DIRNAME,  "article");
			$this->_articleCatArray = $category_handler->getCategoryListForPid('submit_article', TRUE,TRUE,FALSE, NULL, FALSE);
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
	
	// some criterias used by other requests
	public function getArticleCriteria($start = 0, $limit = 0, $article_publisher = FALSE, $article_id = FALSE,$article_cid = FALSE, $order = 'article_published_date', $sort = 'DESC') {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		if ($order) $criteria->setSort($order);
		if ($sort) $criteria->setOrder($sort);
		if ($article_publisher) {
			$tray = new icms_db_criteria_Compo();
			$tray->add(new icms_db_criteria_Item("article_publisher", '%:"' . $article_publisher . '";%', "LIKE"));
			$criteria->add($tray);
		}
		if ($article_id) {
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('short_url', $article_id,'LIKE'));
			$alt_article_id = str_replace('-',' ',$article_id);
			//Added for backward compatiblity in case short_url contains spaces instead of dashes.
			$crit->add(new icms_db_criteria_Item('short_url', $alt_article_id),'OR');
			$crit->add(new icms_db_criteria_Item('article_id', $article_id),'OR');
			$criteria->add($crit);
		}
		if ($article_cid != FALSE && $article_cid > 0)	{
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_cid", '%:"' . $article_cid . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		$criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		$criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
		return $criteria;
	}
	
	public function getArticles($start = 0, $limit = 0,$tag_id = FALSE, $article_publisher = FALSE, $article_id = FALSE,  $article_cid = FALSE, $order = 'weight', $sort = 'ASC') {
		$criteria = $this->getArticleCriteria($start, $limit, $article_publisher, $article_id,  $article_cid, $order, $sort);
		if($tag_id) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_tags", '%:"' . $tag_id . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		$this->setGrantedObjectsCriteria($criteria, "article_grpperm");
		$article = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($article as $article){
			$ret[$article['article_id']] = $article;
		}
		return $ret;
	}
	
	public function getArticleBySeo($seo) {
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", trim($seo)));
		$articles = $this->getObjects($criteria, FALSE, TRUE);
		if($articles) return $articles[0];
		return FALSE;
	}
	
	public function getArticlesForBlocks($start = 0, $limit = 0, $article_cid = FALSE,$updated = FALSE,$popular = FALSE, $order = 'article_published_date', $sort = 'DESC', $img_req = FALSE) {
		global $articleConfig;
		$criteria = new icms_db_criteria_Compo();
		if($start) $criteria->setStart($start);
	 	if($limit) $criteria->setLimit($limit);
		if($order)$criteria->setSort($order);
		if($sort) $criteria->setOrder($sort);
		$criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		$criteria->add(new icms_db_criteria_Item('article_inblocks', TRUE));
		$criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
		if($updated == TRUE) $criteria->add(new icms_db_criteria_Item('article_updated', TRUE));
		if($popular == TRUE) {
			$pop = $articleConfig['article_popular'];
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item('counter', $pop, ">="));
			$criteria->add($critTray);
		}
		if ($article_cid != FALSE)	{
			$crit = new icms_db_criteria_Compo();
			$crit->add(new icms_db_criteria_Item("article_cid", '%:"' . $article_cid . '";%', "LIKE"));
			$criteria->add($crit);
		}
		if($img_req != FALSE) {
			$criteria->add(new icms_db_criteria_Item("article_img", "0", "!="));
		}
		$this->setGrantedObjectsCriteria($criteria, "article_grpperm");
		$articles = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($articles as $article){
			$ret[$article['article_id']] = $article;
		}
		return $ret;
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
	public function article_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function article_inblocks_filter() {
		return array(0 => 'Hidden', 1 => 'Visible');
	}
	
	public function article_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	public function article_broken_filter() {
		return array(0 => 'Online', 1 => 'Broken');
	}
		
	/**
	 * handle some object fields
	 */
	public function getArticleTags() {
		global $articleConfig;
		$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
		if(icms_get_module_status("sprockets")) {
			$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname") , "sprockets");
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item("label_type", 0));
			$criteria->add(new icms_db_criteria_Item("navigation_element", 0));
			
			$tags = $sprockets_tag_handler->getObjects(FALSE, TRUE, FALSE);
			$ret[] = '------------';
			foreach(array_keys($tags) as $i) {
				$ret[$tags[$i]['tag_id']] = $tags[$i]['title'];
			}
			return $ret;
		}
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
	
	public function getCountCriteria ($active = FALSE, $approve = FALSE, $groups = array(), $perm = 'article_grpperm', $article_publisher = FALSE, $article_id = FALSE, $article_cid = FALSE, $tag_id = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if ($active) $criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		if($approve) $criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
		if ($article_cid != FALSE)	{
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_cid", '%:"' . $article_cid . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		if($tag_id) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_tags", '%:"' . $tag_id . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		$this->setGrantedObjectsCriteria($criteria, "article_grpperm");
		$count = $this->getCount($criteria);
		return $count;
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
			$articleObj->updating_counter = TRUE;
			$this->insert($articleObj, TRUE);
		}
	}
	
	protected function beforeInsert(&$obj) {
		$teaser = $obj->getVar("article_teaser", "e");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "input");
		$obj->setVar("article_teaser", $teaser);
		$seo = trim($obj->short_url());
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
			$obj->setVar("short_url", $seotitle.'_'.time());
		}
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		$body = $obj->getVar("article_body", "e");
		$body_parts = explode('[pagebreak]', $body);
		$obj->setVar("article_pagescount", count($body_parts));
		if (!$obj->getVar('article_img_upl') == "") {
			$obj->setVar('article_img', $obj->getVar('article_img_upl') );
			$obj->setVar('article_img_upl', "");
		}
		return TRUE;
	}
	
	protected function afterSave(&$obj) {
		global $articleConfig;
		if ($obj->updating_counter) return TRUE;

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
		if(icms_get_module_status("sprockets")) {
			$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("article_id", $obj->id()));
			$sql = "SELECT (article_tags) FROM " . $this->table . " " . $criteria->renderWhere();
			$result = $this->db->query($sql);
			list($myrow) = $this->db->fetchRow($result);
			$tags = unserialize($myrow);
			if($tags != "" && $tags != "0") {
				$sprocketsModule = icms_getModuleInfo("sprockets");
				$sprockets_taglink_handler = icms_getModuleHandler("taglink", $sprocketsModule->getVar("dirname"), "sprockets");
				foreach ($tags as $key => $value) {
					$tagObj = $sprockets_taglink_handler->create(TRUE);
					$tagObj->setVar("tid", (int)$value);
					$tagObj->setVar("mid", icms::$module->getVar("mid", "e"));
					$tagObj->setVar("item", $this->_itemname);
					$tagObj->setVar("iid", $obj->id());
					$sprockets_taglink_handler->insert($tagObj, TRUE);
				}
			}
		}
		return TRUE;
	}
	
	protected function afterDelete(& $obj) {
		$notification_handler = icms::handler( 'icms_data_notification' );
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname( icms::$module -> getVar( 'dirname' ) );
		$module_id = icms::$module->getVar('mid');
		$category = 'global';
		$article_id = $obj->id();
		// delete global notifications
		$notification_handler->unsubscribeByItem($module_id, $category, $article_id);
		return TRUE;
	}

}