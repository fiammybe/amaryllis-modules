<?php
/**
 * 'Downloads' is a light weight images handling module for ImpressCMS
 *
 * File: /extras/plugins/waiting/album.php
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
 * @package		album
 *
 */

define("_MOD_ALBUM_ALBUM_APPROVE", "Waiting albums for approval");
define("_MOD_ALBUM_IMAGES_APPROVE", "Waiting images for approval");
define("_MOD_ALBUM_MESSAGE_APPROVE", "Waiting Image Comments for approval");

function b_waiting_album() {
	$module_handler = icms::handler('icms_module')->getByDirname("album");
	$album_album_handler = icms_getModuleHandler("album", "album");
	$album_images_handler = icms_getModuleHandler("images", "album");
	$album_message_handler = icms_getModuleHandler("message", "album");
	
	$ret = array();
	
	// album approval
	$block = array();
	$approved = new icms_db_criteria_Compo();
	$approved->add(new icms_db_criteria_Item("album_approve", 0));
	$result = $album_album_handler->getCount($approved);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/album/admin/album.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_ALBUM_ALBUM_APPROVE ;
		$ret[] = $block;
	}
	
	// image approval
	$block = array();
	$approve = new icms_db_criteria_Compo();
	$approve->add(new icms_db_criteria_Item("img_approve", 0));
	$result = $album_images_handler->getCount($approve);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/album/admin/images.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_ALBUM_IMAGES_APPROVE;
		$ret[] = $block;
	}
	
	// image approval
	$block = array();
	$approveM = new icms_db_criteria_Compo();
	$approveM->add(new icms_db_criteria_Item("message_approve", 0));
	$result = $album_message_handler->getCount($approveM);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/album/admin/message.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_ALBUM_MESSAGE_APPROVE;
		$ret[] = $block;
	}
	
	return $ret;
}
