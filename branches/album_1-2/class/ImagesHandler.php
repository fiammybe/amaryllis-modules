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

class AlbumImagesHandler extends icms_ipf_Handler {
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
	}
	
	// retrieve a list of Images
	public function getList($img_active = null, $img_approve = null) {
		$criteria = new icms_db_criteria_Compo();
		if (isset($img_active)) {
			$criteria->add(new icms_db_criteria_Item('img_active', TRUE));
		}
		if (isset($img_approve)) {
			$criteria->add(new icms_db_criteria_Item('img_approve', TRUE));
		}
		$images = & $this->getObjects($criteria, TRUE);
		foreach(array_keys($images) as $i) {
			$ret[$images[$i]->getVar('img_id')] = $images[$i]->getVar('img_title');
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
	public function getImages($active = FALSE, $approve = FALSE, $start = 0, $limit = 0, $order = 'weight', $sort = 'ASC', $a_id = FALSE, $tag_id = FALSE, $publisher = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if($start) $criteria->setStart($start);
		if($limit) $criteria->setLimit($limit);
		$criteria->setOrder($sort);
		$criteria->setSort($order);
		if($active) $criteria->add(new icms_db_criteria_Item('img_active', TRUE));
		if($approve) $criteria->add(new icms_db_criteria_Item('img_approve', TRUE));
		if($tag_id) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("img_tags", '%:"' . $tag_id . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		if($publisher) {
			$criteria->add(new icms_db_criteria_Item("img_publisher", $publisher));
		}
		if($a_id)$criteria->add(new icms_db_criteria_Item('a_id', $a_id));
		$images = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($images as $image) {
			$ret[$image['img_id']] = $image;
		}
		return $ret;
	}
	
	public function getImagesCount ($active = FALSE, $approve = FALSE, $a_id = NULL, $tag_id = FALSE, $publisher = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if(isset($active))	$criteria->add(new icms_db_criteria_Item('img_active', TRUE));
		if(isset($approve)) $criteria->add(new icms_db_criteria_Item('img_approve', TRUE));
		if($tag_id) {
			$critTray = new icms_db_criteria_Compo();
			$critTray->add(new icms_db_criteria_Item("img_tags", '%:"' . $tag_id . '";%', "LIKE"));
			$criteria->add($critTray);
		}
		if($publisher) {
			$criteria->add(new icms_db_criteria_Item("img_publisher", $publisher));
		}
		if (is_null($a_id)) $a_id == 0;
		if($a_id) $criteria->add(new icms_db_criteria_Item('a_id', $a_id));
		return $this->getCount($criteria);
	}
	
	public function changeVisible($img_id) {
		$visibility = '';
		$imagesObj = $this->get($img_id);
		if ($imagesObj->getVar('img_active', 'e') == TRUE) {
			$imagesObj->setVar('img_active', 0);
			$visibility = 0;
		} else {
			$imagesObj->setVar('img_active', 1);
			$visibility = 1;
		}
		$this->insert($imagesObj, TRUE);
		return $visibility;
	}
	
	public function changeApprove($img_id) {
		$approve = '';
		$imagesObj = $this->get($img_id);
		if ($imagesObj->getVar('img_approve', 'e') == TRUE) {
			$imagesObj->setVar('img_approve', 0);
			$approve = 0;
		} else {
			$imagesObj->setVar('img_approve', 1);
			$approve = 1;
		}
		$this->insert($imagesObj, TRUE);
		return $approve;
	}
	
	public function img_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function img_approve_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function getAlbumList() {
		$album_album_handler = icms_getModuleHandler("album", "album");
		$albums = $album_album_handler->getList();
		return $albums;
	}
	
	public function getImagesTags() {
		global $albumConfig;
		$sprocketsModule = icms_getModuleInfo("sprockets");
		if(icms_get_module_status("sprockets") && $albumConfig['use_sprockets'] == 1) {
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
	
	/**
	 * watermarking with image
	 * 
	 * @param $SourceFile - is source of the image file to be watermarked
	 * @param $WatermarkText - is the text of the watermark
	 * @param $DestinationFile - is the destination location where the watermarked images will be placed
	 */
	function watermarkImage ($source, $watermark, $dest) { 
		list($width, $height) = getimagesize($source);
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefromjpeg($source);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height); 
		$black = imagecolorallocate($image_p, 0, 0, 0);
		$font = 'arial.ttf';
		$font_size = 10;
		imagettftext($image_p, $font_size, 0, 10, 20, $black, $font, $watermark);
		if ($DestinationFile<>'') {
			imagejpeg ($image_p, $dest, 100);
		} else {
			header('Content-Type: image/jpeg');
			imagejpeg($image_p, null, 100);
		}
		imagedestroy($image); 
		imagedestroy($image_p);
	}
	
	protected function beforeInsert(&$obj) {
		$dsc = $obj->getVar("img_description", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$obj->setVar("img_description", $dsc);
		return TRUE;
	}
	
	protected function beforeSave(&$obj) {
		$source = ICMS_UPLOAD_PATH . '/album/images/';
		$img = $obj->getVar("img_url", "e");
		$watermark = $obj->getVar("img_copyright", "e");
		//$watermark = icms_core_DataFilter::undoHtmlSpecialChars($watermark);
		$dest = ICMS_UPLOAD_PATH . '/album/images/';
		$timestamp = $obj->getVar("img_published_date", "e");
		$new_img = $timestamp . "_" . $img;
		$this->watermarkImage($source . $img, $watermark, $dest . $new_img);
		icms_core_Filesystem::deleteFile(ALBUM_UPLOAD_ROOT . "images/" . $img);
		$obj->setVar("img_url", $new_img);
		
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