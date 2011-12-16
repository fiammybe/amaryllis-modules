<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/DownloadHandler.php
 * 
 * Classes responsible for managing Downloads download objects
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

class DownloadsDownloadHandler extends icms_ipf_Handler {

	private $_download_grpperm = array();
	
	private $_download_limitations = array();
	
	private $_download_platform = array();
	
	private $_download_version_status = array();
	
	private $_download_license = array();
	
	public $_moduleName;

	public function __construct(&$db) {
		global $downloadsConfig;
		parent::__construct($db, "download", "download_id", "download_title", "download_description", "downloads");
		$this->addPermission('download_grpperm', _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_GRPPERM, _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_GRPPERM_DSC);
		
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($allowedMimeTypes = true, $downloadsConfig['image_file_size'], $downloadsConfig['image_upload_width'], $downloadsConfig['image_upload_height']);
		
		$mimetypes = $this->checkMimeType();
		$filesize = $downloadsConfig['downloads_file_size'];
		$this->enableUpload($mimetypes,	$filesize);
	}
	
	public function checkMimeType() {
		global $icmsModule;
		$mimetypeHandler = icms_getModulehandler('mimetype', 'system');
		$modulename = basename(dirname(dirname(__FILE__)));
		if (empty($this->mediaRealType) && empty($this->allowUnknownTypes)) {
			icms_file_MediaUploadHandler::setErrors(_ER_UP_UNKNOWNFILETYPEREJECTED);
			return false;
		}
		$AllowedMimeTypes = $mimetypeHandler->AllowedModules($this->mediaRealType, $modulename);
		if ((!empty($this->allowedMimeTypes) && !in_array($this->mediaRealType, $this->allowedMimeTypes))
				|| (!empty($this->deniedMimeTypes) && in_array($this->mediaRealType, $this->deniedMimeTypes))
				|| (empty($this->allowedMimeTypes) && !$AllowedMimeTypes))
			{
			icms_file_MediaUploadHandler::setErrors(sprintf(_ER_UP_MIMETYPENOTALLOWED, $this->mediaType));
			return false;
		}
		return true;
	}
	
	public function getList($download_active = null) {
		$criteria = new icms_db_criteria_Compo();
		if (isset($download_active)) {
			$criteria->add(new icms_db_criteria_Item('download_active', true));
		}
		$downloads = & $this->getObjects($criteria, true);
		$ret[]= array();
		foreach(array_keys($downloads) as $i) {
			$ret[$downloads[$i]->getVar('download_id')] = $downloads[$i]->getVar('download_title');
		}
		return $ret;
	}
	
	// some criterias used by other requests
	public function getDownloadsCriteria($start = 0, $limit = 0, $download_publisher = false, $download_id = false,$download_cid = false, $order = 'download_published_date', $sort = 'DESC') {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if ($download_publisher) $criteria->add(new icms_db_criteria_Item('download_publisher', $download_publisher));
		if ($download_id) {
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('short_url', $download_id,'LIKE'));
			$alt_download_id = str_replace('-',' ',$download_id);
			//Added for backward compatiblity in case short_url contains spaces instead of dashes.
			$crit->add(new icms_db_criteria_Item('short_url', $alt_download_id),'OR');
			$crit->add(new icms_db_criteria_Item('download_id', $download_id),'OR');
			$criteria->add($crit);
		}
		if ($download_cid !== false)	$criteria->add(new icms_db_criteria_Item('download_cid', $download_cid));
		return $criteria;
	}
	
	public function getDownloads($start = 0, $limit = 0, $download_publisher = false, $download_id = false,  $download_cid = false, $order = 'weight', $sort = 'ASC') {
		
		$criteria = $this->getDownloadsCriteria($start, $limit, $download_publisher, $download_id,  $download_cid, $order, $sort);
		$downloads = $this->getObjects($criteria, true, false);
		$ret = array();
		foreach ($downloads as $download){
			if ($download['accessgranted']){
				$ret[$download['download_id']] = $download;
			}
		}
		return $ret;
	}
	
	public function getDownload($download_id) {
		$ret = $this->getDownloads(0, 0, false, $download_id);
		return isset($ret[$download_id]) ? $ret[$download_id] : false;
	}
	
	public function getDownloadsForBlocks($start = 0, $limit = 0,$updated = FALSE,$popular = FALSE, $order = 'download_published_date', $sort = 'DESC') {
		global $downloadsConfig;
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart(0);
		$criteria->setLimit($limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		$criteria->add(new icms_db_criteria_Item('download_active', true));
		$criteria->add(new icms_db_criteria_Item('download_inblocks', true));
		$criteria->add(new icms_db_criteria_Item('download_approve', true));
		if($updated == TRUE) $criteria->add(new icms_db_criteria_Item('download_updated', TRUE));
		if($popular == TRUE) {
			$pop = $downloadsConfig['downloads_popular'];
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item('counter', $pop, ">="));
			$criteria->add($critTray);
			
		}
		$downloads = $this->getObjects($criteria, true, false);
		$ret=array();
		foreach ($downloads as $key => &$download){
			if ($download['accessgranted']){
				$ret[$download['download_id']] = $download;
			}
		}
		return $ret;
	}
	
	public function getCatalogueItems() {
		$catalogueModule = icms_getModuleInfo('catalogue');
		$catalogue_item_handler = icms_getModuleHandler ('item', $catalogueModule->getVar('dirname'), 'catalogue');
		$criteria = new icms_db_criteria_Compo();
		$criteria->add (new icms_db_criteria_Item('online_status', true));
		$catalogueObjects = $catalogue_item_handler->getObjects($criteria, true, false);
		$ret = array();
		$ret[0] = '--None--';
		foreach(array_keys($catalogueObjects) as $i) {
			$ret[$catalogueObjects[$i]['item_id']] = $catalogueObjects[$i]['title'];
		}
		return $ret;
	}
	
	public function getAlbumList() {
		$albumModule = icms_getModuleInfo('album');
		$album_album_handler = icms_getModuleHandler ('album', $albumModule->getVar('dirname'), 'album');
		$albumObjects = $album_album_handler->getAlbumsForBlocks($start = 0, $limit = 0, $order = 'album_title', $sort = 'ASC');
		$ret = array();
		$ret[0] = '--None--';
		foreach(array_keys($albumObjects) as $i) {
			$ret[$albumObjects[$i]['album_id']] = $albumObjects[$i]['album_title'];
		}
		return $ret;
	}

	public function userCanSubmit($category_id) {
		global $downloads_isAdmin;
		$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');
		$categoryObject = $downloads_category_handler->get($category_id);
		if (!is_object(icms::$user)) return false;
		if ($downloads_isAdmin) return true;
		$user_groups = icms::$user->getGroups();
		$module = icms::handler("icms_module")->getByDirname(basename(dirname(dirname(__FILE__))), TRUE);
		return count(array_intersect(array($categoryObject->getVar('category_uplperm')), $user_groups)) > 0;
		
	}

	public function changeVisible($download_id) {
		$visibility = '';
		$downloadObj = $this->get($download_id);
		if ($downloadObj->getVar('download_active', 'e') == true) {
			$downloadObj->setVar('download_active', 0);
			$visibility = 0;
		} else {
			$downloadObj->setVar('download_active', 1);
			$visibility = 1;
		}
		$this->insert($downloadObj, true);
		return $visibility;
	}
	
	public function changeShow($download_id) {
		$show = '';
		$downloadObj = $this->get($download_id);
		if ($downloadObj->getVar('download_inblocks', 'e') == true) {
			$downloadObj->setVar('download_inblocks', 0);
			$show = 0;
		} else {
			$downloadObj->setVar('download_inblocks', 1);
			$show = 1;
		}
		$this->insert($downloadObj, true);
		return $show;
	}
	
	public function changeApprove($download_id) {
		$approve = '';
		$downloadObj = $this->get($download_id);
		if ($downloadObj->getVar('download_approve', 'e') == true) {
			$downloadObj->setVar('download_approve', 0);
			$approve = 0;
		} else {
			$downloadObj->setVar('download_approve', 1);
			$approve = 1;
		}
		$this->insert($downloadObj, true);
		return $approve;
	}
	
	public function changeMirrorApprove($download_id) {
		$mirror_approve = '';
		$downloadObj = $this->get($download_id);
		if ($downloadObj->getVar('download_mirror_approve', 'e') == true) {
			$downloadObj->setVar('download_mirror_approve', 0);
			$mirror_approve = 0;
		} else {
			$downloadObj->setVar('download_mirror_approve', 1);
			$mirror_approve = 1;
		}
		$this->insert($downloadObj, true);
		return $mirror_approve;
	}
	
	public function changeBroken($download_id) {
		$broken = '';
		$downloadObj = $this->get($download_id);
		if ($downloadObj->getVar('download_broken', 'e') == true) {
			$downloadObj->setVar('download_broken', 0);
			$broken = 0;
		} else {
			$downloadObj->setVar('download_broken', 1);
			$broken = 1;
		}
		$this->insert($downloadObj, true);
		return $broken;
	}

	public function download_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function download_inblocks_filter() {
		return array(0 => 'Hidden', 1 => 'Visible');
	}
	
	public function download_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	public function download_broken_filter() {
		return array(0 => 'Online', 1 => 'Broken');
	}

	public function download_has_mirror_filter() {
		return array(0 => 'No Mirror', 1 => 'Has Mirror');
	}
	
	public function getDownloadVersionStatus() {
		global $downloadsConfig;
		if (!$this->_download_version_status) {
			$status_array = explode(",", $downloadsConfig['downloads_status_versiontypes']);
			foreach (array_keys($status_array) as $i) {
				$version_status[$status_array[$i]] = $status_array[$i];
			}
			return $version_status;
		}
		return $this->_download_version_status;
	}
	
	public function getDownloadLimitations() {
		global $downloadsConfig;
		if (!$this->_download_limitations) {
			$limitations_array = explode(",", $downloadsConfig['downloads_limitations']);
			foreach (array_keys($limitations_array) as $i) {
				$limitations[$limitations_array[$i]] = $limitations_array[$i];
			}
			return $limitations;
		}
		return $this->_download_limitations;
	}
	
	public function getDownloadLicense() {
		global $downloadsConfig;
		if (!$this->_download_license) {
			$license_array = explode("|", $downloadsConfig['downloads_license']);
			foreach (array_keys($license_array) as $i) {
				$license[$license_array[$i]] = $license_array[$i];
			}
			return $license;
		}
		return $this->_download_license;
	}
	
	public function getDownloadPlatform() {
		global $downloadsConfig;
		if (!$this->_download_license) {
			$platform_array = explode(",", $downloadsConfig['downloads_platform']);
			foreach (array_keys($platform_array) as $i) {
				$platform[$platform_array[$i]] = $platform_array[$i];
			}
			return $platform;
		}
		return $this->_download_license;
	}

	public function getGroups($criteria = null) {
		if (!$this->_download_grpperm) {
			$member_handler =& icms::handler('icms_member');
			$groups = $member_handler->getGroupList($criteria, true);
			return $groups;
		}
		return $this->_download_grpperm;
	}

	public function getPostersArray() {
		return icms::handler('icms_member')->getUserList();
	}
	
	public function getDownloadsCount($download_publisher) {
		$criteria = $this->getDownloadsCriteria(false, false, $download_publisher);
		return $this->getCount($criteria);
	}
	
	public function makeLink($download) {
		$count = $this->getCount(new icms_db_criteria_Item("short_url", $download->getVar("short_url")));

		if ($count > 1) {
			return $download->getVar('download_id');
		} else {
			$seo = str_replace(" ", "-", $download->getVar('short_url'));
			return $seo;
		}
	}
	
	public function getCountCriteria ($active = null, $approve = null, $groups = array(), $perm = 'download_grpperm', $download_publisher = false, $download_id = false, $download_cid = false) {
		$criteria = new icms_db_criteria_Compo();
		
		if (isset($active)) {
			$criteria->add(new icms_db_criteria_Item('download_active', true));
		}
		if (isset($approve)) {
			$criteria->add(new icms_db_criteria_Item('download_approve', true));
		}
		if (is_null($download_cid)) $download_cid = 0;
		$criteria->add(new icms_db_criteria_Item('download_cid', $download_cid));
		
		$downloads = $this->getObjects($criteria, true, false);
		$ret = array();
		foreach ($downloads as $download){
			if ($download['accessgranted']){
				$ret[$download['download_id']] = $download;
			}
		}
		return count($ret);
	
	}
	
	//update hit-counter
	public function updateCounter($download_id) {
		global $download_isAdmin;
		$downloadObj = $this->get($download_id);
		if (!is_object($downloadObj)) return false;

		if (isset($downloadObj->vars['counter']) && !is_object(icms::$user) || (!$download_isAdmin && $downloadObj->getVar('download_publisher', 'e') != icms::$user->uid ()) ) {
			$new_counter = $downloadObj->getVar('counter') + 1;
			$sql = 'UPDATE ' . $this->table . ' SET counter=' . $new_counter
				. ' WHERE ' . $this->keyName . '=' . $downloadObj->id();
			$this->query($sql, null, true);
		}
		return true;
	}
	
	// some fuctions related to icms core functions
	public function getDownloadsForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart($offset);
		$criteria->setLimit($limit);
		if ($userid != 0) $criteria->add(new icms_db_criteria_Item('download_publisher', $userid));

		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('download_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('download_description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$criteria->add(new icms_db_criteria_Item('download_active', true));
		$criteria->add(new icms_db_criteria_Item('download_approve', true));
		return $this->getObjects($criteria, true, false);
	}

	public function updateComments($download_id, $total_num) {
		$downloadObj = $this->get($download_id);
		if ($downloadObj && !$downloadObj->isNew()) {
			$downloadObj->setVar('download_comments', $total_num);
			$this->insert($downloadObj, true);
		}
	}
	
	// some related functions for storing
	protected function beforeSave(&$obj) {
		global $downloadsConfig;
		if ($obj->updating_counter)
		return true;
		if(!empty($mirror_url)) {
			$obj->setVar('download_has_mirror', 1);
		} else {
			$obj->setVar('download_has_mirror', 0);
		}
		return true;
		
	}
	
	protected function afterSave(&$obj) {
		if ($obj->updating_counter)
		return true;

		if (!$obj->getVar('download_notification_sent') && $obj->getVar('download_active', 'e') == true && $obj->getVar('download_approve', 'e') == true) {
			$obj->sendNotifDownloadPublished();
			$obj->setVar('download_notification_sent', true);
			$this->insert($obj);
		}
		return true;
	}
	
	protected function afterDelete(& $obj) {
		$notification_handler = icms::handler( 'icms_data_notification' );
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname( icms::$module -> getVar( 'dirname' ) );
		$module_id = icms::$module->getVar('mid');
		$category = 'global';
		$download_id = $obj->id();
		// delete global notifications
		$notification_handler->unsubscribeByItem($module_id, $category, $download_id);
		return true;
		
		$downloads_log_handler = icms_getModuleHandler("log", basename(dirname(dirname(__FILE__))), "downloads");
		if (!is_object(icms::$user)) {
			$log_uid = 0;
		} else {
			$log_uid = icms::$user->getVar("uid");
		}
		$logObj = $downloads_log_handler->create();
		$logObj->setVar('log_item_id', $obj->id() );
		$logObj->setVar('log_date', (time()-200) );
		$logObj->setVar('download_publisher', $log_uid);
		$logObj->setVar('log_item', 0 );
		$logObj->setVar('log_case', 2	 );
		$logObj->setVar('log_ip', $_SERVER['REMOTE_ADDR'] );
		$logObj->store(TRUE);
			
	}
	
}