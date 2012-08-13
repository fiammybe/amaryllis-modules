<?php
/**
 * "Article" is an article management module for ImpressCMS
 *
 * File: /class/Article.php
 * 
 * Class representing Article article Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: Article.php 670 2012-07-04 12:55:18Z st.flohrer $
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", basename(dirname(dirname(__FILE__))));
if(icms_get_module_status("index")) $indexModule = icms_getModuleInfo("index");
require_once ICMS_ROOT_PATH . '/modules/' . $indexModule->getVar("dirname") . '/include/functions.php';

class ArticleArticle extends icms_ipf_seo_Object {
	
	public $updating_counter = FALSE;
	
	public $_updating_tags = FALSE;
	
	public $_article_thumbs;
	
	public $_article_images;
	
	public $_article_images_url;
	
	public $_article_thumbs_url;
	
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
		$this->initCommonVar("short_url");
		$this->quickInitVar("article_cid", XOBJ_DTYPE_ARRAY, FALSE);
		
		$this->quickInitVar("article_descriptions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_img", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_img_upl", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("article_teaser", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("article_show_teaser", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("article_body", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_conclusion", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_descriptions_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->initCommonVar("article_additionals", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_attachment", XOBJ_DTYPE_FILE, FALSE);
		$this->quickInitVar("article_attachment_alt", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_demo", XOBJ_DTYPE_URLLINK);
		$this->quickInitVar("article_related", XOBJ_DTYPE_ARRAY);
		$this->quickInitVar("article_tags", XOBJ_DTYPE_TXTBOX);
		$this->initCommonVar("article_additionals", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_informations", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_submitter", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("article_publisher", XOBJ_DTYPE_ARRAY, TRUE);
		$this->quickInitVar("article_updater", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_published_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("article_updated_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("article_informations_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_permissions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_approve", XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 1);
		$this->quickInitVar("article_active", XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 1);
		$this->quickInitVar("article_updated", XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 0);
		$this->quickInitVar("article_inblocks", XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 1);
		$this->quickInitVar("article_broken_file", XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 0);
		$this->quickInitVar("article_cancomment", XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 1);
		$this->quickInitVar("article_permissions_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_statics", XOBJ_DTYPE_FORM_SECTION);
		$this->initCommonVar("weight");
		$this->initCommonVar("counter", FALSE, 0);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("dobr", FALSE);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, 1);
		$this->quickInitVar("article_notification_sent", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_pagescount", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_comments", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("article_stats_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->setControl("article_img_upl", "imageupload");
		$this->setControl("article_img", array( "name" => "select", "itemHandler" => "article", "method" => "getImageList", "module" => "article"));
		$this->setControl("article_teaser", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("article_show_teaser", "yesno");
		$this->setControl("article_body", "dhtmltextarea");
		$this->setControl("article_publisher", "user_multi");
		$this->setControl("article_approve", "yesno");
		$this->setControl("article_active", "yesno");
		$this->setControl("article_updated", "yesno");
		$this->setControl("article_inblocks", "yesno");
		$this->setControl("article_broken_file", "yesno");
		$this->setControl("article_cancomment", "yesno");
		
		$this->openFormSection("article_descriptions", _CO_ARTICLE_ARTICLE_ARTICLE_DESCRIPTIONS);
		$this->openFormSection("article_additionals", _CO_ARTICLE_ARTICLE_ARTICLE_ADDITIONALS);
		$this->openFormSection("article_informations", _CO_ARTICLE_ARTICLE_ARTICLE_INFORMATIONS);
		$this->openFormSection("article_permissions", _CO_ARTICLE_ARTICLE_ARTICLE_PERMISSIONS);
		//$this->openFormSection("article_statics", _CO_ARTICLE_ARTICLE_ARTICLE_STATICS);
		if(!icms_get_module_status("index")) {
			$this->hideFieldFromForm("article_tags");
			$this->hideFieldFromSingleView("article_tags");
		}
		if(icms_get_module_status("index")) {
			$this->setControl("article_cid", array("name" => "selectmulti", "itemHandler" => "article", "method" => "getArticleCategoryArray", "module" => "article"));
		}
		if($articleConfig['need_attachments'] == 0) {
			$this->hideFieldFromForm(array("article_broken_file", "article_attachment", "article_attachment_alt"));
			$this->hideFieldFromSingleView(array("article_broken_file", "article_attachment", "article_attachment_alt"));
		} else {
			$this->setControl("article_attachment", "file");
			$this->setControl("article_broken_file", "yesno");
		}
		
		if($articleConfig['need_related'] == 0) {
			$this->hideFieldFromForm("article_related");
			$this->hideFieldFromSingleView("article_related");
		} else {
			$this->setControl("article_related", array("name" => "selectmulti", "itemHandler" => "article", "method" => "getRelated", "module" => "article"));
		}
		if($articleConfig['need_demo_link'] == 0) {
			$this->hideFieldFromForm("article_demo");
			$this->hideFieldFromSingleView("article_demo");
		}
		
		if($articleConfig['need_conclusion'] == 0) {
			$this->hideFieldFromForm("article_conclusion");
			$this->hideFieldFromSingleView("article_conclusion");
		} else {
			$this->setControl("article_conclusion", "dhtmltextarea");
		}
		$this->_article_thumbs = $this->handler->getArticleThumbsPath();
		$this->_article_images = $this->handler->getArticleImagesPath();
		$this->_article_images_url = ICMS_URL . "/cache/" . $this->handler->_moduleName . "/" . $this->handler->_itemname . "/images/";
		$this->_article_thumbs_url = ICMS_URL . "/cache/" . $this->handler->_moduleName . "/" . $this->handler->_itemname . "/thumbs/";
		$this->initiateSEO();
		//hide static fields
		$this->hideFieldFromForm(array("article_updated_date", "article_published_date", "article_updater","article_stats_close", "article_statics", "article_submitter", "weight", "counter",
		 								"article_comments", "article_notification_sent", "article_pagescount", "meta_keywords". "meta_description" ));
	}
	
	public function article_active() {
		$active = $this->getVar('article_active', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=visible">
				<img src="' . INDEX_ICONS_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=visible">
				<img src="' . INDEX_ICONS_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function article_inblocks() {
		$active = $this->getVar('article_inblocks', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeShow">
				<img src="' . INDEX_ICONS_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeShow">
				<img src="' . INDEX_ICONS_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	public function article_approve() {
		$active = $this->getVar('article_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeApprove">
				<img src="' . INDEX_ICONS_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeApprove">
				<img src="' . INDEX_ICONS_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function article_broken_file() {
		$active = $this->getVar('article_broken_file', 'e');
		if ($active == TRUE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . INDEX_ICONS_URL . 'denied.png" alt="Broken" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . INDEX_ICONS_URL . 'approved.png" alt="Online" /></a>';
		}
	}
	
	public function getArticleWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	function needDobr() {
		global $icmsConfig;
		$article_module = icms_getModuleInfo(ARTICLE_DIRNAME);
		$groups = icms::$user->getGroups();
		if (file_exists(ICMS_EDITOR_PATH . "/" . $icmsConfig['editor_default'] . "/xoops_version.php") && icms::handler('icms_member_groupperm')->checkRight('use_wysiwygeditor', $article_module->getVar("mid"), $groups)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	/**
	 * preparing all fields for output
	 */
	public function getArticleCid($itemlink = FALSE) {
		$cid = $this->getVar("article_cid", "s");
		if(icms_get_module_status("index")) {
			$indexModule = icms_getModuleInfo("index");
			$category_handler = icms_getModuleHandler("category", "index");
			$criteria = $category_handler->getCategoryCriterias(FALSE, TRUE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);
			$critTray = new icms_db_criteria_Compo();
			foreach ($cid as $cat) {
				$critTray->add(new icms_db_criteria_Item("category_id", $cat), 'OR');
			}
			$criteria->add($critTray);
			$catObjects = $category_handler->getObjects($criteria, TRUE, FALSE);
			if(!$itemlink) {
				foreach ($catObjects as $category) {
					$ret[$category['id']] = $category['title'];
				}
				$ret = implode(", ", $ret);
			} else {
				foreach ($catObjects as $category) {
					$ret[$category['id']] = $category['seoLink'];
				}
				$ret = implode(", ", $ret);
			}
			unset($category_handler, $catObjects, $criteria, $indexModule);
			return $ret;
		}
		return FALSE;
	}
	
	public function getArticleImage($thumb = FALSE) {
		global $articleConfig;
		$article_img = $cached_img = $cached_image_url = $srcpath = $image = "";
		$article_img = $this->getVar('article_img', 'e');
		if(!$article_img == "" && !$article_img == "0" && icms_get_module_status("index")) {
			$cached_img = ($thumb == FALSE) ? $this->_article_images . $article_img : $this->_article_thumbs . $article_img;
			$cached_image_url = ($thumb == FALSE) ? $this->_article_images_url . $article_img : $this->_article_thumbs_url . $article_img;
			if(!is_file($cached_img)) {
			    require_once ICMS_MODULES_PATH . '/index/class/IndexImage.php';
				$srcpath = ARTICLE_UPLOAD_ROOT . $this->handler->_itemname . "/";
				$image = new IndexImage($article_img, $srcpath);
				$image->resizeImage( ($thumb == FALSE) ? $articleConfig['display_width'] : $articleConfig['thumbnail_width'], 
										($thumb == FALSE) ? $articleConfig['display_height'] : $articleConfig['thumbnail_height'],
										($thumb == FALSE) ? $this->_article_images : $this->_article_thumbs, "100");
				unset($srcpath, $image);
			}
			unset($cached_img, $article_img, $thumb);
			return $cached_image_url;
		}
		return FALSE;
	}
	
	public function getArticleTeaser() {
		$teaser = $this->getVar("article_teaser", "s");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "output");
		return $teaser;
	}
	
	public function getArticleBody() {
		if($this->getVar("article_show_teaser", "e") == 1) {
			$body = $this->getArticleTeaser();
			$body .= "<br />" . $this->getVar("article_body", "s");
		} else {
			$body = $this->getVar("article_body", "s");
		}
		$body_array = explode("[pagebreak]", $body);
		return $body_array;
	}
	
	public function getArticleConclusion() {
		$conclusion = $this->getVar("article_conclusion", "s");
		if($conclusion != "") {
			$conclusion = icms_core_DataFilter::checkVar($conclusion, "html", "output");
			return $conclusion;
		}
	}
	
	public function getArticleAttachment() {
		global $articleConfig;
		$file_alt = $this->getVar("article_attachment_alt", "e");
		$file = $this->getVar("article_attachment", "e");
		$ret = FALSE;
		if(!$file_alt == "") {
			$url = ARTICLE_UPLOAD_URL . 'article/' . $file_alt;
			$path = ARTICLE_UPLOAD_ROOT . $this->handler->_itemname . '/' . $file_alt;
			
			$filename = basename($url);
			$bytes = filesize($path);
			$filesize = articleConvertFileSize($bytes, articleFileSizeType($articleConfig['display_file_size']), 2);
			$filetype = array_pop(explode(".",$path));
			$ret['url'] = $url;
			$ret['filename'] = $filename;
			$ret['filesize'] =  $filesize . '&nbsp;' . articleFileSizeType($articleConfig['display_file_size']) ;
			$ret['filetype'] = $filetype;
			unset($file, $file_alt, $url, $path, $filename, $bytes, $filesize, $filetype);
		} elseif(!$file == "0") {
			$ret = array();
			$file = 'article_attachment';
			$fileObj = $this->getFileObj($file);
			$url = $fileObj->getVar('url', 's');
			$filename = basename($url);
			$path = ICMS_ROOT_PATH . '/uploads/article/article/' . $filename;
			$bytes = filesize($path);
			$filesize = articleConvertFileSize($bytes, articleFileSizeType($articleConfig['display_file_size']), 2);
			$filetype = array_pop(explode(".",$path));
			$ret['url'] = $url;
			$ret['filename'] = $filename;
			$ret['filesize'] =  $filesize . '&nbsp;' . articleFileSizeType($articleConfig['display_file_size']) ;
			$ret['filetype'] = $filetype;
			unset($file, $file_alt, $url, $path, $filename, $bytes, $filesize, $filetype);
		} 
		return $ret;
	}
	
	public function getDemoLink() {
		if($this->getVar("article_demo") != 0) {
			$demo = 'article_demo';
			$linkObj = $this-> getUrlLinkObj($demo);
			return $linkObj->getVar("url");
		}
	}
	
	public function getArticleRelated() {
		$related_array = $this->getVar("article_related" , "s");
		if(!$related_array == "" && $related_array != "0") {
			$result = '';
			foreach ($related_array as $related) {
				if($related != 0) {
					$link = $this->handler->getLink($related);
					$result .= '<li>' . $link . '</li>';
				}
			}
			return $result;
		}
	}
	
	public function getArticleTags($namesOnly = TRUE) {
		$tags = $this->getVar("article_tags", "e");
		if(icms_get_module_status("index") && $tags != "" && $tags != "0") {
			$tags = explode(",", $tags);
			$indexModule = icms_getModuleInfo("index");
			$tag_handler = icms_getModuleHandler ( "tag", $indexModule->getVar("dirname"), "index");
			$criteria = new icms_db_criteria_Compo();
			foreach ($tags as $key => $tag) {
				$criteria->add(new icms_db_criteria_Item("tag_id", $tag), "OR");
			}
			$tags = $tag_handler->getObjects($criteria, TRUE, FALSE);
			unset($indexModule, $tag_handler);
			if($namesOnly) {
				$ret = array();
				foreach ($tags as $key => $value) {
					$ret[] = $value['name'];
				}
				return implode(",", $ret);
			}
			return $tags;
		}
	}
	
	public function getArticlePublishedDate() {
		global $articleConfig;
		$date = $this->getVar("article_published_date", "e");
		return date($articleConfig['article_dateformat'], $date);
	}
	
	public function getArticleUpdatedDate() {
		global $articleConfig;
		$date = $this->getVar("article_updated_date", "e");
		return ($date != 0) ? date($articleConfig['article_dateformat'], $date) : FALSE;
	}
	
	public function getArticleSubmitter() {
		$publisher_uid = $this->getVar("article_submitter", "e");
		return ($publisher_uid != "") ? icms_member_user_Handler::getUserLink($publisher_uid) : FALSE;
	}

	public function getArticleUpdater() {
		$publisher_uid = $this->getVar("article_updater", "e");
		return ($publisher_uid != "") ? icms_member_user_Handler::getUserLink($publisher_uid) : FALSE;
	}
	
	public function getArticlePublishers($byPublisher = FALSE) {
		$publishers = $this->getVar("article_publisher", "s");
		$ret = array();
		if(!$byPublisher) {
			foreach ($publishers as $publisher) {
				$ret[$publisher]['avatar'] = icms::handler("icms_member")->getUser($publisher)->gravatar();
				$ret[$publisher]['publisher'] = icms_member_user_Handler::getUserLink($publisher);
			}
			return $ret;
		} else {
			foreach ($publishers as $publisher) {
				$user = icms::handler("icms_member")->getUser($publisher);
				$uname = $user->getVar("uname");
				$ret[$publisher]['avatar'] = $user->gravatar();
				$ret[$publisher]['publisher'] = '<a href="' . ARTICLE_URL . 'index.php?op=getByAuthor&uid=' . $publisher . '" title="' . _CO_ARTICLE_ARTICLE_GET_BY_AUTHOR . '&nbsp;' . $uname . '">' . $uname . '</a>';
			}
			return $ret;
		}
	}
	
	function userCanEditAndDelete() {
		global $article_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($article_isAdmin) return TRUE;
		if($this->getVar('article_submitter', 'e') == icms::$user->getVar("uid")) return TRUE;
		$publishers = $this->getVar("article_publisher", "s");
		foreach ($publishers as $publisher) {
			return $publisher == icms::$user->getVar("uid");
		}
	}
	
	function accessGranted() {
		if ($this->userCanEditAndDelete()) return TRUE;
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(ARTICLE_DIRNAME);
		$viewperm = $gperm_handler->checkRight('article_grpperm', $this->getVar('article_id', 'e'), $groups, $module->getVar("mid"));
		if ($this->userCanEditAndDelete()) return TRUE;
		if ($viewperm && $this->isActive() && $this->isApproved()) return TRUE;
		return FALSE;
	}
	
	public function getItemLink($onlyurl = FALSE, $seo = TRUE) {
		$cat_id = array_shift($this->getVar("article_cid"));
		$category_handler = icms_getModuleHandler("category", "index");
		$cat = $category_handler->get($cat_id);
		$cattarget = ($seo = TRUE) ? '&cat=' . $cat->short_url() : '&category_id=' . $cat->id();
		$urltarget = ($seo) ? 'article=' . $this->short_url() : 'article_id=' . $this->id();
		$url = ICMS_MODULES_URL . "/" . ARTICLE_DIRNAME . "/singlearticle.php?" . $urltarget . $cattarget;
		if($onlyurl) return $url;
		return '<a href="' . $url . '" title="' . $this->title() . '" class="article_itemlink">' . $this->title() . '</a>'; 
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . ARTICLE_ADMIN_URL . 'article.php?op=view&amp;article_id=' . $this->getVar('article_id', 'e') . '" title="' . _CO_ARTICLE_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . ARTICLE_URL . 'singlearticle.php?article_id=' . $this->getVar('article_id', 'e') . '" title="' . _CO_ARTICLE_PREVIEW . '" target="_blank">' . $this->getVar('article_title') . '</a>';
		return $ret;
	}
	
	public function displayNewIcon() {
		$time = $this->getVar("article_published_date", "e");
		$timestamp = time();
		$newarticle = index_display_new($time, $timestamp);
		return $newarticle;
	}
	
	public function displayUpdatedIcon() {
		$time = $this->getVar("article_updated_date", "e");
		$timestamp = time();
		$newarticle = index_display_updated($time, $timestamp);
		return $newarticle;
	}
	
	public function displayPopularIcon() {
		$popular = index_display_popular($this->getVar("counter"));
		return $popular;
	}
	
	public function userCanComment() {
		return ($this->getVar("article_cancomment", "e") == 1) ? TRUE : FALSE;
	}
	
	public function isActive() {
		return ($this->getVar("article_active", "e") == 1) ? TRUE : FALSE;
	}
	
	public function isApproved() {
		return ($this->getVar("article_approve", "e") == 1) ? TRUE : FALSE;
	}
	
	public function notifSent() {
		return ($this->getVar("article_notification_sent", "e") == 1) ? TRUE : FALSE;
	}
	
	public function toArray() {
		global $articleConfig;
		$ret = parent::toArray();
		$ret['id'] = $this->id();
		$ret['title'] = $this->title();
		$ret['cats'] = $this->getArticleCid(TRUE);
		$ret['thumb'] = $this->getArticleImage(TRUE);
		$ret['image'] = $this->getArticleImage(FALSE);
		$ret['teaser'] = $this->getArticleTeaser();
		$ret['body_array'] = $this->getArticleBody();
		$ret['conclusion'] = $this->getArticleConclusion();
		$ret['file'] = $this->getArticleAttachment();
		$ret['demo'] = $this->getDemoLink();
		$ret['tags'] = $this->getArticleTags(FALSE);
		$ret['related'] = $this->getArticleRelated();
		$ret['bypublisher'] = $this->getArticlePublishers(TRUE);
		$ret['avatar'] = $this->getArticlePublishers(FALSE);
		$ret['submitter'] = $this->getArticleSubmitter();
		$ret['updater'] = $this->getArticleUpdater();
		$ret['published_on'] = $this->getArticlePublishedDate();
		$ret['updated_on'] = $this->getArticleUpdatedDate();
		$ret['counter'] = $this->getVar("counter", "e");
		$ret['comments'] = $this->getVar("article_comments", "e");
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['accessgranted'] = $this->accessGranted();
		$ret['article_is_new'] = $this->displayNewIcon();
		$ret['article_is_updated'] = $this->displayUpdatedIcon();
		$ret['article_popular'] = $this->displayPopularIcon();
		return $ret;
	}

	function sendArticleNotification($case) {
		$valid_case = array("new_article", "article_submitted", "article_modified", "article_approved", "article_file_broken");
		if(in_array($case, $valid_case, TRUE)) {
			$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
			$mid = $module->getVar('mid');
			$tags ['ARTICLE_TITLE'] = $this->getVar('article_title');
			$tags ['ARTICLE_URL'] = $this->getItemLink(FALSE);
			$tags ['ARTICLE_CATS'] = $this->getArticleCid(TRUE);
			switch ($case) {
				case 'article_submitted':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
				
				case 'article_modified':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
			}
			icms::handler('icms_data_notification')->triggerEvent($category, $file_id, $case, $tags, $recipient, $mid);
		}
	}

	public function sendMessageBroken() {
		$message = _CO_ARTICLE_ARTICLE_MESSAGE_BDY;
		$message .= '<br />' . _CO_ARTICLE_ARTICLE_ARTICLE_CID . ' : ' . $this->getArticleCid(TRUE);
		$message .= '<br />' . _CO_ARTICLE_ARTICLE_ARTICLE_TITLE . ' : ' . $this->getItemLink(FALSE);
		$myuid = is_object(icms::$user) ? icms::$user : new icms_member_user_Object;
		$group = icms_member_group_Handler::get("1");
		$pmObj = new icms_messaging_Handler();
		$pmObj->setFromUser($myuid);
		$pmObj->setBody($message);
		$pmObj->setSubject(_CO_ARTICLE_ARTICLE_MESSAGE_SBJ);
		$pmObj->usePM();
		$pmObj->setToGroups($group);
		$pmObj->send();
		return TRUE;
	}
	
	public function sendMessageApproved() {
		$pm_handler = icms::handler('icms_data_privmessage');
		$file = "article_approved.tpl";
		$lang = "language/" . $icmsConfig['language'] . "/mail_template";
		$tpl = ARTICLE_ROOT_PATH . "$lang/$file";
		if (!file_exists($tpl)) {
			$lang = 'language/english/mail_template';
			$tpl = ARTICLE_ROOT_PATH . "$lang/$file";
		}
		$users = $this->getVar("article_publisher", "s");
		$user_array = explode(",", $users);
		$message = file_get_contents($tpl);
		$message = str_replace("{ARTICLE_CATS}", $this->getArticleCid(FALSE), $message);
		$message = str_replace("{ARTICLE_TITLE}", $this->title(), $message);
		foreach ($users as $user) {
			$uname = icms::handler('icms_member_user')->get($user)->getVar("uname");
			$message = str_replace("{X_UNAME}", $uname, $message);
			$pmObj = $pm_handler->create(TRUE);
			$pmObj->setVar("subject", _CO_ARTICLE_HAS_APPROVED);
			$pmObj->setVar("from_userid", 1);
			$pmObj->setVar("to_userid", (int)$user);
			$pmObj->setVar("msg_time", time());
			$pmObj->setVar("msg_text", $message);
			$pm_handler->insert($pmObj, TRUE); //$this->setErrors("PM Not sent") ;
		}
	}
}