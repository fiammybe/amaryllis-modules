<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /include/onupdate.inc.php
 * 
 * install, update and uninstall informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
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
		$cal_handler->insert($cals[$key]);
	}
}

function icms_module_update_event(&$module) {
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater->moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_event(&$module) {
	event_indexpage();
	
	return TRUE;
}
function icms_module_uninstall_event(&$module) {
	if(icms_get_module_status("index")) {
		deleteLinkedModuleItems($module);
	}
	return TRUE;
}


function event_indexpage() {
	if(icms_get_module_status("index")) {
		$mid = icms::handler('icms_module')->getByDirname(EVENT_DIRNAME)->getVar('mid');
	
		$indexModule = icms_getModuleInfo("index");
		$indexpage_handler = icms_getModuleHandler( 'indexpage', $indexModule->getVar("dirname"), 'index' );
		/**
		$index_path = ICMS_UPLOAD_PATH . '/' . $indexModule->getVar("dirname") . '/' . $indexpage_handler->_itemname;
		$image = 'event_indeximage.png';
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . EVENT_DIRNAME . '/images/' . $image, $index_path . '/' . $image);
		*/
		$indexpageObj = $indexpage_handler->create(TRUE);
		$indexpageObj->setVar('index_header', 'Events' );
		$indexpageObj->setVar('index_heading', 'Watch our events' );
		$indexpageObj->setVar('index_footer', '&copy; 2012 | Event module footer');
		$indexpageObj->setVar('index_image', '');
		$indexpageObj->setVar('index_mid', $mid);
		$indexpage_handler -> insert($indexpageObj, TRUE);
		echo '<code>';
		echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully created!<br />';
		echo '&nbsp;&nbsp;-- <b> Indeximage </b> successfully moved!<br />';
		echo '</code>';
	}
}

function deleteLinkedModuleItems(&$module) {
	$module_id = $module->getVar('mid');
	$link_handler = icms_getModuleHandler("link", "index");
	$link_handler->deleteAllByMId($module_id);
	unset($link_handler);
	$indexpage_handler = icms_getModuleHandler("indexpage", "index");
	$indexpage_handler->deleteByMid($module_id);
	unset($indexpage_handler);
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