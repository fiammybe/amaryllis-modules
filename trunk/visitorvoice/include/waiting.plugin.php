<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /include/waiting.plugin.php
 * 
 * plugin for waiting block
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

define("_MOD_VISITORVOIVE_VISITORVOIVE_APPROVE", "Waiting entries for approval");

function b_waiting_visitorvoice() {
	$moduleInfo = icms_getModuleInfo("visitorvoice");
	$module_handler = icms::handler('icms_module')->getByDirname($moduleInfo->getVar("dirname"));
	$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", $moduleInfo->getVar("dirname"), "visitorvoice");
	
	$ret = array();
	
	// entry approval
	$block = array();
	$approved = new icms_db_criteria_Compo();
	$approved->add(new icms_db_criteria_Item("visitorvoice_approve", 0));
	$result = $visitorvoice_visitorvoice_handler->getCount($approved);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/".$moduleInfo->getVar("dirname") ."/admin/visitorvoice.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_VISITORVOIVE_VISITORVOIVE_APPROVE ;
		$ret[] = $block;
	}
	return $ret;
}