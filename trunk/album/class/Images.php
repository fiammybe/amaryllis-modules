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

class AlbumImages extends icms_ipf_Object {

	public function __construct(&$handler) {
		global $albumConfig;
		parent::__construct($handler);

		$this->quickInitVar('img_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('a_id', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('img_title', XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar('img_published_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('img_updated_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('img_description', XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar('img_url', XOBJ_DTYPE_IMAGE, TRUE);
		$this->quickInitVar("img_tags", XOBJ_DTYPE_ARRAY);
		$this->quickInitVar('img_active', XOBJ_DTYPE_INT,TRUE, FALSE, FALSE, 1);
		$this->quickInitVar('img_approve', XOBJ_DTYPE_INT, TRUE, FALSE, FALSE,1);
		$this->initCommonVar( 'weight', XOBJ_DTYPE_INT );
		$this->quickInitVar('img_publisher', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->initCommonVar('dohtml', FALSE, 1);
		$this->initCommonVar('dobr', TRUE, 1);
		$this->initCommonVar('doimage', TRUE, 1);
		$this->initCommonVar('dosmiley', TRUE, 1);
		$this->initCommonVar('docxode', TRUE, 1);
		
		$this->setControl('img_active', 'yesno');
		$this->setControl('img_approve', 'yesno');
		$this->setControl('img_publisher', 'user');
		$this->setControl('a_id', array('itemHandler' => 'album', 'method' => 'getAlbumList', 'module' => 'album'));
		$this->setControl('img_description', 'dhtmltextarea' );
		
		$this->setControl( 'img_url', array( 'name' => 'image' ) );
		$url = ICMS_URL . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/';
		$path = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/';
		$this->setImageDir($url, $path);
		
		$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
		if($albumConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
			$this->setControl("img_tags", array("name" => "select_multi", "itemHandler" => "images", "method" => "getImagesTags", "module" => "album"));
		} else {
			$this->hideFieldFromForm("img_tags");
			$this->hideFieldFromSingleView("img_tags");
		}
		
		$this->hideFieldFromForm( array('img_publisher', 'img_published_date', 'img_updated_date', 'weight', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode'));
		$this->hideFieldFromSingleView(array('weight', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode'));

	}

	public function getVar($key, $format = 's') {
		if ($format == 's' && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	public function image_aid() {
		$cid = $this->getVar ( 'a_id', 'e' );
		$album_album_handler = icms_getModuleHandler ( 'album',basename(dirname(dirname(__FILE__))), 'album' );
		$album = $album_album_handler->get ( $cid );
		
		return $album->getVar ( 'album_title' );
	}
	
	public function img_active() {
		$img_active = $this->getVar('img_active', 'e');
		if ($img_active == false) {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'hidden.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=visible">
				<img src="' . ALBUM_IMAGES_URL . 'visible.png" alt="Online" /></a>';
		}
	}
	
	public function img_approve() {
		$active = $this->getVar('img_approve', 'e');
		if ($active == false) {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'denied.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=changeApprove">
				<img src="' . ALBUM_IMAGES_URL . 'approved.png" alt="Approved" /></a>';
		}
	}

	public function getWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	function userCanEditAndDelete() {
		global $album_isAdmin;
		if (!is_object(icms::$user)) return false;
		if ($album_isAdmin) return true;
		return $this->getVar('image_publisher', 'e') == icms::$user->getVar("uid");
	}
	
	public function getImageTag($indexview = true) {
		$img = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$img = $this->getVar('img_url', 'e');
		$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);
		if($indexview) {
			if (!$img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/images/' . $img;
			} else {
				$image_tag = false;
			}
		} else {
			if (!$img == "") {
				$image_tag = ICMS_URL . '/uploads/album/images/' . $img;
			} else {
				$image_tag = false;
			}
		}
		return $image_tag;
	}

	function img_publisher() {
		return icms_member_user_Handler::getUserLink($this->getVar('img_publisher', 'e'));
	}
	
	// get publisher for frontend
	function getPublisher($link = false) {
		
			$publisher_uid = $this->getVar('img_publisher', 'e');
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
	
	public function getImagesTags($itemlink = FALSE) {
		$tags = $this->getVar('img_tags', 's');
		$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
		if(icms_get_module_status("sprockets") && $tags != "") {
			$sprockets_tag_handler = icms_getModuleHandler ( 'tag', $sprocketsModule->getVar("dirname"), 'sprockets' );
			$ret = array();
			if($itemlink == FALSE) {
				foreach ($tags as $tag) {
					$tagObject = $sprockets_tag_handler->get($tag);
					$ret[$tag] = $tagObject->getVar("title");
				}
			} else {
				foreach ($tags as $tag) {
					$tagObject = $sprockets_tag_handler->get($tag);
					$icon = $tagObject->getVar("icon", "e");
					$title = $tagObject->getVar("title");
					$dsc = $tagObject->getVar("description", "s");
					$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodehigh");
					$dsc = icms_core_DataFilter::undoHtmlSpecialChars($dsc);
					$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodelow");
					if($icon != "") {
						$image = ICMS_URL . '/uploads/' . $sprocketsModule->getVar("dirname") . '/' . $icon;
						$ret[$tag] = '<span class="album_tag" original-title="' . $title . '"><a href="' . $this->getTaglink($tag)
									 . '" title="' . $title . '"><img width=16px height=16px src="'
									. $image . '" title="' . $title . '" alt="' . $title . '" />&nbsp;&nbsp;' . $title . '</a></span>';
						if($dsc != "") {
							$ret[$tag] .= '<span class="popup_tag">' . $dsc . '</span>';
						}
					} else {
						$ret[$tag] = '<span class="album_tag" original-title="' . $title . '"><a href="' . $this->getTaglink($tag) 
									. '" title="' . $title . '">' . $title . '</a></span>';
						if($dsc != "") {
							$ret[$tag] .= '<span class="popup_tag">' . $dsc . '</span>';
						}
					}
				}
			}
			return implode(" | ", $ret);
		} else {
			return FALSE;
		}
	}
	
	public function getTagLink($tag) {
		$link = ALBUM_URL . "index.php?op=getByTags&tag=" . $tag;
		return $link;
	}
	
	/**
	 * convert the date to prefered settings
	 */
	public function getPublishedDate() {
		global $albumConfig;
		$date = '';
		$date = $this->getVar('img_published_date', 'e');
		
		return date($albumConfig['album_dateformat'], $date);
	}
	
	public function getUpdatedDate() {
		global $albumConfig;
		$date = '';
		$date = $this->getVar('img_updated_date', 'e');
		if($date != 0){
			return date($albumConfig['album_dateformat'], $date);
		} else {
			return FALSE;
		}
	}

	public function getMaxHeight() {
		global $albumConfig;
		$innerHeight = $albumConfig['image_display_height'];
		$maxHeight = ((int)($innerHeight) + 300);
		return $maxHeight;
	}
	
	public function getMaxWidth() {
		global $albumConfig;
		$innerWidth = $albumConfig['image_display_width'];
		$maxWidth = ((int)($innerWidth) + 50);
		return $maxWidth;
	}
	
	public function toArray() {
		global $albumConfig;
		$ret = parent::toArray();
		$ret['thumbnail_width'] = $albumConfig['thumbnail_width'];
		$ret['thumbnail_height'] = $albumConfig['thumbnail_height'];
		$ret['inner_width'] = $albumConfig['image_display_width'];
		$ret['inner_height'] = $albumConfig['image_display_height'];
		$ret['max_width'] = $this->getMaxWidth();
		$ret['max_height'] = $this->getMaxHeight();
		$ret['dsc'] = $this->getVar("img_description");
		$ret['title'] = $this->getVar("img_title");
		$ret['img'] = $this->getImageTag(TRUE);
		$ret['img_url'] = $this->getImageTag(FALSE);
		$ret['id'] = $this->getVar("img_id");
		$ret['published_on'] = $this->getPublishedDate();
		$ret['updated_on'] = $this->getUpdatedDate();
		$ret['publisher'] = $this->getPublisher(TRUE);
		$ret['tags'] = $this->getImagesTags(TRUE);
		return $ret;
	}
	
}