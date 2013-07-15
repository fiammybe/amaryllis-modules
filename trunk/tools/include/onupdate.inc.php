<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /include/onupdate.inc.php
 *
 * holds install/update/uninstall functions
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

defined('ICMS_ROOT_PATH') or die("Access Denied");

define('TOOLS_DB_VERSION', 1);

function icms_module_install_tools (&$module) {
	$module->messages = checkDirectories($module);
	return TRUE;
}

function icms_module_update_tools (&$module) {
	$module->messages = checkDirectories($module);
	return TRUE;
}

function icms_module_uninstall_tools (&$module) {
	$module->messages = deleteDirectories($module);
	return TRUE;
}

/**
 * additional functions to be called during install/update/uninstall
 */

function checkDirectories($module) {
	$ret = array();
	$path = ICMS_TRUST_PATH.'/modules/';
	$dir = $module->getVar("dirname");
	if(!is_dir($path.$dir)) {
		if(mkdir($path.$dir, 0755))
			$ret[] = 'TRUSTED DIRECTORY successfully created';
		else
			$ret[] = 'TRUSTED DIRECTORY has NOT been created';
	} else {
		$ret[] = 'TRUSTED DIRECTORY already found';
	}
	return implode("<br />", $ret);
}

function deleteDirectories($module) {
	$ret = array();
	$path = ICMS_TRUST_PATH.'/modules/';
	$dir = $module->getVar("dirname");
	if(is_dir($path.$dir)) {
		if(icms_core_Filesystem::deleteRecursive($path.$dir))
			$ret[] = 'TRUSTED DIRECTORY successfully deleted';
		else
			$ret[] = 'TRUSTED DIRECTORY has NOT been deleted';
	} else {
		$ret[] = 'TRUSTED DIRECTORY not found';
	}
	return implode("<br />", $ret);
}