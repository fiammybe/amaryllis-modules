<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /class/ArticleHandler.php
 * 
 * Classes responsible for managing Artikel article objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Artikel
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		artikel
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class ArtikelArticleHandler extends icms_ipf_Handler {
	
	private $_article_grpperm = array();
	
	private $_article_license = array();
	
	private $_article_related = array();
	
	private $_article_video_sources = array();
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $artikelConfig;
		parent::__construct($db, "article", "article_id", "article_title", "article_teaser", "artikel");
		$this->addPermission('article_grpperm', _CO_ARTIKEL_ARTICLE_ARTICLE_GRPPERM, _CO_ARTIKEL_ARTICLE_ARTICLE_GRPPERM_DSC);
		$mimetypes = $this->checkMimeType();
		$this->enableUpload($mimetypes, $artikelConfig['upload_file_size'], $artikelConfig['image_upload_width'], $artikelConfig['image_upload_height']);
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
			return false;
		}
		$AllowedMimeTypes = $mimetypeHandler->AllowedModules($this->mediaRealType, $modulename);
		if ((!empty($this->allowedMimeTypes) && !in_array($this->mediaRealType, $this->allowedMimeTypes))
				|| (!empty($this->deniedMimeTypes) && in_array($this->mediaRealType, $this->deniedMimeTypes))
				|| (empty($this->allowedMimeTypes) && !$AllowedMimeTypes))
			{
			icms_file_MediaUploadHandler::setErrors(sprintf(_ER_UP_MIMETYPENOTALLOWED, $this->mediaType));
			return false;
		}
		return true;
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
	
	
	/**
	 * handle some object fields
	 */
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
		global $artikelConfig;
		$downloadsModule = icms_getModuleInfo("downloads");
		if($downloadsModule && $artikelConfig['use_downloads'] == 1) {
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
		global $artikelConfig;
		$albumModule = icms_getModuleInfo('album');
		if($albumModule && $artikelConfig['use_album'] == 1) {
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
		global $artikelConfig;
		if (!$this->_article_license) {
			$license_array = explode(",", $artikelConfig['article_license']);
			$license = array();
			foreach (array_keys($license_array) as $i) {
				$license[$license_array[$i]] = $license_array[$i];
			}
			return $license;
		}
		return $this->_article_license;
	}
	
	public function getArticleVideoSources() {
		global $artikelConfig;
		if($artikelConfig['need_videos'] == 1) {
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
	
	
	
	
	
	public function makeLink($article) {
		$count = $this->getCount(new icms_db_criteria_Item("short_url", $article->getVar("short_url")));

		if ($count > 1) {
			return $download->getVar('article_id');
		} else {
			$seo = str_replace(" ", "-", $article->getVar('short_url'));
			return $seo;
		}
	}
	
	protected function beforeInsert(&$obj) {
		$teaser = $obj->getVar("article_teaser", "s");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "input");
		$obj->setVar("article_teaser", $teaser);
		
		$history = $obj->getVar("article_history", "s");
		$history = icms_core_DataFilter::checkVar($history, "html", "input");
		$obj->setVar("article_history", $history);
		
	}

}