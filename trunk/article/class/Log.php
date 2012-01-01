<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/Log.php
 * 
 * Class representing Article log Objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class mod_article_Log extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_article_Log $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("log_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("log_ip", XOBJ_DTYPE_OTHER, FALSE);
		$this->quickInitVar("log_uid", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("log_item_id", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("log_date", XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar("log_item", XOBJ_DTYPE_CURRENCY, FALSE);
		$this->quickInitVar("log_case", XOBJ_DTYPE_INT, FALSE);

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