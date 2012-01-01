<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /class/Tags.php
 * 
 * Class representing Artikel tag Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Artikel
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		artikel
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class mod_artikel_Tags extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_artikel_Tags $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("tags_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("tag_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("tag_description", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("tag_image", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("tag_image_upl", XOBJ_DTYPE_IMAGE, FALSE);
		$this->initCommonVar("counter");
		$this->initCommonVar("dohtml");
		$this->initCommonVar("dosmiley");
		$this->setControl("tag_image_upl", "image");

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
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
}