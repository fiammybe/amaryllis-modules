<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/TagsHandler.php
 * 
 * Classes responsible for managing Article tags objects
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

class mod_article_TagsHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "tags", "tags_id", "tags_title", "tags_description", "article");
		$this->enableUpload(array("image/gif", "image/jpeg", "image/pjpeg", "image/png"), 512000, 32, 32);
	}

	public function getList($approve = TRUE, $active = TRUE) {
		$criteria = new icms_db_criteria_Compo();
		if($approve) $criteria->add(new icms_db_criteria_Item("tags_approve", TRUE));
		if($active) $criteria->add(new icms_db_criteria_Item("tags_active", TRUE));
		$tags = $this->getObjects($criteria, TRUE);
		$ret[] = '-----------------';
		foreach (array_keys($tags) as $i) {
			$ret[$i] = $tags[$i]->getVar("tags_title", "e");
		}
		return $ret;
	}
	
	public function beforeInsert(&$obj)	{
		if ($obj->getVar("tags_image_upl", "e") != "") {
			$obj->setVar("tags_image", $obj->getVar("tags_image_upload"));
		}
		$dsc = $obj->getVar("tags_description", "s");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$obj->setVar("tags_description", $dsc);
		
		return true;
	}

}