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
		parent::__construct($handler);

		$this->quickInitVar('img_id', XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar('a_id', XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar('img_title', XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar('img_published_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('img_updated_date', XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar('img_description', XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar('img_url', XOBJ_DTYPE_IMAGE, TRUE);
		$this->quickInitVar('img_active', XOBJ_DTYPE_INT,TRUE, '', '', 1);
		$this->quickInitVar('img_approve', XOBJ_DTYPE_INT, TRUE);
		$this->initCommonVar( 'weight', XOBJ_DTYPE_INT );
		$this->quickInitVar('img_publisher', XOBJ_DTYPE_INT, FALSE, FALSE, FALSE, 1);
		$this->initCommonVar('dohtml', FALSE, 1);
		$this->initCommonVar('dobr', TRUE, 1);
		$this->initCommonVar('doimage', TRUE, 1);
		$this->initCommonVar('dosmiley', TRUE, 1);
		$this->initCommonVar('docxode', TRUE, 1);
		
		$this -> setControl ( 'img_active', 'yesno' );
		$this->setControl( 'img_publisher', 'user' );
		$this->setControl('a_id', array('itemHandler' => 'album', 'method' => 'getAlbumList', 'module' => 'album'));
		$this -> setControl( 'img_description', 'dhtmltextarea' );
		
		$this->setControl( 'img_url', array( 'name' => 'image' ) );
		$url = ICMS_URL . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/';
		$path = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/';
		$this->setImageDir($url, $path);
		
		$this->hideFieldFromForm( array( 'img_publisher', 'img_published_date', 'img_updated_date', 'weight', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );
		$this->hideFieldFromSingleView( array( 'weight', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );

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
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/stop.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=visible">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/button_ok.png" alt="Online" /></a>';
		}
	}
	
	public function img_approve() {
		$active = $this->getVar('img_approve', 'e');
		if ($active == false) {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ALBUM_ADMIN_URL . 'images.php?img_id=' . $this->getVar('img_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Approved" /></a>';
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

	public function getMaxHeight() {
		global $albumConfig;
		$innerHeight = $albumConfig['image_display_height'];
		$maxHeight = $innerHeight + 300;
		return $maxHeight;
	}
	
	public function getMaxWidth() {
		global $albumConfig;
		$innerWidth = $albumConfig['image_display_width'];
		$maxWidth = $innerWidth + 50;
		return $maxWidth;
	}
	
	public function getEditItemLink() {
		$ret = '<a href="' . ALBUM_ADMIN_URL . 'images.php?op=changedField&amp;img_id=' . $this->getVar('img_id', 'e') . '" title="' . _MD_ALBUM_ALBUM_EDIT . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/edit.png" /></a>';
		return $ret;
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
		
		
		return $ret;
	}
	
}