<?php
/**
 * 'Article' is an tags management module for ImpressCMS
 *
 * File: /class/Tags.php
 * 
 * Class representing Article tag Objects
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

class mod_article_Tags extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_article_Tags $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("tags_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("tags_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("tags_description", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("tags_image", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("tags_image_upl", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("tags_submitter", XOBJ_DTYPE_INT);
		$this->quickInitVar("tags_updater", XOBJ_DTYPE_INT);
		$this->quickInitVar("tags_published_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("tags_updated_date", XOBJ_DTYPE_LTIME);
		$this->quickInitVar("tags_approve", XOBJ_DTYPE_INT, FALSE, "", "", 1);
		$this->quickInitVar("tags_active", XOBJ_DTYPE_INT, FALSE, "", "", 1);
		$this->initCommonVar("counter", FALSE);
		$this->initCommonVar("dohtml", FALSE, 1);
		$this->initCommonVar("dosmiley", FALSE, 1);
		
		$this->setControl("tags_description", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("tags_image_upl", "image");
		$this->setControl("tags_approve", "yesno");
		$this->setControl("tags_active", "yesno");

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
	
	public function tags_active() {
		$active = $this->getVar('tags_active', 'e');
		if ($active == false) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'tags.php?tags_id=' . $this->getVar('tags_id') . '&amp;op=visible">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/stop.png" alt="Offline" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'tags.php?tags_id=' . $this->getVar('tags_id') . '&amp;op=visible">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/button_ok.png" alt="Online" /></a>';
		}
	}
	
	public function tags_approve() {
		$active = $this->getVar('tags_approve', 'e');
		if ($active == false) {
			return '<a href="' . ARTICLE_ADMIN_URL . 'tags.php?tags_id=' . $this->getVar('tags_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/0.png" alt="Denied" /></a>';
		} else {
			return '<a href="' . ARTICLE_ADMIN_URL . 'tags.php?tags_id=' . $this->getVar('tags_id') . '&amp;op=changeApprove">
				<img src="' . ICMS_IMAGES_SET_URL . '/actions/1.png" alt="Approved" /></a>';
		}
	}
	
	
	
	/**
	 * preparing tags for output
	 */
	public function getTagsDescription() {
		$dsc = $this->getVar("tags_description", "e");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "output");
		return $dsc;
	}
	

	public function toArray() {
		$ret = parent::toArray();
		$ret['id'] = $this->getVar("tags_id");
		$ret['title'] = $this->getVar("tags_title", "e");
		$ret['dsc'] = $this->getTagsDescription();
		
		
		
	}
}