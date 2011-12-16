<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /extras/plugins/waiting/downloads.php
 * 
 * plugin file for waiting block
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

define("_MOD_DOWNLOADS_CATEGORY_APPROVE", "Waiting categories for approval");
define("_MOD_DOWNLOADS_DOWNLOAD_APPROVE", "Waiting files for approval");
define("_MOD_DOWNLOADS_MIRROR_APPROVE", "Waiting mirrors for approval");
define("_MOD_DOWNLOADS_BROKEN_FILES", "Waiting broken files");

function b_waiting_downloads() {
	$module_handler = icms::handler('icms_module')->getByDirname("downloads");
	$downloads_category_handler = icms_getModuleHandler("category", "downloads");
	$downloads_download_handler = icms_getModuleHandler("download", "downloads");
	
	$ret = array();
	
	// category approval
	$block = array();
	$approved = new icms_db_criteria_Compo();
	$approved->add(new icms_db_criteria_Item("category_approve", 0));
	$result = $downloads_category_handler->getCount($approved);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/downloads/admin/category.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_DOWNLOADS_CATEGORY_APPROVE ;
		$ret[] = $block;
	}
	
	// file approval
	$block = array();
	$approve = new icms_db_criteria_Compo();
	$approve->add(new icms_db_criteria_Item("download_approve", 0));
	$result = $downloads_download_handler->getCount($approve);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/downloads/admin/category.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_DOWNLOADS_DOWNLOAD_APPROVE;
		$ret[] = $block;
	}
	
	// mirror approval
	$block = array();
	$approve = "";
	$approve = new icms_db_criteria_Compo();
	$approve->add(new icms_db_criteria_Item("download_mirror_approve", 0));
	$result = $downloads_download_handler->getCount($approve);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/downloads/admin/category.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_DOWNLOADS_MIRROR_APPROVE ;
		$ret[] = $block;
	}
	
	// broken files
	$block = array();
	$broken = "";
	$broken = new icms_db_criteria_Compo();
	$broken->add(new icms_db_criteria_Item("download_broken", TRUE));
	$result = $downloads_download_handler->getCount($broken);
	if ($result) {
		$block['adminlink'] = ICMS_URL."/modules/downloads/admin/category.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_DOWNLOADS_BROKEN_FILES ;
		$ret[] = $block;
	}
	
	return $ret;
}
