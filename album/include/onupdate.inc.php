<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /class/AlbumHandler.php
 *
 * File containing onupdate and oninstall functions of album module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// DEFINE SOME PATHS //////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));
define("_MOD_ALBUM_INSTALL_OPEN_SPAN", '<span style="color: red; font-size: 1.5em;">');
define("_MOD_ALBUM_INSTALL_CLOSE_SPAN", "</span>");

// this needs to be the latest db version
define('ALBUM_DB_VERSION',3);

icms_loadLanguageFile("album", "install");

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// UPDATE/ INSTALL/UNINSTALL ALBUM MODULE ///////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Version specific upgrade
 */
function album_db_upgrade_3() {
	global $module;
	$images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
	$message_handler = icms_getModuleHandler("message", ALBUM_DIRNAME, "album");
	$messages = $message_handler->getObjects(NULL, TRUE, TRUE);
	if(!$messages) return TRUE;
	foreach (array_keys($messages) as $k) {
		$image_id = $messages[$k]->getVar("message_item", "e");
		$image = $images_handler->get($image_id);
		if(is_object($image) && !$image->isNew()) {
			$album_id = $image->getVar("a_id", "e");
			$messages[$k]->setVar("message_album", $album_id);
			$messages[$k]->store(TRUE);
		}
		unset($messages[$k], $image);
	}
	unset($images_handler, $message_handler, $messages);
	return TRUE;
}

/**
 * triggered on module update
 */
function icms_module_update_album(&$module) {
    // check if upload directories exist and make them if not
	$module->messages = album_upload_paths();
	// copy main file to root
	$module->messages .= copyMain();
	// check, if indexpage exists or create
	$module->messages .= createIndexpage($module);
    return TRUE;
}

/**
 * triggered on module install
 */
function icms_module_install_album($module) {
	//copy main file to root
	$module->messages = copyMain();
	// check if upload directories exist and make them if not
	$module->messages .= album_upload_paths();
	//prepare indexpage
	$module->messages .= createIndexpage($module);
	return TRUE;
}

/**
 * triggered on module uninstall
 */
function icms_module_uninstall_album($module) {
	$module->messages = deleteFolders($module);
	$module->messages .= deleteFiles();
	$module->messages .= deleteLinkedModuleItems($module);
	return TRUE;
}

/**
 * additional functions
 */

function copyMain() {
	$ret = array();
	$path = ICMS_ROOT_PATH.'/modules/'.ALBUM_DIRNAME.'/extras/front';
	$file = '/'.ALBUM_DIRNAME.'.php';
	$dest = ICMS_ROOT_PATH;
	if(is_file($dest.$file)) {
		if(icms_core_Filesystem::deleteFile($dest.$file)) {
			$ret[] = _MOD_ALBUM_INSTALL_OLD_MAIN_REMOVED;
		}
	} else {
		$ret[] = _MOD_ALBUM_INSTALL_OLD_MAIN_NOT_FOUND;
	}
	if(!is_file($dest.$file)) {
		if(icms_core_Filesystem::copyStream($path.$file, $dest.$file)) {
			$ret[] = _MOD_ALBUM_INSTALL_MAIN_SUCCESS;
		} else {
			$ret[] = _MOD_ALBUM_INSTALL_OPEN_SPAN. sprintf(_MOD_ALBUM_INSTALL_MAIN_ERR, ICMS_MODULES_PATH.'/'.ALBUM_DIRNAME.'/extras/front/') ._MOD_ALBUM_INSTALL_CLOSE_SPAN;
		}
	}
	return implode("</br />", $ret).'<br />';
}

function album_upload_paths() {
	$ret = array();
	$path = ICMS_UPLOAD_PATH . '/'.ALBUM_DIRNAME;
	if(!is_dir($path.'/album')) mkdir($path.'/album', 0777, TRUE);
	$categoryimages = array();
	$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/modules/'.ALBUM_DIRNAME.'/images/folders/', '', array('gif', 'jpg', 'png'));
	foreach($categoryimages as $image) {
		if(!is_file($path.'/'.ALBUM_DIRNAME.'/'.$image)) {
			if(icms_core_Filesystem::copyStream(ICMS_ROOT_PATH.'/modules/'.ALBUM_DIRNAME.'/images/folders/'.$image, $path.'/'.ALBUM_DIRNAME.'/'.$image)) {
				$ret[] = sprintf(_MOD_ALBUM_INSTALL_CATIMG_COPIED, $image);
			} else {
				$ret[] = sprintf(_MOD_ALBUM_INSTALL_CATIMG_ERR, $image);
			}
		} else {
			$ret[] = sprintf(_MOD_ALBUM_INSTALL_CATIMG_EXISTS, $image);
		}
	}
	if(!is_dir($path . '/batch')) mkdir($path . '/batch', 0777, TRUE);
	return TRUE;
}

function deleteFolders(&$module) {
	$cache = ICMS_ROOT_PATH.'/cache/';
	if(is_dir($cache.$module->getVar("dirname"))) {
		icms_core_Filesystem::deleteRecursive($cache.$module->getVar("dirname"));
	}
	$uploads = ICMS_UPLOAD_PATH.'/';
	if(is_dir($uploads.$module->getVar("dirname"))) {
		icms_core_Filesystem::deleteRecursive($uploads.$module->getVar("dirname"));
	}
}

function deleteFiles() {
	$ret = array();
	if(is_file(ICMS_ROOT_PATH.'/'.ALBUM_DIRNAME.'.php')) {
		if(icms_core_Filesystem::deleteFile(ICMS_ROOT_PATH.'/'.ALBUM_DIRNAME.'.php')) {
			$ret[] = _MOD_ALBUM_INSTALL_DELETE_MAIN;
		} else {
			$ret[] = _MOD_ALBUM_INSTALL_OPEN_SPAN.sprintf(_MOD_ALBUM_INSTALL_DELETE_MAIN_ERR,ICMS_ROOT_PATH.'/'.ALBUM_DIRNAME.'.php')._MOD_ALBUM_INSTALL_CLOSE_SPAN;
		}
	} else {
		$ret[] = _MOD_ALBUM_INSTALL_OLD_MAIN_NOT_FOUND;
	}
	return implode("<br />", $ret).'<br />';
}

function createIndexpage(&$module) {
	global $icmsConfig;
	$version = number_format($module->getVar('version')/100, 2);
	$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;
	if(icms_get_module_status("index")) {
		$ret = array();
		$module_id = $module->getVar('mid');
		$indexModule = icms_getModuleInfo("index");
		$indexpage_handler = icms_getModuleHandler('indexpage', $indexModule->getVar("dirname"), 'index');
		$path = ICMS_ROOT_PATH . '/uploads/'.$indexModule->getVar("dirname").'/indexpage/';
		$image = 'album_indeximage.png';
		if(!is_file($path . $image)) {
			if(icms_core_Filesystem::copyStream(ICMS_ROOT_PATH . '/modules/' . ALBUM_DIRNAME . '/images/' . $image, $path . $image)) {
				$ret[] = _MOD_ALBUM_INSTALL_INDEXIMAGE_SUCCESS;
			} else {
				$ret[] = _MOD_ALBUM_INSTALL_OPEN_SPAN.sprintf(_MOD_ALBUM_INSTALL_INDEXIMAGE_ERR, $path ). _MOD_ALBUM_INSTALL_CLOSE_SPAN;
			}
		}
		if($indexpage_handler->getIndexByMid($module_id) !== FALSE) return _MOD_ALBUM_INSTALL_INDEXPAGE_SUCCESS;
		$indexpageObj = $indexpage_handler->create(TRUE);
		$indexpageObj->setVar('title', _MI_ALBUM_MD_NAME );
		$indexpageObj->setVar('body', _MOD_ALBUM_INSTALL_INDEXPAGE_BDY);
		$indexpageObj->setVar('footer', '&copy; ' . date("Y") . ' '.$icmsConfig['sitename'].' - '.$icmsConfig['slogan'].' Powered By: Album '.$version);
		$indexpageObj->setVar('image', 'album_indeximage.png');
		$indexpageObj->setVar('mid', $module_id);
		$indexpageObj->setVar('language', "all");
		$indexpage_handler->insert( $indexpageObj, TRUE);
		$ret [] = _MOD_ALBUM_INSTALL_INDEXPAGE_SUCCESS;
		unset($indexModule, $indexpage_handler, $indexpageObj);
		return implode("<br />", $ret);
	} else {
		$ret = array();
		$album_indexpage_handler = icms_getModuleHandler( 'indexpage', ALBUM_DIRNAME, 'album' );
		$indexpageObj = $album_indexpage_handler -> get(1);
		if(is_object($indexpageObj) && !$indexpageObj->isNew()) return;
		$path = ICMS_ROOT_PATH . '/uploads/'.ALBUM_DIRNAME.'/indexpage/';
		$image = 'album_indeximage.png';
		if(!is_file($path . $image)) {
			if(icms_core_Filesystem::copyStream(ICMS_ROOT_PATH . '/modules/' . ALBUM_DIRNAME . '/images/' . $image, $path . $image)) {
				$ret[] = _MOD_ALBUM_INSTALL_INDEXIMAGE_SUCCESS;
			} else {
				$ret[] = _MOD_ALBUM_INSTALL_OPEN_SPAN.sprintf(_MOD_ALBUM_INSTALL_INDEXIMAGE_ERR, $path ). _MOD_ALBUM_INSTALL_CLOSE_SPAN;
			}
		}
		$indexpageObj->setVar('index_header', _MI_ALBUM_MD_NAME);
		$indexpageObj->setVar('index_heading', _MOD_ALBUM_INSTALL_INDEXPAGE_BDY);
		$indexpageObj->setVar('index_footer', '&copy; ' . date("Y") . ' '.$icmsConfig['sitename'].' - '.$icmsConfig['slogan'].' Powered By: ALBUM '.$version);
		$indexpageObj->setVar('index_image', $image);
		$indexpageObj->setVar('dohtml', 1);
		$indexpageObj->setVar('dobr', 1);
		$indexpageObj->setVar('doimage', 1);
		$indexpageObj->setVar('dosmiley', 1);
		$indexpageObj->setVar('doxcode', 1);
		$album_indexpage_handler->insert( $indexpageObj, TRUE);
		$ret[] = '<b>Indexpage</b> successfully imported!<br />';
		return implode("<br />", $ret);
	}
}
function deleteLinkedModuleItems(&$module) {
	if(icms_get_module_status("index")) {
		$ret = array();
		$module_id = $module->getVar('mid');
		$indexModule = icms_getModuleInfo("index");
		$link_handler = icms_getModuleHandler("link",$indexModule->getVar("dirname"), "index");
		$link_handler->deleteAllByMId($module_id);
		$ret[] = 'Alle Label-/Kategorien-Links wurden erfolgreich gelöscht!';
		unset($link_handler);
		$indexpage_handler = icms_getModuleHandler("indexpage",$indexModule->getVar("dirname"), "index");
		$indexpage_handler->deleteByMid($module_id);
		$ret[] = 'Tutorials Indexseite wurde erfolgreich entfernt';
		unset($indexpage_handler);
	}
}