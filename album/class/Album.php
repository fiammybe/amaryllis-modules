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

class AlbumAlbum extends icms_ipf_seo_Object {

	public $updating_counter = false;
	/**
	 * Constructor
	 *
	 * @param mod_album_Album $handler Object handler
	 */
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar('album_id', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('album_title', XOBJ_DTYPE_TXTBOX, true);
		$this->initCommonVar('short_url');
		$this->quickInitVar('album_pid', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('album_img', XOBJ_DTYPE_TXTAREA, false);
		$this->quickInitVar('album_published_date', XOBJ_DTYPE_LTIME, false);
		$this->quickInitVar('album_updated_date', XOBJ_DTYPE_LTIME, false);
		$this->quickInitVar('album_description', XOBJ_DTYPE_TXTAREA, false);
		$this->quickInitVar('album_active', XOBJ_DTYPE_INT, false, false, false, 1);
		$this->quickInitVar('album_inblocks', XOBJ_DTYPE_INT, false, false, false, 1);
		$this->quickInitVar('album_grpperm', XOBJ_DTYPE_TXTBOX, true );
		$this->quickInitVar('album_uid', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('album_comments', XOBJ_DTYPE_INT, false);
		$this->initCommonVar('weight');
		$this->initCommonVar('counter');
		$this->initCommonVar('dohtml', false, 1);
		$this->initCommonVar('dobr', true, 1);
		$this->initCommonVar('doimage', true, 1);
		$this->initCommonVar('dosmiley', true, 1);
		$this->initCommonVar('docxode', true, 1);
		$this->initNonPersistableVar('album_sub', XOBJ_DTYPE_INT);
		// set controls
		$this->setControl('album_pid', array('itemHandler' => 'album', 'method' => 'getAlbumListForPid', 'module' => 'album'));
		$this->setControl('album_description', 'dhtmltextarea');
		$this->setControl('album_active', 'yesno');
		$this->setControl('album_inblocks', 'yesno');
		$this->setControl('album_uid', 'user');
		$this->setControl('album_img', array( 'name' => 'select', 'itemHandler' => 'album', 'method' => 'getImageList', 'module' => 'album'));
		$this->setControl('album_grpperm', array ( 'name' => 'select_multi', 'itemHandler' => 'album', 'method' => 'getGroups', 'module' => 'album'));
		// hide static fields from forms/single views
		$this->hideFieldFromForm( array( 'album_sub', 'album_comments', 'weight', 'counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );
		$this->hideFieldFromSingleView( array( 'album_sub', 'album_comments', 'weight', 'counter', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );

		$this->initiateSEO();
	}

	public function getVar($key, $format = 's') {
		if ($format == 's' && in_array($key, array('album_uid', 'album_active', 'album_grpperm'))) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}

	// get sub album
	function album_sub() {
		$ret = $this->handler->getAlbumSubCount($this->getVar('album_id', 'e'));

		if ($ret > 0) {
			$ret = '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_pid=' . $this->getVar('album_id', 'e') . '">' . $ret . ' <img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag+.png" align="absmiddle" /></a>';
		}
		return $ret;
	}
	
	function getAlbumSub($toarray) {
		return $this->handler->getAlbumSub($this->getVar('album_id', 'e'), $toarray);
	}
	
	function album_pid() {
		static $album_pidArray;
		if (!is_array($album_pidArray)) {
			$album_pidArray = $this->handler->getAlbumListForPid();
		}
		$ret = $this->getVar('album_pid', 'e');
		if ($ret > 0) {
			$ret = '<a href="' . ALBUM_URL . 'album.php?album_id=' . $ret . '">' . str_replace('-', '', $album_pidArray[$ret]) . '</a>';
		} else {
			$ret = $album_pidArray[$ret];
		}
		return $ret;
	}
	
	// get uname instead of id for publisher
	function album_uid() {
		return icms_member_user_Handler::getUserLink($this->getVar('album_uid', 'e'));
	}
	
	// get publisher for frontend
	function getPublisher($link = false) {
		
			$publisher_uid = $this->getVar('album_uid', 'e');
			$userinfo = array();
			$userObj = icms::handler('icms_member')->getuser($publisher_uid);
			if (is_object($userObj)) {
				$userinfo['uid'] = $publisher_uid;
				$userinfo['uname'] = $userObj->getVar('uname');
				$userinfo['link'] = '<a href="' . ICMS_URL . '/userinfo.php?uid=' . $userinfo['uid'] . '">' . $userinfo['uname'] . '</a>';
			} else {
				global $icmsConfig;
				$userinfo['uid'] = 0;
				$userinfo['uname'] = $icmsConfig['anonymous'];
			}
		
		if ($link && $userinfo['uid']) {
			return $userinfo['link'];
		} else {
			return $userinfo['uname'];
		}
	}
	
	public function getPublishedDate() {
		global $albumConfig;
		$date = '';
		$date = $this->getVar('album_published_date', 'e');
		
		return date($albumConfig['album_dateformat'], $date);
	}
	
	public function getUpdatedDate() {
		global $albumConfig;
		$date = '';
		$date = $this->getVar('album_updated_date', 'e');
		
		return date($albumConfig['album_dateformat'], $date);
	}
	
	public function album_active() {
		$active = $this->getVar('album_active', 'e');
		if ($active == false) {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function album_inblocks() {
		$active = $this->getVar('album_inblocks', 'e');
		if ($active == false) {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeShow">
				<img src="' . ALBUM_IMAGES_URL . 'off.png" alt="Hidden" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'album.php?album_id=' . $this->getVar('album_id') . '&amp;op=changeShow">
				<img src="' . ALBUM_IMAGES_URL . 'on.png" alt="Visible" /></a>';
		}
	}
	
	// Retrieving the visibility of the album/album-set
	function album_grpperm() {
		$ret = $this->getVar('album_grpperm', 'e');
		$groups = $this->handler->getGroups();
		return $groups;
	}
	
	function accessGranted() {
		$gperm_handler = icms::handler('icms_member_groupperm');
		$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);

		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));

		$agroups = $gperm_handler->getGroupIds('module_admin', $module->getVar("mid"));
		$allowed_groups = array_intersect($groups, $agroups);

		$viewperm = $gperm_handler->checkRight('album_grpperm', $this->getVar('album_id', 'e'), $groups, $module->getVar("mid"));

		if (is_object(icms::$user) && icms::$user->getVar("uid") == $this->getVar('album_uid', 'e')) {
			return true;
		}
		
		if ($viewperm && $this->getVar('album_active', 'e') == true) {
			return true;
		}

		if ($viewperm && count($allowed_groups) > 0) {
			return true;
		}
		return false;
	}

	function userCanEditAndDelete() {
		global $album_isAdmin;
		if (!is_object(icms::$user)) return false;
		if ($album_isAdmin) return true;
		return $this->getVar('album_uid', 'e') == icms::$user->getVar("uid");
	}
	
	public function getWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}

	function getItemLink($onlyUrl = false) {
		$seo = $this->handler->makelink($this);
		$url = ALBUM_URL . 'album.php?album_id=' . $this -> getVar( 'album_id' ) . '&amp;album=' . $seo;
		if ($onlyUrl) return $url;
		return '<a href="' . $url . '" title="' . $this -> getVar( 'album_title' ) . ' ">' . $this -> getVar( 'album_title' ) . '</a>';
	}
	
	public function get_albumimage_tag() {
		$album_img = $image_tag = '';
		$album_img = $this->getVar('album_img', 'e');
		if (!empty($album_img)) {
			$image_tag = ALBUM_UPLOAD_URL . 'albumimages/' . $album_img;
		}
		return $image_tag;
	}

	public function getViewItemLink() {
		$ret = '<a href="' . ALBUM_ADMIN_URL . 'album.php?op=view&amp;album_id=' . $this->getVar('album_id', 'e') . '" title="' . _AM_ALBUM_ALBUM_VIEW . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/viewmag.png" /></a>';
		return $ret;
	}
	
	function getPreviewItemLink() {
		$ret = '<a href="' . ALBUM_URL . 'album.php?album_id=' . $this->getVar('album_id', 'e') . '" title="' . _AM_ALBUM_PREVIEW . '" target="_blank">' . $this->getVar('album_title') . '</a>';
		return $ret;
	}
	
	public function getEditItemLink() {
		$ret = '<a href="' . ALBUM_ADMIN_URL . 'album.php?op=changedField&amp;album_id=' . $this->getVar('album_id', 'e') . '" title="' . _AM_ALBUM_ALBUM_EDIT . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/edit.png" /></a>';
		return $ret;
	}
	
	public function getDeleteItemLink() {
		$ret = '<a href="' . ALBUM_ADMIN_URL . 'album.php?op=del&amp;album_id=' . $this->getVar('album_id', 'e') . '" title="' . _AM_ALBUM_ALBUM_DELETE . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/editdelete.png" /></a>';
		return $ret;
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['album_published_on'] = $this->getPublishedDate();
		$ret['album_updated_on'] = $this->getUpdatedDate();
		$ret['album_publisher'] = $this->getPublisher(true);
		$ret['id'] = $this->getVar('album_id');
		$ret['title'] = $this->getVar('album_title');
		
		$ret['img'] = $this->get_albumimage_tag();
		$ret['album_dsc'] = $this->getVar('album_description');
		$ret['sub'] = $this->getAlbumSub($this->getVar('album_id', 'e'), true);
		$ret['hassub'] = (count($ret['album_sub']) > 0) ? true : false;
		$ret['editItemLink'] = $this->getEditItemLink(false, true, true);
		$ret['deleteItemLink'] = $this->getDeleteItemLink(false, true, true);
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		$ret['album_posterid'] = $this->getVar('album_uid', 'e');
		$ret['itemLink'] = $this->getItemLink();
		$ret['accessgranted'] = $this->accessGranted();

		return $ret;
	}

	function sendNotifAlbumPublished() {
		$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
		$tags ['ALBUM_TITLE'] = $this->getVar('album_title');
		$tags ['ALBUM_URL'] = $this->getItemLink(true);
		icms::handler('icms_data_notification')->triggerEvent('global', 0, 'album_published', $tags, array(), $module->getVar('mid'));
	}

	function getReads() {
		return $this->getVar('counter');
	}

	function setReads($qtde = null) {
		$t = $this->getVar('counter');
		if (isset($qtde)) {
			$t += $qtde;
		} else {
			$t++;
		}
		$this->setVar('counter', $t);
	}
}