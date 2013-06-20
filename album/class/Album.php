<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/Album.php
 *
 * Class representing album album objects
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

class mod_album_Album extends icms_ipf_seo_Object {

	public $updating_counter = FALSE;

	public $_album_thumbs;

	public $_album_images;

	public $_album_images_url;

	public $_album_thumbs_url;

	/**
	 * Constructor
	 *
	 * @param mod_album_Album $handler Object handler
	 */
	public function __construct(&$handler) {
		global $albumConfig;
		parent::__construct($handler);

		$this->quickInitVar('album_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('album_title', XOBJ_DTYPE_TXTBOX, TRUE);
		$this->initCommonVar('short_url');
		$this->quickInitVar('album_pid', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('album_tags', XOBJ_DTYPE_TXTBOX, FALSE, FALSE, FALSE);
		$this->quickInitVar('album_img', XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar('album_img_upload', XOBJ_DTYPE_IMAGE);

		$this->quickInitVar('album_published_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('album_updated_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('album_description', XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar('album_active', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar('album_inblocks', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar('album_approve', XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 1);
		$this->quickInitVar('album_onindex', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar('album_updated', XOBJ_DTYPE_INT);

		$this->quickInitVar('album_uid', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->quickInitVar('album_comments', XOBJ_DTYPE_INT, FALSE);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', FALSE, 1);
		$this->initCommonVar('doimage', FALSE, 1);
		$this->initCommonVar('dosmiley', FALSE, 1);
		$this->initCommonVar('doxcode', FALSE, 1);
		$this->quickInitVar('album_notification_sent', XOBJ_DTYPE_INT);
		$this->quickInitVar("album_hassub", XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
		// set controls
		$this->setControl('album_pid', array('name' => 'select', 'itemHandler' => 'album', 'method' => 'getAlbumListForPid', 'module' => 'album'));
		$this->setControl( 'album_img_upload', 'imageupload');
		$this->setControl('album_description', 'dhtmltextarea');
		$this->setControl('album_active', 'yesno');
		$this->setControl('album_inblocks', 'yesno');
		$this->setControl('album_onindex', 'yesno');
		$this->setControl('album_approve', 'yesno');
		$this->setControl('album_updated', 'yesno');
		$this->setControl('album_uid', 'user');
		$this->setControl('album_img', array('name' => 'select', 'itemHandler' => 'album', 'method' => 'getImageList', 'module' => 'album'));


		if(!$this->handler->_index_module_status) {
			$this->hideFieldFromForm("album_tags");
			$this->hideFieldFromSingleView("album_tags");
		}

		$this->_album_thumbs = $this->handler->getAlbumThumbsPath();
		$this->_album_images = $this->handler->getAlbumImagesPath();
		$this->_album_images_url = ICMS_URL . '/cache/' . ALBUM_DIRNAME . '/' . $this->handler->_itemname . "/images/";
		$this->_album_thumbs_url = ICMS_URL . '/cache/' . ALBUM_DIRNAME . '/' . $this->handler->_itemname . "/thumbs/";

		// hide static fields from forms/single views
		$this->hideFieldFromForm( array('album_uid',"album_hassub", 'album_updated_date','album_published_date','album_notification_sent', 'album_comments', 'counter'));
		$this->hideFieldFromSingleView( array('album_uid',"album_hassub",'album_notification_sent', 'album_comments', 'weight', 'counter'));
		//initiate SEO
		$this->initiateSEO();
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
		if (strtolower($format) == "s" && in_array($key, array("album_active", "album_approve", "album_published_date", "album_updated_date", "album_pid", "album_uid" ))) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}

	public function album_pid($linkOnly = TRUE) {
		$pid = $this->getVar("album_pid", "e");
		if($pid > 0) {
			$albums = $this->handler->loadCategories();
			if($linkOnly) return (isset($albums[$pid])) ? $albums[$pid]['itemLink'] : FALSE;
			return (isset($albums[$cid])) ? $albums[$cid] : FALSE;
		}
		return FALSE;
	}

	public function album_tags($namesOnly = TRUE) {
		$labels = $this->getVar("album_tags");
		if($this->handler->_index_module_status && $labels != "" && $labels != "0") {
			if($namesOnly) {return $labels;}
			$this->handler->loadLabels();
			$labels = explode(",", $labels);
			$ret = array();
			foreach ($labels as $k => $v) {
				$ret[$k] = $this->handler->_labelArray[trim($v)];
			}
			unset($labelArray, $labels);
			return array_values($ret);
		}
	}

	/**
	 * publisher link instead of stored id
	 */
	function album_uid($linkOnly = TRUE) {
		global $icmsConfig;
		$suid = $this->getVar("album_uid", "e");
		$users = $this->handler->loadUsers();
		if($linkOnly) return isset($users[$suid]) ? $users[$suid]['link'] : $icmsConfig['anonymous'];
		return (isset($users[$suid])) ? $users[$suid] : $icmsConfig['anonymous'];
	}

	/**
	 * convert the date to prefered settings
	 */
	public function album_published_date() {
		global $albumConfig;
		$date = $this->getVar('album_published_date', 'e');
		return date($albumConfig['album_dateformat'], $date);
	}

	public function album_updated_date() {
		global $albumConfig;
		$date = $this->getVar('album_updated_date', 'e');
		return date($albumConfig['album_dateformat'], $date);
	}

	public function displayNewIcon() {
		$time = $this->getVar("album_published_date", "e");
		$timestamp = time();
		$newalbum = album_display_new($time, $timestamp);
		return $newalbum;
	}

	public function displayUpdatedIcon() {
		$time = $this->getVar("album_updated_date", "e");
		$timestamp = time();
		$newalbum = album_display_updated($time, $timestamp);
		return $newalbum;
	}

	public function displayPopularIcon() {
		$popular = album_display_popular($this->getVar("counter", "e"));
		return $popular;
	}

	/*
	 * some functions to handle easy change album to approved/online/inblocks/onindex or back
	 */
	public function album_active() {
		$active = $this->getVar('album_active', 'e');
		$url = (isset($GLOBALS['MODULE_ALBUM_ADMIN_SIDE']) && $GLOBALS['MODULE_ALBUM_ADMIN_SIDE'] === TRUE) ? ALBUM_ADMIN_URL : ALBUM_URL;
		if ($active == FALSE) {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeVisible"><img src="'.ALBUM_IMAGES_URL.'hidden.png" alt="'._CO_ALBUM_OFFLINE.'" /></a>';
		} else {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeVisible"><img src="'.ALBUM_IMAGES_URL.'visible.png" alt="'._CO_ALBUM_ONLINE.'" /></a>';
		}
	}

	public function album_approve() {
		$approve = $this->getVar('album_approve', 'e');
		$url = (isset($GLOBALS['MODULE_ALBUM_ADMIN_SIDE']) && $GLOBALS['MODULE_ALBUM_ADMIN_SIDE'] === TRUE) ? ALBUM_ADMIN_URL : ALBUM_URL;
		if ($approve == FALSE) {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'denied.png" alt="'._CO_ALBUM_DENIED.'" /></a>';
		} else {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'approved.png" alt="'._CO_ALBUM_APPROVED.'" /></a>';
		}
	}

	public function album_inblocks() {
		$inBlocks = $this->getVar('album_inblocks', 'e');
		$url = (isset($GLOBALS['MODULE_ALBUM_ADMIN_SIDE']) && $GLOBALS['MODULE_ALBUM_ADMIN_SIDE'] === TRUE) ? ALBUM_ADMIN_URL : ALBUM_URL;
		if ($inBlocks == FALSE) {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'denied.png" alt="'._CO_ALBUM_IN_BLOCKS.'" /></a>';
		} else {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'approved.png" alt="'._CO_ALBUM_OFF_BLOCKS.'" /></a>';
		}
	}

	public function album_onindex() {
		$onIndex = $this->getVar('album_inblocks', 'e');
		$url = (isset($GLOBALS['MODULE_ALBUM_ADMIN_SIDE']) && $GLOBALS['MODULE_ALBUM_ADMIN_SIDE'] === TRUE) ? ALBUM_ADMIN_URL : ALBUM_URL;
		if ($onIndex == FALSE) {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'denied.png" alt="'._CO_ALBUM_OFF_INDEX.'" /></a>';
		} else {
			return '<a href="'.$url.'album.php?album_id='.$this->id().'&amp;op=changeApprove"><img src="'.ALBUM_IMAGES_URL.'approved.png" alt="'._CO_ALBUM_ON_INDEX.'" /></a>';
		}
	}

	function accessGranted($perm_name = 'album_grpperm') {
		global $icmsModule, $album_isAdmin;
		if($album_isAdmin) return TRUE;
		if ($this->userCanEditAndDelete() && $perm_name == "album_grpperm") return TRUE;
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$viewperm = $gperm_handler->checkRight($perm_name, $this->id(), $groups, $this->handler->_moduleID);
		if ($viewperm && $this->isActive() && $this->isApproved()) return TRUE;
		return FALSE;
	}

	function userCanEditAndDelete() {
		global $album_isAdmin;
		if (!is_object(icms::$user)) return FALSE;
		if ($album_isAdmin) return TRUE;
		return $this->getVar('album_uid', 'e') == icms::$user->getVar("uid");
	}

	public function getWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}

	public function getItemLink($urlOnly = FALSE) {
		global $albumConfig;
		$cid = $this->album_pid(FALSE);
		if($albumConfig['use_rewrite'] == 1) {
			$cat = ($cid) ? $cid['short_url']."/" : "";
			$url = $this->handler->_moduleUrl;
			$url .= $cat.$this->short_url().'/';
			if($urlOnly) return $url;
			return '<a class="album_link" href="'.$url.'" title="'.$this->title().'">'.$this->title().'</a>';
		} else {
			$url = $this->handler->_moduleUrl;
			$url .= ($this->handler->_moduleUseMain) ? ALBUM_DIRNAME.'.php?album='.$this->short_url() : 'index.php?album='.$this->short_url();
			if($urlOnly) return $url;
			return '<a class="album_link" href="'.$url.'" title="'.$this->title().'">'.$this->title().'</a>';
		}
	}

	public function getAlbumThumb() {
		global $albumConfig;
		$album_img = $this->getVar('album_img', 'e');
		$cached_thumb = $this->_album_thumbs . $album_img;
		$cached_url = $this->_album_thumbs_url . $album_img;
		if(!is_file($cached_thumb)) {
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new mod_album_Image($album_img, $srcpath);
			$image->resizeImage($albumConfig['thumbnail_width'], $albumConfig['thumbnail_height'], $this->_album_thumbs, "90");
		}
		return $cached_url;
	}

	public function getAlbumImage() {
		global $albumConfig;
		$album_img = $this->getVar('album_img', 'e');
		$cached_img = $this->_album_images . $album_img;
		$cached_image_url = $this->_album_images_url . $album_img;
		if(!file_exists($cached_img)) {
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new mod_album_Image($album_img, $srcpath);
			$image->resizeImage($albumConfig['image_display_width'], $albumConfig['image_display_height'], $this->_album_images, "100");
		}
		return $cached_image_url;
	}

	public function getAlbumImageTag() {
		$album_img = $this->getVar("album_img", "e");
		if($album_img != "" && $album_img != "0") {
			return ALBUM_UPLOAD_URL . $this->handler->_itemname . "/" . $album_img;
		}
	}

	public function getViewItemLink() {
		$ret = '<a href="' . ALBUM_ADMIN_URL . 'album.php?op=view&amp;album_id=' . $this->getVar('album_id', 'e') . '" title="' . _AM_ALBUM_ALBUM_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}

	function getPreviewItemLink() {
		$url = $this->handler->_moduleUrl.$this->handler->_page.'?album='.$this->short_url();
		$ret = '<a href="'.$url.'" title="'._AM_ALBUM_PREVIEW.'" target="_blank">'.$this->getVar('album_title').'</a>';
		return $ret;
	}

	public function getEditItemLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		if(!$userSide) {
			$admin_side = ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		} else {
			$admin_side = '';
		}
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "album=".$this->short_url() : $this->handler->keyName."=".$this->id();
		$request = ($userSide) ? '?view=modAlbum&amp;' : '?op=mod&';
		$ret = $this->handler->_moduleUrl.$admin_side.$page.$request.$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img src='".ICMS_IMAGES_SET_URL."/actions/edit.png' alt='"._CO_ICMS_MODIFY."'  title='"._CO_ICMS_MODIFY."'/>" : _CO_ICMS_MODIFY;
		return "<a class='album_edit' href='".$ret."'>".$image."</a>";
	}

	public function getDeleteItemLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		if(!$userSide) {
			$admin_side = ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		} else {
			$admin_side = '';
		}
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "album=".$this->short_url() : $this->handler->keyName."=".$this->getVar($this->handler->keyName);
		$request = ($userSide) ? '?view=delAlbum&amp;' : '?op=del&';
		$ret = $this->handler->_moduleUrl.$admin_side.$page.$request.$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img src='".ICMS_IMAGES_SET_URL."/actions/editdelete.png' alt='"._CO_ICMS_DELETE."'  title='"._CO_ICMS_DELETE."'/>" : _CO_ICMS_DELETE;
		return "<a class='album_delete' href='".$ret."' title='"._CO_ICMS_DELETE."'>".$image."</a>";
	}

	public function getSubmitItemLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		global $albumConfig;
		if(!$userSide) {
			$admin_side = ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		} else {
			$admin_side = '';
		}
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "album_parent=".$this->short_url() : $this->handler->keyName."=".$this->id();
		$request = ($userSide) ? '?view=modAlbum&amp;' : '?op=modAlbum&';
		$classes = ($albumConfig['album_show_upl_disclaimer'] == 1) ? "upl_disclaimer" : "";
		$ret = $this->handler->_moduleUrl.$admin_side.$page.$request.$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img class='icon_middle icon_small' src='".ALBUM_IMAGES_URL."add_cat.png' alt='"._CO_ALBUM_SUBMIT_ALBUM."'  title='"._CO_ALBUM_SUBMIT_ALBUM."'/>" : _CO_ALBUM_SUBMIT_ALBUM;
		return "<a rel='module_submit' class='$classes album_submit' href='".$ret."' title='"._CO_ALBUM_SUBMIT_ALBUM."'>".$image."</a>";
	}

	public function getSubmitImageLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		global $albumConfig;
		if(!$userSide) {
			$admin_side = ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		} else {
			$admin_side = '';
		}
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "album=".$this->short_url() : $this->handler->keyName."=".$this->id();
		$request = ($userSide) ? '?view=modImages&amp;' : '?op=modAlbum&';
		$classes = ($albumConfig['album_show_upl_disclaimer'] == 1) ? "upl_disclaimer" : "";
		$ret = $this->handler->_moduleUrl.$admin_side.$page.$request.$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img class='icon_middle icon_small' src='".ALBUM_IMAGES_URL."add_img.png' alt='"._CO_ALBUM_SUBMIT_IMAGES."'  title='"._CO_ALBUM_SUBMIT_IMAGES."'/>" : _CO_ALBUM_SUBMIT_IMAGES;
		return "<a rel='module_submit' class='$classes album_submit' href='".$ret."' title='"._CO_ALBUM_SUBMIT_IMAGES."'>".$image."</a>";
	}

	public function getSubmitBatchLink($onlyUrl=FALSE, $withimage=TRUE, $userSide=FALSE) {
		global $albumConfig;
		if(!$userSide) {
			$admin_side = ($this->handler->_moduleUseMain) ? 'modules/'.ALBUM_DIRNAME.'/admin/' : 'admin/';
		} else {
			$admin_side = '';
		}
		$page = ($userSide) ? $this->handler->_page : $this->handler->_itemname.'.php';
		$key = ($userSide) ? "album=".$this->short_url() : $this->handler->keyName."=".$this->id();
		$request = ($userSide) ? '?view=batchupload&amp;' : '?op=modAlbum&';
		$classes = ($albumConfig['album_show_upl_disclaimer'] == 1) ? "upl_disclaimer" : "";
		$ret = $this->handler->_moduleUrl.$admin_side.$page.$request.$key;
		if($onlyUrl) return $ret;
		$image = ($withimage) ? "<img class='icon_middle icon_small' src='".ALBUM_IMAGES_URL."add_zip.png' alt='"._CO_ALBUM_SUBMIT_IMAGES."'  title='"._CO_ALBUM_SUBMIT_IMAGES."'/>" : _CO_ALBUM_SUBMIT_IMAGES;
		return "<a rel='module_submit' class='$classes album_submit' href='".$ret."' title='"._CO_ALBUM_SUBMIT_IMAGES."'>".$image."</a>";
	}

	public function isActive() {
		return ($this->getVar("album_active", "e") == 1) ? TRUE : FALSE;
	}

	public function isApproved() {
		return ($this->getVar("album_approve", "e") == 1) ? TRUE : FALSE;
	}

	public function isOnindex() {
		return ($this->getVar("album_onindex", "e") == 1) ? TRUE : FALSE;
	}

	public function hasSubs() {
		return ($this->getVar("album_hassub", "e") > 0) ? TRUE : FALSE;
	}

	function toArray() {
		$ret = parent::toArray();
		$ret['publisher'] = $this->album_uid(TRUE);
		$ret['icon'] = $this->getAlbumImageTag();
		$ret['img'] = $this->getAlbumImage();
		$ret['thumb'] = $this->getAlbumThumb();
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['posterid'] = $this->getVar('album_uid', 'e');
		$ret['labels'] = $this->album_tags(FALSE);
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['album_is_new'] = $this->displayNewIcon();
		$ret['album_is_updated'] = $this->displayUpdatedIcon();
		$ret['album_popular'] = $this->displayPopularIcon();
		$ret['submit_link'] = $this->getSubmitItemLink(FALSE, FALSE, TRUE);
		$ret['submit_img_link'] = $this->getSubmitItemLink(FALSE, TRUE, TRUE);
		$ret['submit_url'] = $this->getSubmitItemLink(TRUE, FALSE, TRUE);
		$ret['images_submit_link'] = $this->getSubmitImageLink(FALSE, FALSE, TRUE);
		$ret['images_submit_img_link'] = $this->getSubmitImageLink(FALSE, TRUE, TRUE);
		$ret['images_submit_url'] = $this->getSubmitImageLink(TRUE, FALSE, TRUE);

		$ret['batch_submit_link'] = $this->getSubmitBatchLink(FALSE, FALSE, TRUE);
		$ret['batch_submit_img_link'] = $this->getSubmitBatchLink(FALSE, TRUE, TRUE);
		$ret['batch_submit_url'] = $this->getSubmitBatchLink(TRUE, FALSE, TRUE);
		return $ret;
	}

	function sendNotifAlbumPublished() {
		$module = icms::handler('icms_module')->getByDirname(ALBUM_DIRNAME);
		$tags ['ALBUM_TITLE'] = $this->getVar('album_title');
		$tags ['ALBUM_URL'] = $this->getItemLink(TRUE);
		icms::handler('icms_data_notification')->triggerEvent('global', 0, 'album_published', $tags, array(), $module->getVar('mid'));
	}

	public function sendMessageApproved() {
		global $icmsConfig;
		$user = $this->getVar("album_uid", "e");
		if($user == 0) return TRUE;
		$pm_handler = icms::handler('icms_data_privmessage');
		$file = "album_approved.tpl";
		$lang = "language/" . $icmsConfig['language'] . "/mail_template";
		$tpl = ALBUM_ROOT_PATH . "$lang/$file";
		if (!file_exists($tpl)) {
			$lang = 'language/english/mail_template';
			$tpl = ALBUM_ROOT_PATH . "$lang/$file";
		}
		$uname = icms::handler('icms_member_user')->get($user)->getVar("uname");
		$message = file_get_contents($tpl);
		$message = str_replace("{X_UNAME}", $uname, $message);
		$message = str_replace("{ALBUM_TITLE}", $this->title(), $message);
		$pmObj = $pm_handler->create(TRUE);
		$pmObj->setVar("subject", _CO_ALBUM_HAS_APPROVED);
		$pmObj->setVar("from_userid", 1);
		$pmObj->setVar("to_userid", (int)$user);
		$pmObj->setVar("msg_time", time());
		$pmObj->setVar("msg_text", $message);
		$pm_handler->insert($pmObj, TRUE);
	}
}