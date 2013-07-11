<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /class/Backup.php
 *
 * class for DB-Backup
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
class mod_tools_Backup {

	private static $db = NULL;
	private static $force = FALSE;
	private static $log = array();
	private static $logpath = NULL;
	private static $logfile = NULL;
	private static $backuppath = NULL;
	private static $backupfile = NULL;
	private static $toolsConfig = NULL;
	private static $zipFile = NULL;

	private function __construct() {}

	/** instance of mod_tools_Tools */
	static public function &instance() {
		static $instance;
		if (!isset( $instance )) {
			$instance = new mod_tools_Backup();
			self::$db = icms::$xoopsDB;
			self::$logpath = ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/logs';
			self::$logfile = self::$logpath.'/log_backup.php';
			self::$backuppath = ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/backup';
			self::$backupfile = self::$backuppath.'/backup_db.sql';
			self::checkPaths();
		}
		return $instance;
	}

	public static function runBackup($file = NULL) {
		return self::_runBackup($file);
	}

	public static function runFullBackup($file = NULL) {
		return self::_runFullBackup($file);
	}

	/**
	 * private methods
	 */

	/** check, if the log path and file are available and create if not */
	private static function checkPaths() {
		if(!is_dir (self::$logpath)) mkdir(self::$logpath, 0777);
		if(!is_dir (self::$backuppath)) mkdir(self::$backuppath, 0777);
		if(!is_file(self::$logfile)) file_put_contents(self::$logfile, "<?\n/**\n#\n# Tools Backup Log file\n#\n*/\n\n");
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

	private static function getTableStructure($tableName) {
		$sqli = 'DESCRIBE '.$tableName;
		$result = self::$db->queryF($sqli);
		$sql = "CREATE TABLE IF NOT EXISTS `$tableName` (\n";
		$prim = "";
		while($myrow = self::$db->fetchArray($result)) {
			$sql .= "\t`".$myrow['Field']."` ". $myrow['Type'];
			$sql .= ($myrow['Null'] == "NO") ? " NOT NULL" : "";
			$sql .= ($myrow['Default'] != "" && $myrow['Default'] != "NULL") ? " DEFAULT '".$myrow['Default']."'" : "";
			$sql .= (preg_match('/AUTO_INCREMENT/i', $myrow['Extra'])) ? " auto_increment" : "";
			$sql .= ",\n";
			if($myrow['Key'] == "PRI") $prim .= "\tPRIMARY KEY (`".$myrow['Field']."`)\n";
		}
		$sql .= $prim;
		$sql .= ");\n\n";
		unset($result, $myrow);
		return $sql;
	}


	private static function setDefaultSQLHeader() {
		global $icmsModule;
		if(!is_object($icmsModule) || $icmsModule->getVar("dirname") != TOOLS_DIRNAME) $icmsModule = icms::handler('icms_module')->getByDirname(TOOLS_DIRNAME);
		$version = number_format($icmsModule->getVar('version')/100, 2);
		$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
		$headers = array("# Tools MySql-Dump File", "# Generator: Tools ".$version." (by QM-B[at]hotmail[dot]de)", "# https://code.google.com/p/amaryllis-modules/ (download page)","#", "# -------------------------------------------------------",
						"# Generation time: ".date("M d, Y ".strtolower("\a\T")." H:i:s \G\M\T P"), "# Host: ".XOOPS_DB_HOST, "# Database: ".XOOPS_DB_NAME,
						"# PHP-Version: ".phpversion(), "# Website: ".ICMS_URL
						);
		return implode("\n", $headers);
	}

	private static function setDefaultSQLFooter() {
		global $icmsModule;
		$version = number_format($icmsModule->getVar('version')/100, 2);
		$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
		$footers = array("#", "# E N D Tools MySql-Dump File", "# Generator: Tools ".$version, "# https://code.google.com/p/amaryllis-modules/ (download page)","#", "# -------------------------------------------------------",
						"# Generation time: ".date("M d, Y ".strtolower("\a\T")." H:i:s \G\M\T P"), "# Host: ".XOOPS_DB_HOST, "# Database: ".XOOPS_DB_NAME,
						"# PHP-Version: ".phpversion(), "# Website: ".ICMS_URL
						);
		return implode("\n", $footers);
	}

	private static function _runBackup($backupFile = NULL){
		if(is_null($backupFile)) $backupFile = self::$backupfile;
		if(is_file($backupFile)) unlink($backupFile);
		$tables = array(); $db_name = XOOPS_DB_NAME;
		$prefix = self::$db->prefix();
		$sql = "SHOW TABLES LIKE '".$prefix."_%' ";
		$result = self::$db->queryF($sql);
		if(!$result) {
			self::addLog('Could not retrieve tables: ' . self::$db->error());
		} else {
			while ($myrow = self::$db->fetchArray($result)) {
				$value = array_values($myrow);
				$tables[] = $value[0];
			}
		}
		$starttime = microtime(true);
		$headers = self::setDefaultSQLHeader();
		$footers = self::setDefaultSQLFooter();
		$outputdata = $lines = '';
		for($t=0; $t < count($tables); $t++){
			$outputdata .= "# ------------------------------------------------------\n\n";
			$outputdata .= "#\n# Table structure for table : `$tables[$t]` \n\n";
			$outputdata .= self::getTableStructure($tables[$t]);
			$outputdata .= "# ------------------------------------------------------\n\n";
			$outputdata .= "\n\n#\n# Dumping data for table : `$tables[$t]`\n#\n\n";
			$sql = "SELECT * FROM $tables[$t]";
			$result = self::$db->queryF($sql);
			while($row = self::$db->fetchArray($result)){
				$nor = count($row);
				$datas = array();
				foreach($row as $r){
					$datas[] = $r;
				}
				$lines .= "INSERT INTO $tables[$t] VALUES (";
				for($i=0;$i<$nor;$i++){
					if($datas[$i]===NULL) {
						$lines .= "NULL";
					} else if((string)$datas[$i] == "0"){
						$lines .= "0";
					} else if(filter_var($datas[$i],FILTER_VALIDATE_INT) || filter_var($datas[$i],FILTER_VALIDATE_FLOAT)){
						$lines .= $datas[$i];
					} else{
						$lines .=  self::$db->quote($datas[$i]);
					}
					if($i==$nor-1){
						$lines .= ");\n";
					} else{
						$lines .= ",";
					}
				}
				$outputdata .= $lines;
				$lines = "";
			}
		}
		$outputdata .= "# ------------------------------------------------------\n";
		$headers .= "\n# Dumping finished at : ". date("Y-m-d-h-i-s") .  "\n\n";
		$endtime = microtime(true);
		$diff = $endtime - $starttime;
		$headers .= "# Dumping data of $db_name took : ". $diff .  " Sec\n\n";
		$headers .= "# ---------------------------------------------------------\n";
		$datadump = $headers.$outputdata.$footers;
		$len = file_put_contents($backupFile, $datadump, LOCK_EX);
		if($len === FALSE) self::addLog("Error on writing dump file");
		self::_packBackup($backupFile);
		self::updateConfig();
	}

	private static function _runFullBackup($file) {
		self::_runBackup($file);
		if(($zip = mod_tools_Zip::instance()) !== FALSE) {
			mod_tools_Zip::openZip(NULL, TRUE);
			mod_tools_Zip::compress(ICMS_TRUST_PATH.'/', TRUE);
			mod_tools_Zip::compress(ICMS_UPLOAD_PATH.'/', TRUE);
			mod_tools_Zip::compress(self::$backupfile);
			self::$zipFile = mod_tools_Zip::closeZip();
			self::_moveToFtp(TRUE);
		}
		self::writeLog();
	}

	private static function _moveToFtp($rmv = FALSE) {
		self::_loadConfig();
		if(self::$toolsConfig['enable_ftp'] == 1 && self::$toolsConfig['ftp_pass'] !== "") {
			self::addLog("FTP triggered");
			if(mod_tools_Ftp::instance()) {
				self::addLog("FTP instance successfully");
				mod_tools_Ftp::ftpLogin(self::$toolsConfig['ftp_url'], self::$toolsConfig['ftp_user'], self::$toolsConfig['ftp_pass'], self::$toolsConfig['ftp_path']);
				mod_tools_Ftp::getPassive(TRUE);
				mod_tools_Ftp::ftpMkdir("tools_backup_".date('Y-m-d--H:i:s'), TRUE);
				if(mod_tools_Ftp::moveFile(self::$zipFile) !== FALSE && $rmv !== FALSE) @unlink(self::$zipFile);
				mod_tools_Ftp::disconnect();
				self::$zipFile = FALSE;
			}
		}
		self::$toolsConfig = FALSE;
	}

	private static function _loadConfig() {
		self::$toolsConfig = icms_getModuleConfig(TOOLS_DIRNAME);
	}

	private static function updateConfig() {
		$config_handler = icms::handler('icms_config_Item');
		$module = icms::handler('icms_module')->getByDirname(TOOLS_DIRNAME);
		$mid = $module->getVar("mid");
		unset($module);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("conf_modid", $mid));
		$criteria->add(new icms_db_criteria_Item("conf_name", "last_backup"));
		$prefix = self::$db->prefix("config");
		$time = time();
		$sql = "UPDATE $prefix SET conf_value='$time' ".$criteria->renderWhere();
		self::$db->queryF($sql);
		unset($criteria);
	}

	private static function _packBackup($file) {
		$zip = new ZipArchive();
		$path = self::$backuppath;
		if(is_file($path.'/db_backup.zip')) unlink($path.'/db_backup.zip');
		$archive = $zip->open($path.'/db_backup.zip', ZipArchive::CREATE);
		if($archive === TRUE) {
			if(is_file($file)) {
				$zip->addFile($file, "backup_db.sql");
			} else {
				self::addLog(sprintf(_AM_TOOLS_BACKUP_FILE_NOT_FOUND, $file));
			}
			$zip->close();
		} else {
			$time = date("Y-m-d H:i:s");
			self::addLog("Message: Zip could not be opened! ERROR-CODE: $archive \n File: $file\nPath: $path\nTime: $time\n");
		}
	}
}
