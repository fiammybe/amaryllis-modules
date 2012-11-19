<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /include/onupdate.inc.php
 * 
 * Install and update informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */


defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('GUESTBOOK_DB_VERSION', 2);
if(!defined("GUESTBOOK_DIRNAME")) define("GUESTBOOK_DIRNAME", basename(dirname(dirname(__FILE__))));

function guestbook_upload_paths() {
	$path = ICMS_ROOT_PATH . '/uploads/' . GUESTBOOK_DIRNAME;
	if(!is_dir($path . '/indexpage')) mkdir($path . '/indexpage', 0777, TRUE);
	$image = 'guestbook_indeximage.png';
	icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . GUESTBOOK_DIRNAME . '/images/' . $image, $path . '/indexpage/' . $image);
	return TRUE;
}

function guestbook_db_upgrade_2() {
	$guestbook_handler = icms_getModuleHandler("guestbook", GUESTBOOK_DIRNAME, "guestbook");
	$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("guestbook_pid", 0));
	$entries = $guestbook_handler->getObjects($criteria, TRUE, TRUE);
	foreach (array_keys($entries) as $key) {
		$crit = new icms_db_criteria_Item("guestbook_pid", $key);
		if($guestbook_handler->getCount($crit)) {
			$entries[$key]->setVar("guestbook_hassub", TRUE);
			$entries[$key]->_updating = TRUE;
			$guestbook_handler->insert($entries[$key]);
		}
		unset($crit);
	}
	return TRUE;
}

function guestbook_indexpage() {
	$guestbook_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'guestbook' );
	$indexpageObj = $guestbook_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'My Guestbook');
	$indexpageObj->setVar('index_heading', 'Welcome to our Guestbook!');
	$indexpageObj->setVar('index_footer', '&copy; 2012 | Guestbook module footer');
	$indexpageObj->setVar('index_image', 'guestbook_indeximage.png');
	$guestbook_indexpage_handler -> insert( $indexpageObj, TRUE );
	echo '&nbsp;&nbsp;-- <b>Guestbook Indexpage </b> successfully imported!<br />';
	echo '</code>';
}

function icms_module_update_guestbook($module) {
	$path = ICMS_ROOT_PATH.'/modules/'.GUESTBOOK_DIRNAME.'/images/';
	if(file_exists($path.'guestbook.png')) icms_core_Filesystem::deleteFile($path.'guestbook.png');
	if(file_exists($path.'guestbook_icon_small.png')) icms_core_Filesystem::deleteFile($path.'guestbook_icon_small.png');
    return TRUE;
}

function icms_module_install_guestbook($module) {
	guestbook_upload_paths();
	guestbook_indexpage();
	return TRUE;
}