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

icms_loadLanguageFile("article", "common");

class ArticleArticleHandler extends icms_ipf_Handler {
	
	private $_article_grpperm = array();
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $articleConfig;
		parent::__construct($db, "article", "article_id", "article_title", "article_teaser", "article");
		$this->_uploadPath = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/article/';
		$this->addPermission('article_grpperm', _CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM, _CO_ARTICLE_ARTICLE_ARTICLE_GRPPERM_DSC);
		$mimetypes = $this->checkMimeType();
		$this->enableUpload($mimetypes, $articleConfig['upload_file_size'], $articleConfig['image_upload_width'], $articleConfig['image_upload_height']);
	}
	
	public function getImagePath() {
		$dir = $this->_uploadPath;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir, '0777', '');
		}
		return $dir . "/";
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
	
	/**
	 * some ways to retrieve articles
	 */
	public function getList($article_active = null, $approve = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if (isset($article_active)) {
			$criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		}
		if (isset($approve)) {
			$criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
		}
		
		$articles = $this->getObjects($criteria, TRUE);
		$ret[0] = '-----------';
		foreach(array_keys($articles) as $i) {
			if($articles[$i]->accessGranted()) {
				$ret[$i] = $articles[$i]->getVar('article_title');
			}
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
		return $criteria;
	}
	
	public function getArticles($start = 0, $limit = 0,$tag_id = FALSE, $article_publisher = FALSE, $article_id = FALSE,  $article_cid = FALSE, $order = 'weight', $sort = 'ASC') {
		
		$criteria = $this->getArticleCriteria($start, $limit, $article_publisher, $article_id,  $article_cid, $order, $sort);
		if($tag_id) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_tags", '%:"' . $tag_id . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		$article = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($article as $article){
			if ($article['accessgranted']){
				$ret[$article['article_id']] = $article;
			}
		}
		return $ret;
	}
	
	public function getArticlesForBlocks($start = 0, $limit = 0, $article_cid = FALSE,$updated = FALSE,$popular = FALSE, $order = 'article_published_date', $sort = 'DESC') {
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
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_cid", '%:"' . $article_cid . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		$articles = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($articles as $key => &$article){
			if ($article['accessgranted']){
				$ret[$article['article_id']] = $article;
			}
		}
		return $ret;
	}

	/**
	 * handling some functions to easily switch some fields
	 */
	public function changeVisible($article_id) {
		$visibility = '';
		$articleObj = $this->get($article_id);
		if ($articleObj->getVar('article_active', 'e') == TRUE) {
			$articleObj->setVar('article_active', 0);
			$visibility = 0;
		} else {
			$articleObj->setVar('article_active', 1);
			$visibility = 1;
		}
		$this->insert($articleObj, TRUE);
		return $visibility;
	}
	
	public function changeShow($article_id) {
		$show = '';
		$articleObj = $this->get($article_id);
		if ($articleObj->getVar('article_inblocks', 'e') == TRUE) {
			$articleObj->setVar('article_inblocks', 0);
			$show = 0;
		} else {
			$articleObj->setVar('article_inblocks', 1);
			$show = 1;
		}
		$this->insert($articleObj, TRUE);
		return $show;
	}
	
	public function changeApprove($article_id) {
		$approve = '';
		$articleObj = $this->get($article_id);
		if ($articleObj->getVar('article_approve', 'e') == TRUE) {
			$articleObj->setVar('article_approve', 0);
			$approve = 0;
		} else {
			$articleObj->setVar('article_approve', 1);
			$approve = 1;
		}
		$this->insert($articleObj, TRUE);
		return $approve;
	}
	
	public function changeBroken($article_id) {
		$broken = '';
		$articleObj = $this->get($article_id);
		if ($articleObj->getVar('article_broken_file', 'e') == TRUE) {
			$articleObj->setVar('article_broken_file', 0);
			$broken = 0;
		} else {
			$articleObj->setVar('article_broken_file', 1);
			$broken = 1;
		}
		$this->insert($articleObj, TRUE);
		return $broken;
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
	
	function getCategoryList($active = NULL, $approve = NULL ) {
		
		$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
		$criteria = new icms_db_criteria_Compo();
		
		if(isset($approve)) $criteria->add(new icms_db_criteria_Item("category_approve", TRUE));
		if(isset($active)) $criteria->add(new icms_db_criteria_Item("category_active", TRUE));
		
		$categories = $article_category_handler->getObjects($criteria, TRUE);
		foreach(array_keys($categories) as $i ) {
			$ret[$categories[$i]->getVar('category_id')] = $categories[$i]->getVar('category_title');
		}
		return $ret;
	}
	
	public function getCategories() {
		$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$categories = $article_category_handler->getCategoryListForPid($groups=array(), 'category_grpperm', TRUE, TRUE, FALSE, NULL, FALSE);
		return $categories;
	}
	
	/**
	 * handle some object fields
	 */
	
	public function getArticleCategories()	{
		if(!$this->_article_cid) {
			$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
			$categories = $article_category_handler->getObjects(FALSE, TRUE, FALSE);
			$ret = array();
			foreach(array_keys($categories) as $i) {
				$ret[$categories[$i]['category_id']] = $categories[$i]['title'];
			}
			return $ret;
		}
		return $this->_article_cid;
	}
	
	public function getArticleTags() {
		global $articleConfig;
		$sprocketsModule = icms_getModuleInfo("sprockets");
		if($sprocketsModule->registerClassPath(TRUE) && ($articleConfig['use_sprockets'] == 1)) {
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
		$related = $this->getList(TRUE, TRUE);
		return $related;
	}
	
	public function getGroups($criteria = null) {
		if (!$this->_article_grpperm) {
			$member_handler =& icms::handler('icms_member');
			$groups = $member_handler->getGroupList($criteria, true);
			return $groups;
		}
		return $this->_article_grpperm;
	}
	
	public function makeLink($article) {
		$count = $this->getCount(new icms_db_criteria_Item("short_url", $article->getVar("short_url")));

		if ($count > 1) {
			return $article->getVar('article_id');
		} else {
			$seo = str_replace(" ", "-", $article->getVar('short_url'));
			return $seo;
		}
	}
	
	public function getCountCriteria ($active = null, $approve = null, $groups = array(), $perm = 'article_grpperm', $article_publisher = FALSE, $article_id = FALSE, $article_cid = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		
		if (isset($active)) {
			$criteria->add(new icms_db_criteria_Item('article_active', true));
		}
		if (isset($approve)) {
			$criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
		}
		if (is_null($article_cid)) $article_cid = 0;
		if ($article_cid != FALSE)	{
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_cid", '%:"' . $article_cid . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		
		$articles = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($articles as $article){
			if ($article['accessgranted']){
				$ret[$article['article_id']] = $article;
			}
		}
		return count($ret);
	
	}
	
	//update hit-counter
	public function updateCounter($article_id) {
		global $article_isAdmin;
		$articleObj = $this->get($article_id);
		if (!is_object($articleObj)) return false;

		if (isset($articleObj->vars['counter']) && !is_object(icms::$user) || (!$article_isAdmin && $articleObj->getVar('article_submitter', 'e') != icms::$user->getVar("uid")) ) {
			$new_counter = $articleObj->getVar('counter') + 1;
			$sql = 'UPDATE ' . $this->table . ' SET counter=' . $new_counter
				. ' WHERE ' . $this->keyName . '=' . $articleObj->id();
			$this->query($sql, null, true);
		}
		return true;
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
				$criteriaKeyword->add(new icms_db_criteria_Item('article_description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		$criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
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
		$teaser = $obj->getVar("article_teaser", "s");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "input");
		$obj->setVar("article_teaser", $teaser);
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		$body = $obj->getVar("article_body", "s");
		$body_parts = explode('[pagebreak]', $body);
		$obj->setVar("article_pagescount", count($body_parts));
		if (!$obj->getVar('article_img_upl') == "") {
			$obj->setVar('article_img', $obj->getVar('article_img_upl') );
		}
		return TRUE;
	}
	
	protected function afterSave(&$obj) {
		if ($obj->updating_counter)
		return TRUE;

		if (!$obj->getVar('article_notification_sent') && $obj->getVar('article_active', 'e') == TRUE && $obj->getVar('article_approve', 'e') == TRUE) {
			$obj->sendArticleNotification('article_published');
			$obj->setVar('article_notification_sent', TRUE);
			$this->insert($obj);
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