<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/ArticleHandler.php
 * 
 * Classes responsible for managing Article article objects
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


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class ArticleArticleHandler extends icms_ipf_Handler {
	
	private $_article_grpperm = array();
	
	private $_article_license = array();
	
	private $_article_related = array();
	
	private $_article_video_sources = array();
	
	private $_article_cid = array();
	
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
	
	/**
	 * some ways to retrieve articles
	 */
	public function getList($article_active = null) {
		$criteria = new icms_db_criteria_Compo();
		if (isset($download_active)) {
			$criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		}
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
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if ($article_publisher) $criteria->add(new icms_db_criteria_Item('article_publisher', $article_publisher));
		if ($article_id) {
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('short_url', $article_id,'LIKE'));
			$alt_article_id = str_replace('-',' ',$article_id);
			//Added for backward compatiblity in case short_url contains spaces instead of dashes.
			$crit->add(new icms_db_criteria_Item('short_url', $alt_article_id),'OR');
			$crit->add(new icms_db_criteria_Item('article_id', $article_id),'OR');
			$criteria->add($crit);
		}
		if ($article_cid != FALSE){
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("article_cid", "%" . $article_cid . "%", "LIKE"));
			$criteria->add($critTray);
		}
		return $criteria;
	}
	
	public function getArticles($start = 0, $limit = 0, $article_publisher = FALSE, $article_id = FALSE,  $article_cid = FALSE, $order = 'weight', $sort = 'ASC') {
		
		$criteria = $this->getDownloadsCriteria($start, $limit, $article_publisher, $article_id,  $article_cid, $order, $sort);
		$article = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($article as $article){
			if ($article['accessgranted']){
				$ret[$article['article_id']] = $article;
			}
		}
		return $ret;
	}
	
	public function getArticlesForBlocks($start = 0, $limit = 0,$updated = FALSE,$popular = FALSE, $order = 'article_published_date', $sort = 'DESC') {
		global $articleConfig;
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart(0);
		$criteria->setLimit($limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		$criteria->add(new icms_db_criteria_Item('article_active', TRUE));
		$criteria->add(new icms_db_criteria_Item('article_inblocks', TRUE));
		$criteria->add(new icms_db_criteria_Item('article_approve', TRUE));
		if($updated == TRUE) $criteria->add(new icms_db_criteria_Item('article_updated', TRUE));
		if($popular == TRUE) {
			$pop = $downloadsConfig['article_popular'];
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item('counter', $pop, ">="));
			$criteria->add($critTray);
		}
		$articles = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($articles as $key => &$article){
			if ($article['accessgranted']){
				$ret[$article['download_id']] = $article;
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
	
	public function changeMirrorApprove($article_id) {
		$mirror_approve = '';
		$articleObj = $this->get($article_id);
		if ($articleObj->getVar('article_mirror_approve', 'e') == TRUE) {
			$articleObj->setVar('article_mirror_approve', 0);
			$mirror_approve = 0;
		} else {
			$articleObj->setVar('article_mirror_approve', 1);
			$mirror_approve = 1;
		}
		$this->insert($articleObj, TRUE);
		return $mirror_approve;
	}
	
	public function changeBroken($article_id) {
		$broken = '';
		$articleObj = $this->get($article_id);
		if ($articleObj->getVar('article_broken', 'e') == TRUE) {
			$articleObj->setVar('article_broken', 0);
			$broken = 0;
		} else {
			$articleObj->setVar('article_broken', 1);
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
	
	public function getLink($download_id = NULL) {
		$file = $this->get($download_id);
		$link = $file->getItemLink(FALSE);
		return $link;
	}
	
	public function getRelated() {
		if (!$this->_article_related) {
			$related = $this->getList(TRUE);
			return $related;
		}
		return $this->_article_related;
	}
	
	public function getRelatedDownloads() {
		global $articleConfig;
		$downloadsModule = icms_getModuleInfo("downloads");
		if($downloadsModule && $articleConfig['use_downloads'] == 1) {
			$downloads_download_handler = icms_getModuleHandler("download", $downloadsModule->getVar("dirname"), "downloads");
			$downloads = $downloads_download_handler->getDownloads(0, 0, FALSE, FALSE, FALSE, 'download_title', 'ASC');
			$ret = array();
			$ret[0] = '--None--';
			foreach(array_keys($downloads) as $i) {
				$ret[$downloads[$i]['download_id']] = $downloads[$i]['download_title'];
			}
			return $ret;
		}
	}
	
	public function getAlbumList() {
		global $articleConfig;
		$albumModule = icms_getModuleInfo('album');
		if($albumModule && $articleConfig['use_album'] == 1) {
			$album_album_handler = icms_getModuleHandler ('album', $albumModule->getVar('dirname'), 'album');
			$albumObjects = $album_album_handler->getAlbums(TRUE, TRUE, TRUE, 0, 0, FALSE, FALSE,  FALSE, 'weight', 'ASC');
			$ret = array();
			$ret[0] = '--None--';
			foreach(array_keys($albumObjects) as $i) {
				$ret[$albumObjects[$i]['album_id']] = $albumObjects[$i]['album_title'];
			}
			return $ret;
		}
	}
	
	public function getArticleLicense() {
		global $articleConfig;
		if (!$this->_article_license) {
			$license_array = explode(",", $articleConfig['article_license']);
			$license = array();
			foreach (array_keys($license_array) as $i) {
				$license[$license_array[$i]] = $license_array[$i];
			}
			return $license;
		}
		return $this->_article_license;
	}
	
	public function getArticleVideoSources() {
		global $articleConfig;
		if($articleConfig['need_videos'] == 1) {
			if (!$this->_article_license) {
				$sources_array = array(1 => "MyTube", 2 => "YouTube", 3 => "MetaCafe", 4 => "Spike", 5 => "Viddler", 6 => "MySpace TV", 7 => "DailyMotion", 8 => "Blip.tv", 9 => "ClipFish", 10 => "LiveLeak", 11 => "Veoh", 12 => "Vimeo", 13 => "MegaVideo", 14 => "National Geographik");
				$sources = var_dump($sources_array);
				$ret = array();
				foreach (array_keys($sources) as $i) {
					$ret[$sources[$i]] = $sources[$i];
				}
				return $ret;
			}
			return $this->_article_video_sources;
		}
	}
	
	public function getGroups($criteria = null) {
		if (!$this->_article_grpperm) {
			$member_handler =& icms::handler('icms_member');
			$groups = $member_handler->getGroupList($criteria, true);
			return $groups;
		}
		return $this->_article_grpperm;
	}
	
	
	public function userCanSubmit($category_id) {
		global $article_isAdmin;
		$article_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'article');
		$categoryObject = $article_category_handler->get($category_id);
		if (!is_object(icms::$user)) return FALSE;
		if ($article_isAdmin) return TRUE;
		$user_groups = icms::$user->getGroups();
		$module = icms::handler("icms_module")->getByDirname(basename(dirname(dirname(__FILE__))), TRUE);
		return count(array_intersect(array($categoryObject->getVar('category_uplperm')), $user_groups)) > 0;
	}
	
	public function makeLink($article) {
		$count = $this->getCount(new icms_db_criteria_Item("short_url", $article->getVar("short_url")));

		if ($count > 1) {
			return $download->getVar('article_id');
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
			$critTray->add(new icms_db_criteria_Item("article_cid", "%" . $article_cid . "%", "LIKE"));
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
	
	
	protected function beforeInsert(&$obj) {
		$teaser = $obj->getVar("article_teaser", "s");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "input");
		$obj->setVar("article_teaser", $teaser);
		
		$history = $obj->getVar("article_history", "s");
		$history = icms_core_DataFilter::checkVar($history, "html", "input");
		$obj->setVar("article_history", $history);
		
	}
	
	protected function afterSave(&$obj) {
		if ($obj->updating_counter)
		return TRUE;

		if (!$obj->getVar('article_notification_sent') && $obj->getVar('article_active', 'e') == TRUE && $obj->getVar('article_approve', 'e') == TRUE) {
			$obj->sendNotifArticlePublished();
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