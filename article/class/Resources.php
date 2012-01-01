<?php
/**
 * "Article" is an article management module for ImpressCMS
 *
 * File: /class/Resources.php
 * 
 * Class representing Article resources Objects
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

class ArticleResources extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_article_Article $handler Object handler
	 */
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar("resources_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("resources_name", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_titel", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_subtitle", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_names_in", XOBJ_DTYPE_TXTAREA);
		$this->quickInitVar("resources_title_in", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_subtitle_in", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_publishing_company_city", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_publishing_company", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_edition", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_year", XOBJ_DTYPE_INT);
		$this->quickInitVar("resources_volume", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_pages", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_url", XOBJ_DTYPE_URLLINK);
		$this->quickInitVar("resources_submitter", XOBJ_DTYPE_INT);
		$this->quickInitVar("resources_updater", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_submitting_date", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_updating_date", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("resources_approve", XOBJ_DTYPE_INT);
		$this->quickInitVar("resources_case", XOBJ_DTYPE_TXTBOX);
		
		$this->setControl("resources_approve", "yesno");
		$this->hideFieldFromForm(array("resources_submitter", "resources_updater", "resources_submitting_date", "resources_updating_date", "resources_case"));
		
	}
}
