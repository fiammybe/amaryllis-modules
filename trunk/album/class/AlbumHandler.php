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

icms_loadLanguageFile('album', 'common');

class AlbumAlbumHandler extends icms_ipf_Handler {
	
	public $_moduleName;
	
	public $_uploadPath;

	public function __construct(&$db) {
		parent::__construct($db, "album", "album_id", "album_title", "album_description", "album");
		$this->addPermission('album_grpperm', _CO_ALBUM_ALBUM_ALBUM_GRPPERM, _CO_ALBUM_ALBUM_ALBUM_GRPPERM_DSC);
		$this->addPermission('album_uplperm', _CO_ALBUM_ALBUM_ALBUM_UPLPERM, _CO_ALBUM_ALBUM_ALBUM_UPLPERM_DSC);
		$this->_uploadPath = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/albumimages/';
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, 2000000, 500, 500);
	}
	
	public function getImagePath() {
		$dir = $this->_uploadPath;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir, "0777", '' );
		}
		return $dir . "/";
	}
	
	// retrieve a list of Albums
	public function getList($album_active = null, $album_approve = null) {
		$criteria = new icms_db_criteria_Compo();
		if (isset($album_active)) {
			$criteria->add(new icms_db_criteria_Item('album_active', TRUE));
		}
		if (isset($album_approve)) {
			$criteria->add(new icms_db_criteria_Item('album_approve', TRUE));
		}
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		$albums = & $this->getObjects($criteria, TRUE);
		foreach(array_keys($albums) as $i) {
			$ret[$albums[$i]->getVar('album_id')] = $albums[$i]->getVar('album_title');
		}
		return $ret;
	}
	
	// some criterias used by other requests
	public function getAlbumsCriteria($start = 0, $limit = 0, $album_uid = FALSE, $album_id = FALSE,  $album_pid = FALSE, $order = 'album_published_date', $sort = 'DESC') {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if ($album_uid) $criteria->add(new icms_db_criteria_Item('album_uid', $album_uid));
		if ($album_id) {
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('short_url', $album_id,'LIKE'));
			$alt_album_id = str_replace('-',' ',$album_id);
			//Added for backward compatiblity in case short_url contains spaces instead of dashes.
			$crit->add(new icms_db_criteria_Item('short_url', $alt_album_id),'OR');
			$crit->add(new icms_db_criteria_Item('album_id', $album_id),'OR');
			$criteria->add($crit);
		}
		if ($album_pid !== FALSE)	$criteria->add(new icms_db_criteria_Item('album_pid', $album_pid));
		return $criteria;
	}
	
	// get a album List for pid
	public function getAlbumListForPid($groups = array(), $perm = 'album_grpperm', $status = null, $approve = null, $album_id = null, $showNull = TRUE) {
	
		$criteria = new icms_db_criteria_Compo();
		if (is_array($groups) && !empty($groups)) {
			$criteriaTray = new icms_db_criteria_Compo();
			foreach($groups as $gid) {
				$criteriaTray->add(new icms_db_criteria_Item('gperm_groupid', $gid), 'OR');
			}
			$criteria->add($criteriaTray);
			if ($perm == 'album_grpperm' || $perm == 'album_admin') {
				$criteria->add(new icms_db_criteria_Item('gperm_name', $perm));
				$criteria->add(new icms_db_criteria_Item('gperm_modid', 1));
			}
		}
		if (isset($status)) {
			$criteria->add(new icms_db_criteria_Item('album_active', TRUE));
		}
		if (isset($approve)) {
			$criteria->add(new icms_db_criteria_Item('album_approve', TRUE));
		}
		if (is_null($album_id)) $album_id = 0;
		$criteria->add(new icms_db_criteria_Item('album_pid', $album_id));
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		$albums = & $this->getObjects($criteria, TRUE);
		$ret = array();
		if ($showNull) {
			$ret[0] = '-----------------------';
		}
		foreach(array_keys($albums) as $i) {
			$ret[$i] = $albums[$i]->getVar('album_title');
			$subalbums = $this->getAlbumListForPid($groups, $perm, $status, $albums[$i]->getVar('album_id'), $showNull);
			foreach(array_keys($subalbums) as $j) {
				$ret[$j] = '-' . $subalbums[$j];
			}
		}
		return $ret;
	}
	
	public function getAlbums($approve = NULL, $onindex = NULL, $active = NULL, $start = 0, $limit = 0, $album_uid = FALSE, $album_id = FALSE,  $album_pid = FALSE, $order = 'weight', $sort = 'ASC') {
		$criteria = $this->getAlbumsCriteria($start, $limit, $album_uid, $album_id,  $album_pid, $order, $sort);
		if(isset($approve)) $criteria->add(new icms_db_criteria_Item("album_active", TRUE));
		if(isset($onindex)) $criteria->add(new icms_db_criteria_Item("album_onindex", TRUE));
		if(isset($active)) $criteria->add(new icms_db_criteria_Item("album_active", TRUE));
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		$albums = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($albums as $album){
			$ret[$album['album_id']] = $album;
		}
		return $ret;
	}

	public function getAlbumsCount ($active = NULL, $approve = NULL, $onindex = NULL, $groups = array(), $perm = 'album_grpperm', $album_uid = FALSE, $album_id = NULL, $album_pid = NULL) {
		$criteria = new icms_db_criteria_Compo();
		if(isset($active))	$criteria->add(new icms_db_criteria_Item('album_active', TRUE));
		if(isset($approve)) $criteria->add(new icms_db_criteria_Item('album_approve', TRUE));
		if(isset($onindex)) $criteria->add(new icms_db_criteria_Item('album_onindex', TRUE));
		
		if (is_null($album_id)) $album_id = 0;
		if($album_id) $criteria->add(new icms_db_criteria_Item('album_id', $album_id));
		if (is_null($album_pid)) $album_pid == 0;
		if($album_pid) $criteria->add(new icms_db_criteria_Item('album_pid', $album_pid));
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		return $this->getCount($criteria);
	}
	
	public function getAlbumsForBlocks($start = 0, $limit = 0, $order = 'weight', $sort = 'ASC') {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item('album_active', TRUE));
		$criteria->add(new icms_db_criteria_Item('album_inblocks', TRUE));
		$criteria->add(new icms_db_criteria_Item('album_approve', TRUE));
		$criteria->add(new icms_db_criteria_Item('album_onindex', TRUE));
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		$albums = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($albums as $key => &$album){
			$ret[$album['album_id']] = $album;
		}
		return $ret;
	}
	
	//set album online/offline
	public function changeVisible($album_id) {
		$visibility = '';
		$albumObj = $this->get($album_id);
		if ($albumObj->getVar('album_active', 'e') == TRUE) {
			$albumObj->setVar('album_active', 0);
			$visibility = 0;
		} else {
			$albumObj->setVar('album_active', 1);
			$visibility = 1;
		}
		$this->insert($albumObj, TRUE);
		return $visibility;
	}
	
	// show/hide Album in Block
	public function changeShow($album_id) {
		$show = '';
		$albumObj = $this->get($album_id);
		if ($albumObj->getVar('album_inblocks', 'e') == TRUE) {
			$albumObj->setVar('album_inblocks', 0);
			$show = 0;
		} else {
			$albumObj->setVar('album_inblocks', 1);
			$show = 1;
		}
		$this->insert($albumObj, TRUE);
		return $show;
	}

	// approve/deny album
	public function changeApprove($album_id) {
		$approve = '';
		$albumObj = $this->get($album_id);
		if ($albumObj->getVar('album_approve', 'e') == TRUE) {
			$albumObj->setVar('album_approve', 0);
			$approve = 0;
		} else {
			$albumObj->setVar('album_approve', 1);
			$approve = 1;
		}
		$this->insert($albumObj, TRUE);
		return $approve;
	}
	
	/**
	 * An album can be approved and activated but hidden in index page.
	 */
	public function changeIndex($album_id) {
		$onindex = '';
		$albumObj = $this->get($album_id);
		if ($albumObj->getVar('album_onindex', 'e') == TRUE) {
			$albumObj->setVar('album_onindex', 0);
			$onindex = 0;
		} else {
			$albumObj->setVar('album_onindex', 1);
			$onindex = 1;
		}
		$this->insert($albumObj, TRUE);
		return $onindex;
	}
	
	public function makeLink($album) {
		$seo = str_replace(" ", "-", $album->getVar('short_url'));
		return $seo;
	}
	
	public function getAlbumList() {
		
		$criteria = new icms_db_criteria_Compo();
		if (isset($album_id)) {
			$criteria->add( new icms_db_criteria_Item( 'album_id', (int)$album_id ) );
		}
		$criteria->add( new icms_db_criteria_Item( 'album_active', TRUE ) );
		$this->setGrantedObjectsCriteria($criteria, "album_grpperm");
		$albums = & $this -> getObjects( $criteria, TRUE );
		foreach( array_keys( $albums ) as $i ) {
			$ret[$albums[$i]->getVar( 'album_id' )] = $albums[$i] -> getVar( 'album_title' );
		}
		return $ret;
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
		$albumimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/uploads/' . icms::$module -> getVar( 'dirname' ) . '/albumimages/', '', array('gif', 'jpg', 'png'));
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
						$ret = "<a href='" . ALBUM_URL . "index.php?album_id=" . $album->getVar('album_id', 'e') . "&amp;album=" . $this->makeLink($album) . "'>" . $album->getVar('album_title', 'e') . "</a>";
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
			$sql = 'UPDATE ' . $this->table . ' SET counter=' . $new_counter
				. ' WHERE ' . $this->keyName . '=' . $albumObj->id();
			$this->query($sql, NULL, TRUE);
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
			$this->insert($albumObj, TRUE);
		}
	}
	
	// some related functions for storing
	protected function beforeSave(&$obj) {
		if ($obj->updating_counter)
		return TRUE;
		if ($obj->getVar('album_pid','e') == $obj->getVar('album_id','e')){
			$obj->setVar('album_pid', 0);
		}
		if (!$obj->getVar('album_img_upload') == "") {
			$obj->setVar('album_img', $obj->getVar('album_img_upload') );
		}
		return TRUE;
	}
	
	protected function afterSave(& $obj) {
		if($obj->getVar('album_published_date') < time()) {
			if (!$obj->getVar('album_notification_sent') && $obj->getVar ('album_active', 'e') == 1 && $obj->getVar ('album_approve', 'e') == 1 && $obj->getVar ('album_onindex', 'e') == 1 ) {
			$obj->sendNotifAlbumPublished();
			$obj->setVar('album_notification_sent', TRUE);
			$this->insert ($obj);
			}
		}
		return TRUE;
	}
	
	protected function afterDelete(& $obj) {
		$notification_handler = icms::handler( 'icms_data_notification' );
		$module_handler = icms::handler('icms_module');
		$module = $module_handler->getByDirname( icms::$module -> getVar( 'dirname' ) );
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
		return TRUE;
	}
}