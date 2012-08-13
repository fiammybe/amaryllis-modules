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

class AlbumAlbum extends icms_ipf_seo_Object {

	public $updating_counter = FALSE;
	
	public $_album_thumbs;
	
	public $_album_images;
	
	public $_album_images_url;
	
	public $_album_thumbs_url;
	
	/**
	 * Constructor
	 *
	 * @param AlbumAlbum $handler Object handler
	 */
	public function __construct(&$handler) {
		global $albumConfig;
		parent::__construct($handler);

		$this->quickInitVar('album_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('album_title', XOBJ_DTYPE_TXTBOX, TRUE);
		$this->initCommonVar('short_url');
		$this->quickInitVar('album_pid', XOBJ_DTYPE_INT, FALSE);
		//$this->quickInitVar('album_cid', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 0);
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
		$this->initCommonVar('docxode', FALSE, 1);
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
		
		if(!icms_get_module_status("index")) {
			$this->hideFieldFromForm("album_tags");
			$this->hideFieldFromSingleView("album_tags");
		}
		/**
		if($albumConfig['need_cats'] == 1 && icms_get_module_status("index")) {
			$this->setControl('album_cid', array('name' => 'select', 'itemHandler' => 'category', 'method' => 'getCategoryListForPid', 'module' => 'index'));
		} else {
			$this->hideFieldFromForm("album_cid");
			$this->hideFieldFromSingleView("album_cid");
		}
		 */
		
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

	public function getAlbumParent() {
		$parent = $this->getVar("album_pid", "e");
		if($parent == 0){
			return '-------------';
		} else {
			$album = $this->handler->get($parent);
			$parent_link = $album->getItemLink(FALSE);
			return $parent_link;
		}
	}
	
	function album_pid() {
		static $album_pidArray;
		if (!is_array($album_pidArray)) {
			$album_pidArray = $this->handler->getAlbumListForPid();
		}
		$ret = $this->getVar('album_pid', 'e');
		if ($ret > 0) {
			$ret = '<a href="' . ALBUM_URL . 'index.php?album_id=' . $ret . '">' . str_replace('-', '', $album_pidArray[$ret]) . '</a>';
		} else {
			$ret = $album_pidArray[$ret];
		}
		return $ret;
	}
	
	public function getAlbumTags($namesOnly = TRUE) {
		$tags = $this->getVar("album_tags", "e");
		if(icms_get_module_status("index") && $tags != "" && $tags != "0") {
			$indexModule = icms_getModuleInfo("index");
			$tags = explode(",", $tags);
			$tag_handler = icms_getModuleHandler ( "tag", $indexModule->getVar("dirname"), "index");
			$criteria = new icms_db_criteria_Compo();
			foreach ($tags as $key => $tag) {
				$criteria->add(new icms_db_criteria_Item("tag_id", $tag), "OR");
			}
			$criteria->add(new icms_db_criteria_Item("tag_approve", TRUE));
			$tags = $tag_handler->getObjects($criteria, TRUE, FALSE);
			unset($tag_handler, $criteria);
			if($namesOnly) {
				$ret = array();
				foreach ($tags as $key => $value) {
					$ret[] = $value['name'];
				}
				return implode(",", $ret);
			}
			return $tags;
		}
	}
	
	/**
	 * publisher link instead of stored id
	 */
	function getPublisher() {
		return icms_member_user_Handler::getUserLink($this->getVar('album_uid', 'e'));
	}
	
	/**
	 * convert the date to prefered settings
	 */
	public function getPublishedDate() {
		global $albumConfig;
		$date = $this->getVar('album_published_date', 'e');
		return date($albumConfig['album_dateformat'], $date);
	}
	
	public function getUpdatedDate() {
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
		if ($active == FALSE) {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function album_inblocks() {
		$active = $this->getVar('album_inblocks', 'e');
		if ($active == FALSE) {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeShow">
				<img src="' . ALBUM_IMAGES_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeShow">
				<img src="' . ALBUM_IMAGES_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	public function album_approve() {
		$active = $this->getVar('album_approve', 'e');
		if ($active == FALSE) {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}
	
	public function album_onindex() {
		$active = $this->getVar('album_onindex', 'e');
		if ($active == FALSE) {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeIndex">
				<img src="' . ALBUM_IMAGES_URL . 'denied.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeIndex">
				<img src="' . ALBUM_IMAGES_URL . 'approved.png" alt="Visible" /></a>';
		}
	}
	
	function getAlbumDescription() {
		$dsc = $this->getVar("album_description", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		return $dsc;
	}
	
	function submitAccessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$submitperm = $gperm_handler->checkRight('album_uplperm', $this->getVar('album_id', 'e'), $groups, $module->getVar("mid"));
		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('album_uid', 'e')) {
			return TRUE;
		}
		if ($submitperm && ($this->getVar('album_active', 'e') == TRUE) && ($this->getVar('album_approve', 'e') == TRUE)) {
			return TRUE;
		}
		return FALSE;
	}
	
	function accessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);

		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));

		$agroups = $gperm_handler->getGroupIds('module_admin', $module->getVar("mid"));
		$allowed_groups = array_intersect($groups, $agroups);

		$viewperm = $gperm_handler->checkRight('album_grpperm', $this->getVar('album_id', 'e'), $groups, $module->getVar("mid"));

		if ($this->userCanEditAndDelete()) return TRUE;
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

	function getItemLink($onlyUrl = FALSE, $seo = TRUE) {
		$urltarget = ($seo) ? 'album=' . $this->short_url() : 'album_id=' . $this->id();
		$url = ICMS_MODULES_URL . '/' . ALBUM_DIRNAME . '/index.php?' . $urltarget;
		if($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this->title() . '" class="article_itemlink">' . $this->title() . '</a>';
	}
	
	public function getAlbumThumb() {
		global $albumConfig;
		$album_img = $this->getVar('album_img', 'e');
		$cached_thumb = $this->_album_thumbs . $album_img;
		$cached_url = $this->_album_thumbs_url . $album_img;
		if(!is_file($cached_thumb)) {
			require_once ICMS_MODULES_PATH . "/index/class/IndexImage.php";
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new IndexImage($album_img, $srcpath);
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
			require_once ICMS_MODULES_PATH . "/index/class/IndexImage.php";
			$srcpath = ALBUM_UPLOAD_ROOT . $this->handler->_itemname . "/";
			$image = new IndexImage($album_img, $srcpath);
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
		$ret = '<a href="' . ALBUM_URL . 'index.php?album_id=' . $this->getVar('album_id', 'e') . '" title="' . _AM_ALBUM_PREVIEW . '" target="_blank">' . $this->getVar('album_title') . '</a>';
		return $ret;
	}
	
	public function isActive() {
		return $this->getVar("album_active" == 1) ? TRUE : FALSE;
	}
	
	public function isApproved() {
		return $this->getVar("album_approve" == 1) ? TRUE : FALSE;
	}
	
	public function isOnindex() {
		return $this->getVar("album_onindex" == 1) ? TRUE : FALSE;
	}
	
	public function hasSubs() {
		return ($this->getVar("album_hassub", "e") > 0) ? TRUE : FALSE;
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['published_on'] = $this->getPublishedDate();
		$ret['updated_on'] = $this->getUpdatedDate();
		$ret['publisher'] = $this->getPublisher(TRUE);
		$ret['id'] = $this->id();
		$ret['title'] = $this->title();
		$ret['icon'] = $this->getAlbumImageTag();
		$ret['img'] = $this->getAlbumImage();
		$ret['thumb'] = $this->getAlbumThumb();
		$ret['dsc'] = $this->getAlbumDescription();
		$ret['editItemLink'] = $this->getEditItemLink(FALSE, TRUE, TRUE);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(FALSE, TRUE, TRUE);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['posterid'] = $this->getVar('album_uid', 'e');
		$ret['tags'] = $this->getAlbumTags(FALSE);
		$ret['itemLink'] = $this->getItemLink(FALSE);
		$ret['itemURL'] = $this->getItemLink(TRUE);
		$ret['accessgranted'] = $this->accessGranted();
		$ret['user_upload'] = $this->submitAccessGranted();
		$ret['album_is_new'] = $this->displayNewIcon();
		$ret['album_is_updated'] = $this->displayUpdatedIcon();
		$ret['album_popular'] = $this->displayPopularIcon();
		return $ret;
	}

	function sendNotifAlbumPublished() {
		$module = icms::handler('icms_module')->getByDirname(ALBUM_DIRNAME);
		$tags ['ALBUM_TITLE'] = $this->getVar('album_title');
		$tags ['ALBUM_URL'] = $this->getItemLink(TRUE);
		icms::handler('icms_data_notification')->triggerEvent('global', 0, 'album_published', $tags, array(), $module->getVar('mid'));
	}

	public function sendMessageApproved() {
		$pm_handler = icms::handler('icms_data_privmessage');
		$file = "album_approved.tpl";
		$lang = "language/" . $icmsConfig['language'] . "/mail_template";
		$tpl = ALBUM_ROOT_PATH . "$lang/$file";
		if (!file_exists($tpl)) {
			$lang = 'language/english/mail_template';
			$tpl = ALBUM_ROOT_PATH . "$lang/$file";
		}
		$user = $this->getVar("album_uid", "e");
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