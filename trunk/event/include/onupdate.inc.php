<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /include/onupdate.inc.php
 *
 * install, update and uninstall informations
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

// this needs to be the latest db version
define('EVENT_DB_VERSION', 2);

function event_db_upgrade_2() {
	$cal_handler = icms_getModuleHandler("calendar", EVENT_DIRNAME, "event");
	$cals = $cal_handler->getObjects(NULL, TRUE, TRUE);
	foreach(array_keys($cals) as $key) {
		$cals[$key]->setVar("calendar_active", TRUE);
		$cals[$key]->_updating = TRUE;
		$cal_handler->insert($cals[$key]);
	}
}

function icms_module_update_event(&$module) {
	$module->messages = copyMain();
    return TRUE;
}

function icms_module_install_event(&$module) {
	$module->messages = copyMain();
	if(icms_get_module_status("index")) $module->messages .= createIndexpage($module);
	return TRUE;
}
function icms_module_uninstall_event(&$module) {
	$module->messages = deleteLinkedModuleItems($module);
	$module->messages .= deleteFiles();
	return TRUE;
}

/**
 * additional functions for updating/install/uninstall
 */
function copyMain() {
	$ret = array();
	$path = ICMS_ROOT_PATH.'/modules/'.EVENT_DIRNAME.'/extras/front';
	$file = '/'.EVENT_DIRNAME.'.php';
	$dest = ICMS_ROOT_PATH;
	if(is_file($dest.$file)) {
		if(icms_core_Filesystem::deleteFile($dest.$file)) {
			$ret[] = "&nbsp;&nbsp;-- Old main file successfully removed!";
		}
	} else {
		$ret[] = 'No old main file found'.'&hellip;';
	}
	if(!is_file($dest.$file)) {
		if(icms_core_Filesystem::copyStream($path.$file, $dest.$file)) {
			$ret[] = "&nbsp;&nbsp;-- Main file successfully copied!";
		} else {
			$ret[] = '<span style="color:red; font-weight: bold; font-size: 1.2em;"> Main page has not been copied to Root Path!Please copy files from '.ICMS_MODULES_PATH.'/'.EVENT_DIRNAME.'/extras/front/ to your Root'.'</span>';
		}
	}
	return implode("</br />", $ret).'<br />';
}

function createIndexpage(&$module) {
	global $icmsConfig;
	if(icms_get_module_status("index")) {
		$ret = array();
		$version = number_format($module->getVar('version')/100, 2);
		$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
		$module_id = $module->getVar('mid');
		$indexModule = icms_getModuleInfo("index");
		$indexpage_handler = icms_getModuleHandler('indexpage', $indexModule->getVar("dirname"), 'index');
		/*
		$path = ICMS_ROOT_PATH . '/uploads/'.$indexModule->getVar("dirname").'/indexpage/';
		$image = 'tutorials_indeximage.png';
		if(!is_file($path . $image)) {
			if(icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . EVENT_DIRNAME . '/images/' . $image, $path . $image)) {
				$ret[] = "&nbsp;&nbsp;-- <b> Indeximage </b> successfully copied!";
			} else {
				$ret[] = "&nbsp;&nbsp;-- <span style='color: red;'><b><i><u> Indeximage has not been copied to Index Upload Path!</u></i></b></span>";
			}
		}
		 *
		 */
		$indexpageObj = $indexpage_handler->create(TRUE);
		$indexpageObj->setVar('title', 'Events' );
		$indexpageObj->setVar('body', 'Willkommen in unserem Kalender. ' );
		$indexpageObj->setVar('footer', '&copy; ' . date("Y") . ' '.$icmsConfig['sitename'].' - '.$icmsConfig['slogan'].' Powered By: Event '.$version);
		$indexpageObj->setVar('image', '');
		$indexpageObj->setVar('mid', $module_id);
		$indexpageObj->setVar('language', "all");
		$indexpage_handler->insert( $indexpageObj);
		$ret [] = '&nbsp;&nbsp;-- <b> Indexpage </b> successfully added!';
		unset($indexModule, $indexpage_handler, $indexpageObj);
		return '<code>'.implode("<br />", $ret).'<br /></code>';
	} else {
		return TRUE;
	}
}

function deleteLinkedModuleItems(&$module) {
	if(icms_get_module_status("index")) {
		$ret = array();
		$module_id = $module->getVar('mid');
		$indexModule = icms_getModuleInfo("index");
		$link_handler = icms_getModuleHandler("link",$indexModule->getVar("dirname"), "index");
		$link_handler->deleteAllByMId($module_id);
		$ret[] = 'Alle Label-Links wurden erfolgreich gelöscht!';
		unset($link_handler);
		$indexpage_handler = icms_getModuleHandler("indexpage",$indexModule->getVar("dirname"), "index");
		$indexpage_handler->deleteByMid($module_id);
		$ret[] = 'Event Indexseite wurde erfolgreich entfernt';
		unset($indexpage_handler);
		return implode("<br />", $ret).'<br />';
	}
}

function copySitemapPlugin() {
	if(!icms_get_module_status("index")) {
		$dir = ICMS_ROOT_PATH . '/modules/event/include/';
		$file = 'event.php';
		$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
		if(is_dir($plugin_folder)) {
			icms_core_Filesystem::copyRecursive($dir . $file, $plugin_folder . $file);
		}
	}
}

function deleteFiles() {
	$ret = array();
	if(is_file(ICMS_ROOT_PATH.'/'.EVENT_DIRNAME.'.php')) {
		if(icms_core_Filesystem::deleteFile(ICMS_ROOT_PATH.'/'.EVENT_DIRNAME.'.php')) {
			$ret[] = "Main File has been removed successfully";
		} else {
			$ret[] = '<span style:"color:red; font-weight: bold; font-size: 2em;">Sorry, module main file has NOT been removed! You\'ll need to remove yourself. '.ICMS_ROOT_PATH.'/'.EVENT_DIRNAME.'.php</span>';
		}
	} else {
		$ret[] = "Event Main File not found to delete file"."&hellip;";
	}
	return implode("<br />", $ret).'<br />';
}