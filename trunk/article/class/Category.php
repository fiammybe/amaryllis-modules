<?php
/**
 * "Article" is an article management module for ImpressCMS
 *
 * File: /class/Category.php
 * 
 * Class representing Article category Objects
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

class ArticleCategory extends icms_ipf_seo_Object {
	/**
	 * Constructor
	 *
	 * @param mod_article_Category $handler Object handler
	 */
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar("category_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("category_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->initCommonVar("short_url");
		$this->quickInitVar("category_description", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("category_pid", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("category_image", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("category_image_upl", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("category_grpperm", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("category_uplperm", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("category_submitter", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_publisher", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_updater", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_published_date", XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar("category_updated_date", XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar("category_active", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("category_approve", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("category_inblocks", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar("category_updated", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->initCommonVar("weight");
		$this->initCommonVar("counter");
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, 1);
		$this->quickInitVar("category_notification_sent", XOBJ_DTYPE_INT, FALSE);
		
		$this->setControl("category_pid", array("name" => "select", "itemHandler" => "category", "method" => "getCategoryListForPid", "module" => "article"));
		$this->setControl("category_description", "dhtmltextarea");
		$this->setControl("category_image", array("name" => "select", "itemHandler" => "category", "method" => "getImageList", "module" => "article"));
		$this->setControl("category_image_upl", "image");
		$this->setControl("category_publisher", "user");
		$this->setControl("category_grpperm", array("name" => "select_multi", "itemHandler" => "category", "method" => "getGroups", "module" => "article"));
		$this->setControl("category_uplperm", "group_multi");
		$this->setControl("category_active", "yesno");
		$this->setControl("category_approve", "yesno");
		$this->setControl("category_inblocks", "yesno");
		$this->setControl("category_updated", "yesno");
		

		$this->hideFieldFromForm(array("category_notification_sent", "category_published_date", "category_updated_date", "weight", "counter", "category_submitter", "category_updater"));
		$this->hideFieldFromSingleView(array("dohtml", "doimage", "dosmiley", "doxcode"));

	}

	public function getVar($key, $format = 's') {
		if ($format == 's' && in_array($key, array('category_grpperm', 'category_pid'))) {
			return call_user_func(array($this,$key));
		}
		return parent::getVar($key, $format);
	}

	// get uname instead of id for publisher
	function category_publisher() {
		return icms_member_user_Handler::getUserLink($this->getVar('category_publisher', 'e'));
	}
	
	function category_updater() {
		return icms_member_user_Handler::getUserLink($this->getVar('category_updater', 'e'));
	}
	
	// get publisher for frontend
	function getCategoryPublisher($link = FALSE) {		
		$publisher_uid = $this->getVar('category_publisher', 'e');
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
	
	// get publisher for frontend
	function getCategoryUpdater($link = FALSE) {		
		$publisher_uid = $this->getVar('category_updater', 'e');
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
	
	public function getCategoryPublishedDate() {
		global $articleConfig;
		$date = '';
		$date = $this->getVar('category_published_date', 'e');
		
		return date($articleConfig['article_dateformat'], $date);
	}

	public function getCategoryUpdatedDate() {
		global $articleConfig;
		$date = '';
		$date = $this->getVar('category_updated_date', 'e');
		
		return date($articleConfig['article_dateformat'], $date);
	}
	
	public function getCategoryImageTag() {
		$category_img = $image_tag = '';
		$category_img = $this->getVar('category_image', 'e');
		if (!empty($category_img)) {
			$image_tag = ARTICLE_UPLOAD_URL . 'categoryimages/' . $category_img;
		}
		return $image_tag;
	}
	
	public function category_active() {
		$active = $this->getVar('category_active', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=visible">
				<img src="' . ARTICLE_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=visible">
				<img src="' . ARTICLE_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function category_inblocks() {
		$active = $this->getVar('category_inblocks', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . ARTICLE_IMAGES_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . ARTICLE_IMAGES_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	public function category_approve() {
		$active = $this->getVar('category_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeApprove">
				<img src="' . ARTICLE_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeApprove">
				<img src="' . ARTICLE_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function getCategoryWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	function getSubsCount(){
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$count = $this->handler->getCategoriesCount (TRUE, TRUE, $groups,'category_grpperm', FALSE, FALSE, $this->getVar("category_id", "e"));
		return $count;
	}
	// get sub category
	function category_sub() {
		$ret = $this->handler->getCategorySubCount($this->getVar('category_id', 'e'));

		if ($ret > 0) {
			$ret = '<a href="' . ARTICLE_ADMIN_URL . 'category.php?category_pid=' . $this->getVar('category_id', 'e') . '">' . $ret . ' <img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag+.png" align="absmiddle" /></a>';
		}
		return $ret;
	}

	function getCategorySub($toarray) {
		return $this->handler->getCategorySub($this->getVar('category_id', 'e'), $toarray);
	}
	
	function getArticlesCount() {
		$article_article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');
		$files_count = $article_article_handler->getCountCriteria(TRUE, TRUE, $groups = array(), $perm = 'category_grpperm', $article_publisher = FALSE, $article_id = FALSE, $this->getVar("category_id"));
		
		return $files_count;
	}
	
	function category_pid() {
		static $category_pidArray;
		if (!is_array($category_pidArray)) {
			$category_pidArray = $this->handler->getCategoryListForPid();
		}
		$ret = $this->getVar('category_pid', 'e');
		if ($ret > 0) {
			$ret = '<a href="' . ARTICLE_URL . 'index.php?category_id=' . $ret . '">' . str_replace('-', '', $category_pidArray[$ret]) . '</a>';
		} else {
			$ret = $category_pidArray[$ret];
		}
		return $ret;
	}
	
	// Retrieving the visibility of the category/category-set
	function category_grpperm() {
		$ret = $this->getVar('category_grpperm', 'e');
		$groups = $this->handler->getGroups();
		return $groups;
	}
	
	// Retrieving the visibility of the category/category-set
	function category_uplperm() {
		$ret = $this->getVar('category_uplperm', 'e');
		$groups = $this->handler->getUplGroups();
		return $groups;
	}

	function accessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$agroups = $gperm_handler->getGroupIds('module_admin', $module->getVar("mid"));
		$allowed_groups = array_intersect($groups, $agroups);
		$viewperm = $gperm_handler->checkRight('category_grpperm', $this->getVar('category_id', 'e'), $groups, $module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('category_publisher', 'e')) {
			return TRUE;
		}
		if ($viewperm && ($this->getVar('category_active', 'e') == TRUE)) {
			return TRUE;
		}
		if ($viewperm && ($this->getVar('category_approve', 'e') == TRUE)) {
			return TRUE;
		}
		if ($viewperm && (count($allowed_groups) > 0)) {
			return TRUE;
		}
		return FALSE;
	}

	function userCanEditAndDelete() {
		global $article_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($article_isAdmin) return TRUE;
		return $this->getVar('category_publisher', 'e') == icms::$user->getVar("uid");
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . ARTICLE_ADMIN_URL . 'category.php?op=view&amp;category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_ARTICLE_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getItemLink($onlyUrl = FALSE) {
		$seo = $this->handler->makelink($this);
		$url = ARTICLE_URL . 'index.php?category_id=' . $this -> getVar( 'category_id' ) . '&amp;cat=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar( 'category_title' ) . ' ">' . $this -> getVar( 'category_title' ) . '</a>';
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . ARTICLE_URL . 'index.php?category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_ARTICLE_PREVIEW . '" target="_blank">' . $this->getVar('category_title') . '</a>';
		return $ret;
	}
	
	function getEditAndDelete() {
		$article_article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');
		if($article_article_handler->userCanSubmit($this->id())) {
			return ARTICLE_URL . 'article.php?op=mod&amp;category_id=' . $this->id();
		} else {
			return FALSE;
		}
	}
	
	public function userCanSubmit() {
		$submit = $this->handler->userCanSubmit();
		if($submit) {
			$link = ARTICLE_URL . 'category.php?op=mod&amp;category_pid=' . $this->getVar("category_id", "e");
		} else {
			$link = FALSE;
		}
		return $link;
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar('category_id');
		$ret['title'] = $this->getVar('category_title');
		$ret['img'] = $this->getCategoryImageTag();
		$ret['dsc'] = $this->getVar('category_description');
		$ret['sub'] = $this->getCategorySub($this->getVar('category_id', 'e'), TRUE);
		$ret['hassub'] = (count($ret['sub']) > 0) ? TRUE : FALSE;
		$ret['published_date'] = $this->getCategoryPublishedDate();
		$ret['updated_date'] = $this->getCategoryUpdatedDate();
		$ret['publisher'] = $this->getCategoryPublisher(TRUE);
		$ret['updated_by'] = $this->getCategoryUpdater(TRUE);
		$ret['category_posterid'] = $this->getVar('category_publisher', 'e');
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['accessgranted'] = $this->accessGranted();
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['cat_count'] = $this->getSubsCount();
		$ret['articles_count'] = $this->getArticlesCount();
		$ret['user_upload'] = $this->getEditAndDelete();
		$ret['user_submit'] = $this->userCanSubmit();
		return $ret;
	}

	function sendNotifCategoryPublished() {
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$tags ['CATEGORY_TITLE'] = $this->getVar('category_title');
		$tags ['CATEGORY_URL'] = $this->getItemLink(TRUE, TRUE);
		icms::handler('icms_data_notification')->triggerEvent('global', 0, 'category_published', $tags, array(), $module->getVar('mid'));
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