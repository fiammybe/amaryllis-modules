<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /blocks/visitorvoice_recent_visitorvoices.php
 *
 * block to show recent visitorvoices
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 * 
 */

 if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function b_visitorvoice_recent_entries_show($options) {
	global $visitorvoiceConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$visitorvoice_visitorvoice_handler = icms_getModuleHandler('visitorvoice', basename(dirname(dirname(__FILE__))), 'visitorvoice');

	$block['visitorvoice_entries'] = $visitorvoice_visitorvoice_handler->getEntries(TRUE, 0, 0, $options[0]);
	
	return $block;
}

function b_visitorvoice_recent_entries_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$visitorvoice_visitorvoice_handler = icms_getModuleHandler('visitorvoice', basename(dirname(dirname(__FILE__))), 'visitorvoice');
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_VISITORVOICE_VISITORVOICE_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}