<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/ImagesHandler.php
 *
 * Classes responsible for managing album images objects
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
 * pdf-pass "XXX999"
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_album_ImagesHandler extends icms_ipf_Handler {

	public $_watermarkPosition;
	public $_watermarkColors;
	public $_watermarkFontsize;
	public $_watermarkFont;

	public $_images_cache_path;
	public $_images_thumbs_path;
	public $_images_images_path;
	public $_images_admin_path;

	public $_index_module_status = FALSE;
	public $_index_module_dirname = FALSE;
	public $_index_module_mid = FALSE;

	private $_albumsForImages;
	private $_albumArray;
	private $_labelArray;
	public $_usersArray;
	public $_urlLinks;

	private $_aHandler;
	public $_moduleID;

	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, 'images', 'img_id', 'img_title', 'img_description', ALBUM_DIRNAME);
		global $albumConfig;
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes,	$albumConfig['image_file_size'], $albumConfig['image_upload_width'], $albumConfig['image_upload_height']);
		$this->_aHandler = new mod_album_AlbumHandler(icms::$xoopsDB);
		$this->_images_cache_path = ICMS_ROOT_PATH . '/cache/' . ALBUM_DIRNAME . '/' . $this->_itemname;
		$this->_images_thumbs_path = $this->_images_cache_path . '/thumbs';
		$this->_images_images_path = $this->_images_cache_path . '/images';
		$this->_images_admin_path = $this->_images_cache_path . '/admin';
		$this->_moduleID = $this->_aHandler->_moduleID;
		$this->_index_module_status = $this->_aHandler->_index_module_status;
		$this->_index_module_dirname = $this->_aHandler->_index_module_dirname;
		$this->_index_module_mid = $this->_aHandler->_index_module_mid;
		$this->_moduleUrl = $this->_aHandler->_moduleUrl;
		$this->_page = $this->_aHandler->_page;

	}

	public function loadAlbums() {
		return $this->_aHandler->loadAlbums();
	}

	/**
	 * gives a list of all images in batch upload folder
	 * /uploads/album/batch
	 */
	public function getImagesFromBatch() {
		$images = array();
		$images = icms_core_Filesystem::getFileList(ALBUM_UPLOAD_ROOT.'batch/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		foreach(array_keys($images) as $i ) {
			$ret[$i] = $images[$i];
		}
		return $ret;
	}

	public function getImagesThumbsPath() {
		$dir = $this->_images_thumbs_path;
		if (!file_exists($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir . "/";
	}

	public function getImagesAdminPath() {
		$dir = $this->_images_admin_path;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir . "/";
	}

	public function getImagesImagesPath() {
		$dir = $this->_images_images_path;
		if (!file_exists($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir . "/";
	}

	public function getImagePath() {
		$dir = $this->_uploadPath.$this->_itemname;
		if (!is_dir($dir)) {
			mkdir($dir, 0777, TRUE);
		}
		return $dir."/";
	}

	public function getWatermarkPositions() {
		if(!count($this->_watermarkPosition)) {
			$this->_watermarkPosition['TL'] = _CO_ALBUM_IMAGES_WATERMARKPOS_TL;
			$this->_watermarkPosition['TR'] = _CO_ALBUM_IMAGES_WATERMARKPOS_TR;
			$this->_watermarkPosition['TC'] = _CO_ALBUM_IMAGES_WATERMARKPOS_TC;
			$this->_watermarkPosition['CL'] = _CO_ALBUM_IMAGES_WATERMARKPOS_CL;
			$this->_watermarkPosition['CR'] = _CO_ALBUM_IMAGES_WATERMARKPOS_CR;
			$this->_watermarkPosition['C'] = _CO_ALBUM_IMAGES_WATERMARKPOS_C;
			$this->_watermarkPosition['BL'] = _CO_ALBUM_IMAGES_WATERMARKPOS_BL;
			$this->_watermarkPosition['BR'] = _CO_ALBUM_IMAGES_WATERMARKPOS_BR;
			$this->_watermarkPosition['BC'] = _CO_ALBUM_IMAGES_WATERMARKPOS_BC;
		}
		return $this->_watermarkPosition;
	}

	public function getWatermarkColors() {
		if(!count($this->_watermarkColors)) {
			$this->_watermarkColors['black'] = _CO_ALBUM_IMAGES_WATERMARKCOLOR_BLACK;
			$this->_watermarkColors['blue'] = _CO_ALBUM_IMAGES_WATERMARKCOLOR_BLUE;
			$this->_watermarkColors['green'] = _CO_ALBUM_IMAGES_WATERMARKCOLOR_GREEN;
			$this->_watermarkColors['white'] = _CO_ALBUM_IMAGES_WATERMARKCOLOR_WHITE;
			$this->_watermarkColors['red'] = _CO_ALBUM_IMAGES_WATERMARKCOLOR_RED;
			asort($this->_watermarkColors);
		}
		return $this->_watermarkColors;
	}

	public function getWatermarkFontSize() {
		if(!count($this->_watermarkFontsize)) {
			$this->_watermarkFontsize['12'] = "12pt";
			$this->_watermarkFontsize['18'] = "18pt";
			$this->_watermarkFontsize['20'] = "20pt";
			$this->_watermarkFontsize['25'] = "25pt";
			$this->_watermarkFontsize['28'] = "28pt";
			$this->_watermarkFontsize['30'] = "30pt";
			$this->_watermarkFontsize['35'] = "35pt";
			$this->_watermarkFontsize['40'] = "40pt";
			$this->_watermarkFontsize['45'] = "45pt";
			$this->_watermarkFontsize['48'] = "48pt";
			$this->_watermarkFontsize['50'] = "50pt";
		}
		return $this->_watermarkFontsize;
	}

	public function getWatermarkFont() {
		if(!count($this->_watermarkFont)) {
			$fonts = icms_core_Filesystem::getFileList(ICMS_MODULES_PATH .'/'.ALBUM_DIRNAME.'/extras/fonts/', '', array('ttf'));
			foreach(array_keys($fonts) as $i ) {
				$this->_watermarkFont[$i] = $fonts[$i];
			}
		} return $this->_watermarkFont;
	}

	public function getAlbumList() {
		if (!count($this->_albumsForImages)) {
			$albums = $this->getAlbumArray();
			foreach ($albums as $key => $value) {
				$this->_albumsForImages[$key] = $value;
			}
		}
		return $this->_albumsForImages;
	}

	public function getAlbumArray() {
		$album_handler = icms_getModuleHandler("album", ALBUM_DIRNAME, "album");
		return $album_handler->getAlbumListForPid();
	}

	public function loadUrlLinks() {
		global $albumConfig;
		if(!count($this->_urlLinks) && $albumConfig['need_image_links'] == TRUE) {
			$urllink_handler = icms::handler('icms_data_urllink');
			$criteria = new icms_db_criteria_Item("mid", $this->_moduleID);
			$urls = $urllink_handler->getObjects($criteria, TRUE, TRUE);
			unset($criteria);
			foreach (array_keys($urls) as $k) {
				$this->_urlLinks[$k] = $urls[$k]->render();
				unset($urls[$k]);
			}
			unset($urls, $urllink_handler);
		}
		return $this->_urlLinks;
	}

	public function loadUsers() {
		global $icmsConfig, $icmsConfigUser;
		if(!count($this->_usersArray)) {
			$member_handler = icms::handler("icms_member_user");
			$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("level", 0, '>='));
			$sql = "SELECT DISTINCT (img_publisher) FROM " . $this->table;
			$critTray = new icms_db_criteria_Compo();
			if ($result = icms::$xoopsDB->query($sql)) {
				while ($myrow = icms::$xoopsDB->fetchArray($result)) {
					$critTray->add(new icms_db_criteria_Item("uid", $myrow['img_publisher']), "OR");
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
		return $this->_aHandler->loadLabels();
	}

	public function getImagesCriterias($active = FALSE, $approve = FALSE, $a_id = FALSE, $tag = FALSE, $publisher = FALSE, $start = 0, $limit = 0, $order = 'weight', $sort = 'ASC') {
		$criteria = new icms_db_criteria_Compo();
		if($start)$criteria->setStart($start);
		if($limit) $criteria->setLimit((int)$limit);
		if($sort) $criteria->setOrder($sort);
		if($order) $criteria->setSort($order);
		if($active) $criteria->add(new icms_db_criteria_Item('img_active', TRUE));
		if($approve) $criteria->add(new icms_db_criteria_Item('img_approve', TRUE));
		if($a_id)$criteria->add(new icms_db_criteria_Item('a_id', $a_id));
		if($tag) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("img_tags", $tag . ',%', "LIKE"), 'OR');
			$critTray->add(new icms_db_criteria_Item("img_tags", '%,' . $tag . ',%', "LIKE"), 'OR');
			$critTray->add(new icms_db_criteria_Item("img_tags", '%,' . $tag, "LIKE"), 'OR');
			$criteria->add($critTray);
		}
		$perm_handler = new icms_ipf_permission_Handler($this->_aHandler);
		$grantedItems = $perm_handler->getGrantedItems("album_grpperm");
		unset($perm_handler);
		if(count($grantedItems) > 0)
		$criteria->add(new icms_db_criteria_Item("a_id", '(' . implode(', ', $grantedItems) . ')', 'IN'));
		if($publisher) $criteria->add(new icms_db_criteria_Item("img_publisher", $publisher));
		return $criteria;
	}

	// retrieve a list of Images
	public function getList($img_active = FALSE, $img_approve = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($active) $criteria->add(new icms_db_criteria_Item('img_active', TRUE));
		if($approve) $criteria->add(new icms_db_criteria_Item('img_approve', TRUE));
		$images = $this->getObjects($criteria, TRUE);
		foreach(array_keys($images) as $i) {
			$ret[$images[$i]->id()] = $images[$i]->title();
		}
		return $ret;
	}

	/**
	 * getImages returns images objects
	 *
	 * @param $active - only active images
	 * @param $approve - approved images
	 * @param $start - start of images for pagination
	 * @param $limit - imit to fetch - to be set in module preferences
	 * @param $order by field
	 * @param $sort - sort ASC/DESC/RAND()
	 * @param $a_id - album_id to get by Album
	 * @param $tag_id - to get only with tag_id
	 * @param $publisher - published by
	 */
	public function getImages($active = FALSE, $approve = FALSE, $a_id = FALSE, $tag = FALSE, $publisher = FALSE, $start = 0, $limit = 0, $order = 'weight', $sort = 'ASC') {
		$criteria = $this->getImagesCriterias($active, $approve, $a_id, $tag, $publisher, $start, $limit, $order, $sort);
		$images = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($images as $k => $image) {
			$ret[$k] = $image;
		}
		return $ret;
	}

	public function getImagesCount($active = FALSE, $approve = FALSE, $a_id = FALSE, $tag = FALSE, $publisher = FALSE, $start = 0, $limit = 0, $order = 'weight', $sort = 'ASC') {
		$criteria = $this->getImagesCriterias($active, $approve, $a_id, $tag, $publisher, $start, $limit, $order, $sort);
		return $this->getCount($criteria);
	}

	public function changeField($img_id, $field) {
		$imagesObj = $this->get($img_id);
		if ($imagesObj->getVar("$field", "e") == TRUE) {
			$imagesObj->setVar("$field", 0);
			$value = 0;
		} else {
			$imagesObj->setVar("$field", 1);
			$value = 1;
		}
		$imagesObj->_updating = TRUE;
		$this->insert($imagesObj, TRUE);
		return $value;
	}

	public function img_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}

	public function img_approve_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	/**
	public function getAlbumList() {
		$album_handler = icms_getModuleHandler("album", ALBUM_DIRNAME, "album");
		$albums = $album_handler->getList();
		return $albums;
	}
	*/
	public function filterUsers($showNull = FALSE) {
		$sql = "SELECT DISTINCT (img_publisher) FROM " . $this->table;
		if ($result = icms::$xoopsDB->query($sql)) {
			$bids = array();
			if($showNull) $bids[0] = '--------------';
			while ($myrow = icms::$xoopsDB->fetchArray($result)) {
				$bids[$myrow['img_publisher']] = icms_member_user_Object::getUnameFromId((int)$myrow['img_publisher']);
			}
			return $bids;
		}
	}

	// some fuctions related to icms core functions
	public function getImagesForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = $this->getImagesCriterias(TRUE, TRUE, FALSE, FALSE, $userid, $offset, $limit, "img_published_date", "DESC");
		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('img_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('img_description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				if($this->_index_module_status) {
					$criteriaKeyword->add(new icms_db_criteria_Item('img_tags', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				}
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		return $this->getObjects($criteria, TRUE, FALSE);
	}

	protected function beforeSave(&$obj) {
		global $albumConfig;
		if($obj->_updating)
		return TRUE;
		if($albumConfig['img_use_copyright'] == 1 && $obj->isNew()) {
			$img = $obj->getVar("img_url", "e");
			$srcpath = ALBUM_UPLOAD_ROOT . $this->_itemname . "/";
			$watermark = $obj->getVar("img_copyright", "e");
			$color = $obj->getVar("img_copy_color", "e");
			$pos = $obj->getVar("img_copy_pos", "e");
			$font = $obj->getVar("img_copy_font", "e");
			$fontsize = $obj->getVar("img_copy_fontsize", "e");
			$timestamp = $obj->getVar("img_published_date", "e");
			$new_img = $timestamp . "_" . array_pop(explode("_", $img));
			$image = new mod_album_Image($img, $srcpath);
			$image->watermarkImage($watermark, $srcpath, $new_img, $color, $pos, $font, $fontsize);
			unset($image);
			icms_core_Filesystem::deleteFile(ALBUM_UPLOAD_ROOT . "images/" . $img);
			$obj->setVar("img_url", $new_img);
		}
		return TRUE;
	}

	public function afterSave(&$obj) {
		global $albumConfig, $icmsConfig;
		if($obj->_updating)
		return TRUE;
		$needUpdate = FALSE;
		if($this->_aHandler->_index_module_status && $obj->isActive() && $obj->isApproved()) {
			$link_handler = new mod_index_LinkHandler(icms::$xoopsDB);
			$link_handler->deleteAllByCriteria(FALSE, FALSE, $this->_moduleID, $this->_itemname, $obj->id());
			$aid = $obj->getVar("a_id", "e"); $albums = $this->loadAlbums();
			$short_url = (isset($albums[$aid])) ? $albums[$aid]['short_url'] : FALSE;
			if(!$short_url) return FALSE;
			$img = $obj->getVar("img_url", "e");$title = $obj->title();$teaser = $obj->summary();$lang = FALSE;
			$labels = trim($obj->getVar("img_tags")); $pid = FALSE; $pdate = $obj->getVar("img_published_date", "e");
			if($labels != "") {
				$label_handler = icms_getModuleHandler("label", $this->_aHandler->_index_module_dirname, "index");
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
						$labelname = $label_handler->addLabel($label, 0, $this->_moduleID, $this->_itemname, "album=".$short_url,$obj->id(), $img, $teaser, $title, $pid , $lang, $pdate);
						$newArray[] = $labelname;
						if($labelname != $label) $needUpdate = TRUE;
					}
					unset($intersection, $count);
				}
				$obj->setVar("img_tags", implode(",", $newArray));
				unset($labels, $label_handler, $labelarray);
			}

		} elseif ($this->_aHandler->_index_module_status && (!$obj->isActive() || !$obj->isApproved())) {
			$link_handler = icms_getModuleHandler("link", $this->_aHandler->_index_module_dirname, "index");
			$link_handler->deleteAllByCriteria(FALSE, FALSE, $this->_moduleID, $this->_itemname, $obj->id());
		}

		if($needUpdate) {
			$obj->_updating = TRUE;
			$obj->store(TRUE);
		}
		return TRUE;
	}

	protected function afterDelete(& $obj) {
		$message_handler = icms_getModuleHandler("message", "album");
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("message_item", $obj->id()));
		$message_handler->deleteAll($criteria);
		return TRUE;
	}
}