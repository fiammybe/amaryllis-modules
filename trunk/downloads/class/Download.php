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

	public $updating_counter = FALSE;

	public function __construct(&$handler) {
		global $downloadsConfig, $icmsConfig;
		icms_ipf_object::__construct($handler);

		$this->quickInitVar('download_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('download_title', XOBJ_DTYPE_TXTBOX, TRUE);
		$this->initCommonVar('short_url');
		$this->quickInitVar('download_cid', XOBJ_DTYPE_ARRAY);
		$this->quickInitVar('download_file', XOBJ_DTYPE_FILE);
		$this->quickInitVar('download_file_alt', XOBJ_DTYPE_TXTBOX);
		
		$this->initVar("download_file_descriptions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_teaser', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_description', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_keyfeatures', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_requirements', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_version', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_version_status', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_version_link', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_history', XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar('download_limitations', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_license', XOBJ_DTYPE_ARRAY);
		$this->quickInitVar('download_platform', XOBJ_DTYPE_ARRAY);
		$this->quickInitVar("download_language", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('download_related', XOBJ_DTYPE_ARRAY);
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
		$this->quickInitVar('download_has_mirror', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("download_mirror_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_developer_info", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("download_dev", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("download_dev_hp", XOBJ_DTYPE_URLLINK);
		$this->quickInitVar("download_demo", XOBJ_DTYPE_URLLINK);
		$this->quickInitVar("download_developer_information_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_publish_info", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_submitter', XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->quickInitVar('download_publisher', XOBJ_DTYPE_INT);
		$this->quickInitVar('download_published_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('download_updated_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar("download_tags", XOBJ_DTYPE_ARRAY);
		$this->quickInitVar("download_publish_info_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_view_section", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_active', XOBJ_DTYPE_INT,FALSE, FALSE, FALSE, 1);
		$this->quickInitVar('download_inblocks', XOBJ_DTYPE_INT,FALSE, FALSE, FALSE, 1);
		$this->quickInitVar('download_approve', XOBJ_DTYPE_INT);
		$this->quickInitVar('download_updated', XOBJ_DTYPE_INT,FALSE, FALSE, FALSE, 0);
		$this->quickInitVar('download_broken', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->quickInitVar("download_view_section_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("download_static_section", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar('download_comments', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('download_notification_sent', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('download_status_set', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('download_like', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('download_dislike', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('download_downcounter', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', FALSE, 1);
		$this->initCommonVar('dobr', TRUE, 1);
		$this->initCommonVar('doimage', TRUE, 1);
		$this->initCommonVar('dosmiley', TRUE, 1);
		$this->initCommonVar('docxode', TRUE, 1);
		$this->quickInitVar("download_static_section_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		// set controls
		$this->setControl('download_cid', array('name' => 'select_multi', 'itemHandler' => 'category', 'method' => 'getCategoryListForPid', 'module' => 'downloads'));
		$this->setControl('download_description', 'dhtmltextarea');
		$this->setControl('download_teaser', array('name' => 'textarea', 'form_editor' => 'htmlarea'));
		$this->setControl('download_file', 'file');
		$this->setControl('download_img', 'image');
		$this->setControl('download_screen_1','image');
		$this->setControl('download_screen_2','image');
		$this->setControl('download_screen_3','image');
		$this->setControl('download_screen_4','image');
		$this->setControl('download_limitations',array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getDownloadLimitations', 'module' => 'downloads'));
		$this->setControl('download_license',array('name' => 'select_multi', 'itemHandler' => 'download', 'method' => 'getDownloadLicense', 'module' => 'downloads'));
		$this->setControl('download_platform',array('name' => 'select_multi', 'itemHandler' => 'download', 'method' => 'getDownloadPlatform', 'module' => 'downloads'));
		$this->setControl('download_publisher','user');
		$this->setControl('download_active', 'yesno');
		$this->setControl('download_inblocks', 'yesno');
		$this->setControl('download_approve', 'yesno');
		$this->setControl('download_updated', 'yesno');
		$this->setControl('download_broken', 'yesno');
		// hide static fields from form
		$this->hideFieldFromForm(array('weight','download_version_link', 'download_status_set', 'download_inblocks', 'download_downcounter', 'download_submitter','download_like','download_dislike', 'download_has_mirror', 'download_comments','download_notification_sent', 'counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		// hide fields from single view
		$this->hideFieldFromSingleView(array('download_has_mirror', 'download_version_link', 'download_status_set', 'download_comments','download_notification_sent','download_fb_like', 'download_fb_dislike','download_g_like', 'counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxode'));
		
		$albumModule = icms_getModuleInfo('album');
		if ($downloadsConfig['use_album'] == 1 && icms_get_module_status("album")){
			$this->setControl('download_album', array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getAlbumList', 'module' => 'downloads'));
		} else {
			$this->hideFieldFromForm('download_album');
			$this->hideFieldFromSingleView('download_album');
		}
		
		$catalogueModule = icms_getModuleInfo('catalogue');
		if ($downloadsConfig['use_catalogue'] == 1 && icms_get_module_status("catalogue")){
			$this->setControl('catalogue_item', array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getCatalogueItems', 'module' => 'downloads'));
		} else {
			$this->hideFieldFromForm('catalogue_item');
			$this->hideFieldFromSingleView('catalogue_item');
		}
		
		$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
		if($downloadsConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
			$this->setControl("download_tags", array("name" => "select_multi", "itemHandler" => "download", "method" => "getDownloadTags", "module" => "downloads"));
		} else {
			$this->hideFieldFromForm("download_tags");
			$this->hideFieldFromSingleView("download_tags");
		}

		if ($downloadsConfig['use_mirror'] == 0){
			$this->hideFieldFromForm(array('download_mirror_approve','download_mirror_handling','download_mirror_url', 'download_mirror_title'));
			$this->hideFieldFromSingleView(array('download_mirror_approve','download_mirror_handling','download_mirror_url', 'download_mirror_title'));
		} else {
			$this->openFormSection('download_mirror_handling', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_MIRROR_HANDLING);
			$this->setControl('download_mirror_approve', 'yesno');
		}

		if($downloadsConfig['need_version_control'] == 1) {
			$this->setControl('download_history', array('name' => 'textarea', 'form_editor' => 'htmlarea'));
			$this->setControl('download_version_status',array('name' => 'select', 'itemHandler' => 'download', 'method' => 'getDownloadVersionStatus', 'module' => 'downloads'));
		} else {
			$this->hideFieldFromForm(array("download_history", "download_version", "download_version_status", "download_version_link"));
			$this->hideFieldFromSingleView(array("download_history", "download_version", "download_version_status", "download_version_link"));
		}
		
		if($downloadsConfig['need_related_files'] == 1) {
			$this->setControl('download_related', array('name' => 'select_multi', 'itemHandler' => 'download', 'method' => 'getRelated', 'module' => 'downloads'));
		} else {
			$this->hideFieldFromForm("download_related");
			$this->hideFieldFromSingleView("download_related");
		}
		
		if($downloadsConfig['need_demo'] == 0) {
			$this->hideFieldFromForm("download_demo");
			$this->hideFieldFromSingleView("download_demo");
		}
			
		if($downloadsConfig['need_requirements'] == 1){
			$this->setControl('download_requirements', 'textarea');
		} else {
			$this->hideFieldFromForm("download_requirements");
			$this->hideFieldFromSingleView("download_requirements");
		}
		
		if($downloadsConfig['need_keyfeatures'] == 1){
			$this->setControl('download_keyfeatures', 'textarea');
		} else {
			$this->hideFieldFromForm("download_keyfeatures");
			$this->hideFieldFromSingleView("download_keyfeatures");
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
	
	public function getDownloadCid($itemlink = FALSE) {
		$cid = $this->getVar ( 'download_cid', 's' );
		$downloads_category_handler = icms_getModuleHandler ( 'category',basename(dirname(dirname(__FILE__))), 'downloads' );
		$ret = array();
		if($itemlink == FALSE) {
			foreach ($cid as $category) {
				$categoryObject = $downloads_category_handler->get($category);
				$ret[$category] = $categoryObject->getVar("category_title");
			}
		} else {
			foreach ($cid as $category) {
				$categoryObject = $downloads_category_handler->get($category);
				$ret[$category] = $categoryObject->getItemLink(FALSE);
			}
		}
		return implode(" | ", $ret);
	}
	
	public function getDownloadTags($itemlink = FALSE) {
		$tags = $this->getVar('download_tags', 's');
		$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
		if(icms_get_module_status("sprockets") && $tags != "") {
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
					$title = $tagObject->getVar("title");
					$dsc = $tagObject->getVar("description", "s");
					$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodehigh");
					$dsc = icms_core_DataFilter::undoHtmlSpecialChars($dsc);
					$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodelow");
					if($icon != "") {
						$image = ICMS_URL . '/uploads/' . $sprocketsModule->getVar("dirname") . '/' . $tagObject->getVar("icon", "e");
						$ret[$tag] = '<span class="download_tag" original-title="' . $title . '"><a href="' . $this->getTaglink($tag)
									 . '" title="' . $title . '"><img width=16px height=16px src="'
									. $image . '" title="' . $title . '" alt="' . $title . '" />&nbsp;&nbsp;' . $title . '</a></span>';
						if($dsc != "") {
							$ret[$tag] .= '<span class="popup_tag">' . $dsc . '</span>';
						}
					} else {
						$ret[$tag] = '<span class="download_tag" original-title="' . $title . '"><a href="' . $this->getTaglink($tag) 
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
		$link = DOWNLOADS_URL . "index.php?op=getByTags&tag=" . $tag;
		return $link;
	}
	
	public function download_active() {
		$active = $this->getVar('download_active', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=visible">
				<img src="' . DOWNLOADS_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=visible">
				<img src="' . DOWNLOADS_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function download_inblocks() {
		$active = $this->getVar('download_inblocks', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeShow">
				<img src="' . DOWNLOADS_IMAGES_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeShow">
				<img src="' . DOWNLOADS_IMAGES_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	public function download_approve() {
		$active = $this->getVar('download_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeApprove">
				<img src="' . DOWNLOADS_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeApprove">
				<img src="' . DOWNLOADS_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function download_mirror_approve() {
		$active = $this->getVar('download_mirror_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeMirrorApprove">
				<img src="' . DOWNLOADS_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeMirrorApprove">
				<img src="' . DOWNLOADS_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function download_broken() {
		$active = $this->getVar('download_broken', 'e');
		if ($active == TRUE) {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeBroken">
				<img src="' . DOWNLOADS_IMAGES_URL . 'denied.png" alt="Broken" /></a>';
		} else {
			return '<a href="' . DOWNLOADS_ADMIN_URL . 'download.php?download_id=' . $this->getVar('download_id') . '&amp;op=changeBroken">
				<img src="' . DOWNLOADS_IMAGES_URL . 'approved.png" alt="Online" /></a>';
		}
	}
	
	public function getDownloadWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
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
		$ret = array($this->getVar('download_license', 's'));
		$license = $this->handler->getDownloadLicense();
		return $license;
	}
	
	function download_related() {
		$ret = array($this->getVar('download_related', 's'));
		$related = $this->handler->getRelated();
		return $related;
	}
	
	public function getDownloadPublishedDate() {
		global $downloadsConfig;
		$date = $this->getVar('download_published_date', 'e');
		return date($downloadsConfig['downloads_dateformat'], $date);
	}
	
	public function getDownloadUpdatedDate() {
		global $downloadsConfig;
		$date = $this->getVar('download_updated_date', 'e');
		if($date != 0) {
			return date($downloadsConfig['downloads_dateformat'], $date);
		}
	}
	
	public function getDownloadPublisher() {
		return icms_member_user_Handler::getUserLink($this->getVar('download_publisher', 'e'));
	}
	
	public function getDownloadImageTag($singleview = TRUE) {
		$download_img = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$download_img = $this->getVar('download_img', 'e');
		if($singleview) {
			$document_root = str_replace('modules/' . $directory_name . '/singledownload.php', '', $script_name);
			if (!$download_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/download/' . $download_img;
			}else {
				$image_tag=FALSE;
			}
		} else {
			$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);
			if (!$download_img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/download/' . $download_img;
			}else {
				$image_tag=FALSE;
			}
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
			$image_tag=FALSE;
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
			$image_tag=FALSE;
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
			$image_tag=FALSE;
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
			$image_tag=FALSE;
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

	public function getDownloadRelated() {
		$related_array = $this->getVar('download_related' , 's');
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
	
	public function getDownloadLicense() {
		$licenses = $this->getVar("download_license", "s");
		if($licenses != "") {
			$license = implode(", ", $licenses);
			return $license;
		}
	}
	
	public function getDownloadPlatform() {
		$platforms = $this->getVar("download_platform", "s");
		if($platforms != "") {
			$platform = implode(", ", $platforms);
			return $platform;
		}
	}
	
	public function getDownloadVersionStatus() {
		$status = $this->getVar("download_version_status", "e");
		switch ($status) {
			case '1':
				return _CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_FINAL;
				break;
			
			case '2':
				return _CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_ALPHA;
				break;
				
			case '3':
				return _CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_BETA;
				break;
				
			case '4':
				return _CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_RC;
				break;
				
			case '5':
				return _CO_DOWNLOADS_DOWNLOAD_VERSION_STATUS_NONE;
				break;
		}
	}
	
	public function getDownloadHistory() {
		$history = icms_core_Datafilter::checkVar($this->getVar('download_history'), 'html', 'output');
		return $history;
	}
	
	public function getDownloadTeaser() {
		$teaser = icms_core_Datafilter::checkVar($this->getVar('download_teaser'), 'html', 'output');
		return $teaser;
	}

	public function getDevHpLink() {
		if($this->getVar("download_dev_hp") != 0) {
			$dev_hp = 'download_dev_hp';
			$linkObj = $this-> getUrlLinkObj($dev_hp);
			$url = $linkObj->render();
			return $url;
		}
	}
	
	public function getDemoLink() {
		if($this->getVar("download_demo") != 0) {
			$demo = 'download_demo';
			$linkObj = $this-> getUrlLinkObj($demo);
			$url = $linkObj->render();
			return $url;
		}
	}
	
	public function getDownloadTag($url = TRUE, $path = FALSE ) {
		$file_alt = $this->getVar("download_file_alt", "e");
		$file = $this->getVar("download_file", "e");
		if($url){
			if(!$file_alt == "") {
				$url = DOWNLOADS_UPLOAD_URL . 'download/' . $file_alt;
			} elseif($file != 0) {
				$file = 'download_file';
				$fileObj = $this->getFileObj($file);
				$url = $fileObj->getVar('url');
			} else {
				$url = FALSE;
			}
			return $url;
		} elseif ($path){
			if(!$file_alt == "") {
				$path = DOWNLOADS_UPLOAD_ROOT . 'download/' . $file_alt;
			} elseif($file != 0) {
				$file = 'download_file';
				$fileObj = $this->getFileObj($file);
				$url = $fileObj->getVar('url', 's');
				$filename = basename($url);
				$path = ICMS_ROOT_PATH . '/uploads/downloads/download/' . $filename;
			} else {
				$path = FALSE;
			}
			return $path;
		}
	}
	
	public function getFileSize() {
		global $downloadsConfig;
		$myfile = $this->getDownloadTag(FALSE, TRUE);
		if($myfile) {
			$bytes = filesize($myfile);
			$filesize = downloadsConvertFileSize($bytes, downloadsFileSizeType($downloadsConfig['display_file_size']), 2);
			return $filesize . '&nbsp;' . downloadsFileSizeType($downloadsConfig['display_file_size']) ;
		}
	}
	
	public function getFileType() {
		$myfile = $this->getDownloadTag(FALSE, TRUE);
		/**
		 * @TODO if going fully php 5.3 use finfo
		 */
		if($myfile != "") {
			$filetype = explode(".",$myfile);
			$last = (isset($filetype[count($filetype)-1])) ? $filetype[count($filetype)-1] : NULL;
			return $last;
		}
	}
	
	function accessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$agroups = $gperm_handler->getGroupIds('module_admin', $module->getVar("mid"));
		$allowed_groups = array_intersect($groups, $agroups);
		$viewperm = $gperm_handler->checkRight('download_grpperm', $this->getVar('download_id', 'e'), $groups, $module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('download_publisher', 'e')) {
			return TRUE;
		}
		if ($viewperm && ($this->getVar('download_active', 'e') == TRUE) && ($this->getVar('download_approve', 'e') == TRUE) && (count($allowed_groups) > 0)) {
			return TRUE;
		}
		return FALSEa;
	}
	
	function userCanEditAndDelete() {
		global $downloads_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($downloads_isAdmin) return TRUE;
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
			if($downloadsConfig['mirror_needs_approve'] == 1 ){
				if ($mirror_approve == TRUE) {
					return $onlyurl;
				} else {
					return FALSE;
				}
			} else {
				return $onlyurl;
			}
		} else {
			return FALSE;
		}
	}

	function getItemLink($onlyUrl = FALSE) {
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
		$ret['id'] = $this->getVar('download_id');
		$ret['title'] = $this->getVar('download_title');
		$ret['cats'] = $this->getDownloadCid(TRUE);
		$ret['cats_title'] = $this->getDownloadCid(FALSE);
		$ret['teaser'] = $this->getDownloadTeaser();
		$ret['dsc'] = $this->getVar('download_description');
		
		$ret['file'] = $this->getDownloadTag(TRUE, FALSE);
		$ret['filesize'] = $this->getFileSize();
		$ret['filetype'] = $this->getFileType();
		
		$ret['index_img'] = $this->getDownloadImageTag(FALSE);
		$ret['img'] = $this->getDownloadImageTag(TRUE);
		$ret['screen_1'] = $this->getDownloadScreen1Tag();
		$ret['screen_2'] = $this->getDownloadScreen2Tag();
		$ret['screen_3'] = $this->getDownloadScreen3Tag();
		$ret['screen_4'] = $this->getDownloadScreen4Tag();
		$albumModule = icms_getModuleInfo('album');
		if ($downloadsConfig['use_album'] == TRUE && $albumModule){
			$ret['album_images'] = $this->getVar('download_album');
		} 
		
		$ret['version'] = $this->getVar('download_version', 'e');
		$ret['version_status'] = $this->getDownloadVersionStatus();
		$ret['history'] = $this->getDownloadHistory();
		//$ret['version_control'] = $this->getDownloadVersionControl();
		$ret['tags'] = $this->getDownloadTags(TRUE);
		$ret['published_date'] = $this->getDownloadPublishedDate();
		$ret['updated_date'] = $this->getDownloadUpdatedDate();
		$ret['publisher'] = $this->getDownloadPublisher(TRUE);
		
		$ret['keyfeatures'] = $this->getDownloadKeyfeatures();
		$ret['requirements'] = $this->getDownloadRequirements();
		$ret['limitations'] = $this->getVar('download_limitations');
		$ret['platform'] = $this->getDownloadPlatform();
		$ret['language'] = $this->getVar('download_language');
		$ret['license'] = $this->getDownloadLicense();
		$ret['related'] = $this->getDownloadRelated();
		$ret['mirror'] = $this->getMirrorLink();
		$ret['dev'] = $this->getVar('download_dev');
		$ret['dev_hp'] = $this->getDevHpLink();
		$ret['demo'] = $this->getDemoLink();
		$ret['catalogue_item'] = $this->getVar('catalogue_item');
		
		$ret['like'] = $this->getVar('download_like');
		$ret['dislike'] = $this->getVar('download_dislike');
		$ret['downcounter'] = $this->getVar('download_downcounter', 'e');
		
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['download_posterid'] = $this->getVar('download_publisher', 'e');
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['accessgranted'] = $this->accessGranted();
		
		return $ret;
	}

	function sendDownloadNotification($case) {
		$valid_case = array('new_file', 'file_submit', 'file_modified', 'review_submitted');
		if(in_array($case, $valid_case)) {
			$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
			$mid = $module->getVar('mid');
			$tags ['DOWNLOAD_TITLE'] = $this->getVar('download_title');
			$tags ['DOWNLOAD_URL'] = $this->getItemLink(FALSE);
			$tags ['DOWNLOAD_CATS'] = $this->getDownloadCid(TRUE);
			switch ($case) {
				case 'new_file':
					$category = 'global';
					$file_id = $this->id();
					$recipient = array();
					break;
				
				case 'file_submit':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
				
				case 'file_modified':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
					
				case 'review_submitted':
					$category = 'global';
					$file_id = 0;
					$recipient = array();
					break;
					
			}
			icms::handler('icms_data_notification')->triggerEvent($category, $file_id, $case, $tags, $recipient, $mid);
		}
	}

	function getReads() {
		return $this->getVar('counter');
	}

	function setReads($qtde = NULL) {
		$t = $this->getVar('counter');
		if (isset($qtde)) {
			$t += $qtde;
		} else {
			$t++;
		}
		$this->setVar('counter', $t);
	}

}