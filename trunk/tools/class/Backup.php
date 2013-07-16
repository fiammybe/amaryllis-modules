<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /class/Backup.php
 *
 * class for DB-Backup
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
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
	private static $toolsConfig = array();
	private static $zipFile = NULL;
	private static $debug = FALSE;
	private static $case = FALSE;

	private function __construct() {}

	/** instance of mod_tools_Tools */
	static public function &instance($debug = FALSE) {
		static $instance;
		if (!isset( $instance )) {
			self::_reset();
			$instance = new mod_tools_Backup();
			self::$db = icms::$xoopsDB;
			self::$debug = $debug;
			self::$logpath = ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/logs';
			self::$logfile = self::$logpath.'/log_backup.php';
			self::$backuppath = ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/backup';
			self::$backupfile = self::$backuppath.'/backup_db.sql';
			self::_checkPaths();
			self::$log[] = 'Backup-File: '.self::$backupfile;
			self::$log[] = 'Log-File: '.self::$logfile;
		}
		return $instance;
	}

	public static function runBackup($file = NULL) {
		return self::_runBackup($file);
	}

	public static function runFullBackup($file = NULL) {
		if(self::$debug) icms_core_Debug::message(_AM_TOOLS_BACKUP_TRIGGERED);
		return self::_runFullBackup($file);
	}

	public static function setCase($case) {
		self::$case = $case;
	}

	/**
	 * private methods
	 */

	/** check, if the log path and file are available and create if not */
	private static function _checkPaths() {
		if(!is_dir (self::$logpath)) mkdir(self::$logpath, 0777);
		if(!is_dir (self::$backuppath)) mkdir(self::$backuppath, 0777);
		if(!is_file(self::$logfile)) file_put_contents(self::$logfile, "<?\n/**\n#\n# Tools Backup Log file\n#\n*/\n\n");
	}

	private static function _reset() {
		self::$backupfile = NULL;
		self::$backuppath = NULL;
		self::$case = NULL;
		self::$db = NULL;
		self::$debug = FALSE;
		self::$log = array();
		self::$logfile = NULL;
		self::$toolsConfig = array();
		self::$zipFile = NULL;
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
		if(($file = file_put_contents(self::$logfile, join("\n",self::$log)."\n", FILE_APPEND | LOCK_EX)) === FALSE)
		if(self::$debug) icms_core_Debug::vardump("Trying to write Log: ". $file);
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

	private static function _runBackup($backupFile = NULL, $pack = TRUE){
		if(self::$debug) icms_core_Debug::message(sprintf(_AM_TOOLS_BACKUP_STARTED, formatTimestamp(time())));
		if(is_null($backupFile)) $backupFile = self::$backupfile;
		if(is_file($backupFile)) @unlink($backupFile);
		$tables = array(); $db_name = XOOPS_DB_NAME;
		$prefix = self::$db->prefix();
		$sql = "SHOW TABLES LIKE '".$prefix."_%' ";
		$result = self::$db->queryF($sql);
		if(!$result) {
			self::addLog(_AM_TOOLS_BACKUP_NO_TABLES.': ' . self::$db->error());
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
		if(self::$debug) icms_core_Debug::message("Backup finished after ".$diff.' Sek.');
		$len = file_put_contents($backupFile, $datadump, LOCK_EX);
		if($len === FALSE) self::addLog("Error on writing dump file");
		if(self::$debug) icms_core_Debug::vardump(self::$log);
		if($pack) {
			self::_packBackup($backupFile);
			self::_sendAdminmail();
			self::writeLog();
		}
		self::updateConfig();
	}

	private static function _runFullBackup($file) {
		while(self::_runBackup($file, FALSE)) {}
		if(self::$debug) icms_core_Debug::message("DB Backup complete");
		try {
			if(self::$debug) icms_core_Debug::message("Trying to get zip instance");
			$toolsZip = mod_tools_Zip::instance(NULL, NULL, self::$debug);
			self::addLog("Zipping has been triggered!");
			$toolsZip::openZip(NULL, TRUE);
			while($toolsZip::compress(ICMS_TRUST_PATH.'/', TRUE)) {}
			while($toolsZip::compress(ICMS_UPLOAD_PATH.'/', TRUE)) {}
			while($toolsZip::compress(ICMS_ROOT_PATH.'/themes/', TRUE)) {}
			while($toolsZip::compress(self::$backupfile)){}
			self::$zipFile = $toolsZip::closeZip();
			if(self::$debug) icms_core_Debug::message("Zip-File: ".self::$zipFile);
			while($move = self::_moveToFtp(TRUE)) {}
		} catch (Exception $e) {
		    if(self::$debug) icms_core_Debug::vardump($e->getMessage());
		    self::addLog("Zipping has not been triggered!");
			foreach ($e->getMessage() as $k => $msg) {
				self::addLog($msg);
			}
		}
		self::_sendAdminmail(TRUE);
		self::writeLog();
	}

	private static function _moveToFtp($rmv = FALSE) {
		while(self::_loadConfig()) {}
		if(self::$debug) icms_core_Debug::vardump(self::$toolsConfig);
		if(self::$toolsConfig['enable_ftp'] == 1 && self::$toolsConfig['ftp_pass'] !== "") {
			self::addLog("FTP triggered");
			if($toolsFtp = mod_tools_Ftp::instance(self::$debug)) {
				self::addLog("FTP instance successfully");
				$toolsFtp::ftpLogin(trim(self::$toolsConfig['ftp_url']), trim(self::$toolsConfig['ftp_user']), trim(self::$toolsConfig['ftp_pass']), trim(self::$toolsConfig['ftp_path']));
				$toolsFtp::getPassive(TRUE);
				$toolsFtp::ftpMkdir("tools_backup_".date('Y-m-d--H:i:s'), TRUE);
				if(($up = $toolsFtp::moveFile(self::$zipFile))!==FALSE && $rmv !== FALSE) @unlink(self::$zipFile);
				$toolsFtp::disconnect();
				self::$zipFile = FALSE;
			}
		}
		self::$toolsConfig = FALSE;
	}

	private static function _loadConfig() {
		global $toolsModule;
		if(isset($toolsModule) && is_object($toolsModule)) {
			self::$toolsConfig = $toolsModule->config;
		} else {
			self::$toolsConfig = icms_getModuleConfig(TOOLS_DIRNAME);
		}
	}

	private static function _sendAdminmail($fullBackup = FALSE) {
		global $icmsConfigMailer, $icmsConfig;
		$mail_handler = new icms_messaging_Handler();
		if($icmsConfigMailer['from'] == "") {
			self::$log[] = _AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_FROM;
			if(self::$debug) icms_core_Debug::message(_AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_FROM);
			return FALSE;
		}
		if($icmsConfigMailer['fromname'] == "") {
			self::$log[] = _AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_FROM_NAME;
			if(self::$debug) icms_core_Debug::message(_AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_FROM_NAME);
			return FALSE;
		}
		if($icmsConfig['adminmail'] == "") {
			self::$log[] = _AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_ADMIN_MAIL;
			if(self::$debug) icms_core_Debug::message(_AM_TOOLS_BACKUP_MAIL_FAILED_CONFIG_ADMIN_MAIL);
			return FALSE;
		}
		$mail_handler->setFromEmail($icmsConfigMailer['from']);
		$mail_handler->setFromName($icmsConfigMailer['fromname']);
		$mail_handler->setToEmails($icmsConfig['adminmail']);
		$mail_handler->setSubject(icms_core_DataFilter::undoHtmlSpecialChars(_AM_TOOLS_BACKUP_MAIL_SUBJ));
		if($fullBackup) {
			$body = sprintf(_AM_TOOLS_BACKUP_FULL_TRIGGERED_ON, formatTimestamp(time()));
		} else {
			$body = sprintf(_AM_TOOLS_BACKUP_SIMPLE_TRIGGERED_ON, formatTimestamp(time()));
		}
		$body .= '<br />'.self::$case.'<br />';
		$body .= implode("<br />", self::$log);
		$mail_handler->useMail();
		$mail_handler->addHeaders("Content-type: text/html; charset=utf-8");
		$mail_handler->addHeaders("MIME-Version: 1.0");
		$mail_handler->setBody(icms_core_DataFilter::undoHtmlSpecialChars($body));
		$mail_handler->send(self::$debug);
		if(self::$debug && $mail_handler->getErrors()) {
			self::$log[] = "** Mailer Errors **\n". implode("\n", $mail_handler->getErrors(FALSE));
		}
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
		$toolsZip = mod_tools_Zip::instance(NULL, 'db_backup.zip', self::$debug);
		$archive = $toolsZip::openZip(NULL, TRUE);
		if(is_file($file)) {
			$toolsZip::compress($file);
		} else {
			self::addLog(sprintf(_AM_TOOLS_BACKUP_FILE_NOT_FOUND, $file));
		}
		self::$zipFile = $toolsZip::closeZip();
		if(self::$debug) icms_core_Debug::message("Zip-File: ".self::$zipFile);
		while($move = self::_moveToFtp(TRUE)) {}
	}
}
