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
	
	public function __construct(&$db) {
		global $albumConfig;
		parent::__construct($db, "album", "album_id", "album_title", "album_description", "album");
		$this->addPermission('album_grpperm', _CO_ALBUM_ALBUM_ALBUM_GRPPERM, _CO_ALBUM_ALBUM_ALBUM_GRPPERM_DSC);
		$this->addPermission('album_uplperm', _CO_ALBUM_ALBUM_ALBUM_UPLPERM, _CO_ALBUM_ALBUM_ALBUM_UPLPERM_DSC);
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $albumConfig['image_file_size'], $albumConfig['image_upload_width'], $albumConfig['image_upload_height']);
		$this->_album_cache_path = ICMS_CACHE_PATH . '/' . ALBUM_DIRNAME . '/' . $this->_itemname;
		$this->_album_thumbs_path = $this->_album_cache_path . '/thumbs';
		$this->_album_images_path = $this->_album_cache_path . '/images';
	}
	
	public function getAlbumThumbsPath() {
		$dir = $this->_album_thumbs_path;
		if (!file_exists($dir)) {
			mkdir($dir, '0777', TRUE);
		}
		return $dir . '/';
	}
	
	public function getmod_album_ImagesPath() {
		$dir = $this->_album_images_path;
		if (!file_exists($dir)) {
			mkdir($dir, '0777', TRUE);
		}
		return $dir . '/';
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
	
	// retrieve a list of Albums
	public function getList($status = null, $approve = null) {
		$criteria = new icms_db_criteria_Compo();
		if($status) $criteria->add(new icms_db_criteria_Item('album_active', TRUE));
		if($approve) $criteria->add(new icms_db_criteria_Item('album_approve', TRUE));
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		$albums = & $this->getObjects($criteria, TRUE);
		foreach(array_keys($albums) as $i) {
			$ret[$albums[$i]->id()] = $albums[$i]->title();
		}
		return $ret;
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
		foreach ($albums as $album){
			$ret[$album['album_id']] = $album;
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
		$album = FALSE;
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", trim($seo)));
		$albums = $this->getObjects($criteria, FALSE, FALSE);
		if($albums) $album = $this->get($albums[0]['id']);
		return $album;
	}
	/**
	 * adding some filters for module ACP
	 */
	public function album_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function album_inblocks_filter() {
		return array(0 => 'Hidden', 1 => 'Visible');
	}
	
	public function album_onindex_filter() {
		return array(0 => 'Hidden', 1 => 'Visible');
	}
	
	public function album_approve_filter() {
		return array(0 => 'Denied', 1 => 'Approved');
	}
	
	/**
	 * retrieve the images from uploads/album/albumimages/
	 */
	static public function getImageList() {
		$albumimages = array();
		$albumimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/uploads/' . icms::$module -> getVar( 'dirname' ) . '/album/', '', array('gif', 'jpg', 'png'));
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
	public function getBreadcrumbForPid($album_id, $userside=FALSE){
		$ret = FALSE;
		if ($album_id == FALSE) {
			return $ret;
		} else {
			if ($album_id > 0) {
				$album = $this->get($album_id);
				if ($album->getVar('album_id', 'e') > 0) {
					if (!$userside) {
						$ret = "<a href='" . ALBUM_URL . "index.php?album_id=" . $album->getVar('album_id', 'e') . "&amp;album_pid=" . $album->getVar('album_id', 'e') . "'>" . $album->getVar('album_title', 'e') . "</a>";
					} else {
						$ret = "<a href='" . ALBUM_URL . "index.php?album=" . $album->short_url() . "'>" . $album->title() . "</a>";
					}
					if ($album->getVar('album_pid', 'e') == 0) {
						if (!$userside){
							return "<a href='" . ALBUM_URL . "index.php?album_id=" . $album->getVar('album_id', 'e') . "'>" . _MI_ALBUM_ALBUMS . "</a> &nbsp;:&nbsp; " . $ret;
						} else {
							return $ret;
						}
					} elseif ($album->getVar('album_pid','e') > 0) {
						$ret = $this->getBreadcrumbForPid($album->getVar('album_pid', 'e'), $userside) . " &nbsp;:&nbsp; " . $ret;
					}
				}
			} else {
				return $ret;
			}
		}
		return $ret;
	}
	
	//update hit-counter
	public function updateCounter($album_id) {
		global $album_isAdmin;
		$albumObj = $this->get($album_id);
		if (!is_object($albumObj)) return FALSE;

		if (isset($albumObj->vars['counter']) && !is_object(icms::$user) || (!$album_isAdmin && $albumObj->getVar('album_uid', 'e') != icms::$user->uid ()) ) {
			$new_counter = $albumObj->getVar('counter') + 1;
			$albumObj->setVar("counter", $new_counter);
			$albumObj->updating_counter = TRUE;
			$this->insert($albumObj, TRUE);
		}
		return TRUE;
	}
	
	// some fuctions related to icms core functions
	public function getAlbumsForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart($offset);
		$criteria->setLimit($limit);
		if ($userid != 0) $criteria->add(new icms_db_criteria_Item('album_uid', $userid));

		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('album_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('album_description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		$criteria->add(new icms_db_criteria_Item('album_active', TRUE));
		$criteria->add(new icms_db_criteria_Item('album_approve', TRUE));
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
		$dsc = $obj->getVar("album_description", "e");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$obj->setVar("album_description", $dsc);
		// check seo and check, if the seo doesn't exist twice
		$seo = $obj->short_url();
		$title = $obj->title();
		if($seo == "") {
			$seotitle = icms_ipf_Metagen::generateSeoTitle($title, FALSE);
			$obj->setVar("short_url", $seotitle);
			$seo = $seotitle;
		} else {
			$seotitle = icms_ipf_Metagen::generateSeoTitle($seo, FALSE);
		}
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seotitle));
		if($this->getCount($criteria) > 0) {
			$obj->setErrors(_CO_INDEX_ERRORS_TAG_SEO_EXISTS);
			return FALSE;
		}
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		if($obj->updating_counter) return TRUE;
		// check, if parent album not current album
		if ($obj->getVar('album_pid','e') == $obj->getVar('album_id','e')){
			$obj->setVar('album_pid', 0);
		}
		// check, if an image has been uploaded
		if (!$obj->getVar("album_img_upload", "e") == "") {
			$obj->setVar('album_img', $obj->getVar('album_img_upload') );
		}
		// handle tags
		$tags = trim($obj->getVar("album_tags"));
		if($tags != "" && $tags != "0" && icms_get_module_status("index")) {
			$indexModule = icms_getModuleInfo("index");
			$tag_handler = icms_getModuleHandler("tag", $indexModule->getVar("dirname") , "index");
			$tagarray = explode(",", $tags);
			$tagarray = array_map('strtolower', $tagarray);
			$newArray = array();
			foreach ($tagarray as $key => $tag) {
				$intersection = array_intersect($tagarray, array($tag));
				$count = count($intersection);
				if($count > 1) {
					unset($tagarray[$key]);
				} else {
					
					$tag_id = $tag_handler->addTag(ucwords($tag), FALSE, $obj, $obj->getVar("album_published_date", "e"), $obj->getVar("album_uid", "e"), "album_description", $obj->getVar("album_img", "e"));
					$newArray[] = $tag_id;
				}
				unset($intersection, $count);
			}
			$obj->setVar("album_tags", implode(",", $newArray));
			unset($tags, $tag_handler, $tags, $tagarray);
		}
		return TRUE;
	}
	
	protected function afterSave(& $obj) {
		global $albumConfig;
		if($obj->updating_counter) 
		return TRUE;
		if($obj->getVar('album_published_date') < time()) {
			if (!$obj->getVar('album_notification_sent') && $obj->isActive() && $obj->isApproved() && $obj->isOnindex() ) {
				$obj->sendNotifAlbumPublished();
				$obj->setVar('album_notification_sent', TRUE);
				$obj->updating_counter = TRUE;
				$this->insert ($obj);
			}
		}
		
		if($albumConfig['album_autopost_twitter'] == 1) {
			$this->sendTwitterPost($obj);
		}
		return TRUE;
	}
	
	protected function afterDelete(& $obj) {
		$notification_handler = icms::handler( 'icms_data_notification' );
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname( icms::$module->getVar('dirname'));
		$module_id = icms::$module->getVar('mid');
		$category = 'global';
		$album_id = $obj->id();
		// delete global notifications
		$notification_handler->unsubscribeByItem($module_id, $category, $album_id);
		//delete images
		$images_handler = icms_getModuleHandler("images", "album");
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("a_id", $obj->id()));
		$images_handler->deleteAll($criteria);
		//delete all linked tags
		$link_handler = icms_getModuleHandler("link", "index");
		$link_handler->deleteAllByCriteria(FALSE, FALSE, $module_id, $this->_itemname, $album_id);
		unset($notification_handler, $module_handler, $module, $link_handler);
		return TRUE;
	}
}