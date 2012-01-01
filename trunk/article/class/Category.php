<?php
/**
 * "Artikel" is an article management module for ImpressCMS
 *
 * File: /class/Category.php
 * 
 * Class representing Artikel category Objects
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

class ArtikelCategory extends icms_ipf_seo_Object {
	/**
	 * Constructor
	 *
	 * @param mod_artikel_Category $handler Object handler
	 */
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar("category_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("category_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->initCommonVar("short_url");
		$this->quickInitVar("category_descriprion", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("category_pid", XOBJ_DTYPE_CURRENCY, FALSE);
		$this->quickInitVar("category_image", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("category_image_upl", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("category_grpperm", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("category_uplperm", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("category_submitter", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_publisher", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_updater", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_published_date", XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar("category_updated_date", XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar("category_active", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_approve", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_inblocks", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("category_updated", XOBJ_DTYPE_INT, FALSE);
		$this->initCommonVar("weight");
		$this->initCommonVar("counter");
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("doimage", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		$this->initCommonVar("docxode", FALSE, 1);
		$this->quickInitVar("category_notification_sent", XOBJ_DTYPE_INT, FALSE);
		
		$this->setControl("category_image", array("name" => "select", "itemhandler" => "category", "method" => "getImageList", "module" => "artikel"));
		$this->setControl("category_image_upl", "image");
		$this->setControl("category_publisher", "user");
		$this->setControl("category_grpperm", array("name" => "select_multi", "itemhandler" => "category", "method" => "getGroups", "module" => "artikel"));
		$this->setControl("category_uplperm", array("name" => "select_multi", "itemhandler" => "category", "method" => "getUplGroups", "module" => "artikel"));
		$this->setControl("category_active", "yesno");
		$this->setControl("category_approve", "yesno");
		$this->setControl("category_inblocks", "yesno");
		$this->setControl("category_updated", "yesno");

		$this->hideFieldFromForm(array("category_published_date", "category_updated_date", "weight", "counter", "category_submitter", "category_updater"));
		$this->hideFieldFromSingleView(array("dohtml", "doimage", "dosmiley", "doxcode"));

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
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
}