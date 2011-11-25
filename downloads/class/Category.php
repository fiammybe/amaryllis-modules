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

	public $updating_counter = false;
	
	public $categories = true;
	
	public function __construct(&$handler) {
		
		icms_ipf_object::__construct($handler);
		
		$this->quickInitVar('category_id', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('category_title', XOBJ_DTYPE_TXTBOX, true);
		$this->initCommonVar('short_url');
		$this->quickInitVar('category_pid', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('category_img', XOBJ_DTYPE_TXTAREA, false);
		$this->quickInitVar('category_img_upload', XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('category_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('category_active', XOBJ_DTYPE_INT, false, false,false, 1);
		$this->quickInitVar('category_inblocks',XOBJ_DTYPE_INT, false, false,false, 1);
		$this->quickInitVar('category_approve',XOBJ_DTYPE_INT);
		$this->quickInitVar('category_grpperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_uplperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_published_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('category_updated_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('category_publisher', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_submitter', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('category_notification_sent', XOBJ_DTYPE_INT, false);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', false, 1);
		$this->initCommonVar('dobr', true, 1);
		$this->initCommonVar('doimage', true, 1);
		$this->initCommonVar('dosmiley', true, 1);
		$this->initCommonVar('docxode', true, 1);
		$this->initNonPersistableVar('category_sub', XOBJ_DTYPE_INT);
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
		$this->hideFieldFromSingleView(array('category_sub','counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		
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
	function getCategoryPublisher($link = false) {		
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
		if ($active == false) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=visible">
				<img src="' . DOWNLOADS_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=visible">
				<img src="' . DOWNLOADS_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function category_inblocks() {
		$active = $this->getVar('category_inblocks', 'e');
		if ($active == false) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . DOWNLOADS_IMAGES_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . DOWNLOADS_IMAGES_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	public function category_approve() {
		$active = $this->getVar('category_approve', 'e');
		if ($active == false) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeApprove">
				<img src="' . DOWNLOADS_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeApprove">
				<img src="' . DOWNLOADS_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function getCategoryWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
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
			return true;
		}
		
		if ($viewperm && $this->getVar('category_active', 'e') == true) {
			return true;
		}
		
		if ($viewperm && $this->getVar('category_approve', 'e') == true) {
			return true;
		}

		if ($viewperm && count($allowed_groups) > 0) {
			return true;
		}
		return false;
	}

	function userCanEditAndDelete() {
		global $downloads_isAdmin;
		if (!is_object(icms::$user)) return false;
		if ($downloads_isAdmin) return true;
		return $this->getVar('category_publisher', 'e') == icms::$user->getVar("uid");
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?op=view&amp;category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getItemLink($onlyUrl = false) {
		$seo = $this->handler->makelink($this);
		$url = DOWNLOADS_URL . 'index.php?category_id=' . $this -> getVar( 'category_id' ) . '&amp;cat=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar( 'category_title' ) . ' ">' . $this -> getVar( 'category_title' ) . '</a>';
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . DOWNLOADS_URL . 'index.php?category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_PREVIEW . '" target="_blank">' . $this->getVar('category_title') . '</a>';
		return $ret;
	}
	
	public function getEditItemLink($onlyUrl = false, $withimage = true, $userSide = false) {
		$retadmin = '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?op=changedField&amp;category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_EDIT . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/edit.png" /></a>';
		$retuser = '<a href="' . DOWNLOADS_URL . 'index.php?op=mod&amp;category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_EDIT . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/edit.png" /></a>';
		if(!$userSide) {
			return $retadmin;
		} else {
			return $retuser;
		}
	}
	
	public function getDeleteItemLink($onlyUrl = false, $withimage = true, $userSide = false) {
		$retadmin = '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?op=del&amp;category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_DELETE . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/editdelete.png" /></a>';
		$retuser = '<a href="' . DOWNLOADS_URL . 'index.php?op=del&amp;category_id=' . $this->getVar('category_id', 'e') . '" title="' . _CO_DOWNLOADS_DELETE . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/editdelete.png" /></a>';
		if(!$userSide) {
			return $retadmin;
		} else {
			return $retuser;
		}
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['published_date'] = $this->getCategoryPublishedDate();
		$ret['updated_date'] = $this->getCategoryUpdatedDate();
		$ret['publisher'] = $this->getCategoryPublisher(true);
		$ret['id'] = $this->getVar('category_id');
		$ret['title'] = $this->getVar('category_title');
		$ret['img'] = $this->getCategoryImageTag();
		$ret['dsc'] = $this->getVar('category_description');
		$ret['sub'] = $this->getCategorySub($this->getVar('category_id', 'e'), true);
		$ret['hassub'] = (count($ret['category_sub']) > 0) ? true : false;
		$ret['editItemLink'] = $this->getEditItemLink(false, true, true);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(false, true, true);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['category_posterid'] = $this->getVar('category_publisher', 'e');
		$ret['itemLink'] = $this->getItemLink(true, true);
		$ret['accessgranted'] = $this->accessGranted();
		return $ret;
	}

	function sendNotifCategoryPublished() {
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$tags ['CATEGORY_TITLE'] = $this->getVar('category_title');
		$tags ['CATEGORY_URL'] = $this->getItemLink(true, true);
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
		