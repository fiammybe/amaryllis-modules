<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /include/waiting.plugin.php
 * 
 * plugin for waiting block
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

define("_MOD_GUESTBOOK_GUESTBOOK_APPROVE", "Waiting entries for approval");

function b_waiting_guestbook() {
	$module_handler = icms::handler('icms_module')->getByDirname("guestbook");
	$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", "guestbook");
	
	$ret = array();
	
	// entry approval
	$block = array();
	$approved = new icms_db_criteria_Compo();
	$approved->add(new icms_db_criteria_Item("guestbook_approve", 0));
	$result = $guestbook_guestbook_handler->getCount($approved);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/guestbook/admin/guestbook.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_GUESTBOOK_GUESTBOOK_APPROVE ;
		$ret[] = $block;
	}
	return $ret;
}