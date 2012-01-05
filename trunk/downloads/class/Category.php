<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/Category.php
 * 
 * Class representing Download category objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

class DownloadsCategory extends icms_ipf_seo_Object {

	public $updating_counter = FALSE;
	
	public $categories = TRUE;
	
	public function __construct(&$handler) {
		
		icms_ipf_object::__construct($handler);
		
		$this->quickInitVar('category_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('category_title', XOBJ_DTYPE_TXTBOX, TRUE);
		$this->initCommonVar('short_url');
		$this->quickInitVar('category_pid', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('category_img', XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar('category_img_upload', XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('category_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('category_active', XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 1);
		$this->quickInitVar('category_inblocks',XOBJ_DTYPE_INT, FALSE, FALSE,FALSE, 1);
		$this->quickInitVar('category_approve',XOBJ_DTYPE_INT);
		$this->quickInitVar('category_grpperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_uplperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_published_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('category_updated_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('category_publisher', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_submitter', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_notification_sent', XOBJ_DTYPE_INT, FALSE);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', FALSE, 1);
		$this->initCommonVar('dobr', TRUE, 1);
		$this->initCommonVar('doimage', TRUE, 1);
		$this->initCommonVar('dosmiley', TRUE, 1);
		$this->initCommonVar('docxode', TRUE, 1);
		$this->quickInitVar('category_sub', XOBJ_DTYPE_INT);
		// set controls
		$this->setControl('category_pid', 'parentcategory');
		$this->setControl('category_description', 'dhtmltextarea');
		$this->setControl('category_img', array( 'name' => 'select', 'itemhandler' => 'category', 'method' => 'getImageList', 'module' => 'downloads'));
		$this->setControl('category_img_upload', 'image');
		$this->setControl('category_active', 'yesno');
		$this->setControl('category_inblocks', 'yesno');
		$this->setControl('category_approve', 'yesno');
		$this->setControl('category_grpperm', array('name' => 'select_multi', 'itemhandler' => 'category', 'method' => 'getGroups', 'module' => 'downloads'));
		$this->setControl('category_uplperm', array('name' => 'select_multi', 'itemhandler' => 'category', 'method' => 'getUplGroups', 'module' => 'downloads'));
		$this->setControl('category_publisher', 'user');
		// hide static fields from form
		$this->hideFieldFromForm(array('category_submitter', 'category_notification_sent', 'category_sub','counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		// hide fields from single view
		$this->hideFieldFromSingleView(array('category_notification_sent', 'weight', 'category_sub','counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		
		//make use of seo
		$this->initiateSEO();
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
	
	public function getCategoryPublishedDate() {
		global $downloadsConfig;
		$date = '';
		$date = $this->getVar('category_published_date', 'e');
		
		return date($downloadsConfig['downloads_dateformat'], $date);
	}

	public function getCategoryUpdatedDate() {
		global $downloadsConfig;
		$date = '';
		$date = $this->getVar('category_updated_date', 'e');
		
		return date($downloadsConfig['downloads_dateformat'], $date);
	}
	
	public function getCategoryImageTag() {
		$category_img = $image_tag = '';
		$category_img = $this->getVar('category_img', 'e');
		if (!empty($category_img)) {
			$image_tag = DOWNLOADS_UPLOAD_URL . 'categoryimages/' . $category_img;
		}
		return $image_tag;
	}
	
	public function category_active() {
		$active = $this->getVar('category_active', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=visible">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/stop.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=visible">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/button_ok.png" alt="Online" /></a>';
		}
	}
	
	public function category_inblocks() {
		$active = $this->getVar('category_inblocks', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Visible" /></a>';
		}
	}
	
	public function category_approve() {
		$active = $this->getVar('category_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Approved" /></a>';
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
			$ret = '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_pid=' . $this->getVar('category_id', 'e') . '">' . $ret . ' <img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag+.png" align="absmiddle" /></a>';
		}
		return $ret;
	}

	function getCategorySub($toarray) {
		return $this->handler->getCategorySub($this->getVar('category_id', 'e'), $toarray);
	}
	
	function getFilesCount() {
		$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');
		$files_count = $downloads_download_handler->getCountCriteria(TRUE, TRUE, $groups = array(), $perm = 'download_grpperm', $download_publisher = FALSE, $download_id = FALSE, $this->getVar("category_id"));
		
		return $files_count;
	}
	
	function category_pid() {
		static $category_pidArray;
		if (!is_array($category_pidArray)) {
			$category_pidArray = $this->handler->getCategoryListForPid();
		}
		$ret = $this->getVar('category_pid', 'e');
		if ($ret > 0) {
			$ret = '<a href="' . DOWNLOADS_URL . 'index.php?category_id=' . $ret . '">' . str_replace('-', '', $category_pidArray[$ret]) . '</a>';
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
		global $downloads_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($downloads_isAdmin) return TRUE;
		return $this->getVar('category_publisher', 'e') == icms::$user->getVar("uid");
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?op=view&amp;category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getItemLink($onlyUrl = FALSE) {
		$seo = $this->handler->makelink($this);
		$url = DOWNLOADS_URL . 'index.php?category_id=' . $this -> getVar( 'category_id' ) . '&amp;cat=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar( 'category_title' ) . ' ">' . $this -> getVar( 'category_title' ) . '</a>';
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . DOWNLOADS_URL . 'index.php?category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_PREVIEW . '" target="_blank">' . $this->getVar('category_title') . '</a>';
		return $ret;
	}
	
	function getEditAndDelete() {
		$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');
		if($downloads_download_handler->userCanSubmit($this->id())) {
			return DOWNLOADS_URL . 'download.php?op=mod&amp;category_id=' . $this->id();
		} else {
			return FALSE;
		}
	}
	
	public function userCanSubmit() {
		$submit = $this->handler->userCanSubmit();
		if($submit) {
			$link = DOWNLOADS_URL . 'category.php?op=mod&amp;category_pid=' . $this->getVar("category_id", "e");
		} else {
			$link = FALSE;
		}
		return $link;
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['published_date'] = $this->getCategoryPublishedDate();
		$ret['updated_date'] = $this->getCategoryUpdatedDate();
		$ret['publisher'] = $this->getCategoryPublisher(TRUE);
		$ret['id'] = $this->getVar('category_id');
		$ret['title'] = $this->getVar('category_title');
		$ret['img'] = $this->getCategoryImageTag();
		$ret['dsc'] = $this->getVar('category_description');
		$ret['sub'] = $this->getCategorySub($this->getVar('category_id', 'e'), TRUE);
		$ret['hassub'] = (count($ret['sub']) > 0) ? TRUE : FALSE;
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['category_posterid'] = $this->getVar('category_publisher', 'e');
		$ret['itemLink'] = $this->getItemLink(TRUE);
		$ret['catlink'] = $this->getItemLink(FALSE);
		$ret['accessgranted'] = $this->accessGranted();
		$ret['cat_count'] = $this->getSubsCount();
		$ret['files_count'] = $this->getFilesCount();
		$ret['user_upload'] = $this->getEditAndDelete();
		$ret['user_submit'] = $this->userCanSubmit();
		return $ret;
	}

	function sendCategoryNotification($case) {
		$valid_case = array('new_category', 'category_modified', 'category_approved');
		if(in_array($case, $valid_case, TRUE)) {
			$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
			$mid = $module->getVar('mid');
			$tags ['CATEGORY_TITLE'] = $this->getVar('category_title');
			$tags ['CATEGORY_URL'] = $this->getItemLink(FALSE);
			switch ($case) {
				case 'new_category':
					$category = 'global';
					$cat_id = 0;
					$recipient = array();
					break;
					
				case 'category_modified':
					$category = 'global';
					$cat_id = 0;
					$recipient = array();
					break;
					
				case 'category_submitted':
					$category = 'global';
					$cat_id = 0;
					$recipient = array();
					break;
					
				case 'category_approved':
					$category = 'category';
					$cat_id = $this->id();
					$recipient = $this->getVar("category_publisher", "e");
					break;
				
			}
			icms::handler('icms_data_notification')->triggerEvent($category, $cat_id, $case, $tags, $recipient, $mid);
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
		