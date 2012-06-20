<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /class/Options.php
 * 
 * Class representing icmspoll options objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */
 
defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class IcmspollOptions extends icms_ipf_Object {

	/**
	 * constructor
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);
		$this->quickInitVar("option_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("poll_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("option_text", XOBJ_DTYPE_TXTBOX, TRUE, FALSE, FALSE);
		$this->quickInitVar("option_count", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("option_color", XOBJ_DTYPE_OTHER, FALSE, FALSE, FALSE, "");
		$this->initCommonVar("weight");
		
		$this->setControl("poll_id", array("name" => "select", "itemHandler" => "polls", "method" => "getList", "module" => "icmspoll"));
		$this->setControl("option_color", array("name" => "select", "itemHandler" => "options", "method" => "getOptionColors", "module" => "icmspoll"));
		
		$this->hideFieldFromForm("option_count");
	}

}
