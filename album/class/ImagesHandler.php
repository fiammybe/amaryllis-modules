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
	
	private $_albumsForImages;
	
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, 'images', 'img_id', 'img_title', 'a_id', 'album');
		global $albumConfig;
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes,	$albumConfig['image_file_size'], $albumConfig['image_upload_width'], $albumConfig['image_upload_height']);
		$this->_images_cache_path = ICMS_CACHE_PATH . '/' . ALBUM_DIRNAME . '/' . $this->_itemname;
		$this->_images_thumbs_path = $this->_images_cache_path . '/thumbs';
		$this->_images_images_path = $this->_images_cache_path . '/images';
	}
	
	
	/**
	 * gives a list of all images in batch upload folder
	 * /uploads/album/batch
	 */
	public function getImagesFromBatch() {
		$images = array();
		$images = icms_core_Filesystem::getFileList(ALBUM_UPLOAD_ROOT . 'batch/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		foreach(array_keys($images) as $i ) {
			$ret[$i] = $images[$i];
		}
		return $ret;
	}
	
	public function getImagesThumbsPath() {
		$dir = $this->_images_thumbs_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
	}
	
	public function getImagesImagesPath() {
		$dir = $this->_images_images_path;
		if (!file_exists($dir)) {
			icms_core_Filesystem::mkdir($dir);
		}
		return $dir . "/";
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
			$fonts = icms_core_Filesystem::getFileList(ICMS_MODULES_PATH . '/index/extras/fonts/', '', array('ttf'));
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
		if($publisher) $criteria->add(new icms_db_criteria_Item("img_publisher", $publisher));
		return $criteria;
	}
	
	// retrieve a list of Images
	public function getList($img_active = FALSE, $img_approve = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($active) $criteria->add(new icms_db_criteria_Item('img_active', TRUE));
		if($approve) $criteria->add(new icms_db_criteria_Item('img_approve', TRUE));
		$images = & $this->getObjects($criteria, TRUE);
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
		foreach ($images as $image) {
			$ret[$image['id']] = $image;
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
	
	public function getImagesTags() {
		global $albumConfig;
		$sprocketsModule = icms_getModuleInfo("sprockets");
		if(icms_get_module_status("sprockets") && !icms_get_module_status("index")) {
			$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname") , "sprockets");
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item("label_type", 0));
			$criteria->add(new icms_db_criteria_Item("navigation_element", 0));
			
			$tags = $sprockets_tag_handler->getObjects(FALSE, TRUE, FALSE);
			$ret[] = '------------';
			foreach(array_keys($tags) as $i) {
				$ret[$tags[$i]['tag_id']] = $tags[$i]['title'];
			}
			return $ret;
		}
	}

	protected function beforeInsert(&$obj) {
		if($obj->_updating)
		return TRUE;
		$dsc = $obj->getVar("img_description", "e");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$obj->setVar("img_description", $dsc);
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		global $albumConfig;
		if($obj->_updating)
		return TRUE;
		if($albumConfig['img_use_copyright'] == 1 && $obj->isNew()) {
			$img = $obj->getVar("img_url", "e");
			require_once ICMS_MODULES_PATH . "/album/class/Image.php";
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
		if($obj->_updating_table)
		return TRUE;
		$tags = $obj->getVar("img_tags", "e");
		if($tags != "" && $tags != "0" && icms_get_module_status("index")) {
			$indexModule = icms_getModuleInfo("index");
			$tag_handler = icms_getModuleHandler("tag", $indexModule->getVar("dirname"), "index");
			$tagarray = explode(",", $tags);
			$tagarray = array_map('strtolower', $tagarray);
			$newArray = array();
			foreach ($tagarray as $key => $tag) {
				$intersection = array_intersect($tagarray, array($tag));
				$count = count($intersection);
				if($count > 1) {
					unset($tagarray[$key]);
				} else {
					$tag_id = $tag_handler->addTag($tag, FALSE, $obj, $obj->getVar("img_published_date", "e"), $obj->getVar("img_publisher", "e"), "img_description", $obj->getVar("img_url", "e"));
					$newArray[] = $tag_id;
				}
				unset($intersection, $count);
			}
			$obj->setVar("img_tags", implode(",", $newArray));
			unset($tags, $tag_handler, $tags, $tagarray);
		}
		return TRUE;
	}

	public function afterSave(&$obj) {
		global $albumConfig;
		if($obj->_updating)
		return TRUE;
		$img = $obj->getVar('img_url', 'e');
		if($img != "0" && $img != "") {
		    require_once ICMS_MODULES_PATH . "/album/class/Image.php";
			$cached_img = $obj->_images_images . $img;
			$cached_image_url = $obj->_images_images_url . $img;
			if(!file_exists($cached_img)) {
				$srcpath = ALBUM_UPLOAD_ROOT . $this->_itemname . "/";
				$image = new mod_album_Image($img, $srcpath);
				$image->resizeImage($albumConfig['image_display_width'], $albumConfig['image_display_height'], $obj->_images_images, "100");
			}
			$cached_thumb = $obj->_images_thumbs . $images_img;
			$cached_url = $obj->_images_thumbs_url . $images_img;
			if(!is_file($cached_thumb)) {
				$srcpath = ALBUM_UPLOAD_ROOT . $this->_itemname . "/";
				$thumb = new mod_album_Image($images_img, $srcpath);
				$thumb->resizeImage($albumConfig['thumbnail_width'], $albumConfig['thumbnail_height'], $obj->_images_thumbs, "90");
			}
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