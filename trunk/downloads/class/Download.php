<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/Download.php
 * 
 * Class representing Downloads download objects
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

class DownloadsDownload extends icms_ipf_seo_Object {

	public $updating_counter = false;

	public function __construct(&$handler) {
		global $downloadsConfig, $icmsConfig;
		icms_ipf_object::__construct($handler);

		$this->quickInitVar('download_id', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('download_title', XOBJ_DTYPE_TXTBOX, true);
		$this->initCommonVar('short_url');
		$this->quickInitVar('download_cid', XOBJ_DTYPE_INT, true, false, false, 1);
		$this->quickInitVar('download_file', XOBJ_DTYPE_FILE);
		$this->quickInitVar('download_file_alt', XOBJ_DTYPE_TXTBOX);
		
		$this->initVar("download_file_descriptions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_teaser', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_keyfeatures', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_requirements', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_version', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_version_status', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_limitations', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_license', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_platform', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_history', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("download_file_descriptions_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_file_images", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_img',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_screen_1',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_screen_2',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_screen_3',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_screen_4',XOBJ_DTYPE_IMAGE);
		$this->quickInitVar('download_album', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('catalogue_item', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("download_file_images_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_mirror_handling", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_mirror_url',XOBJ_DTYPE_URLLINK);
		$this->quickInitVar('download_mirror_approve', XOBJ_DTYPE_INT);
		$this->quickInitVar('download_has_mirror', XOBJ_DTYPE_INT, false);
		$this->quickInitVar("download_mirror_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_developer_info", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("download_dev", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("download_dev_hp", XOBJ_DTYPE_URLLINK);
		$this->quickInitVar("download_developer_information_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_publish_info", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_submitter', XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->quickInitVar('download_publisher', XOBJ_DTYPE_INT);
		$this->quickInitVar('download_published_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('download_updated_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar("download_publish_info_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_view_section", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_grpperm', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_active', XOBJ_DTYPE_INT,false, false, false, 1);
		$this->quickInitVar('download_inblocks', XOBJ_DTYPE_INT,false, false, false, 1);
		$this->quickInitVar('download_approve', XOBJ_DTYPE_INT);
		$this->quickInitVar('download_updated', XOBJ_DTYPE_INT,false, false, false, 0);
		$this->quickInitVar('download_broken', XOBJ_DTYPE_INT, false, false, false, 0);
		$this->quickInitVar("download_view_section_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_static_section", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_comments', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('download_notification_sent', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('download_fb_like', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('download_fb_dislike', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('download_g_like', XOBJ_DTYPE_INT, false);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', false, 1);
		$this->initCommonVar('dobr', true, 1);
		$this->initCommonVar('doimage', true, 1);
		$this->initCommonVar('dosmiley', true, 1);
		$this->initCommonVar('docxode', true, 1);
		$this->quickInitVar("download_static_section_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		// set controls
		$this->setControl('download_cid', array('name' => 'select', 'itemHandler' => 'category', 'method' => 'getCategoryList', 'module' => 'downloads'));
		$this->setControl('download_description', 'dhtmltextarea');
		$this->setControl('download_teaser', array('name' => 'textarea', 'form_editor' => 'htmlarea'));
		$this->setControl('download_history', array('name' => 'textarea', 'form_editor' => 'htmlarea'));
		$this->setControl('download_keyfeatures', 'textarea');
		$this->setControl('download_requirements', 'textarea');
		$this->setControl('download_file', 'file');
		$this->setControl('download_img', 'image');
		$this->setControl('download_screen_1','image');
		$this->setControl('download_screen_2','image');
		$this->setControl('download_screen_3','image');
		$this->setControl('download_screen_4','image');
		$this->setControl('download_version_status',array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getDownloadVersionStatus', 'module' => 'downloads'));
		$this->setControl('download_limitations',array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getDownloadLimitations', 'module' => 'downloads'));
		$this->setControl('download_license',array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getDownloadLicense', 'module' => 'downloads'));
		$this->setControl('download_platform',array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getDownloadPlatform', 'module' => 'downloads'));
		$this->setControl('download_publisher','user');
		$this->setControl('download_grpperm', array('name' => 'select_multi', 'itemHandler' => 'download', 'method' => 'getGroups', 'module' => 'downloads'));
		$this->setControl('download_active', 'yesno');
		$this->setControl('download_inblocks', 'yesno');
		$this->setControl('download_approve', 'yesno');
		$this->setControl('download_updated', 'yesno');
		$this->setControl('download_broken', 'yesno');
		// hide static fields from form
		$this->hideFieldFromForm(array( 'download_submitter', 'download_has_mirror', 'download_comments','download_notification_sent','download_fb_like', 'download_fb_dislike','download_g_like', 'counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		// hide fields from single view
		$this->hideFieldFromSingleView(array('download_has_mirror', 'download_comments','download_notification_sent','download_fb_like', 'download_fb_dislike','download_g_like', 'counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		
		$albumModule = icms_getModuleInfo('album');
		if ($downloadsConfig['use_album'] == 1 && $albumModule){
			$this->setControl('download_album', array('name' => 'select', 'itemhandler' => 'download', 'method' => 'getAlbumList', 'module' => 'downloads'));
		} else {
			$this->hideFieldFromForm('download_album');
			$this->hideFieldFromSingleView('download_album');
		}
		
		$catalogueModule = icms_getModuleInfo('catalogue');
		if ($downloadsConfig['use_catalogue'] == 1 && $catalogueModule){
			$this->setControl('catalogue_item', array('name' => 'select', 'itemhandler' => 'download', 'method' => 'getCatalogueItems', 'module' => 'downloads'));
		} else {
			$this->hideFieldFromForm('catalogue_item');
			$this->hideFieldFromSingleView('catalogue_item');
		}

		if ($downloadsConfig['use_mirror'] == 0){
			$this->hideFieldFromForm(array('download_mirror_approve','download_mirror_handling','download_mirror_url', 'download_mirror_title'));
			$this->hideFieldFromSingleView(array('download_mirror_approve','download_mirror_handling','download_mirror_url', 'download_mirror_title'));
		} else {
			$this->openFormSection('download_mirror_handling', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_HANDLING);
			$this->setControl('download_mirror_approve', 'yesno');
		}

		$this->openFormSection('download_file_descriptions', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_DESCRIPTIONS);
		$this->openFormSection('download_file_images', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_FILE_IMAGES);
		$this->openFormSection('download_developer_info', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_DEVELOPER_INFO);
		$this->openFormSection('download_publish_info', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISH_INFO);
		$this->openFormSection('download_view_section', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_VIEW_SECTION);
		$this->openFormSection('download_static_section', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_STATIC_SECTION);
		
		//make use of seo
		$this->initiateSEO();

	}
	
	public function getVar($key, $format = 's') {
		if ($format == 's' && in_array($key, array('download_publisher','download_grpperm', 'download_cid'))) {
			return call_user_func(array($this,$key));
		}
		return parent::getVar($key, $format);
	}
	
	public function download_cid() {
		$cid = $this->getVar ( 'download_cid', 'e' );
		$downloads_category_handler = icms_getModuleHandler ( 'category',basename(dirname(dirname(__FILE__))), 'downloads' );
		$category = $downloads_category_handler->get ( $cid );
		
		return $category->getVar ( 'category_title' );
	}
	/** prepared for later use
	public function download_cid() {
		$cid_array = implode(" ", array($this->getVar('download_cid', 's')));
		$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');
		$category_array = $downloads_category_handler->getObjects();
		
		$categories = array_intersect_key(explode(",", $cid_array), $category_array);
		$category=array();
		foreach($categories as &$category) {
			$category = $downloads_category_handler->get($category, false);
			
		}
		return $category['category_title'];
	}
	**/
	public function download_active() {
		$active = $this->getVar('download_active', 'e');
		if ($active == false) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=visible">
				<img src="' . DOWNLOADS_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=visible">
				<img src="' . DOWNLOADS_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function download_inblocks() {
		$active = $this->getVar('download_inblocks', 'e');
		if ($active == false) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeShow">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeShow">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Visible" /></a>';
		}
	}
	
	public function download_approve() {
		$active = $this->getVar('download_approve', 'e');
		if ($active == false) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Approved" /></a>';
		}
	}
	
	public function download_mirror_approve() {
		$active = $this->getVar('download_mirror_approve', 'e');
		if ($active == false) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeMirrorApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeMirrorApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Approved" /></a>';
		}
	}
	
	public function download_broken() {
		$active = $this->getVar('download_broken', 'e');
		if ($active == true) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeBroken">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Broken" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeBroken">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Online" /></a>';
		}
	}
	
	public function getDownloadWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}

	function download_grpperm() {
		$ret = $this->getVar('download_grpperm', 'e');
		$groups = $this->handler->getGroups();
		return $groups;
	}
	
	function download_limitations() {
		$ret = $this->getVar('download_limitations', 'e');
		$limitations = $this->handler->getDownloadLimitations();
		return $limitations;
	}
	
	function download_platform() {
		$ret = $this->getVar('download_platform', 'e');
		$platform = $this->handler->getDownloadPlatform();
		return $platform;
	}
	
	function download_version_status() {
		$ret = $this->getVar('download_version_status', 'e');
		$version_status = $this->handler->getDownloadVersionStatus();
		return $version_status;
	}
	
	function download_license() {
		$ret = $this->getVar('download_license', 'e');
		$license = $this->handler->getDownloadLicense();
		return $license;
	}
	
	public function getDownloadPublishedDate() {
		global $downloadsConfig;
		$date = '';
		$date = $this->getVar('download_published_date', 'e');
		
		return date($downloadsConfig['downloads_dateformat'], $date);
	}
	
	public function getDownloadUpdatedDate() {
		global $downloadsConfig;
		$date = '';
		$date = $this->getVar('download_updated_date', 'e');
		
		return date($downloadsConfig['downloads_dateformat'], $date);
	}
	
	public function getDownloadPublisher($link = false) {
		$publisher_uid = $this->getVar('download_publisher', 'e');
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
	
	public function download_publisher() {
		return icms_member_user_Handler::getUserLink($this->getVar('download_publisher', 'e'));
	}
	
	public function getDownloadImageTag() {
		$download_img = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$document_root = str_replace('modules/' . $directory_name . '/singledownload.php', '', $script_name);
		$download_img = $this->getVar('download_img', 'e');
		if (!$download_img == "") {
			$image_tag = $document_root . 'uploads/' . $directory_name . '/download/' . $download_img;
		}else {
			$image_tag=false;
		}
		return $image_tag;
	}
	
	public function getDownloadScreen1Tag() {
		$download_screen_1 = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$document_root = str_replace('modules/' . $directory_name . '/singledownload.php', '', $script_name);
		$download_screen_1 = $this->getVar('download_screen_1', 'e');
		if (!$download_screen_1 == "") {
			$image_tag = $document_root . 'uploads/' . $directory_name . '/download/' . $download_screen_1;
		}else {
			$image_tag=false;
		}
		return $image_tag;
	}
	
	public function getDownloadScreen2Tag() {
		$download_screen_2 = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$document_root = str_replace('modules/' . $directory_name . '/singledownload.php', '', $script_name);
		$download_screen_2 = $this->getVar('download_screen_2', 'e');
		if (!$download_screen_2 == "") {
			$image_tag = $document_root . 'uploads/' . $directory_name . '/download/' . $download_screen_2;
		}else {
			$image_tag=false;
		}
		return $image_tag;
	}
	
	public function getDownloadScreen3Tag() {
		$download_screen_3 = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$document_root = str_replace('modules/' . $directory_name . '/singledownload.php', '', $script_name);
		$download_screen_3 = $this->getVar('download_screen_3', 'e');
		if (!$download_screen_3 == "") {
			$image_tag = $document_root . 'uploads/' . $directory_name . '/download/' . $download_screen_3;
		}else {
			$image_tag=false;
		}
		return $image_tag;
	}
	
	public function getDownloadScreen4Tag() {
		$download_screen_4 = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$document_root = str_replace('modules/' . $directory_name . '/singledownload.php', '', $script_name);
		$download_screen_4 = $this->getVar('download_screen_4', 'e');
		if (!$download_screen_4 == "") {
			$image_tag = $document_root . 'uploads/' . $directory_name . '/download/' . $download_screen_4;
		} else {
			$image_tag=false;
		}
		return $image_tag;
	}
	
	public function getDownloadKeyfeatures() {
		$keyfeature_array = $this->getVar('download_keyfeatures');
		if (!$keyfeature_array == "") {
			$keyfeatures = explode("|", $keyfeature_array);
			$result = '';
			foreach ($keyfeatures as $key => $keyfeature) {
				$result .= '<li>' . $keyfeature . '</li>';
			}
			return $result;
		}
	}
	
	public function getDownloadRequirements() {
		$requirements_array = $this->getVar('download_requirements');
		if (!$requirements_array == "") {
			$requirements = explode("|", $requirements_array);
			$result = '';
			foreach ($requirements as $requirement) {
				$result .= '<li>' . $requirement . '</li>';
			}
			return $result;
		}
	}
	
	public function getDownloadHistory() {
		$history = icms_core_Datafilter::checkVar($this->getVar('download_history'), 'str', 'encodehigh');
		return $history;
	}
	
	public function getDownloadTeaser() {
		$teaser = icms_core_Datafilter::checkVar($this->getVar('download_teaser'), 'str', 'encodehigh');
		return $teaser;
	}

	public function getDevHpLink() {
		$dev_hp = 'download_dev_hp';
		$linkObj = $this-> getUrlLinkObj($dev_hp);
		$url = $linkObj->render();
		return $url;
	}
	
	public function getDownloadTag($url = TRUE, $path = FALSE ) {
		$file_alt = $this->getVar("download_file_alt", "e");
		if($url){
			if(!$file_alt == "") {
				$url = DOWNLOADS_UPLOAD_URL . 'download/' . $file_alt;
			} else {
				$file = 'download_file';
				$fileObj = $this->getFileObj($file);
				$url = $fileObj->getVar('url');
			}
			return $url;
		} elseif ($path){
			if(!$file_alt == "") {
				$path = DOWNLOADS_UPLOAD_ROOT . 'download/' . $file_alt;
			} else {
				$file = 'download_file';
				$fileObj = $this->getFileObj($file);
				$url = $fileObj->getVar('url', 's');
				$filename = basename($url);
				$path = ICMS_ROOT_PATH . '/uploads/downloads/download/' . $filename;
			}
			return $path;
		}
	}
	
	public function getFileSize() {
		global $downloadsConfig;
		$myfile = $this->getDownloadTag(FALSE, TRUE);
		$bytes = filesize($myfile);
		$filesize = downloadsConvertFileSize($bytes, downloadsFileSizeType($downloadsConfig['display_file_size']), 2);
		return $filesize . '&nbsp;' . downloadsFileSizeType($downloadsConfig['display_file_size']) ;
	}
	
	function accessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$agroups = $gperm_handler->getGroupIds('module_admin', $module->getVar("mid"));
		$allowed_groups = array_intersect($groups, $agroups);
		$viewperm = $gperm_handler->checkRight('download_grpperm', $this->getVar('download_id', 'e'), $groups, $module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('download_publisher', 'e')) {
			return true;
		}
		if ($viewperm && $this->getVar('download_active', 'e') == true) {
			return true;
		}
		if ($viewperm && $this->getVar('download_approve', 'e') == true) {
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
		return $this->getVar('download_publisher', 'e') == icms::$user->getVar("uid");
	}
	
	public function getMirrorLink() {
		global $downloadsConfig;
		$mirror = $this->getVar('download_mirror_url');
		if ($downloadsConfig['use_mirror'] == 1 && !$mirror == "") {
			$mirror_approve = $this->getVar('download_mirror_approve', 'e');
			$mirror_url = 'download_mirror_url';
			$linkObj = $this-> getUrlLinkObj($mirror_url);
			$onlyurl = $linkObj->getVar("url", "e");
			//$urltitle = $linkObj->getVar("caption", "e");
			//$urldsc = $linkObj->getVar("description", "e");
			//$url = '<a href="' . $onlyurl . '" title="' . $urlsdsc . '">' . $urltitle . '</a>';
			//$url = $linkObj->render();
			if($downloadsConfig['mirror_needs_approve'] == 1 ){
				if ($mirror_approve == true) {
					return $onlyurl;
				} else {
					return false;
				}
			} else {
				return $onlyurl;
			}
		} else {
			return false;
		}
	}

	function getItemLink($onlyUrl = false) {
		$seo = $this->handler->makelink($this);
		$url = DOWNLOADS_URL . 'singledownload.php?download_id=' . $this -> getVar( 'download_id' ) . '&amp;file=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar( 'download_title' ) . ' ">' . $this -> getVar( 'download_title' ) . '</a>';
	}
	
	public function getViewItemLink() {
		$ret = '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?op=view&amp;download_id=' . $this->getVar('download_id', 'e') . '" title="' . _CO_DOWNLOADS_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . DOWNLOADS_URL . 'singledownload.php?download_id=' . $this->getVar('download_id', 'e') . '" title="' . _CO_DOWNLOADS_PREVIEW . '" target="_blank">' . $this->getVar('download_title') . '</a>';
		return $ret;
	}
	
	public function toArray() {
		global $icmsConfig, $downloadsConfig;
		$ret = parent::toArray();
		$ret['published_date'] = $this->getDownloadPublishedDate();
		$ret['updated_date'] = $this->getDownloadUpdatedDate();
		$ret['publisher'] = $this->getDownloadPublisher(true);
		$ret['teaser'] = $this->getDownloadTeaser();
		$ret['history'] = $this->getDownloadHistory();
		$ret['id'] = $this->getVar('download_id');
		$ret['title'] = $this->getVar('download_title');
		$ret['img'] = $this->getDownloadImageTag();
		$ret['file'] = $this->getDownloadTag(TRUE, FALSE);
		$ret['dsc'] = $this->getVar('download_description');
		$ret['keyfeatures'] = $this->getDownloadKeyfeatures();
		$ret['requirements'] = $this->getDownloadRequirements();
		$ret['version'] = $this->getVar('download_version');
		$ret['version_status'] = $this->getVar('download_version_status');
		$ret['limitations'] = $this->getVar('download_limitations');
		$ret['license'] = $this->getVar('download_license');
		$ret['platform'] = $this->getVar('download_platform');
		$ret['mirror'] = $this->getMirrorLink();
		$ret['dev'] = $this->getVar('download_dev');
		$ret['dev_hp'] = $this->getDevHpLink();
		$ret['catalogue_item'] = $this->getVar('catalogue_item');
		$ret['thumbnail_width'] = $downloadsConfig['thumbnail_width'];
		$ret['thumbnail_height'] = $downloadsConfig['thumbnail_height'];
		$ret['filesize'] = $this->getFileSize();
		$ret['file_thumbnail_width'] = $downloadsConfig['file_img_thumbnail_width'];
		$ret['file_thumbnail_height'] = $downloadsConfig['file_img_thumbnail_height'];
		
		$albumModule = icms_getModuleInfo('album');
		if ($downloadsConfig['use_album'] == true && $albumModule){
			$ret['album_images'] = $this->getVar('download_album');
		} 
		$ret['screen_1'] = $this->getDownloadScreen1Tag();
		$ret['screen_2'] = $this->getDownloadScreen2Tag();
		$ret['screen_3'] = $this->getDownloadScreen3Tag();
		$ret['screen_4'] = $this->getDownloadScreen4Tag();
		
		$ret['editItemLink'] = $this->getEditItemLink(false, true, true);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(false, true, true);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['download_posterid'] = $this->getVar('download_publisher', 'e');
		$ret['itemLink'] = $this->getItemLink(true, true);
		$ret['accessgranted'] = $this->accessGranted();
		return $ret;
	}
	
	function sendNotifDownloadPublished() {
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$tags ['DOWNLOAD_TITLE'] = $this->getVar('download_title');
		$tags ['DOWNLOAD_URL'] = $this->getItemLink();
		icms::handler('icms_data_notification')->triggerEvent('global', 0, 'download_published', $tags, array(), $module->getVar('mid'));
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