<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /language/german/install.php
 *
 * german install language file
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.30
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: onupdate.inc.php 191 2013-06-14 13:04:17Z qm-b $
 * @package		album
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
global $icmsConfig;
define("_MOD_ALBUM_INSTALL_OLD_MAIN_REMOVED", "Old main file successfully removed!");
define("_MOD_ALBUM_INSTALL_OLD_MAIN_NOT_FOUND", "No old main file found &hellip;");
define("_MOD_ALBUM_INSTALL_MAIN_SUCCESS", "Main file successfully copied!");
define("_MOD_ALBUM_INSTALL_MAIN_ERR", "Main page has not been copied to Root Path!Please copy files from %s to your Root'.'");
define("_MOD_ALBUM_INSTALL_INDEXIMAGE_SUCCESS", "<b>Indeximage</b> successfully copied!");
define("_MOD_ALBUM_INSTALL_INDEXIMAGE_ERR", "Indeximage has not been copied to %s !");
define("_MOD_ALBUM_INSTALL_INDEXPAGE_SUCCESS", "<b>Indexpage</b> successfully added!");
define("_MOD_ALBUM_INSTALL_INDEXPAGE_ERR", "An error occured while adding an Indexpage for faq-module to index-module");
define("_MOD_ALBUM_INSTALL_INDEXPAGE_BDY", "This page contains answers to commonly-asked questions about ".$icmsConfig['sitename']);
define("_MOD_ALBUM_INSTALL_DELETE_CATLINK", "All linked categories/labels has been removed successfully");
define("_MOD_ALBUM_INSTALL_DELETE_INDEXPAGE", "ALBUM Indexpage has been removed successfully");
define("_MOD_ALBUM_INSTALL_DELETE_MAIN", "ALBUM main-file has been removed successfully");
define("_MOD_ALBUM_INSTALL_DELETE_TRUST_ERR", "Sorry, Trusted directory has NOT been removed! You'll need to remove yourself. Go to %s and remove directory.");
define("_MOD_ALBUM_INSTALL_DELETE_CACHE_ERR", "Sorry, cache directory has NOT been removed! You'll need to remove yourself. Go to %s and remove directory.");
define("_MOD_ALBUM_INSTALL_DELETE_MAIN_ERR", "Sorry, main file has NOT been removed! You'll need to remove yourself. Go to %s and remove the file.");
define("_MOD_ALBUM_INSTALL_CATIMG_EXISTS", "Category Image %s already found");
define("_MOD_ALBUM_INSTALL_CATIMG_COPIED", "Category Image %s successfully moved");
define("_MOD_ALBUM_INSTALL_CATIMG_ERR", "Category Image %s has not been copied to upload path!");