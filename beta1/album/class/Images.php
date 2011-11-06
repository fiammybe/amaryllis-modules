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
		$this->quickInitVar('img_active', XOBJ_DTYPE_INT, true, '', '', 1);
		$this -> initCommonVar( 'weight', XOBJ_DTYPE_INT );
		$this->quickInitVar('img_publisher', XOBJ_DTYPE_INT, FALSE);
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
		
		$this->hideFieldFromForm( array( 'weight', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );
		$this->hideFieldFromSingleView( array( 'weight', 'dohtml', 'dobr', 'doimage', 'dosmiley', 'docxcode' ) );

	}

	public function getVar($key, $format = 's') {
		if ($format == 's' && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	public function album_id() {
		static $album_idArray;
		$album_album_handler = icms_getModuleHandler('album', basename(dirname(dirname(__FILE__))), 'album');
		if (!is_array($album_idArray)) {
			$album_idArray = $this->handler->getAlbumList();
		}
		$ret = $this->getVar('a_id', 'e');
		if ($ret > 0) {
			$ret = '<a href="' . ALBUM_URL . 'album.php?album_id=' . $ret . '">' . str_replace('-', '', $album_idArray[$ret]) . '</a>';
		} else {
			$ret = $album_idArray[$ret];
		}
		return $ret;
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

	public function getWeightControl() {
		$control = new icms_form_elements_Text( '', 'weight[]', 5, 7,$this -> getVar( 'weight', 'e' ) );
		$control->setExtra( 'style="text-align:center;"' );
		return $control->render();
	}
	
	public function getEditItemLink() {
		$ret = '<a href="' . ALBUM_ADMIN_URL . 'images.php?op=changedField&amp;img_id=' . $this->getVar('img_id', 'e') . '" title="' . _MD_ALBUM_ALBUM_EDIT . '"><img src="' . ICMS_IMAGES_SET_URL . '/actions/edit.png" /></a>';
		return $ret;
	}
	
}