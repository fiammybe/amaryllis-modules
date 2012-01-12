<?php
/**
 * "Article" is an article management module for ImpressCMS
 *
 * File: /class/Article.php
 * 
 * Class representing Article article Objects
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

class ArticleArticle extends icms_ipf_seo_Object {
	
	public $updating_counter = false;
	
	/**
	 * Constructor
	 *
	 * @param mod_article_Article $handler Object handler
	 */
	public function __construct(&$handler) {
		global $articleConfig, $icmsConfig;
		icms_ipf_object::__construct($handler);

		$this->quickInitVar("article_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("article_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("article_cid", XOBJ_DTYPE_ARRAY, TRUE);
		
		$this->quickInitVar("article_descriptions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_image", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("article_teaser", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("article_show_teaser", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("article_body", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("article_descriptions_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_additionals", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_version", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("article_steps", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_tips", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_warnings", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_license", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_needed", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_attachment", XOBJ_DTYPE_FILE, FALSE);
		$this->quickInitVar("article_attachment_alt", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_downloads", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_album", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_video", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_video_source", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_video_upload", XOBJ_DTYPE_FILE, FALSE);
		$this->quickInitVar("article_video_upload_alt", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_history", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_related", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_resources", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_tags", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_conclusion", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_additionals_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_informations", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_submitter", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_publisher", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_updater", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_published_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("article_updated_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("article_informations_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_permissions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_grpperm", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("article_approve", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_active", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_updated", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_inblocks", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_broken_file", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_broken_video", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_permissions_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_statics", XOBJ_DTYPE_FORM_SECTION);
		$this->initCommonVar("weight");
		$this->initCommonVar("counter");
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, 1);
		$this->quickInitVar("article_like", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_dislike", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_notification_sent", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_stats_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		
		$this->setControl("article_cid", array("name" => "select_multi", "itemhandler" => "category", "method" => "getCategoryListForPid", "module" => "article"));
		$this->setControl("article_image", "image");
		$this->setControl("article_teaser", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("article_show_teaser", "yesno");
		$this->setControl("article_body", "dhtmltextarea");
		$this->setControl("article_publisher", "user_multi");
		$this->setControl("article_approve", "yesno");
		$this->setControl("article_active", "yesno");
		$this->setControl("article_updated", "yesno");
		$this->setControl("article_inblocks", "yesno");

		$this->hideFieldFromForm(array("article_submitter", "weight", "counter", "article_like", "article_dislike"));
		
		$this->openFormSection("article_descriptions", _CO_ARTICLE_ARTICLE_ARTICLE_DESCRIPTIONS);
		$this->openFormSection("article_additionals", _CO_ARTICLE_ARTICLE_ARTICLE_ADDITIONALS);
		$this->openFormSection("article_informations", _CO_ARTICLE_ARTICLE_ARTICLE_INFORMATIONS);
		$this->openFormSection("article_permissions", _CO_ARTICLE_ARTICLE_ARTICLE_PERMISSIONS);
		$this->openFormSection("article_statics", _CO_ARTICLE_ARTICLE_ARTICLE_STATICS);
		
		/**
		 * check, if 'Downloads' can be used to attach files, else hide field
		 */
		if($articleConfig['use_downloads'] == 1) {
			$this->setControl("article_downloads", array("name" => "select_multi", "itemhandler" => "article", "method" => "getRelatedDownloads", "module" => "article"));
		} else {
			$this->hideFieldFromForm("article_downloads");
			$this->hideFieldFromSingleView("article_downloads");
		}
		
		/**
		 * check, if 'Album' module can be used to display images, else hid field
		 */
		
		if($articleConfig['use_album'] == 1) {
			$this->setControl("article_album", array("name" => "select", "itemhandler" => "article", "method" => "getAlbumList", "module" => "article"));
		} else {
			$this->hideFieldFromForm("article_album");
			$this->hideFieldFromSingleView("article_album");
		}
		
		if($articleConfig['use_sprockets'] == 1) {
			$this->setControl("article_tags", array("name" => "select_multi", "itemhandler" => "article", "method" => "getArticleTags", "module" => "article"));
		} else {
			$this->hideFieldFromForm("article_album");
			$this->hideFieldFromSingleView("article_album");
		}
		
		/**
		 * check, if steps are needed, else hide them
		 */
		if($articleConfig['need_steps'] == 0) {
			$this->hideFieldFromForm("article_steps");
			$this->hideFieldFromSingleView("article_steps");
		}
		
		/**
		 * check, if tips are needed, else hide them
		 */
		if($articleConfig['need_tips'] == 0) {
			$this->hideFieldFromForm("article_tips");
			$this->hideFieldFromSingleView("article_tips");
		}
		
		/**
		 * check, if warnings are needed, else hide them
		 */
		if($articleConfig['need_warnings'] == 0) {
			$this->hideFieldFromForm("article_warnings");
			$this->hideFieldFromSingleView("article_warnings");
		}
		
		/**
		 * check, if licenses are needed, else hide them
		 */
		if($articleConfig['need_licenses'] == 0) {
			$this->hideFieldFromForm("article_license");
			$this->hideFieldFromSingleView("article_license");
		} else {
			$this->setControl("article_license", array("name" => "select_multi", "itemhandler" => "article", "method" => "getArticleLicense", "module" => "article"));
		}
		
		/**
		 * check, if 'needed things' are needed, else hide them
		 */
		if($articleConfig['need_needed_things'] == 0) {
			$this->hideFieldFromForm("article_needed");
			$this->hideFieldFromSingleView("article_needed");
		}
		
		/**
		 * check, if attachments are needed, else hide them
		 */
		if($articleConfig['need_attachments'] == 0) {
			$this->hideFieldFromForm(array("article_broken_file", "article_attachment", "article_attachment_alt"));
			$this->hideFieldFromSingleView(array("article_broken_file", "article_attachment", "article_attachment_alt"));
		} else {
			$this->setControl("article_attachment", "file");
			$this->setControl("article_broken_file", "yesno");
		}
		
		/**
		 * check, if videos are needed, else hide them
		 */
		if($articleConfig['need_videos'] == 0) {
			$this->hideFieldFromForm(array("article_broken_video", "article_video", "article_video_source", "article_video_upload", "article_video_upload_alt"));
			$this->hideFieldFromSingleView(array("article_video", "article_broken_video", "article_video_source", "article_video_upload", "article_video_upload_alt"));
		} else {
			$this->setControl("article_video_source", array("name" => "select", "itemhandler" => "article", "method" => "getVideoSources", "module" => "article"));
			$this->setControl("article_video_upload", "file");
			$this->setControl("article_broken_video", "yesno");
		}
		
		/**
		 * check, if history is needed, else hide it
		 */
		if($articleConfig['need_history'] == 0) {
			$this->hideFieldFromForm("article_history");
			$this->hideFieldFromSingleView("article_history");
		} else {
			$this->setControl("article_history", array("name" => "textarea", "form_editor" => "htmlarea"));
		}
		
		/**
		 * check, if relateds are needed, else hide them
		 */
		if($articleConfig['need_related'] == 0) {
			$this->hideFieldFromForm("article_related");
			$this->hideFieldFromSingleView("article_related");
		} else {
			$this->setControl("article_related", array("name" => "select_multi", "itemhandler" => "article", "method" => "getRelated", "module" => "article"));
		}
		
		/**
		 * check, if resources are needed, else hide them
		 */
		if($articleConfig['need_resources'] == 0) {
			$this->hideFieldFromForm("article_resources");
			$this->hideFieldFromSingleView("article_resources");
		} else {
			$this->setControl("article_resources", array("name" => "select_multi", "itemhandler" => "resources", "method" => "getResources", "module" => "article"));
		}
		
		/**
		 * check, if conclusion is needed, else hide it
		 */
		if($articleConfig['need_conclusion'] == 0) {
			$this->hideFieldFromForm("article_conclusion");
			$this->hideFieldFromSingleView("article_conclusion");
		} else {
			$this->setControl("article_conclusion", array("name" => "textarea", "form_editor" => "htmlarea"));
		}
		
		if($articleConfig['use_tags'] == 1) {
			$this->setControl("article_tags", array("name" => "select_multi", "itemhandler" => "tags", "method" => "getTags", "module" => "tags"));
		}
		
		$this->initiateSEO();
	}

	/**
	 * Overriding the icms_ipf_Object::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	function article_cid() {
		$ret = $this->getVar('article_cid', 's');
		$categories = $this->handler->getArticleCategories();
		return $categories;
	}
	
	public function getArticleCid() {
		$cid = $this->getVar ( 'article_cid', 's' );
		//$cids = explode(",", $cid);
		$article_category_handler = icms_getModuleHandler ( 'category',basename(dirname(dirname(__FILE__))), 'article' );
		$ret = array();
		foreach ($cid as $category) {
			$categoryObject = $article_category_handler->get($category);
			$ret[$category] = $categoryObject->getVar("category_title");
		}
		return implode(", ", $ret);
	}
	
	function article_license() {
		$ret = array($this->getVar('article_license', 's'));
		$license = $this->handler->getArticleLicense();
		return $license;
	}
	
	function article_related() {
		$ret = array($this->getVar('article_related', 's'));
		$related = $this->handler->getRelated();
		return $related;
	}
	
	public function article_video_sources() {
		$ret = array($this->getVar('article_video_sources', 's'));
		$sources = $this->handler->getArticleVideoSources();
		return $sources;
	}
	
	function article_tags() {
		$ret = $this->getVar('article_tags', 's');
		$tags = $this->handler->getArticleTags();
		return $tags;
	}
	
	public function article_active() {
		$active = $this->getVar('article_active', 'e');
		if ($active == false) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=visible">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/stop.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=visible">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/button_ok.png" alt="Online" /></a>';
		}
	}
	
	public function article_inblocks() {
		$active = $this->getVar('article_inblocks', 'e');
		if ($active == false) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeShow">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeShow">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Visible" /></a>';
		}
	}
	
	public function article_approve() {
		$active = $this->getVar('article_approve', 'e');
		if ($active == false) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Approved" /></a>';
		}
	}
	
	public function article_broken_file() {
		$active = $this->getVar('article_broken_file', 'e');
		if ($active == true) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Broken" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Online" /></a>';
		}
	}
	
	public function article_broken_video() {
		$active = $this->getVar('article_broken_video', 'e');
		if ($active == true) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Broken" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Online" /></a>';
		}
	}
	
	public function getDownloadWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}

	function article_grpperm() {
		$ret = $this->getVar('article_grpperm', 'e');
		$groups = $this->handler->getGroups();
		return $groups;
	}
	
	public function article_updater() {
		return icms_member_user_Handler::getUserLink($this->getVar('article_publisher', 'e'));
	}

	public function article_submitter() {
		return icms_member_user_Handler::getUserLink($this->getVar('article_publisher', 'e'));
	}
	
	/**
	 * preparing all fields for output
	 */
	
	public function getCategories() {
		$cids = array($this->getVar("article_category", "s"));
		$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
		$category = function($cid) {return $article_category_handler->get($cid);}; 
		$cids = array_map($category, $cids);
		$cid = array();
		foreach ($cids as $cid) {
			$cid['id'] = $cid['title'];
		}
		return implode(",", $cids);
	}
	
	public function getArticleImageTag($singleview = true) {
		$article_img = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$article_img = $this->getVar('article_image', 'e');
		if($singleview) {
			$document_root = str_replace('modules/' . $directory_name . '/singlearticle.php', '', $script_name);
			if (!$article_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/article/' . $article_img;
			}else {
				$image_tag = false;
			}
		} else {
			$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);
			if (!$article_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/article/' . $article_img;
			} else {
				$image_tag = false;
			}
		}
		return $image_tag;
	}
	
	public function getArticleTeaser() {
		$teaser = $this->getVar("article_teaser", "s");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "output");
		return $teaser;
	}
	
	public function getArticleSteps() {
		$steps = $this->getVar("article_steps", "s");
		if($steps != "") {
			$steps_array = explode("|", $steps);
			$ret = "";
			foreach($steps_array as $step) {
				$ret .= $step;
			}
		} else {
			$ret = FALSE;
		}
		return $ret;
	}
	
	public function getArticleTips() {
		$tips = $this->getVar("article_tips", "s");
		if($tips != "") {
			$tips_array = explode("|", $tips);
			$ret = "";
			foreach($tips_array as $tip) {
				$ret .= $tip;
			}
		} else {
			$ret = FALSE;
		}
		return $ret;
	}
	
	public function getArticleWarnings() {
		$warnings = $this->getVar("article_warnings", "s");
		if($warnings != "") {
			$warnings_array = explode("|", $warnings);
			$ret = "";
			foreach($warnings_array as $warning) {
				$ret .= $warning;
			}
		} else {
			$ret = FALSE;
		}
		return $ret;
	}
	
	public function getArticleLicense() {
		$licenses = $this->getVar("download_license", "s");
		if($licenses != "") {
			$license = implode(", ", $licenses);
			return $license;
		}
	}
	
	public function getArticleNeeded() {
		$neededs = $this->getVar("article_needed", "s");
		if($neededs != "") {
			$needed_array = explode("|", $neededs);
			$ret = "";
			foreach($needed_array as $needed) {
				$ret .= $needed;
			}
		} else {
			$ret = FALSE;
		}
		return $ret;
	}
	
	public function getArticleAttachment($url = TRUE, $path = FALSE ) {
		$file_alt = $this->getVar("article_attachment_alt", "e");
		$file = $this->getVar("article_attachment", "e");
		
		if($url){
			if(!$file_alt == "") {
				$url = ARTICLE_UPLOAD_URL . 'article/' . $file_alt;
			} elseif(!$file == "0") {
				$file = 'download_file';
				$fileObj = $this->getFileObj($file);
				$url = $fileObj->getVar('url');
			} else {
				$url = FALSE;
			}
			return $url;
		} elseif ($path){
			if(!$file_alt == "") {
				$path = ARTICLE_UPLOAD_ROOT . 'article/' . $file_alt;
			} elseif (!$file == "0") {
				$file = 'download_file';
				$fileObj = $this->getFileObj($file);
				$url = $fileObj->getVar('url', 's');
				$filename = basename($url);
				$path = ICMS_ROOT_PATH . '/uploads/article/article/' . $filename;
			} else {
				$path = FALSE;
			}
			return $path;
		}
	}
	
	public function getFileSize() {
		global $articleConfig;
		$myfile = $this->getArticleAttachment(FALSE, TRUE);
		if($myfile) {
			$bytes = filesize($myfile);
			$filesize = downloadsConvertFileSize($bytes, articleFileSizeType($articleConfig['display_file_size']), 2);
			return $filesize . '&nbsp;' . articleFileSizeType($articleConfig['display_file_size']) ;
		} else {
			return FALSE;
		}
	}
	
	public function getFileType() {
		$myfile = $this->getArticleAttachment(FALSE, TRUE);
		/**
		 * @TODO if going fully php 5.3 use finfo
		 */
		if($myfile) {
			$filetype = explode(".",$myfile);
			$last = (isset($filetype[count($filetype)-1])) ? $filetype[count($filetype)-1] : null;
			return $last;
		} else {
			return FALSE;
		}
	}
	
	public function getDownloadsLinks() {
		global $articleConfig;
		$downloads_array = $this->getVar('article_downloads' , 's');
		$downloadsModule = icms_getModuleInfo("downloads");
		if($downloadsModule && $articleConfig['use_downloads'] == 1) {
			$downloads_download_handler = icms_getModuleHandler("download", $downloadsModule->getVar("dirname"), "downloads");
			$downloads = implode(",", $downloads_array);
			$downloads2 = explode(",", $relateds);
			$result = '';
			foreach ($downloads2 as $download) {
				if($download != 0) {
					$link = $downloads_download_handler->getLink($related);
					$result .= '<li>' . $link . '</li>';
				}
			}
			return $result;
		} else {
			return FALSE;
		}
	}
	
	public function getArticleAlbum() {
		$album = $this->getVar("article_album", "e");
		if($album != "" && $album != 0) {
			return $album;
		} else {
			return FALSE;
		}
	}
	
	public function getArticleVideo() {
		global $articleConfig;
		if($articleConfig['need_videos'] == 1) {
			$video_upl_alt = $this->getVar("article_video_upload_alt", "e");
			$video_upl = $this->getVar("article_video_upl", "e");
			if($video_upl_alt != "") {
				$path = ARTICLE_UPLOAD_PATH . "article/" . $video_upl_alt;
			} elseif ($video_upl != "0") {
				$file = 'article_video_upl';
				$fileObj = $this->getFileObj($file);
				$url = $fileObj->getVar('url', 's');
				$filename = basename($url);
				$path = ICMS_ROOT_PATH . '/uploads/article/article/' . $filename;
			} else {
				$video = $this->getVar("article_video", "e");
				$source = $this->getVar("article_video_source");
				switch ($source) {
					//myTube Video
					case '1':
						$myTubeModule = icms_getModuleInfo("mytube");
						$mytubeConfig = icms_getModuleConfig($myTubeModule->getVar("dirname"));
						$upload_path = $mytubeConfig['videodir'];
						$path = ICMS_URL . $upload_path . '/' . $video;
						break;
					//YouTube
					case '2':
						$path = 'http://www.youtube.com/watch?v=' . $video;
						break;
					//MetaCafe
					case '3':
						$path = 'http://www.metacafe.com/watch/' . $video;
						break;
					//Spike/ifilm
					case '4':
						$path = 'http://www.ifilm.com/video/' . $video;
						break;
					//Viddler
					case '5':
						$path = 'http://www.viddler.com/player/' . $video;
						break;
					// MySpace TV
					case '6':
						$path = 'http://vids.myspace.com/index.cfm?fuseaction=vids.individual&videoid=' . $video;
						break;
					// Daily Motion
					case '7':
						$path = 'http://www.dailymotion.com/video/' . $video . '_blondesecretary_fun';
						break;
					// Blip.tv
					case '8':
						$path = 'http://blip.tv/play/' . $video;
						break;
					// Clip Fish
					case '9':
						$path = 'http://www.clipfish.de/player.php?videoid=' . $video;
						break;
					// LiveLeak
					case '10':
						$path = 'http://www.liveleak.com/view?i=' . $video;
						break;
					// Veoh	
					case '11':
						$path = 'http://www.veoh.com/videos/' . $video;
						break;
					// Vimeo
					case '12':
						$path = 'http://www.vimeo.com/' . $video;
						break;
					// MegaVideo
					case '13':
						$path = 'http://www.megavideo.com/?v=' . $video;
						break;
					// National Geographic
					case '14':
						$path = 'http://video.nationalgeographic.com/video/player/news/environment-news/' . $video . '.html';
						break;
				}
				return $path;
			}
		} else {
			return FALSE;
		}
	}

	public function getArticleHistory() {
		$history = $this->getVar("article_history", "s");
		$history = icms_core_DataFilter::checkVar($history, "html", "output");
		return $history;
	}
	
	public function getArticleRelated() {
		$related_array = $this->getVar("article_related" , 's');
		$relateds = implode(",", $related_array);
		$relateds2 = explode(",", $relateds);
		$result = '';
		foreach ($relateds2 as $related) {
			if($related != 0) {
				$link = $this->handler->getLink($related);
				$result .= '<li>' . $link . '</li>';
			}
		}
		return $result;
	}
	
	public function getArticleConclusion() {
		$conclusion = $this->getVar("article_conclusion", "s");
		if($conclusion != "") {
			$conclusion = icms_core_DataFilter::checkVar($conclusion, "html", "output");
		} else {
			$conclusion = FALSE;
		}
		return $conclusion;
	}
	
	public function getArticleTags($itemlink = FALSE) {
		$tags = $this->getVar('article_tags', 's');
		$sprocketsModule = icms_getModuleInfo("sprockets");
		if($sprocketsModule && $tags != "") {
			$sprockets_tag_handler = icms_getModuleHandler ( 'tag', $sprocketsModule->getVar("dirname"), 'sprockets' );
			$ret = array();
			if($itemlink == FALSE) {
				foreach ($tags as $tag) {
					$tagObject = $sprockets_tag_handler->get($tag);
					$ret[$tag] = $tagObject->getVar("title");
				}
			} else {
				foreach ($tags as $tag) {
					$tagObject = $sprockets_tag_handler->get($tag);
					$icon = $tagObject->getVar("icon", "e");
					if($icon != "") {
						$image = ICMS_URL . '/uploads/' . $sprocketsModule->getVar("dirname") . '/' . $tagObject->getVar("icon", "e");
						$title = $tagObject->getVar("title");
						
						$ret[$tag] = '<a href="' . $this->getTaglink($tag) . '" title="' . $tagObject->getVar("title") . '"><img width=16px height=16px src="'
							. $image . '" title="' . $title . '" alt="' . $title . '" />&nbsp;&nbsp;' . $tagObject->getVar("title") . '</a>' ;
					} else {
						$ret[$tag] = '<a href="' . $this->getTaglink($tag) . '" title="' . $tagObject->getVar("title") . '">' . $tagObject->getVar("title") . '</a>';
					}
				}
			}
			return implode(" | ", $ret);
		} else {
			return FALSE;
		}
	}

	public function getTagLink($tag) {
		$link = ARTICLE_URL . "index.php?op=getByTags&tag=" . $tag;
		return $link;
	}
	
	public function getArticlePublishedDate() {
		global $articleConfig;
		$date = '';
		$date = $this->getVar('article_published_date', 'e');
		
		return date($articleConfig['article_dateformat'], $date);
	}
	
	public function getArticleUpdatedDate() {
		global $articleConfig;
		$date = '';
		$date = $this->getVar('article_updated_date', 'e');
		
		return date($articleConfig['article_dateformat'], $date);
	}
	
	public function getArticleSubmitter($link = false) {
		$publisher_uid = $this->getVar('article_submitter', 'e');
		$userinfo = array();
		$userObj = icms::handler('icms_member')->getuser($publisher_uid);
		if (is_object($userObj)) {
			$userinfo['uid'] = $publisher_uid;
			$userinfo['uname'] = $userObj->getVar('uname');
			$userinfo['link'] = '<a href="' . ICMS_URL . '/userinfo.php?uid=' . $userinfo['uid'] . '">' . $userinfo['uname'] . '</a>';
		} else {
			global $icmsConfig;
			$userinfo['uid'] = 0;
			$userinfo['uname'] = $icmsConfig['anonymous'];
		}
		if ($link && $userinfo['uid']) {
			return $userinfo['link'];
		} else {
			return $userinfo['uname'];
		}
	}

	public function getArticleUpdater($link = false) {
		$publisher_uid = $this->getVar('article_updater', 'e');
		$userinfo = array();
		$userObj = icms::handler('icms_member')->getuser($publisher_uid);
		if (is_object($userObj)) {
			$userinfo['uid'] = $publisher_uid;
			$userinfo['uname'] = $userObj->getVar('uname');
			$userinfo['link'] = '<a href="' . ICMS_URL . '/userinfo.php?uid=' . $userinfo['uid'] . '">' . $userinfo['uname'] . '</a>';
		} else {
			global $icmsConfig;
			$userinfo['uid'] = 0;
			$userinfo['uname'] = $icmsConfig['anonymous'];
		}
		if ($link && $userinfo['uid']) {
			return $userinfo['link'];
		} else {
			return $userinfo['uname'];
		}
	}
	
	public function getArticlePublishers() {
		$publishers = $this->getVar("article_publisher", "s");
		$ret = array();
		foreach ($publishers as $publisher) {
			$ret[$publisher] = icms_member_user_Handler::getUserLink($publisher);
		}
		return implode(", ", $ret);
	}
	
	function userCanEditAndDelete() {
		global $article_isAdmin;
		if (!is_object(icms::$user)) return false;
		if ($downloads_isAdmin) return true;
		if($this->getVar('article_submitter', 'e') == icms::$user->getVar("uid")) return TRUE;
		$publishers = $this->getVar("article_publisher", "s");
		foreach ($publishers as $publisher) {
			if($publisher == icms::$user->getVar("uid")) return TRUE;
		}
	}
	
	function accessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$agroups = $gperm_handler->getGroupIds('module_admin', $module->getVar("mid"));
		$allowed_groups = array_intersect($groups, $agroups);
		$viewperm = $gperm_handler->checkRight('article_grpperm', $this->getVar('article_id', 'e'), $groups, $module->getVar("mid"));
		if ($this->userCanEditAndDelete()) {
			return true;
		}
		if ($viewperm && $this->getVar('article_active', 'e') == true) {
			return true;
		}
		if ($viewperm && $this->getVar('article_approve', 'e') == true) {
			return true;
		}
		if ($viewperm && count($allowed_groups) > 0) {
			return true;
		}
		return false;
	}
	
	function getItemLink($onlyUrl = false) {
		$seo = $this->handler->makelink($this);
		$url = DOWNLOADS_URL . 'singlearticle.php?article_id=' . $this -> getVar( 'article_id' ) . '&amp;article=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar( 'article_title' ) . ' ">' . $this -> getVar( 'article_title' ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . ARTICLE_ADMIN_URL . 'article.php?op=view&amp;article_id=' . $this->getVar('article_id', 'e') . '" title="' . _CO_ARTICLE_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . ARTICLE_URL . 'singlearticle.php?article_id=' . $this->getVar('article_id', 'e') . '" title="' . _CO_ARTICLE_PREVIEW . '" target="_blank">' . $this->getVar('article_title') . '</a>';
		return $ret;
	}
	
	
	
	public function toArray() {
		global $articleConfig;
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("article_id", "e");
		$ret['title'] = $this->getVar("article_title", "e");
		$ret['image'] = $this->getArticleImageTag(TRUE);
		$ret['teaser'] = $this->getArticleTeaser();
		$ret['body'] = $this->getVar("article_body", "e");
		$ret['version'] = $this->getVar("article_version", "e");
		$ret['steps'] = $this->getArticleSteps();
		$ret['tips'] = $this->getArticleTips();
		$ret['warnings'] = $this->getArticleWarnings();
		$ret['neededs'] = $this->getArticleNeeded();
		$ret['license'] = $this->getArticleLicense();
		$ret['file'] = $this->getArticleAttachment(TRUE, FALSE);
		$ret['filesize'] = $this->getFileSize();
		$ret['filetype'] = $this->getFileType();
		$ret['downloads'] = $this->getDownloadsLinks();
		$ret['album'] = $this->getArticleAlbum();
		$ret['video'] = $this->getArticleVideo();
		$ret['history'] = $this->getArticleHistory();
		$ret['tags'] = $this->getArticleTags();
		$ret['conclusion'] = $this->getArticleConclusion();
		$ret['publisher'] = $this->getArticlePublishers();
		$ret['submitter'] = $this->getArticleSubmitter(TRUE);
		$ret['updater'] = $this->getArticleUpdater(TRUE);
		$ret['published_on'] = $this->getArticlePublishedDate();
		$ret['updated_on'] = $this->getArticleUpdatedDate();
		$ret['counter'] = $this->getVar("counter", "e");
		$ret['like'] = $this->getVar("article_like", "e");
		$ret['dislike'] = $this->getVar("article_dislike", "e");
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['accessgranted'] = $this->accessGranted();
		/** related for single view **/
		$ret['active'] = $this->article_active();
		$ret['approve'] = $this->article_approve();
		$ret['inblocks'] = $this->article_inblocks();
		$ret['broken_file'] = $this->article_broken_file();
		$ret['broken_video'] = $this->article_broken_video();
		/** some configs **/
		$ret['thumbnail_width'] = $articleConfig['thumbnail_width'];
		$ret['thumbnail_height'] = $articleConfig['thumbnail_height'];
		$ret['display_width'] = $articleConfig['display_width'];
		$ret['display_height'] = $articleConfig['display_height'];
		
		return $ret;
	}

	function sendNotifArticlePublished() {
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$tags ['ARTICLE_TITLE'] = $this->getVar('article_title');
		$tags ['ARTICLE_URL'] = $this->getItemLink();
		icms::handler('icms_data_notification')->triggerEvent('global', 0, 'article_published', $tags, array(), $module->getVar('mid'));
	}

	function getReads() {
		return $this->getVar('counter');
	}

	function setReads($qtde = null) {
		$t = $this->getVar('counter');
		if (isset($qtde)) {
			$t += $qtde;
		} else {
			$t++;
		}
		$this->setVar('counter', $t);
	}
	
}