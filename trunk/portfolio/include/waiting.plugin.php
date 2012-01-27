<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /include/waiting.plugin.php
 * 
 * plugin for system waiting block
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

define("_MOD_PORTFOLIO_CONTACT_ISNEW", "Waiting contacts to be read");

function b_waiting_portfolio() {
	$module_handler = icms::handler('icms_module')->getByDirname("portfolio");
	$portfolio_contact_handler = icms_getModuleHandler("contact", "portfolio");
	
	$ret = array();
	
	// new contact message
	$block = array();
	$approved = new icms_db_criteria_Compo();
	$approved->add(new icms_db_criteria_Item("contact_isnew", 0));
	$result = $portfolio_contact_handler->getCount($approved);
	if ($result > 0) {
		$block['adminlink'] = ICMS_URL."/modules/portfolio/admin/contact.php";
		list($block['pendingnum']) = $result;
		$block['lang_linkname'] = _MOD_PORTFOLIO_CONTACT_ISNEW ;
		$ret[] = $block;
	}
	
	return $ret;
}