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
		$this->quickInitVar("article_body", XOBJ_DTYPE_TXTAREA, TRUE);
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
		
		
		$this->setControl("article_cid", array("name" => "select_multi", "itemHandler" => "category", "method" => "getCategoryListForPid", "module" => "article"));
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
			$this->setControl("article_tags", array("name" => "select_multi", "itemHandler" => "article", "method" => "getArticleTags", "module" => "article"));
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
			$this->setControl("article_related", array("name" => "select_multi", "itemHandler" => "article", "method" => "getRelated", "module" => "article"));
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
	
	public function getArticleAttachment($url = TRUE, $path = FALSE ) {
		global $articleConfig;
		$file_alt = $this->getVar("article_attachment_alt", "e");
		$file = $this->getVar("article_attachment", "e");
		
		if($url){
			if(!$file_alt == "") {
				$url = ARTICLE_UPLOAD_URL . 'article/' . $file_alt;
			} elseif(!$file == "0") {
				$file = 'article_attachment';
				$fileObj = $this->getFileObj($file);
				$filelink = $fileObj->getVar("url", "e");
				$titlelink = explode("/",$filelink);
				$last = (isset($titlelink[count($titlelink)-1])) ? $titlelink[count($titlelink)-1] : null;
				if($articleConfig['show_down_disclaimer'] == 1) {
					$down_link = 'down_disclaimer';
				} else {
					$down_link = '';
				}
				$url = '<a class="' . $down_link . ' btn download" href="' . $filelink . '" title="' . $last . '"> ' . $last . '</a>';
			} else {
				$url = FALSE;
			}
			return $url;
		} elseif ($path){
			if(!$file_alt == "") {
				$path = ARTICLE_UPLOAD_ROOT . 'article/' . $file_alt;
			} elseif (!$file == "0") {
				$file = 'article_attachment';
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
			$filesize = articleConvertFileSize($bytes, articleFileSizeType($articleConfig['display_file_size']), 2);
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
						$image = ICMS_URL . '/uploads/' . $sprocketsModule->getVar("dirname") . '/' . $tagObject->getVar("icon", "e");
						$ret[$tag] = '<span class="article_tag" original-title="' . $title . '"><a href="' . $this->getTaglink($tag)
									 . '" title="' . $title . '"><img width=16px height=16px src="'
									. $image . '" title="' . $title . '" alt="' . $title . '" />&nbsp;&nbsp;' . $title . '</a></span>';
						if($dsc != "") {
							$ret[$tag] .= '<span class="popup_tag">' . $dsc . '</span>';
						}
					} else {
						$ret[$tag] = '<span class="article_tag" original-title="' . $title . '"><a href="' . $this->getTaglink($tag) 
									. '" title="' . $title . '">' . $title . '</a></span>';
						if($dsc != "") {
							$ret[$tag] .= '<span class="popup_tag">' . $dsc . '</span>';
						}
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
	
	public function getArticlePublishers($userlink = TRUE) {
		$publishers = $this->getVar("article_publisher", "s");
		$ret = array();
		if($userlink) {
			foreach ($publishers as $publisher) {
				$ret[$publisher] = icms_member_user_Handler::getUserLink($publisher);
			}
		} else {
			foreach ($publishers as $publisher) {
				$uname = icms::handler('icms_member')->getUser($publisher)->getVar("uname");
				$ret[$publisher] = '<a href="' . ARTICLE_URL . 'index.php?op=getByAuthor&uid=' . $publisher . '" title="' . _CO_ARTICLE_ARTICLE_GET_BY_AUTHOR . '&nbsp;' . $uname . '">' . $uname . '</a>';
			}
		}
		return implode(", ", $ret);
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
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$viewperm = $gperm_handler->checkRight('article_grpperm', $this->getVar('article_id', 'e'), $groups, $module->getVar("mid"));
		if ($this->userCanEditAndDelete()) {
			return TRUE;
		}
		if ($viewperm && ($this->getVar("article_active", "e") == TRUE) && ($this->getVar("article_approve", "e") == TRUE) ) {
			return TRUE;
		}
		
		return FALSE;
	}
	
	function getItemLink($onlyUrl = FALSE) {
		$seo = $this->handler->makelink($this);
		$url = ARTICLE_URL . 'singlearticle.php?article_id=' . $this -> getVar( 'article_id' ) . '&amp;article=' . $seo;
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
	
	public function getArticleImagePath() {
		$image = $this->getVar("article_img", "e");
		if($image != "") {
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
		$ret['file'] = $this->getArticleAttachment(TRUE, FALSE);
		$ret['filesize'] = $this->getFileSize();
		$ret['filetype'] = $this->getFileType();
		$ret['demo'] = $this->getDemoLink();
		$ret['tags'] = $this->getArticleTags(TRUE);
		$ret['related'] = $this->getArticleRelated();
		$ret['publisher'] = $this->getArticlePublishers(TRUE);
		$ret['bypublisher'] = $this->getArticlePublishers(FALSE);
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
		$valid_case = array("new_article", "article_submitted", "article_modified", "article_approved", "article_file_broken");
		if(in_array($case, $valid_case, TRUE)) {
			$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
			$mid = $module->getVar('mid');
			$tags ['ARTICLE_TITLE'] = $this->getVar('article_title');
			$tags ['ARTICLE_URL'] = $this->getItemLink(FALSE);
			$tags ['ARTICLE_CATS'] = $this->getArticleCid(TRUE);
			switch ($case) {
				case 'new_article':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
				
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
				
				case 'article_approved':
					$category = 'article';
					$file_id = $this->id();
					$recipient = $this->getVar("article_publisher", "s");
					break;
				
				case 'article_file_broken':
					$category = 'article';
					$file_id = $this->id();
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