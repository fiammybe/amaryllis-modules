<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/Image.php
 * 
 * Class representing album images objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: Images.php 677 2012-07-05 18:10:29Z st.flohrer $
 * @package		album
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

include_once ICMS_ROOT_PATH . '/modules/album/include/common.php';

class AlbumImages extends icms_ipf_Object {
	
	public $_updating = FALSE;
	
	public $_updating_table = FALSE;
	
	public $_images_thumbs;
	
	public $_images_images;
	
	public $_images_images_url;
	
	public $_images_thumbs_url;

	public function __construct(&$handler) {
		global $albumConfig;
		parent::__construct($handler);

		$this->quickInitVar('img_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('a_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('img_title', XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar('img_published_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('img_updated_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('img_description', XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar('img_url', XOBJ_DTYPE_IMAGE);
		$this->quickInitVar("img_tags", XOBJ_DTYPE_TXTBOX,FALSE, FALSE, FALSE);
		$this->quickInitVar('img_active', XOBJ_DTYPE_INT,TRUE, FALSE, FALSE, 1);
		$this->quickInitVar('img_approve', XOBJ_DTYPE_INT, TRUE, FALSE, FALSE,1);
		$this->initCommonVar('weight');
		$this->quickInitVar('img_publisher', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar('img_urllink', XOBJ_DTYPE_URLLINK);
		$this->initVar('img_copyright', XOBJ_DTYPE_TXTBOX, $albumConfig['img_default_copyright'], FALSE, 255, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);
		$this->initVar('img_copy_pos', XOBJ_DTYPE_TXTBOX, "BL", FALSE, 255, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);
		$this->initVar('img_copy_color', XOBJ_DTYPE_TXTBOX, "black", FALSE, 255, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);
		$this->initVar('img_copy_font', XOBJ_DTYPE_TXTBOX, "arial.ttf", FALSE, 255, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);
		$this->initVar('img_copy_fontsize', XOBJ_DTYPE_INT, "20", FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);
		$this->quickInitVar("img_hasmsg", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		$this->initCommonVar('dohtml', FALSE, 1);
		$this->initCommonVar('dobr', FALSE, 0);
		$this->initCommonVar('doimage', FALSE, 1);
		$this->initCommonVar('dosmiley', FALSE, 1);
		$this->initCommonVar('docxode', FALSE, 1);
		
		$this->setControl('img_active', 'yesno');
		$this->setControl('img_approve', 'yesno');
		$this->setControl('img_publisher', 'user');
		$this->setControl('a_id', array('name' => 'select', 'itemHandler' => 'album', 'method' => 'getAlbumListForPid', 'module' => 'album'));
		$this->setControl('img_description', 'dhtmltextarea' );
		$this->setControl('img_copy_pos', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkPositions', 'module' => 'album'));
		$this->setControl('img_copy_color', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkColors', 'module' => 'album'));
		$this->setControl('img_copy_font', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkFont', 'module' => 'album'));
		$this->setControl('img_copy_fontsize', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkFontSize', 'module' => 'album'));
		$this->setControl( 'img_url', array('name' => 'image', 'nourl' => TRUE));
		
		if($albumConfig['need_image_links'] == 0) {
			$this->hideFieldFromForm("img_urllink");
			$this->hideFieldFromSingleView("img_urllink");
		}
		if(!icms_get_module_status("index")) {
			$this->hideFieldFromForm("img_tags");
			$this->hideFieldFromSingleView("img_tags");
		}
		if($albumConfig['img_allow_uploader_copyright'] == 0) {
			$this->hideFieldFromForm('img_copyright');
		}
		
		$this->_images_thumbs = $this->handler->getImagesThumbsPath();
		$this->_images_images = $this->handler->getImagesImagesPath();
		$this->_images_images_url = ICMS_URL . '/cache/' . ALBUM_DIRNAME . '/' . $this->handler->_itemname . '/images/';
		$this->_images_thumbs_url = ICMS_URL . '/cache/' . ALBUM_DIRNAME . '/' . $this->handler->_itemname . '/thumbs/';

		$this->hideFieldFromForm( array('img_publisher', 'img_published_date', 'img_updated_date'));
	}

	public function image_aid() {
		$cid = $this->getVar('a_id', 'e');
		$album_album_handler = icms_getModuleHandler ( 'album',ALBUM_DIRNAME, 'album' );
		$album = $album_album_handler->get($cid);
		return $album->title();
	}
	
	/**
	 * prepare some control fields for ACP Image overview
	 */
	public function img_active() {
		$img_active = $this->getVar('img_active', 'e');
		if ($img_active == FALSE) {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function img_approve() {
		$active = $this->getVar('img_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}

	public function getTitleControl() {
		$control = new icms_form_elements_Text( '', 'img_title[]', 10, 255,$this->getVar('img_title', 'e'));
		$control->setExtra( 'style="width: 7em;"' );
		return $control->render();
	}
	
	public function getDscControl() {
		$control = new icms_form_elements_Textarea( '', 'img_description[]', $this->getVar('img_description', 'e'), 3, 20);
		return $control->render();
	}

	public function getWeightControl() {
		$control = new icms_form_elements_Text('', 'weight[]', 3, 7,$this->getVar('weight', 'e'), FALSE);
		$control->setExtra( 'style="text-align:center; width: 2em;"' );
		return $control->render();
	}
	
	public function getTagsControl() {
		$control = new icms_form_elements_Text( '', 'img_tags[]', 15, 255,$this->getImageTags(TRUE));
		return $control->render();
	}
	
	public function getAlbumControl() {
		global $album_album_handler;
		$control = new icms_form_elements_Select("", 'a_id[]', $this->getVar("a_id", "e"));
		$control->addOptionArray($album_album_handler->getAlbumListForPid());
		return $control->render();
	}
	
	public function getImgPreview() {
		$img = '<img src="' . $this->getImagePath() . '" . width=64% />';
		return $img;
	}
	
	public function getImagesThumb() {
		global $albumConfig;
		$images_img = $this->getVar('img_url', 'e');
		$cached_thumb = $this->_images_thumbs . $images_img;
		$cached_url = $this->_images_thumbs_url . $images_img;
		if(!is_file($cached_thumb)) {
			require_once ICMS_MODULES_PATH . "/index/class/IndexImage.php";
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new IndexImage($images_img, $srcpath);
			$image->resizeImage($albumConfig['thumbnail_width'], $albumConfig['thumbnail_height'], $this->_images_thumbs, "90");
		}
		return $cached_url;
	}
	
	public function getImagesImage() {
		global $albumConfig;
		$images_img = $this->getVar('img_url', 'e');
		$cached_img = $this->_images_images . $images_img;
		$cached_image_url = $this->_images_images_url . $images_img;
		if(!is_file($cached_img)) {
			require_once ICMS_MODULES_PATH . "/index/class/IndexImage.php";
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new IndexImage($images_img, $srcpath);
			$image->resizeImage($albumConfig['image_display_width'], $albumConfig['image_display_height'], $this->_images_images, "100");
		}
		return $cached_image_url;
	}
	
	public function getImagePath() {
		$img = $image_tag = '';
		$img = $this->getVar('img_url', 'e');
		if (!$img == "") {
			$image_tag = ICMS_URL . '/uploads/album/images/' . $img;
		} else {
			$image_tag = FALSE;
		}
		return $image_tag;
	}

	// get publisher for frontend
	public function getPublisher($link = FALSE) {
		$uid = $this->getVar('img_publisher', 'e');
		if($link) {
			return icms_member_user_Handler::getUserLink($uid);
		} else {
			return icms::handler('icms_member_user')->get($uid)->getVar("uname");
		}
	}
	
	public function getImageDescription() {
		$dsc = $this->getVar("img_description", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		return $dsc;
	}
	
	public function getImageTags($namesOnly = TRUE) {
		$img_tags = $this->getVar("img_tags", "e");
		if(icms_get_module_status("index") && $img_tags != "" && $img_tags != "0") {
			$indexModule = icms_getModuleInfo("index"); 
			$tagids = explode(",", $img_tags);
			$tag_handler = icms_getModuleHandler ( "tag", $indexModule->getVar("dirname") , "index");
			$criteria = new icms_db_criteria_Compo();
			foreach ($tagids as $key => $tagid) {
				$criteria->add(new icms_db_criteria_Item("tag_id", (int)trim($tagid)), 'OR');
			}
			$tags = $tag_handler->getObjects($criteria, TRUE, FALSE);
			unset($tag_handler, $criteria);
			if($namesOnly) {
				$ret = array();
				foreach ($tags as $key => $value) {
					$ret[] = $value['name'];
				}
				unset($tags);
				return implode(", ", $ret);
			}
			return $tags;
		}
	}
	
	/**
	 * convert the date to prefered settings
	 */
	public function getPublishedDate() {
		global $albumConfig;
		$date = $this->getVar('img_published_date', 'e');
		return date($albumConfig['album_dateformat'], $date);
	}
	
	public function getUpdatedDate() {
		global $albumConfig;
		$date = $this->getVar('img_updated_date', 'e');
		if($date != 0){
			return date($albumConfig['album_dateformat'], $date);
		} else {
			return FALSE;
		}
	}
	
	public function getImagesURL() {
		if($this->getVar("img_urllink", "e") != 0) {
			$demo = 'img_urllink';
			$linkObj = $this-> getUrlLinkObj($demo);
			$url = $linkObj->render();
			return $url;
		}
	}

	public function getMaxHeight() {
		global $albumConfig;
		$innerHeight = $albumConfig['image_display_height'];
		$maxHeight = (int)$innerHeight + 500;
		return $maxHeight;
	}
	
	public function getMaxWidth() {
		global $albumConfig;
		$innerWidth = $albumConfig['image_display_width'];
		$maxWidth = (int)$innerWidth + 500;
		return $maxWidth;
	}
	
	public function getImageComments() {
		global $albumConfig;
		if($albumConfig['use_messages'] == 1 && $this->getVar("img_hasmsg", "e") == 1) {
			$album_message_handler = icms_getModuleHandler("message", ALBUM_DIRNAME, "album");
			$messages = $album_message_handler->getMessages($this->getVar("img_id", "e"), FALSE);
			return $messages;
		}
	}

	function userCanEditAndDelete() {
		global $album_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($album_isAdmin) return TRUE;
		return $this->getVar('img_publisher', 'e') == icms::$user->getVar("uid");
	}
	
	public function getMyEditItemLink() {
		if($this->userCanEditAndDelete()) {
			return '<a href="' . ALBUM_URL . 'images.php?op=mod&img_id=' . $this->id() . '&album_id=' . $this->getVar("a_id", "e") . '" title="' . _EDIT . '">'
					. '<img src="' . ICMS_IMAGES_SET_URL . '/actions/edit.png" /></a>';
		}
	}
	
	public function getMyDeleteItemLink() {
		if($this->userCanEditAndDelete()) {
			return '<a href="' . ALBUM_URL . 'images.php?op=del&img_id=' . $this->id() . '&album_id=' . $this->getVar("a_id", "e") . '" title="' . _DELETE . '">'
					. '<img src="' . ICMS_IMAGES_SET_URL . '/actions/editdelete.png" /></a>';
		}
	}
	
	public function toArray() {
		global $albumConfig;
		$ret = parent::toArray();
		$ret['max_width'] = $this->getMaxWidth();
		$ret['max_height'] = $this->getMaxHeight();
		$ret['display_width'] = $albumConfig['image_display_width'] + 25;
		$ret['display_height'] = $albumConfig['image_display_height'] + 400;
		$ret['dsc'] = $this->getImageDescription();
		$ret['title'] = $this->title();
		$ret['thumb'] = $this->getImagesThumb();
		$ret['img'] = $this->getImagesImage();
		$ret['id'] = $this->id();
		$ret['published_on'] = $this->getPublishedDate();
		$ret['updated_on'] = $this->getUpdatedDate();
		$ret['publisher'] = $this->getPublisher(TRUE);
		$ret['uname'] = $this->getPublisher(FALSE);
		$ret['urllink'] = $this->getImagesURL();
        //if(defined("ALBUM_SHOW_TAGS")) {
		  $ret['tags'] = $this->getImageTags(FALSE);
		//}
		$ret['messages'] = $this->getImageComments();
		$ret['editItemLink'] = $this->getMyEditItemLink();
		$ret['deleteItemLink'] = $this->getMyDeleteItemLink();
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		return $ret;
	}
}