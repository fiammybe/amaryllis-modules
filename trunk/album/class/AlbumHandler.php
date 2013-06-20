<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/AlbumHandler.php
 *
 * Classes responsible for managing album album objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));
icms_loadLanguageFile("album", "common");

class mod_album_AlbumHandler extends icms_ipf_Handler {

	public $_album_cache_path;
	public $_album_thumbs_path;
	public $_album_images_path;

	public $_moduleID;
	public $_moduleUseMain;
	public $_moduleUseRewrite;

	public $_index_module_status = FALSE;
	public $_index_module_dirname = FALSE;
	public $_index_module_mid = FALSE;

	public $_labelArray;
	private $_usersArray;
	private $_albumArray;

	public function __construct(&$db) {
		global $albumConfig;
		parent::__construct($db, "album", "album_id", "album_title", "album_description", "album");
		$this->addPermission('album_grpperm', _CO_ALBUM_ALBUM_ALBUM_GRPPERM, _CO_ALBUM_ALBUM_ALBUM_GRPPERM_DSC);
		$this->addPermission('album_uplperm', _CO_ALBUM_ALBUM_ALBUM_UPLPERM, _CO_ALBUM_ALBUM_ALBUM_UPLPERM_DSC);
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $albumConfig['image_file_size'], $albumConfig['image_upload_width'], $albumConfig['image_upload_height']);
		$this->_album_cache_path = ICMS_ROOT_PATH.'/cache/'.ALBUM_DIRNAME.'/'.$this->_itemname;
		$this->_album_thumbs_path = $this->_album_cache_path . '/thumbs';
		$this->_album_images_path = $this->_album_cache_path . '/images';
		$this->_index_module_status = icms_get_module_status("index");
		if($this->_index_module_status) {
			$indexModule = icms_getModuleInfo("index");
			$this->_index_module_dirname = $indexModule->getVar("dirname");
			$this->_index_module_mid = $indexModule->getVar("mid");
			unset($indexModule);
		}
		$aModule = icms::handler('icms_module')->getByDirname(ALBUM_DIRNAME);
		if(is_object($aModule))
		$this->_moduleID = $aModule->getVar("mid");
		unset($aModule);

		$this->_uploadPath = ICMS_ROOT_PATH."/uploads/".ALBUM_DIRNAME."/";
		$this->_uploadUrl = ICMS_URL."/uploads/".ALBUM_DIRNAME."/";
		$this->_moduleUseMain = (($albumConfig['use_main'] == 1) || (isset($GLOBALS['MODULE_'.strtoupper(ALBUM_DIRNAME).'_USE_MAIN']) &&
									$GLOBALS['MODULE_'.strtoupper(ALBUM_DIRNAME).'_USE_MAIN'] === TRUE)) ? TRUE : FALSE;
		$this->_moduleUseRewrite = ($albumConfig['use_rewrite'] == 1) ? TRUE : FALSE;
		$this->_moduleUrl = ($this->_moduleUseMain) ? ICMS_URL.'/' : ICMS_MODULES_URL.'/'.ALBUM_DIRNAME.'/';
		$this->_moduleUrl = ($this->_moduleUseRewrite) ? $this->_moduleUrl.ALBUM_DIRNAME.'/' : $this->_moduleUrl;
		$this->_page = ($this->_moduleUseMain) ? ALBUM_DIRNAME.'.php' : "index.php";
		$this->_page = ($this->_moduleUseRewrite) ? "" : $this->_page;
	}

	public function getAlbumThumbsPath() {
		$dir = $this->_album_thumbs_path;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir . '/';
	}

	public function getAlbumImagesPath() {
		$dir = $this->_album_images_path;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir . '/';
	}

	public function getImagePath() {
		$dir = $this->_uploadPath.$this->_itemname;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir."/";
	}

	public function loadUsers() {
		global $icmsConfig, $icmsConfigUser;
		if(!count($this->_usersArray)) {
			$member_handler = icms::handler("icms_member_user");
			$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("level", 0, '>='));
			$sql = "SELECT DISTINCT (album_uid) FROM " . $this->table;
			$critTray = new icms_db_criteria_Compo();
			if ($result = icms::$xoopsDB->query($sql)) {
				while ($myrow = icms::$xoopsDB->fetchArray($result)) {
					$critTray->add(new icms_db_criteria_Item("uid", $myrow['album_uid']), "OR");
				}
			}
			$criteria->add($critTray);
			$users = $member_handler->getObjects($criteria, TRUE);
			unset($criteria);
			foreach (array_keys($users) as $key) {
				$arr = array();
				$arr['uid'] = $key;
				$arr['link'] = '<a class="user_link" href="'.ICMS_URL.'/userinfo.php?uid='.$key.'">'.$users[$key]->getVar("uname").'</a>';
				if ($users[$key]->getVar('user_avatar') && $users[$key]->getVar('user_avatar') != 'blank.gif' && $users[$key]->getVar('user_avatar') != ''){
					$arr['avatar'] = ICMS_UPLOAD_URL.'/'.$users[$key]->getVar('user_avatar');
				} elseif ($icmsConfigUser['avatar_allow_gravatar'] == 1) {
					$arr['avatar'] = $users[$key]->gravatar('G', $icmsConfigUser['avatar_width']);
				}
				$arr['attachsig'] = $users[$key]->getVar("attachsig");
				$arr['user_sig'] = icms_core_DataFilter::checkVar($users[$key]->getVar("user_sig", "n"), "html", "output");
				$arr['uname'] = $users[$key]->getVar("uname");
				$arr['icq'] = $users[$key]->getVar("user_icq");
				$arr['msn'] = $users[$key]->getVar("user_msnm");
				$arr['yim'] = $users[$key]->getVar("user_yim");
				$arr['regdate'] = date("d/m/Y", $users[$key]->getVar("user_regdate", "e"));
				$this->_usersArray[$key] = $arr;
				unset($arr, $users[$key]);
			}
			unset($users, $member_handler);
		}
		return $this->_usersArray;
	}

	public function loadLabels() {
		if(!count($this->_labelArray) && $this->_index_module_status) {
			$label_handler = icms_getModuleHandler("label", $this->_index_module_dirname, "index");
			$labels = $label_handler->getObjects(NULL, TRUE, FALSE);
			foreach ($labels as $key => $value) {
				$this->_labelArray[$value['title']] = $value;
			}
			unset($label_handler, $labels);
		}
		return $this->_labelArray;
	}

	public function loadAlbums() {
		if(!count($this->_albumArray)) {
			$albums = $this->getObjects(NULL, TRUE, FALSE);
			foreach ($albums as $key => $value) {
				$this->_albumArray[$key] = $value;
			}
			unset($albums);
		}
		return $this->_albumArray;
	}

	public function getAlbumCriterias($active = FALSE, $approve = FALSE, $onindex = FALSE, $album_uid = FALSE, $album_id = FALSE,  $album_pid = NULL, $tag = FALSE,
										$start = 0, $limit = 0, $order = 'weight', $sort = 'ASC', $perm = 'album_grpperm', $inblocks = FALSE ) {
		global $album_isAdmin;
		$criteria = new icms_db_criteria_Compo();
		if($start) $criteria->setStart($start);
		if($limit) $criteria->setLimit((int)$limit);
		if($order) $criteria->setSort($order);
		if($sort) $criteria->setOrder($sort);
		if($active)	$criteria->add(new icms_db_criteria_Item('album_active', TRUE));
		if($approve) $criteria->add(new icms_db_criteria_Item('album_approve', TRUE));
		if($onindex) $criteria->add(new icms_db_criteria_Item('album_onindex', TRUE));
		if($album_uid) $criteria->add(new icms_db_criteria_Item("album_uid", $album_uid));
		if($album_id) $criteria->add(new icms_db_criteria_Item("album_id", $album_id));
		if ($album_pid === 0) $album_pid = 0;
		if ($album_pid === 0 OR $album_pid > 0) $criteria->add(new icms_db_criteria_Item('album_pid', (int)$album_pid));
		if($tag) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("album_tags", $tag . ',%', "LIKE"), 'OR');
			$critTray->add(new icms_db_criteria_Item("album_tags", '%,' . $tag . ',%', "LIKE"), 'OR');
			$critTray->add(new icms_db_criteria_Item("album_tags", '%,' . $tag, "LIKE"), 'OR');
			$criteria->add($critTray);
		}
		$this->setGrantedObjectsCriteria($criteria, $perm);
		if($inblocks) $criteria->add(new icms_db_criteria_Item('album_inblocks', TRUE));

		return $criteria;
	}

	// get a album List for pid
	public function getAlbumListForPid($active = FALSE, $approve = FALSE, $onindex = FALSE, $album_uid = FALSE, $album_id = FALSE,  $album_pid = NULL,
								$start = 0, $limit = 0, $order = 'weight', $sort = 'ASC', $perm = "album_uplperm", $inblocks = FALSE, $showNull = TRUE) {
		global $album_isAdmin;
		$criteria = $this->getAlbumCriterias($active, $approve, $onindex, $album_uid, $album_id, $album_pid, FALSE, $start, $limit, $order, $sort, $perm, $inblocks);
		$albums = & $this->getObjects($criteria, TRUE);
		$ret = array();
		if ($showNull) {
			$ret[0] = '-----------------------';
		}
		foreach(array_keys($albums) as $i) {
			$ret[$i] = $albums[$i]->title();
			$subalbums = $this->getAlbumListForPid($active, $approve, $onindex, $album_uid, $album_id, $albums[$i]->id(), $start, $limit, $order, $sort, $perm, $inblocks);
			foreach(array_keys($subalbums) as $j) {
				$ret[$j] = '-' . $subalbums[$j];
			}
		}
		return $ret;
	}

	public function getAlbums($active = FALSE, $approve = FALSE, $onindex = FALSE, $album_uid = FALSE, $album_id = FALSE,  $album_pid = FALSE, $tag = FALSE,
								$start = 0, $limit = 0, $order = 'weight', $sort = 'ASC', $perm = "album_grpperm", $inblocks = FALSE) {
		$criteria = $this->getAlbumCriterias($active, $approve, $onindex, $album_uid, $album_id, $album_pid, $tag, $start, $limit, $order, $sort, $perm, $inblocks);
		$albums = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($albums as $key => $album){
			$ret[$key] = $album;
		}
		return $ret;
	}

	public function getAlbumsCount ($active = FALSE, $approve = FALSE, $onindex = FALSE, $album_uid = FALSE, $album_id = FALSE,  $album_pid = FALSE, $tag = FALSE,
								$start = 0, $limit = 0, $order = 'weight', $sort = 'ASC', $perm = "album_grpperm", $inblocks = FALSE) {
		$criteria = $this->getAlbumCriterias($active, $approve, $onindex, $album_uid, $album_id, $album_pid, $tag, $start, $limit, $order, $sort, $perm, $inblocks);
		return $this->getCount($criteria);
	}

	public function changeField($album_id, $field) {
		$albumObj = $this->get($album_id);
		if ($albumObj->getVar("$field", "e") == TRUE) {
			$albumObj->setVar("$field", 0);
			$value = 0;
		} else {
			$albumObj->setVar("$field", 1);
			$value = 1;
		}
		$albumObj->updating_counter = TRUE;
		$this->insert($albumObj, TRUE);
		return $value;
	}

	public function getAlbumBySeo($seo) {
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", trim($seo)));
		$albums = $this->getObjects($criteria, FALSE, TRUE);
		if(!$albums || !is_object($albums[0])) return FALSE;
		return $albums[0];
	}
	/**
	 * adding some filters for module ACP
	 */
	public function album_active_filter() {
		return array(0 => _CO_ALBUM_OFFLINE, 1 => _CO_ALBUM_ONLINE);
	}

	public function album_inblocks_filter() {
		return array(0 => _CO_ALBUM_OFF_BLOCKS, 1 => _CO_ALBUM_IN_BLOCKS);
	}

	public function album_onindex_filter() {
		return array(0 => _CO_ALBUM_OFF_INDEX, 1 => _CO_ALBUM_ON_INDEX);
	}

	public function album_approve_filter() {
		return array(0 => _CO_ALBUM_DENIED, 1 => _CO_ALBUM_APPROVED);
	}

	/**
	 * retrieve the images from uploads/album/albumimages/
	 */
	public function getImageList() {
		$albumimages = array();
		$albumimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH.'/uploads/'.icms::$module->getVar('dirname').'/album/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($albumimages) as $i ) {
			$ret[$i] = $albumimages[$i];
		}
		return $ret;
	}

	/**
	 * frontend permission control
	 */
	public function userCanSubmit() {
		global $album_isAdmin, $albumConfig;
		if ($album_isAdmin) return TRUE;
		$user_groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		return count(array_intersect($albumConfig['uploader_groups'], $user_groups)) > 0;
	}

	// get breadcrumb
	public function getBreadcrumbForPid($album_id = FALSE){
		$ret = FALSE;
		if($album_id == FALSE) return $ret;
		if ($album_id > 0) {
			$albums = $this->loadAlbums();
			$album = isset($albums[$album_id]) ? $albums[$album_id] : FALSE;
			if ($album) {
				if($GLOBALS['MODULE_'.strtoupper(ALBUM_DIRNAME).'_USE_MAIN'] === TRUE) {
					$ret = "<li><a class='album_breadcrumb_link' href='".ICMS_URL."/".ALBUM_DIRNAME.".php?album=".$album['short_url']."' title='".$album['title']."'>".$album['title']."</a></li>";
				} else {
					$ret = "<li><a class='album_breadcrumb_link' href='".ALBUM_URL."index.php?album=".$album['short_url']."' title='".$album['title']."'>".$album['title']."</a></li>";
				}
				if ($album['album_pid'] == 0) {
					return $ret;
				} elseif ($album['album_pid'] > 0) {
					$ret = $this->getBreadcrumbForPid($album['album_pid']) .$ret;
				}
			}
		} else {
			return $ret;
		}
		return $ret;
	}

	//update hit-counter
	public function updateCounter(&$albumObj) {
		global $album_isAdmin;
		if (!is_object($albumObj)) return FALSE;
		if (!is_object(icms::$user) || (!$album_isAdmin && $albumObj->getVar('album_uid', 'e') != icms::$user->uid ()) ) {
			$new_counter = $albumObj->getVar('counter') + 1;
			$albumObj->setVar("counter", $new_counter);
			$albumObj->updating_counter = TRUE;
			$albumObj->store(TRUE);
		}
		return TRUE;
	}

	// some fuctions related to icms core functions
	public function getAlbumsForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = $this->getAlbumCriterias(TRUE, TRUE, TRUE, $userid, FALSE, FALSE, FALSE, $offset, $limit, "album_published_date", "DESC", "album_grpperm", FALSE);
		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('album_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('album_description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				if($this->_index_module_status) {
					$criteriaKeyword->add(new icms_db_criteria_Item('album_tags', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				}
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		return $this->getObjects($criteria, TRUE, FALSE);
	}

	public function updateComments($album_id, $total_num) {
		$albumObj = $this->get($album_id);
		if ($albumObj && !$albumObj->isNew()) {
			$albumObj->setVar('album_comments', $total_num);
			$albumObj->updating_counter = TRUE;
			$this->insert($albumObj, TRUE);
		}
	}

	// some related functions for storing
	protected function beforeInsert(&$obj) {
		if ($obj->updating_counter)
		return TRUE;
		// check seo and check, if the seo doesn't exist twice
		$seo = trim($obj->getVar("short_url", "e"));
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle(trim($obj->title()), FALSE);
		$seo = urldecode($seo);
		$umlaute = array("ä","ö","ü","Ä","Ö","Ü","ß");
		$replace = array("ae","oe","ue","Ae","Oe","Ue","ss");
		$seo = str_ireplace($umlaute, $replace, $seo);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
		}
		$obj->setVar("short_url", $seo);
		return TRUE;
	}

	protected function beforeSave(&$obj) {
		if($obj->updating_counter) return TRUE;
		// check, if parent album not current album
		if ($obj->getVar('album_pid','e') == $obj->getVar('album_id','e')){
			$obj->setVar('album_pid', 0);
		}
		// check, if an image has been uploaded
		if ($obj->getVar("album_img_upload", "e") !== "") {
			$obj->setVar('album_img', $obj->getVar('album_img_upload') );
			$obj->setVar('album_img_upload', '');
		}
		return TRUE;
	}

	protected function afterSave(&$obj) {
		global $albumConfig, $icmsConfig;
		//if($obj->updating_counter)
		//return TRUE;
		$needUpdate = FALSE;
		if($obj->getVar('album_published_date') < time()) {
			if (!$obj->getVar('album_notification_sent') && $obj->isActive() && $obj->isApproved() && $obj->isOnindex() ) {
				$obj->sendNotifAlbumPublished();
				$obj->setVar('album_notification_sent', TRUE);
				$needUpdate = TRUE;
			}
		}
		if($this->_index_module_status && $obj->isActive() && $obj->isApproved()) {
			$link_handler = icms_getModuleHandler("link", $this->_index_module_dirname, "index");
			$link_handler->deleteAllByCriteria(FALSE, FALSE, $this->_moduleID, $this->_itemname, $obj->id());
			$img = $obj->getVar("album_img", "e");$title = $obj->title();$teaser = $obj->summary();$lang = FALSE;
			$labels = trim($obj->getVar("album_tags")); $pid = $obj->getVar("album_pid", "e"); $pdate = $obj->getVar("album_published_date", "e");
			if($labels != "") {
				$label_handler = icms_getModuleHandler("label", $this->_index_module_dirname, "index");
				$labels = explode(",", $labels);
				$labelarray = array_map('strtolower', $labels);
				$newArray = array();
				foreach ($labels as $key => $label) {
					$intersection = array_intersect($labelarray, array(strtolower($label)));
					$count = count($intersection);
					if($count >= 2) {
						unset($labels[$key]);
						$needUpdate = TRUE;
					} else {
						if(!$label_handler->addLabel($label, 0, $this->_moduleID, $this->_itemname, "album=".$obj->short_url(), $obj->id(), $img, $teaser, $title, $pid , $lang, $pdate)) return FALSE;
						$labelname = $label_handler->addLabel($label, 0, $this->_moduleID, $this->_itemname, "album=".$obj->short_url(), $obj->id(), $img, $teaser, $title, $pid , $lang, $pdate);
						$newArray[] = $labelname;
						if($labelname != $label) $needUpdate = TRUE;
					}
					unset($intersection, $count);
				}
				$obj->setVar("album_tags", implode(",", $newArray));
				unset($labels, $label_handler, $labelarray);
			}

		} elseif ($this->_index_module_status && (!$obj->isActive() || !$obj->isApproved())) {
			$link_handler = icms_getModuleHandler("link", $this->_index_module_dirname, "index");
			$link_handler->deleteAllByCriteria(FALSE, FALSE, $this->_moduleID, $this->_itemname, $obj->id());
		}

		$pid = $obj->getVar("album_pid", "e");
		if($pid > 0) {
			$album = $this->get($pid);
			if(is_object($album)) {
				$subs = $album->getVar("album_hassub", "e");
				$album->setVar("album_hassub", $subs+1);
				$album->_updating = TRUE;
				$this->insert($album, TRUE);
			}
		}
		if($needUpdate) {
			$obj->updating_counter = TRUE;
			$obj->store(TRUE);
		}
		return TRUE;
	}

	protected function afterDelete(& $obj) {
		$notification_handler = icms::handler( 'icms_data_notification' );
		$notification_handler->unsubscribeByItem($this->_moduleID, "global", $obj->id());
		//delete images
		$images_handler = new mod_album_ImagesHandler(icms::$xoopsDB);
		$criteria = new icms_db_criteria_Item("a_id", $obj->id());
		$images_handler->deleteAll($criteria);
		//delete all linked tags
		$link_handler = icms_getModuleHandler("link", $this->_index_module_dirname, "index");
		$link_handler->deleteAllByCriteria(FALSE, FALSE, $this->_moduleID, $this->_itemname, $obj->id());
		if(is_file($this->_album_images_path.$obj->getVar("album_img", "e"))) {
			icms_core_Filesystem::deleteFile($this->_album_images_path.$obj->getVar("album_img", "e"));
		}
		if(is_file($this->_album_thumbs_path.$obj->getVar("album_img", "e"))) {
			icms_core_Filesystem::deleteFile($this->_album_images_path.$obj->getVar("album_img", "e"));
		}
		unset($notification_handler, $link_handler);
		return TRUE;
	}
}