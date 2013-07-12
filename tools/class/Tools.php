<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /class/Tools.php
 *
 * class for DB-Tools
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

defined("ICMS_ROOT_PATH") or die("Access Denied");
defined("TOOLS_DIRNAME") or define("TOOLS_DIRNAME", basename(dirname(dirname(__FILE__))));

/**
 *
 */
class mod_tools_Tools {

	private static $db = NULL;
	private static $force = FALSE;
	private static $log = array();
	private static $logpath = NULL;
	private static $logfile = NULL;

	private function __construct() {}

	/** instance of mod_tools_Tools */
	static public function &instance() {
		static $instance;
		if (!isset( $instance )) {
			$instance = new mod_tools_Tools();
			self::$db = icms::$xoopsDB;
			self::$logpath = ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/logs';
			self::$logfile = self::$logpath.'/log_tool.php';
			self::checkPaths();
		}
		return $instance;
	}

	/**
	 * public methods
	 */
	static public function maintainDB() {
		self::_maintainDB();
		self::writeLog();
		self::cleanLog();
	}

	static public function clearSessions() {
		self::_clearSessions();
		self::writeLog();
		self::cleanLog();
	}

	static public function clearCache() {
		self::_clearCache();
		self::writeLog();
		self::cleanLog();
	}

	static public function clearTemplates() {
		self::_clearTemplates();
		self::writeLog();
		self::cleanLog();
	}

	static public function runTools() {
		self::cleanLog();
		self::_maintainDB();
		self::_clearCache();
		self::_clearTemplates();
		self::_clearSessions();
		self::cleanLog();
	}

	static public function showTables() {
		$tables = array();
		$prefix = self::$db->prefix();
		$sql = "SHOW TABLES LIKE '".$prefix."_%' ";
		$result = self::$db->queryF($sql);
		while ($myrow = self::$db->fetchArray($result)) {
			$value = array_values($myrow);
			$tables[] = $value[0];
		}
		$lst_tbl = join(',', $tables);
		return $lst_tbl;
	}

	/**
	 * private methods
	 */

	/** check, if the log path and file are available and create if not */
	private static function checkPaths() {
		if(!is_dir (self::$logpath)) mkdir(self::$logpath, 0777);
		if(!is_file(self::$logfile)) file_put_contents(self::$logfile, "<?\n/**\n#\n# Tools Tool Log file\n#\n*/\n\n");
	}

	/** adding new log messages */
	private static function addLog($msg) {
		self::$log[] = '"'.formatTimestamp(time()).' - '.$msg.'"';
	}

	/** clean log buffer */
	private static function cleanLog() {
		self::$log = array();
	}

	/** write log file */
	private static function writeLog() {
		file_put_contents(self::$logfile, join("\n",self::$log)."\n", FILE_APPEND | LOCK_EX);
	}

	/** fetch log result and add to log */
	private static function fetchLogResult(&$result) {
		while ($myrow = self::$db->fetchArray($result)) {
			self::addLog($myrow['Table'].' - '.$myrow['Op'].' - '.$myrow['Msg_type'].' - '.$myrow['Msg_text']);
		}
	}

	/** Database Maintenance */
	private static function _maintainDB() {
		global $icmsConfig;
		$tables = array();
		$prefix = self::$db->prefix();
		$sql = "SHOW TABLES LIKE '".$prefix."_%' ";
		$result = self::$db->queryF($sql);
		while ($myrow = self::$db->fetchArray($result)) {
			$value = array_values($myrow);
			$tables[] = $value[0];
		}
		$lst_tbl = join(',', $tables);
		$result = self::$db->queryF('CHECK TABLE '.$lst_tbl);
		self::addLog('** '._AM_TOOLS_MAINTAIN_DB.' **');
		self::fetchLogResult($result);
		/** Repair DB */
		$result = self::$db->queryF('REPAIR TABLE '.$lst_tbl);
		self::fetchLogResult($result);
		/** Analyze DB */
		$result = self::$db->queryF('ANALYZE TABLE '.$lst_tbl);
		self::fetchLogResult($result);
		// Optimize
		$result = self::$db->queryF('OPTIMIZE TABLE '.$lst_tbl);
		self::fetchLogResult($result);
		self::_updateConfig();
	}

	private static function _clearSessions() {
		self::addLog('** '._AM_TOOLS_CLEAR_SESSION.' **');
		$result = self::$db->queryF('TRUNCATE TABLE '.self::$db->prefix('session'));
		self::fetchLogResult($result);
	}

	private static function _updateConfig() {
		$config_handler = icms::handler('icms_config_Item');
		$module = icms::handler('icms_module')->getByDirname(TOOLS_DIRNAME);
		$mid = $module->getVar("mid");
		unset($module);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("conf_modid", $mid));
		$criteria->add(new icms_db_criteria_Item("conf_name", "last_mc"));
		$prefix = self::$db->prefix("config");
		$time = time();
		$sql = "UPDATE $prefix SET conf_value='$time' ".$criteria->renderWhere();
		self::$db->queryF($sql);
		unset($criteria);
	}

	private static function _clearTemplates() {
		self::addLog('** '._AM_TOOLS_CLEAR_TEMPLATES.' **');
		if(icms_core_Filesystem::deleteRecursive(ICMS_ROOT_PATH.'/templates_c', FALSE)) {
			icms_core_Filesystem::writeIndexFile(ICMS_ROOT_PATH.'/templates_c/');
			self::addLog(_AM_TOOLS_CLEAR_TEMPLATES_SUCCESS);
		} else {
			self::addLog(_AM_TOOLS_CLEAR_TEMPLATES_FAIL);
		}
	}

	private static function _clearCache() {
		self::addLog('** '._AM_TOOLS_CLEAR_CACHE.' **');
		if(icms_core_Filesystem::deleteRecursive(ICMS_ROOT_PATH.'/cache/', FALSE) !== FALSE) {
			self::addLog('-- '._AM_TOOLS_CLEAR_CACHE_SUCCESS);
			icms_core_Filesystem::writeIndexFile(ICMS_ROOT_PATH.'/cache/');
		} else {
			self::addLog('-- '._AM_TOOLS_CLEAR_CACHE_FAIL);
		}
	}
}
