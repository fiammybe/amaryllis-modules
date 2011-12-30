<?php
/**
 * "Artikel" is an article management module for ImpressCMS
 *
 * File: /class/Article.php
 * 
 * Class representing Artikel article Objects
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

class mod_artikel_Article extends icms_ipf_seo_Object {
	/**
	 * Constructor
	 *
	 * @param mod_artikel_Article $handler Object handler
	 */
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar("article_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("article_title", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("article_cid", XOBJ_DTYPE_INT, TRUE);
		
		$this->quickInitVar("article_descriptions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_image", XOBJ_DTYPE_IMAGE, FALSE);
		$this->quickInitVar("article_teaser", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("article_body", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("article_descriptions_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_additionals", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_steps", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_tips", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_warnings", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_license", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_needed", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_attachment", XOBJ_DTYPE_FILE, FALSE);
		$this->quickInitVar("article_attachment_alt", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_downloads", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_album", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_video", XOBJ_DTYPE_CURRENCY, FALSE);
		$this->quickInitVar("article_video_source", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_video_upload", XOBJ_DTYPE_FILE, FALSE);
		$this->quickInitVar("article_history", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_related", XOBJ_DTYPE_ARRAY, FALSE);
		$this->quickInitVar("article_resources", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_tags", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("article_conclusion", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("article_additionals_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_informations", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_submitter", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_publisher", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_updater", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_published_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("article_updated_date", XOBJ_DTYPE_LTIME, TRUE);
		$this->quickInitVar("article_informations_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_permissions", XOBJ_DTYPE_FORM_SECTION);
		$this->quickInitVar("article_grpperm", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("article_approve", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_active", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_updated", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_inblocks", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_permissions_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		$this->quickInitVar("article_statics", XOBJ_DTYPE_FORM_SECTION);
		$this->initCommonVar("weight");
		$this->initCommonVar("counter");
		$this->initCommonVar("dohtml");
		$this->initCommonVar("doimage");
		$this->initCommonVar("dosmiley");
		$this->initCommonVar("docxode");
		$this->quickInitVar("article_notification_sent", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("article_stats_close", XOBJ_DTYPE_FORM_SECTION_CLOSE);
		
		
		$this->setControl("article_cid", array("name" => "select_multi", "itemhandler" => "category", "method" => "getCategoryListForPid", "module" => "artikel"));
		$this->setControl("article_image", "image");
		$this->setControl("article_teaser", array("name" => "textarea", "form_editor" => "htmlarea"));
		$this->setControl("article_body", "dhtmltextarea");
		$this->setControl("article_license",array("name" => "select_multi", "itemhandler" => "artikel", "method" => "getArticleLicense", "module" => "artikel"));
		
		$this->setControl("article_publisher", "user");
		$this->setControl("article_approve", "yesno");
		$this->setControl("article_active", "yesno");
		$this->setControl("article_updated", "yesno");
		$this->setControl("article_inblocks", "yesno");


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