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
 * @version		$Id$
 * @package		album
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

include_once ICMS_ROOT_PATH . '/modules/'.ALBUM_DIRNAME.'/include/common.php';

class mod_album_Images extends icms_ipf_Object {

	public $_updating = FALSE;

	public $_updating_table = FALSE;
	public $_admin_thumbs;
	public $_images_thumbs;

	public $_images_images;

	public $_images_images_url;

	public $_images_thumbs_url;
	public $_admin_thumbs_url;

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
		$this->initCommonVar('dohtml', FALSE, TRUE);
		$this->initCommonVar('dobr', FALSE, FALSE);
		$this->initCommonVar('doimage', FALSE, TRUE);
		$this->initCommonVar('dosmiley', FALSE, TRUE);
		$this->initCommonVar('docxode', FALSE, TRUE);

		$this->setControl('img_active', 'yesno');
		$this->setControl('img_approve', 'yesno');
		$this->setControl('img_publisher', 'user');
		$this->setControl('a_id', array('name' => 'select', 'itemHandler' => 'album', 'method' => 'getAlbumListForPid', 'module' => 'album'));
		//$this->setControl('img_description', 'dhtmltextarea' );
		$this->setControl('img_copy_pos', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkPositions', 'module' => 'album'));
		$this->setControl('img_copy_color', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkColors', 'module' => 'album'));
		$this->setControl('img_copy_font', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkFont', 'module' => 'album'));
		$this->setControl('img_copy_fontsize', array('name' => 'select', 'itemHandler' => 'images', 'method' => 'getWatermarkFontSize', 'module' => 'album'));
		$this->setControl( 'img_url', array('name' => 'image', 'nourl' => TRUE));

		if($albumConfig['need_image_links'] == 0) {
			$this->hideFieldFromForm("img_urllink");
			$this->hideFieldFromSingleView("img_urllink");
		}
		if(!$this->handler->_index_module_status) {
			$this->hideFieldFromForm("img_tags");
			$this->hideFieldFromSingleView("img_tags");
		}
		if($albumConfig['img_allow_uploader_copyright'] == 0) {
			$this->hideFieldFromForm('img_copyright');
		}

		if($albumConfig['img_use_copyright'] == 0) {
			$this->hideFieldFromForm(array("img_copyright", "img_copy_pos", "img_copy_color", "img_copy_font", "img_copy_fontsize"));
			$this->hideFieldFromSingleView(array("img_copyright", "img_copy_pos", "img_copy_color", "img_copy_font", "img_copy_fontsize"));
		}

		$this->_images_thumbs = $this->handler->getImagesThumbsPath();
		$this->_images_images = $this->handler->getImagesImagesPath();
		$this->_admin_thumbs = $this->handler->getImagesAdminPath();
		$this->_images_images_url = ICMS_URL . '/cache/' . ALBUM_DIRNAME . '/' . $this->handler->_itemname . '/images/';
		$this->_images_thumbs_url = ICMS_URL . '/cache/' . ALBUM_DIRNAME . '/' . $this->handler->_itemname . '/thumbs/';
		$this->_admin_thumbs_url = ICMS_URL . '/cache/' . ALBUM_DIRNAME . '/' . $this->handler->_itemname . '/admin/';
		$this->hideFieldFromForm( array('img_publisher', 'img_published_date', 'img_updated_date'));
	}

	/**
	 * Overriding the icms_ipf_Object::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	public function getVar($key, $format = "s") {
		if (strtolower($format) == "s" && in_array($key, array("img_active", "img_approve", "img_published_date", "img_updated_date", "a_id", "img_publisher" ))) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}

	/**
	 * overriding some output fields directly
	 */
	public function a_id($linkOnly = TRUE) {
		$cid = $this->getVar('a_id', 'e');
		$albums = $this->handler->loadAlbums();
		$album = isset($albums[$cid]) ? $albums[$cid] : FALSE;
		if($linkOnly) return ($album) ? $albums[$cid]['itemLink'] : FALSE;
		return $album;
	}

	public function img_publisher($linkOnly = TRUE) {
		global $icmsConfig;
		$suid = $this->getVar("img_publisher", "e");
		$this->handler->loadUsers();
		if($linkOnly) return isset($this->handler->_usersArray[$suid]) ? $this->handler->_usersArray[$suid]['link'] : $icmsConfig['anonymous'];
		return (isset($this->handler->_usersArray[$suid])) ? $this->handler->_usersArray[$suid] : $icmsConfig['anonymous'];
	}

	public function img_tags($namesOnly = TRUE) {
		$labels = $this->getVar("img_tags");
		if($labels != "" && $labels != "0" && $this->handler->_index_module_status) {
			if($namesOnly) {return $labels;}
			$labelArray = $this->handler->loadLabels();
			$labels = explode(",", $labels);
			$ret = array();
			foreach ($labels as $k => $v) {
				$ret[$k] = $labelArray[trim($v)];
			}
			unset($labelArray, $labels);
			return array_values($ret);
		}
	}

	public function img_published_date() {
		global $albumConfig;
		$date = $this->getVar('img_published_date', 'e');
		return date($albumConfig['album_dateformat'], $date);
	}

	public function img_updated_date() {
		global $albumConfig;
		$date = $this->getVar('img_updated_date', 'e');
		if($date != 0){
			return date($albumConfig['album_dateformat'], $date);
		} else {
			return FALSE;
		}
	}

	public function img_urllink() {
		global $albumConfig;
		if($albumConfig['need_image_links']) {
			$link = $this->getVar("img_urllink", "e");
			$this->handler->loadUrlLinks();
			return isset($this->handler->_urllinks[$link]) ? $this->handler->_urllinks[$link] : FALSE;
		}
		return FALSE;
	}
	/**
	 * prepare some control fields for ACP Image overview
	 */
	public function img_active() {
		$active = $this->getVar('img_active', 'e');
		$url = (isset($GLOBALS['MODULE_ALBUM_ADMIN_SIDE']) && $GLOBALS['MODULE_ALBUM_ADMIN_SIDE'] === TRUE) ? ALBUM_ADMIN_URL : ALBUM_URL;
		if ($active == FALSE) {
			return '<a href="'.$url.'images.php?img_id='.$this->id().'&amp;op=changeVisible"><img src="'.ALBUM_IMAGES_URL.'hidden.png" alt="'._CO_ALBUM_OFFLINE.'" /></a>';
		} else {
			return '<a href="'.$url.'images.php?img_id='.$this->id().'&amp;op=changeVisible"><img src="'.ALBUM_IMAGES_URL.'visible.png" alt="'._CO_ALBUM_ONLINE.'" /></a>';
		}
	}

	public function img_approve() {
		$approve = $this->getVar('img_approve', 'e');
		$url = (isset($GLOBALS['MODULE_ALBUM_ADMIN_SIDE']) && $GLOBALS['MODULE_ALBUM_ADMIN_SIDE'] === TRUE) ? ALBUM_ADMIN_URL : ALBUM_URL;
		if ($approve == FALSE) {
			return '<a href="'.$url.'images.php?img_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'denied.png" alt="'._CO_ALBUM_DENIED.'" /></a>';
		} else {
			return '<a href="'.$url.'images.php?img_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'approved.png" alt="'._CO_ALBUM_APPROVED.'" /></a>';
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
		$img = '<img src="'.$this->getAdminImage().'" />';
		return $img;
	}

	/**
	 * prepare some output fields
	 */
	public function getImagesThumb() {
		global $albumConfig;
		$img = $this->getVar('img_url', 'e');
		$cached_thumb = $this->_images_thumbs . $img;
		$cached_url = $this->_images_thumbs_url . $img;
		if(is_file($cached_thumb) === FALSE) {
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new mod_album_Image($img, $srcpath);
			$image->resizeImage($albumConfig['thumbnail_width'], $albumConfig['thumbnail_height'], $this->_images_thumbs, "90");
		}
		return $cached_url;
	}

	public function getAdminImage() {
		global $albumConfig;
		$images_img = $this->getVar('img_url', 'e');
		$cached_thumb = $this->_images_thumbs . $images_img;
		$cached_url = $this->_images_thumbs_url . $images_img;
		if(is_file($cached_thumb) === FALSE) {
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new mod_album_Image($images_img, $srcpath);
			$image->resizeImage(100, 100, $this->_images_thumbs, "90");
		}
		return $cached_url;
	}

	public function getImagesImage() {
		global $albumConfig;
		$img = $this->getVar('img_url', 'e');
		$cached_image_url = $this->_images_images_url . $img;
		$cached_img = $this->_images_images.$img;
		if(is_file($cached_img) === FALSE) {
			$srcpath = ALBUM_UPLOAD_ROOT.$this->handler->_itemname."/";
			$image2 = new mod_album_Image($img, $srcpath);
			$image2->resizeImage($albumConfig['image_display_width'], $albumConfig['image_display_height'], $this->_images_images, "100");
		}
		return $cached_image_url;
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
		return FALSE;
	}

	function userCanEditAndDelete() {
		global $album_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($album_isAdmin) return TRUE;
		return $this->getVar('img_publisher', 'e') == icms::$user->getVar("uid");
	}

	public function getEditItemLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		$admin_side = $userSide ? '' : ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "image_id=".$this->id() : $this->handler->keyName."=".$this->id();
		$ret = $this->handler->_moduleUrl.$admin_side.$page."?op=mod&amp;".$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img src='".ICMS_IMAGES_SET_URL."/actions/edit.png' alt='"._CO_ICMS_MODIFY."'  title='"._CO_ICMS_MODIFY."'/>" : _CO_ICMS_MODIFY;
		return "<a class='album_edit' href='".$ret."'>".$image."</a>";
	}

	public function getDeleteItemLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		$admin_side = $userSide ? '' : ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "image_id=".$this->id() : $this->handler->keyName."=".$this->id();
		$ret = $this->handler->_moduleUrl.$admin_side.$page."?op=del&amp;".$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img class='icon_middle icon_small' src='".ICMS_IMAGES_SET_URL."/actions/editdelete.png' alt='"._CO_ICMS_DELETE."'  title='"._CO_ICMS_DELETE."'/>" : _CO_ICMS_DELETE;
		return "<a class='album_edit' href='".$ret."'>".$image."</a>";
	}

	public function getSubmitItemLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		if(!$userSide) {
			$admin_side = ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		} else {
			$admin_side = '';
		}
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "images_id=".$this->id() : $this->handler->keyName."=".$this->id();
		$request = ($userSide) ? '?view=modImages&amp;' : '?op=del&';
		$ret = $this->handler->_moduleUrl.$admin_side.$page.$request.$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img class='icon_middle icon_small' src='".ALBUM_IMAGES_URL."add_img.png' alt='"._SUBMIT."'  title='"._SUBMIT."'/>" : _SUBMIT;
		return "<a rel='module_submit' class='album_submit' href='".$ret." title='"._SUBMIT."'>".$image."</a>";
	}

	function accessGranted($perm_name = "album_grpperm") {
		if ($this->userCanEditAndDelete()) return TRUE;
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$viewperm = $gperm_handler->checkRight($perm_name, $this->getVar('a_id', 'e'), $groups, $this->handler->_moduleID);
		if ($viewperm && $this->isActive() && $this->isApproved()) return TRUE;
		return FALSE;
	}

	public function getItemLink($urlOnly = FALSE) {
		$album = $this->a_id(FALSE);
		return $album['itemUrl'];
	}

	public function isActive() {
		return ($this->getVar("img_active", "e") == 1) ? TRUE : FALSE;
	}

	public function isApproved() {
		return ($this->getVar("img_approve", "e") == 1) ? TRUE : FALSE;
	}

	public function toArray() {
		global $albumConfig;
		$ret = parent::toArray();
		$ret['max_width'] = $this->getMaxWidth();
		$ret['max_height'] = $this->getMaxHeight();
		$ret['display_width'] = $albumConfig['image_display_width'] + 25;
		$ret['display_height'] = $albumConfig['image_display_height'] + 400;
		$ret['thumb'] = $this->getImagesThumb();
		$ret['img'] = $this->getImagesImage();
		$ret['publisher'] = $this->img_publisher(FALSE);
		$ret['uname'] = $this->img_publisher(TRUE);
		$ret['urllink'] = $this->img_urllink();
		$ret['posterid'] = $this->getVar('img_publisher', 'e');
        //if(defined("ALBUM_SHOW_TAGS")) {
		  $ret['labels'] = $this->img_tags(FALSE);
		//}
		$ret['messages'] = $this->getImageComments();
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['submit_link'] = $this->getSubmitItemLink(FALSE, FALSE, TRUE);
		$ret['submit_img_link'] = $this->getSubmitItemLink(FALSE, TRUE, TRUE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		return $ret;
	}
}