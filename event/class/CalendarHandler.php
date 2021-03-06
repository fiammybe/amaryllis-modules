<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /class/CalendarHandler.php
 *
 * Classes responsible for managing event calendar objects
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

class mod_event_CalendarHandler extends icms_ipf_Handler {

	public $_moduleID;
	public $_moduleUseMain;

	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		global $eventConfig;
		parent::__construct($db, "calendar", "calendar_id", "calendar_name", "calendar_dsc", EVENT_DIRNAME);
		$eModule = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME);
		$this->_moduleID = $eModule->getVar("mid");
		unset($eModule);

		$this->_moduleUseMain = (($eventConfig['use_main'] == 1) || (isset($GLOBALS['MODULE_'.strtoupper(EVENT_DIRNAME).'_USE_MAIN']) &&
									$GLOBALS['MODULE_'.strtoupper(EVENT_DIRNAME).'_USE_MAIN'] === TRUE)) ? TRUE : FALSE;
		$this->_moduleUrl = ($this->_moduleUseMain) ? ICMS_URL.'/' : ICMS_MODULES_URL.'/'.EVENT_DIRNAME.'/';
		$this->_page = ($this->_moduleUseMain) ? EVENT_DIRNAME.'.php' : "index.php";
	}

	public function getCalendarBySeo($seo) {
		$criteria = new icms_db_criteria_Item("short_url", trim($seo));
		$cals = $this->getObjects($criteria, FALSE, TRUE);
		if(!$cals) return FALSE;
		return $cals[0];
	}

	public function filterActive() {
		return array(0 => 'Inactive', 1 => 'Active');
	}

	/**
	 * handling some functions to easily switch some fields
	 */
	public function changeField($calendar_id, $field) {
		$calObj = $this->get($calendar_id);
		if ($calObj->getVar("$field", 'e') == TRUE) {
			$calObj->setVar("$field", 0);
			$value = 0;
		} else {
			$calObj->setVar("$field", 1);
			$value = 1;
		}
		$calObj->_updating = TRUE;
		$this->insert($calObj, TRUE);
		return $value;
	}


	protected function beforeInsert(&$obj) {
		if($obj->_updating)
		return TRUE;
		$seo = trim($obj->getVar("short_url", "e"));
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle(trim($obj->title()), FALSE);
		$seo = urldecode($seo);
		$umlaute = array("ä","ö","ü","Ä","Ö","Ü","ß", "%C3%84", "%C3%96", "%C3%9C");
		$replace = array("ae","oe","ue","Ae","Oe","Ue","ss", "Ae", "Oe", "Ue");
		$seo = str_ireplace($umlaute, $replace, $seo);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
		}
		$obj->setVar("short_url", $seo);
		$dsc = $obj->getVar("calendar_dsc", "e");
		$dsc = icms_core_DataFilter::checkVar($dsc, "html", "input");
		$dsc = str_replace("'",'"', $dsc);
		$obj->setVar("calendar_dsc", $dsc);
		return TRUE;
	}
}