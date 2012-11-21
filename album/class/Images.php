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

include_once ICMS_ROOT_PATH . '/modules/album/include/common.php';

class AlbumImages extends icms_ipf_Object {

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
		$this->quickInitVar("img_tags", XOBJ_DTYPE_ARRAY,FALSE, FALSE, FALSE, '');
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
		$this->initCommonVar('dobr', FALSE, 1);
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
		if($albumConfig['use_sprockets'] == 1 && icms_get_module_status("sprockets")) {
			$this->setControl("img_tags", array("name" => "selectmulti", "itemHandler" => "images", "method" => "getImagesTags", "module" => "album"));
		} else {
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
		$this->hideFieldFromForm( array('img_hasmsg', 'img_publisher', 'img_published_date', 'img_updated_date'));
		$this->hideFieldFromSingleView(array('dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode'));

	}

	public function image_aid() {
		$cid = $this->getVar ( 'a_id', 'e' );
		$album_album_handler = icms_getModuleHandler ( 'album',basename(dirname(dirname(__FILE__))), 'album' );
		$album = $album_album_handler->get ( $cid );
		
		return $album->getVar ( 'album_title' );
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
		$control = new icms_form_elements_Text( '', 'img_title[]', 15, 255,$this->getVar('img_title', 'e'));
		return $control->render();
	}
	
	public function getDscControl() {
		$control = new icms_form_elements_Textarea( '', 'img_description[]', $this->getVar('img_description', 'e'), 3, 40);
		return $control->render();
	}

	public function getWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
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
	
	public function getImageTag($indexview = TRUE) {
		$img = $image_tag = '';
		$directory_name = basename(dirname( dirname( __FILE__ ) ));
		$script_name = getenv("SCRIPT_NAME");
		$img = $this->getVar('img_url', 'e');
		$document_root = str_replace('modules/' . $directory_name . '/index.php', '', $script_name);
		if($indexview) {
			if (!$img == "") {
				$image_tag = $document_root . 'uploads/' . $directory_name . '/images/' . $img;
			} else {
				$image_tag = FALSE;
			}
		} else {
			if (!$img == "") {
				$image_tag = ICMS_URL . '/uploads/album/images/' . $img;
			} else {
				$image_tag = FALSE;
			}
		}
		return $image_tag;
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

	public function img_publisher() {
		return icms_member_user_Handler::getUserLink($this->getVar('img_publisher', 'e'));
	}
	
	// get publisher for frontend
	public function getPublisher($link = FALSE) {
		if($link) {
			return icms_member_user_Handler::getUserLink($this->getVar('img_publisher', 'e'));
		} else {
			$users = $this->handler->getUsersArray();
			return $users[$this->getVar('img_publisher', 'e')];
		}
	}
	
	public function getImageDescription() {
		$dsc = $this->getVar("img_description");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		return $dsc;
	}
	
	public function getImagesTags($itemlink = FALSE) {
		$tags = $this->getVar("img_tags", "s");
		$sprocketsModule = icms_getModuleInfo("sprockets");
		if(icms_get_module_status("sprockets") && $tags != "") {
			$sprockets_tag_handler = icms_getModuleHandler ( "tag", $sprocketsModule->getVar("dirname"), "sprockets");
			$ret = array();
			if($itemlink == FALSE) {
				foreach ($tags as $tag) {
					$tagObject = $sprockets_tag_handler->get($tag);
					if(is_object($tagObject) && !$tagObject->isNew()) {
						$ret[$tag] = $tagObject->getVar("title");
					}
				}
			} else {
				foreach ($tags as $tag) {
					$tagObject = $sprockets_tag_handler->get($tag);
					if(is_object($tagObject) && !$tagObject->isNew()) {
						$icon = $tagObject->getVar("icon", "e");
						$title = $tagObject->getVar("title");
						$dsc = $tagObject->getVar("description", "s");
						$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodehigh");
						$dsc = icms_core_DataFilter::undoHtmlSpecialChars($dsc);
						$dsc = icms_core_DataFilter::checkVar($dsc, "str", "encodelow");
						if($icon != "") {
							$ret[$tag]['icon'] = ICMS_URL . '/uploads/' . $sprocketsModule->getVar("dirname") . '/' . $tagObject->getVar("icon", "e");
						}
						$ret[$tag]['title'] = $title;
						$ret[$tag]['link'] = $this->getTaglink($tag);
						if($dsc != "") {
							$ret[$tag]['dsc'] = $dsc;
						}
					}
				}
			}
			return $ret;
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
		if($this->getVar("img_urllink") != 0) {
			$demo = 'img_urllink';
			$linkObj = $this-> getUrlLinkObj($demo);
			$url = $linkObj->render();
			return $url;
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
	
	public function getImageComments() {
		global $albumConfig;
		$album_message_handler = icms_getModuleHandler("message", basename(dirname(dirname(__FILE__))), "album");
		$messages = $album_message_handler->getMessages($this->getVar("img_id", "e"));
		if($messages && $albumConfig['use_messages'] == 1) {
			foreach (array_keys($messages) as $message) {
				$messageObj = $album_message_handler->get($message);
				$date = $messageObj->getPublishedDate();
				$body = $messageObj->getMessageBody();
				$ulink = $messageObj->getPublisher();
				$avatar = $messageObj->getPublisherAvatar();
				$ret[$message]['date'] = $date;
				$ret[$message]['body'] = $body;
				$ret[$message]['ulink'] = $ulink;
				$ret[$message]['avatar'] = $avatar;
			}
			return $ret;
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
		$ret['thumbnail_width'] = (int)$albumConfig['thumbnail_width'];
		$ret['thumbnail_height'] = (int)$albumConfig['thumbnail_height'];
		$ret['inner_width'] = (int)$albumConfig['image_display_width'];
		$ret['inner_height'] = (int)$albumConfig['image_display_height'];
		$ret['max_width'] = $this->getMaxWidth();
		$ret['max_height'] = $this->getMaxHeight();
		$ret['dsc'] = $this->getImageDescription();
		$ret['title'] = $this->getVar("img_title");
		$ret['img'] = $this->getImageTag(TRUE);
		$ret['img_url'] = $this->getImageTag(FALSE);
		$ret['img_path'] = $this->getImagePath();
		$ret['id'] = $this->getVar("img_id");
		$ret['published_on'] = $this->getPublishedDate();
		$ret['updated_on'] = $this->getUpdatedDate();
		$ret['publisher'] = $this->getPublisher(TRUE);
		$ret['uname'] = $this->getPublisher(FALSE);
		$ret['urllink'] = $this->getImagesURL();
		$ret['tags'] = $this->getImagesTags(TRUE);
		$ret['messages'] = $this->getImageComments();
		$ret['editItemLink'] = $this->getMyEditItemLink();
		$ret['deleteItemLink'] = $this->getMyDeleteItemLink();
		$ret['userCanEditAndDelete'] = $this->userCanEditAndDelete();
		return $ret;
	}
}