<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /class/ArticleHandler.php
 * 
 * Classes responsible for managing Artikel article objects
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

class mod_artikel_ArticleHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "article", "article_id", "article_title", "article_teaser", "artikel");
		$this->enableUpload(array("image/gif", "image/jpeg", "image/pjpeg", "image/png"), 512000, 800, 600);
	}


}