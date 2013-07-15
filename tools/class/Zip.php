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

class mod_tools_Zip {

	private static $version = NULL;
	private static $log = array();
	private static $logpath = NULL;
	private static $logfile = NULL;
	private static $backuppath = NULL;
	private static $backupfile = NULL;
	private static $zip = NULL;
	private static $zipFile = NULL;
	private static $debug = FALSE;
	private static $clear_instance = FALSE;

	private function __construct() {}

	public static function &instance($dest = NULL, $file = NULL, $debug = FALSE) {
		static $instance = NULL;
		if(!isset( $instance )) {
			$instance = new mod_tools_Zip();
			if($debug) self::$debug = $debug;
			self::$logpath = ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/logs';
			self::$logfile = self::$logpath.'/log_pack.php';

			self::$backuppath = (is_null($dest)) ? ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/backup' : $dest;
			self::$backupfile = (is_null($file)) ? self::$backuppath.'/backup.zip' : self::$backuppath.'/'.$file;
			self::checkPaths();
			self::$zip = new ZipArchive();
			if(!is_object(icms::$module) || (is_object(icms::$module) && icms::$module->getVar("dirname") !== TOOLS_DIRNAME)) {
				$module = icms::handler('icms_module')->getByDirname(TOOLS_DIRNAME);
				$version = number_format($module->getVar('version')/100, 2);
				$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
				self::$version = "Zip File Generator: Tools".$version;
				unset($module);
			}
		}
		return $instance;
	}

	public static function openZip($file = NULL, $create = FALSE) {
		self::_openZip($file, $create);
	}

	public static function addFile($file) {
		if(!self::$zipFile) return FALSE;
		if(is_file($file) === TRUE) {
			$path = strlen(dirname($file).'/');
			self::$zip->addFile($file, substr($file, $path));
		} else {
			self::addLog(sprintf(_AM_TOOLS_ZIP_FAILED_ADD_FILE, $file));
		}
	}

	public static function addEmptyDir($dir) {
		if(!self::$zipFile) return FALSE;
		if(self::$zip->addEmptyDir($dir) === TRUE) {

		} else {
			self::addLog(sprintf(_AM_TOOLS_ZIP_FAILED_ADD_DIR, $dir));
		}
	}

	public static function getNameIndex($index) {
		return self::_getNameByIndex($index);
	}

	public static function statIndex($index) {
		return self::$zip->statIndex($index, ZIPARCHIVE::FL_UNCHANGED);
	}

	public static function statName($name) {
		return self::$zip->statName($name, ZIPARCHIVE::FL_UNCHANGED);
	}

	public static function closeZip() {
		self::$zip->close();
		if(!empty(self::$log)) {self::writeLog();self::cleanLog();}
		@chmod(self::$backupfile, 0777);
		return self::$backupfile;
	}

	public static function extractZip($dest = "", $files = array()) {
		if($dest == "") self::addLog("You need to give a Destination where to extrakt");
		if(!empty($files)) {
			if(self::$zip->extractTo($dest, $files) === FALSE) {
				$files = implode(", ", $files);
				self::addLog("Files $files couldn't be extracted to Destination.");
			}
		} else {
			if(self::$zip->extractTo($dest) === FALSE) {
				self::addLog("Zip File couldn't be extracted to Destination.");
			}
		}
	}

	public static function setArchiveComment($comment = NULL) {
		if(!isset($comment)) return FALSE;
		return self::_addArchiveComment($comment);
	}

	public static function compress($source, $include_dir = FALSE) {
		return self::_compress($source, $include_dir);
	}

	/**
	 * private methods
	 */

	/** check, if the log path and file are available and create if not */
	private static function checkPaths() {
		if(!is_dir (self::$logpath)) mkdir(self::$logpath, 0777);
		if(!is_dir (self::$backuppath)) mkdir(self::$backuppath, 0777);
		if(!is_file(self::$logfile)) file_put_contents(self::$logfile, "<?\n/**\n#\n# Tools Zip Log file\n#\n*/\n\n");
		if(is_file(self::$backupfile)) @unlink(self::$backupfile);
		self::cleanLog();
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

	private static function _openZip($file = NULL, $create = FALSE) {
		$file = (is_null($file)) ? self::$backupfile : $file;
		if($create && ($zipFile = self::$zip->open($file, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === TRUE)) {
			self::$zipFile = TRUE;
			self::_setArchiveComment(self::$version);
			if(self::$debug) icms_core_Debug::message("Zip created");
		} elseif(!$create && ($zipFile = self::$zip->open($file)) === TRUE) {
			self::$zipFile = TRUE;
			if(self::$debug) icms_core_Debug::message("Zip opened");
		} else {
			self::addLog(sprintf(_AM_TOOLS_ZIP_FAILED_OPEN, $zipFile));
			self::$zipFile = FALSE;
			if(self::$debug) icms_core_Debug::message(_AM_TOOLS_ZIP_FAILED_OPEN);
		}
	}

	private static function _getNameByIndex($index) {
		return self::$zip->getNameIndex((int)$index, ZIPARCHIVE::FL_UNCHANGED);
	}

	private static function _setArchiveComment($comment) {
		self::$zip->setArchiveComment($comment);
	}

	private static function _compress($source, $include_dir) {
		$zip = self::$zip;
		$source = str_replace('\\', '/', realpath($source));
		$exclude = array('.', '..');
		$exclude2 = array('tools', "backup", "log");
		if(is_dir($source) === true) {
			$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
			if ($include_dir) {
				$arr = explode("/",$source);
				$maindir = $arr[count($arr)- 1];
				$source = "";
				for ($i=0; $i < count($arr) - 1; $i++) {
					$source .= '/' . $arr[$i];
				}
				$source = substr($source, 1);
				$zip->addEmptyDir($maindir);
			}
			foreach ($files as $file) {
				$file = str_replace('\\', '/', $file);
				if(in_array(substr($file, strrpos($file, '/')+1), $exclude)) continue;
				$file = realpath($file);
				if(is_dir($file) === TRUE) {
					if(in_array(str_replace($source . '/', '', $file), $exclude2)) continue;
					self::addEmptyDir(str_replace($source . '/', '', $file . '/'));
				} else {
					$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
				}
			}
		} else {
			self::addFile($source);
		}
	}
}