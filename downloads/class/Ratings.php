<?php
/**
 * Class representing downloads ratings objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		downloads
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class DownloadsRatings extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_downloads_Ratings $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("ratings_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("item", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("rating_rate", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("rating_ip", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("rating_fb_like", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("rating_fb_dislike", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("ratings_total", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("ratings_g_like", XOBJ_DTYPE_INT, FALSE);

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