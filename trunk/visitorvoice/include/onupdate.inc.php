<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 * 
 * Install and update informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('VISITORVOICE_DB_VERSION', 2);
if(!defined("VISITORVOICE_DIRNAME")) define("VISITORVOICE_DIRNAME", basename(dirname(dirname(__FILE__))));

function visitorvoice_upload_paths() {
	$path = ICMS_ROOT_PATH . '/uploads/' . VISITORVOICE_DIRNAME;
	if(!is_dir($path . '/indexpage')) mkdir($path . '/indexpage', 0777, TRUE);
	$image = 'visitorvoice_indeximage.png';
	icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . VISITORVOICE_DIRNAME . '/images/' . $image, $path . '/indexpage/' . $image);
	return TRUE;
}

function visitorvoice_db_upgrade_2() {
	$visitorvoice_handler = icms_getModuleHandler("visitorvoice", VISITORVOICE_DIRNAME, "visitorvoice");
	$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("visitorvoice_pid", 0));
	$entries = $visitorvoice_handler->getObjects($criteria, TRUE, TRUE);
	foreach (array_keys($entries) as $key) {
		$crit = new icms_db_criteria_Item("visitorvoice_pid", $key);
		if($visitorvoice_handler->getCount($crit)) {
			$entries[$key]->setVar("visitorvoice_hassub", TRUE);
			$entries[$key]->_updating = TRUE;
			$visitorvoice_handler->insert($entries[$key]);
		}
		unset($crit);
	}
	return TRUE;
}

function visitorvoice_indexpage() {
	$visitorvoice_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'visitorvoice' );
	$indexpageObj = $visitorvoice_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'My Visitorvoice');
	$indexpageObj->setVar('index_heading', 'Welcome to our Visitorvoice!');
	$indexpageObj->setVar('index_footer', '&copy; 2012 | Visitorvoice module footer');
	$indexpageObj->setVar('index_image', 'visitorvoice_indeximage.png');
	$visitorvoice_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b>Visitorvoice Indexpage </b> successfully imported!<br />';
	echo '</code>';
}

function icms_module_update_visitorvoice($module) {
	$path = ICMS_ROOT_PATH.'/modules/'.VISITORVOICE_DIRNAME.'/images/';
	if(file_exists($path.'visitorvoice.png')) icms_core_Filesystem::deleteFile($path.'visitorvoice.png');
	if(file_exists($path.'visitorvoice_icon_small.png')) icms_core_Filesystem::deleteFile($path.'visitorvoice_icon_small.png');
    return TRUE;
}

function icms_module_install_visitorvoice($module) {
	visitorvoice_upload_paths();
	visitorvoice_indexpage();
	return TRUE;
}