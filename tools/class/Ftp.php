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

class mod_tools_Ftp {

	private static $con_id = FALSE;
	private static $log = array();
	private static $logpath = NULL;
	private static $logfile = NULL;
	private static $debug = FALSE;

	private function __construct(){ }

	public static function &instance($debug = FALSE) {
		static $instance;
		if(!isset( $instance )) {
			$instance = new mod_tools_Ftp();
			self::$debug = $debug;
			self::$logpath = ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/logs';
			self::$logfile = self::$logpath.'/log_ftp.php';
			self::checkPaths();
			self::addLog("FTP Successfully initiated");
		}
		if(self::$debug) icms_core_Debug::vardump($instance);
		return $instance;
	}

	public static function ftpLogin($url, $uname, $password, $dir = FALSE) {
		if(self::$debug) icms_core_Debug::message("FTP-Login triggered");
		return self::_ftpLogin($url, $uname, $password, $dir);
	}

	public static function ftpMkdir($dir, $chDir = FALSE) {
		return self::_ftpMkdir($dir, $chDir);
	}

	public static function moveFile($file) {
		return self::_moveFile($file);
	}

	public static function disconnect() {
		return self::_disconnect();
	}

	public static function changeDir($dir) {
		return self::_changeDir($dir);
	}

	public static function getLog() {
		return self::$log;
	}

	public static function getPassive($pasv = TRUE) {
		ftp_pasv(self::$con_id, $pasv);
	}


	/**
	 * private methods
	 */

	/** check, if the log path and file are available and create if not */
	private static function checkPaths() {
		if(!is_dir (self::$logpath)) mkdir(self::$logpath, 0777);
		if(!is_file(self::$logfile)) file_put_contents(self::$logfile, "<?\n/**\n#\n# Tools FTP Log file\n#\n*/\n\n");
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
		file_put_contents(self::$logfile, implode("\n",self::$log)."\n", FILE_APPEND | LOCK_EX);
	}

	private static function _ftpLogin($url, $uname, $password, $dir) {
		self::$con_id = ftp_connect($url);
		if(self::$con_id === FALSE) {
			self::addLog("Connection failed");
			if(self::$debug) icms_core_Debug::message("Connection failed");
		}
		if(ftp_login(self::$con_id, $uname, $password) === FALSE) {
			self::addLog("Login Failed");
			if(self::$debug) icms_core_Debug::message("Login failed");
		} else {
			self::addLog("Connection successfully established");
			if(self::$debug) icms_core_Debug::message("Connection successfully established");
		}
		if($dir != FALSE) {
			self::_changeDir($dir);
		}
	}

	private static function _ftpMkdir($dir, $chDir) {
		if(ftp_mkdir(self::$con_id, $dir) === FALSE) {self::addLog("Directory $dir couldn't be created"); return FALSE;}
		else {
			self::addLog("Directory $dir successfully created");
			$mode = "0777";
			$mode = octdec( str_pad($mode,4,'0',STR_PAD_LEFT) );
			ftp_chmod(self::$con_id, $mode, $dir);
		}
		if($chDir) {
			if(self::$debug) icms_core_Debug::message("Triggered changing dir");
			self::_changeDir($dir);
		}
	}

	private static function _changeDir($dir) {
		if(ftp_chdir(self::$con_id, $dir) === FALSE) {
			self::addLog("Couldn't change to new directory");
			if(self::$debug) icms_core_Debug::message("Couldn't change to new directory");
			return FALSE;
		}
	}

	private static function _moveFile($file) {
		if(self::$debug) icms_core_Debug::message("Triggered moving File");
		$path = strlen(dirname($file).'/');
		$remote_file = substr($file, $path);
		$put = ftp_put(self::$con_id, $remote_file, $file, FTP_BINARY);
		if($put === TRUE) {
			return TRUE;
		} else {
			self::addLog("Datei $file konnte nicht übertragen werden!");
			if(self::$debug) icms_core_Debug::message("Datei $file konnte nicht übertragen werden!");
			return FALSE;
		}
	}

	private static function _disconnect() {
		ftp_close(self::$con_id);
		self::$con_id = FALSE;
		if(!empty(self::$log)) self::writeLog();self::cleanLog();
	}
}