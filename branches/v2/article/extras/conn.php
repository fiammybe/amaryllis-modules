<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /include/connect.inc.php
 * 
 * Common File of the module included on all pages of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */


define('ARTICLE_CHECK_PATH', 0);
// Protect against external scripts execution if safe mode is not enabled
if (ARTICLE_CHECK_PATH && !@ini_get('safe_mode')) {
	if (function_exists('debug_backtrace')) {
		$articleScriptPath = debug_backtrace();
		if (!count($articleScriptPath)) {
		 	die("ImpressCMS path check: this file cannot be requested directly");
		}
		$articleScriptPath = $articleScriptPath[0]['file'];
	} else {
		$articleScriptPath = isset($_SERVER['PATH_TRANSLATED']) ? $_SERVER['PATH_TRANSLATED'] :  $_SERVER['SCRIPT_FILENAME'];
	}
	if (DIRECTORY_SEPARATOR != '/') {
		// IIS6 may double the \ chars
		$articleScriptPath = str_replace( strpos( $articleScriptPath, '\\\\', 2 ) ? '\\\\' : DIRECTORY_SEPARATOR, '/', $articleScriptPath);
	}
	if (strcasecmp( substr($articleScriptPath, 0, strlen(ICMS_ROOT_PATH)), str_replace( DIRECTORY_SEPARATOR, '/', ICMS_ROOT_PATH))) {
	 	exit("ImpressCMS path check: Script is not inside XOOPS_ROOT_PATH and cannot run.");
	}
}