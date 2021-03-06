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
 * @version		$Id$
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", basename(dirname(dirname(__FILE__))));

include_once ICMS_ROOT_PATH . '/modules/' . basename(dirname(dirname(__FILE__))) . '/include/functions.php';

class ArticleArticle extends icms_ipf_seo_Object {
	
	public $updating_counter = FALSE;
	
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
		$this->quickInitVar("article_tags", XOBJ_DTYPE_ARRAY);
		$this->initCommonVar("article_additionals", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_informations", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_submitter", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_publisher", XOBJ_DTYPE_ARRAY);
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
		$this->initCommonVar("counter");
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("dobr", FALSE);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, 1);
		$this->quickInitVar("article_notification_sent", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_pagescount", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_comments", XOBJ_DTYPE_INT);
		$this->quickInitVar("article_stats_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		
		$this->setControl("article_cid", array("name" => "selectmulti", "itemHandler" => "article", "method" => "getArticleCategoryArray", "module" => "article"));
		$this->setControl("article_img_upl", "image");
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

		$this->hideFieldFromForm(array("article_updated_date", "article_published_date", "article_updater","article_stats_close", "article_statics", "article_submitter", "weight", "counter", "article_comments", "article_notification_sent", "article_pagescount" ));
		
		$this->openFormSection("article_descriptions", _CO_ARTICLE_ARTICLE_ARTICLE_DESCRIPTIONS);
		$this->openFormSection("article_additionals", _CO_ARTICLE_ARTICLE_ARTICLE_ADDITIONALS);
		$this->openFormSection("article_informations", _CO_ARTICLE_ARTICLE_ARTICLE_INFORMATIONS);
		$this->openFormSection("article_permissions", _CO_ARTICLE_ARTICLE_ARTICLE_PERMISSIONS);
		//$this->openFormSection("article_statics", _CO_ARTICLE_ARTICLE_ARTICLE_STATICS);
		$sprocketsModule = icms_getModuleInfo("sprockets");
		if(!icms_get_module_status("sprockets")) {
			$this->hideFieldFromForm("article_tags");
			$this->hideFieldFromSingleView("article_tags");
		} elseif ($articleConfig['use_sprockets'] == 1) {
			$this->setControl("article_tags", array("name" => "selectmulti", "itemHandler" => "article", "method" => "getArticleTags", "module" => "article"));
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
		 * check, if relateds are needed, else hide them
		 */
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
		
		$this->initiateSEO();
	}

	public function article_active() {
		$active = $this->getVar('article_active', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=visible">
				<img src="' . ARTICLE_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=visible">
				<img src="' . ARTICLE_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function article_inblocks() {
		$active = $this->getVar('article_inblocks', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeShow">
				<img src="' . ARTICLE_IMAGES_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeShow">
				<img src="' . ARTICLE_IMAGES_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	public function article_approve() {
		$active = $this->getVar('article_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeApprove">
				<img src="' . ARTICLE_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeApprove">
				<img src="' . ARTICLE_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function article_broken_file() {
		$active = $this->getVar('article_broken_file', 'e');
		if ($active == TRUE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . ARTICLE_IMAGES_URL . 'denied.png" alt="Broken" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'article.php?article_id=' . $this->getVar('article_id') . '&amp;op=changeBroken">
				<img src="' . ARTICLE_IMAGES_URL . 'approved.png" alt="Online" /></a>';
		}
	}
	
	public function getArticleWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	/**
	 * preparing all fields for output
	 */
	
	public function getArticleCid($itemlink = FALSE) {
		$cid = $this->getVar ( "article_cid", "s");
		$article_category_handler = icms_getModuleHandler ( "category",basename(dirname(dirname(__FILE__))), "article");
		$ret = array();
		if($itemlink == FALSE) {
			foreach ($cid as $category) {
				$categoryObject = $article_category_handler->get($category);
				$ret[$category] = $categoryObject->getVar("category_title");
			}
		} else {
			foreach ($cid as $category) {
				$categoryObject = $article_category_handler->get($category);
				$ret[$category] = $categoryObject->getItemLink(FALSE);
			}
		}
		return implode(" | ", $ret);
	}
	
	public function getArticleImageTag($singleview = TRUE) {
		$article_img = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$article_img = $this->getVar('article_img', 'e');
		if($singleview) {
			$document_root = str_replace('modules/' . $directory_name . '/singlearticle.php', '', $script_name);
			if (!$article_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/article/' . $article_img;
			}else {
				$image_tag = FALSE;
			}
		} else {
			$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);
			if (!$article_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/article/' . $article_img;
			} else {
				$image_tag = FALSE;
			}
		}
		return $image_tag;
	}
	
	public function getArticleTeaser() {
		$teaser = $this->getVar("article_teaser", "s");
		$teaser = icms_core_DataFilter::checkVar($teaser, "html", "output");
		return $teaser;
	}
	
	public function myBody() {
		if($this->getVar("article_show_teaser", "e") == 1) {
			$body = icms_core_DataFilter::checkVar($this->getVar("article_teaser", "s"), "html", "output");
			$body .= $this->getVar("article_body", "s");
		} else {
			$body = $this->getVar("article_body", "s");
		}
		return $body;
	}
	
	public function getArticleBody() {
		$body = $this->myBody();
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
		$file_alt = trim($this->getVar("article_attachment_alt", "e"));
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
			$url = $linkObj->getVar("url");
			return $url;
		}
	}
	
	public function getArticleRelated() {
		$related_array = $this->getVar("article_related" , "s");
		if(!$related_array == "" && $related_array != 0) {
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
	
	public function getArticleTags($itemlink = FALSE) {
		$tags = $this->getVar("article_tags", "s");
		$sprocketsModule = icms_getModuleInfo("sprockets");
		if(icms_get_module_status("sprockets") && $tags != "") {
			$sprockets_tag_handler = icms_getModuleHandler ( "tag", $sprocketsModule->getVar("dirname"), "sprockets");
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
					$title = $tagObject->getVar("title");
					$dsc = $tagObject->getVar("description", "s");
					$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodehigh");
					$dsc = icms_core_DataFilter::undoHtmlSpecialChars($dsc);
					$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodelow");
					if($icon != "") {
						$ret[$tag]['icon'] = ICMS_URL . '/uploads/' . $sprocketsModule->getVar("dirname") . '/' . $tagObject->getVar("icon", "e");
					}
					$ret[$tag]['title'] = $title;
					$ret[$tag]['link'] = $this->getTaglink($tag);
					if($dsc != "") {
						$ret[$tag]['dsc'] = $dsc;
					}
				}
			}
			return $ret;
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
		$date = $this->getVar("article_published_date", "e");
		
		return date($articleConfig['article_dateformat'], $date);
	}
	
	public function getArticleUpdatedDate() {
		global $articleConfig;
		$date = '';
		$date = $this->getVar("article_updated_date", "e");
		if($date != 0) {
			return date($articleConfig['article_dateformat'], $date);
		}
	}
	
	public function getArticleSubmitter() {
		$publisher_uid = $this->getVar("article_submitter", "e");
		if($publisher_uid != "") {
			return icms_member_user_Handler::getUserLink($publisher_uid);
		}
	}

	public function getArticleUpdater() {
		$publisher_uid = $this->getVar("article_updater", "e");
		if($publisher_uid != "") {
			return icms_member_user_Handler::getUserLink($publisher_uid);
		}
	}
	
	public function getArticlePublishers($userlink = TRUE, $avatar= FALSE) {
		$publishers = $this->getVar("article_publisher", "s");
		$ret = array();
		if($avatar) {
			foreach ($publishers as $publisher) {
				$link = icms_member_user_Handler::getUserLink($publisher);
				$ret[$publisher]['avatar'] = icms::handler("icms_member")->getUser($publisher)->gravatar();
				$ret[$publisher]['publisher'] = icms_member_user_Handler::getUserLink($publisher);
			}
			return $ret;
		} elseif ($userlink) {
			foreach ($publishers as $publisher) {
				$ret[$publisher] = icms_member_user_Handler::getUserLink($publisher);
			}
			return implode(", ", $ret);
		} else {
			foreach ($publishers as $publisher) {
				$uname = icms::handler('icms_member')->getUser($publisher)->getVar("uname");
				$ret[$publisher]['avatar'] = icms::handler("icms_member")->getUser($publisher)->gravatar();
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
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(ARTICLE_DIRNAME);
		$viewperm = $gperm_handler->checkRight('article_grpperm', $this->id(), $groups, $module->getVar("mid"));
		if ($this->userCanEditAndDelete()) {return TRUE;}
		if ($viewperm && $this->isActive() && $this->isApproved() ) {return TRUE;}
		return FALSE;
	}
	
	function getItemLink($onlyUrl = FALSE) {
		$url = ARTICLE_URL . 'singlearticle.php?article=' . $this->short_url();
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this->title() . ' ">' . $this->title() . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . ARTICLE_ADMIN_URL . 'article.php?op=view&amp;article_id=' . $this->getVar('article_id', 'e') . '" title="' . _CO_ARTICLE_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . ARTICLE_URL . 'singlearticle.php?article_id=' . $this->getVar('article_id', 'e') . '" title="' . _CO_ARTICLE_PREVIEW . '" target="_blank">' . $this->getVar('article_title') . '</a>';
		return $ret;
	}
	
	public function getArticleImagePath() {
		$image = $this->getVar("article_img", "e");
		if(($image != "") && ($image != "0")) {
			$path = ICMS_URL . '/uploads/article/article/' . $image;
			return $path;
		} else {
			return FALSE;
		}
	}
	
	public function displayNewIcon() {
		$time = $this->getVar("article_published_date", "e");
		$timestamp = time();
		$newarticle = article_display_new($time, $timestamp);
		return $newarticle;
	}
	
	public function displayUpdatedIcon() {
		$time = $this->getVar("article_updated_date", "e");
		$timestamp = time();
		$newarticle = article_display_updated($time, $timestamp);
		return $newarticle;
	}
	
	public function displayPopularIcon() {
		$popular = article_display_popular($this->getVar("counter"));
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
		$ret['id'] = $this->getVar("article_id", "e");
		$ret['title'] = $this->getVar("article_title", "e");
		$ret['cats'] = $this->getArticleCid(TRUE);
		$ret['index_img'] = $this->getArticleImageTag(FALSE);
		$ret['image'] = $this->getArticleImageTag(TRUE);
		$ret['imgpath'] = $this->getArticleImagePath();
		$ret['teaser'] = $this->getArticleTeaser();
		$ret['body_array'] = $this->getArticleBody();
		$ret['conclusion'] = $this->getArticleConclusion();
		$ret['file'] = $this->getArticleAttachment();
		$ret['demo'] = $this->getDemoLink();
		$ret['tags'] = $this->getArticleTags(TRUE);
		$ret['related'] = $this->getArticleRelated();
		$ret['publisher'] = $this->getArticlePublishers(TRUE, FALSE);
		$ret['bypublisher'] = $this->getArticlePublishers(FALSE, FALSE);
		$ret['avatar'] = $this->getArticlePublishers(FALSE, TRUE);
		$ret['submitter'] = $this->getArticleSubmitter();
		$ret['updater'] = $this->getArticleUpdater();
		$ret['published_on'] = $this->getArticlePublishedDate();
		$ret['updated_on'] = $this->getArticleUpdatedDate();
		$ret['counter'] = $this->getVar("counter", "e");
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['accessgranted'] = $this->accessGranted();
		$ret['article_is_new'] = $this->displayNewIcon();
		$ret['article_is_updated'] = $this->displayUpdatedIcon();
		$ret['article_popular'] = $this->displayPopularIcon();
		return $ret;
	}

	function sendArticleNotification($case) {
		$valid_case = array("new_article", "article_submitted", "article_modified");
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
			if($user > 0) {
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