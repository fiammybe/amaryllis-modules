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
		$this->setControl('category_img', array( 'name' => 'select', 'itemHandler' => 'category', 'method' => 'getImageList', 'module' => 'downloads'));
		$this->setControl('category_img_upload', 'image');
		$this->setControl('category_active', 'yesno');
		$this->setControl('category_inblocks', 'yesno');
		$this->setControl('category_approve', 'yesno');
		$this->setControl('category_grpperm', array('name' => 'select_multi', 'itemHandler' => 'category', 'method' => 'getGroups', 'module' => 'downloads'));
		$this->setControl('category_uplperm', array('name' => 'select_multi', 'itemHandler' => 'category', 'method' => 'getUplGroups', 'module' => 'downloads'));
		$this->setControl('category_publisher', 'user');
		// hide static fields from form
		$this->hideFieldFromForm(array('category_submitter', 'category_notification_sent', 'category_sub','counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		// hide fields from single view
		$this->hideFieldFromSingleView(array('category_notification_sent', 'weight', 'category_sub','counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		
		//make use of seo
		$this->initiateSEO();
	}

	// get publisher as userlink
	function getCategoryPublisher($link = FALSE) {		
		return icms_member_user_Handler::getUserLink($this->getVar('category_publisher', 'e'));
	}
	
	public function getCategoryPublishedDate() {
		global $downloadsConfig;
		$date = $this->getVar('category_published_date', 'e');
		return date($downloadsConfig['downloads_dateformat'], $date);
	}

	public function getCategoryUpdatedDate() {
		global $downloadsConfig;
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
				<img src="' . DOWNLOADS_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=visible">
				<img src="' . DOWNLOADS_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function category_inblocks() {
		$active = $this->getVar('category_inblocks', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . DOWNLOADS_IMAGES_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'category.php?category_id=' . $this->getVar('category_id') . '&amp;op=changeShow">
				<img src="' . DOWNLOADS_IMAGES_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	public function category_approve() {
		$active = $this->getVar('category_approve', 'e');
		if ($active == FALSE) {
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
	
	function getSubsCount(){
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$count = $this->handler->getCategoriesCount (TRUE, TRUE, $groups, 'category_grpperm', FALSE, FALSE, $this->getVar("category_id", "e"));
		return $count;
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
	
	function submitAccessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$viewperm = $gperm_handler->checkRight('submit_downloads', $this->getVar('category_id', 'e'), $groups, $module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('category_publisher', 'e')) {
			return TRUE;
		}
		if ($viewperm && ($this->getVar('category_active', 'e') == TRUE) && ($this->getVar('category_approve', 'e') == TRUE)) {
			return TRUE;
		}
		return FALSE;
	}

	function accessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$viewperm = $gperm_handler->checkRight('category_grpperm', $this->getVar('category_id', 'e'), $groups, icms::$module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('category_publisher', 'e')) {
			return TRUE;
		}
		if ($viewperm && ($this->getVar('category_active', 'e') == TRUE) && ($this->getVar('category_approve', 'e') == TRUE)) {
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
	
	public function getUserCanSubmitFile() {
		$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(dirname(__FILE__))), "downloads");
		
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
		$ret['id'] = $this->getVar("category_id", "e");
		$ret['title'] = $this->getVar("category_title", "e");
		$ret['img'] = $this->getCategoryImageTag();
		$ret['dsc'] = $this->getVar('category_description');
		$ret['published_date'] = $this->getCategoryPublishedDate();
		$ret['updated_date'] = $this->getCategoryUpdatedDate();
		$ret['publisher'] = $this->getCategoryPublisher(TRUE);
		$ret['cat_count'] = $this->getSubsCount();
		$ret['hassub'] = (count($ret['cat_count']) > 0) ? TRUE : FALSE;
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['itemLink'] = $this->getItemLink(TRUE);
		$ret['catlink'] = $this->getItemLink(FALSE);
		$ret['accessgranted'] = $this->accessGranted();
		$ret['user_upload'] = $this->submitAccessGranted();
		$ret['user_submit'] = $this->userCanSubmit();
		return $ret;
	}

	function sendCategoryNotification($case) {
		$valid_case = array('new_category', 'category_submitted', 'category_modified', 'category_approved');
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