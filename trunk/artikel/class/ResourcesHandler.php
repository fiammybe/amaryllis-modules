<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /class/ResourcesHandler.php
 * 
 * Classes responsible for managing Artikel resources objects
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

class ArtikelResourcesHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "resources", "resources_id", "resources_title", "resources_publishing_company", "artikel");
	}


}