<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /blocks/portfolio_spotlight.php
 * 
 * spotlight block
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

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("PORTFOLIO_DIRNAME")) define("PORTFOLIO_DIRNAME",basename(dirname(dirname(__FILE__))));

function b_portfolio_recent_contacts_show($options) {
	global $portfolioConfig;
	include_once ICMS_ROOT_PATH.'/modules/'.PORTFOLIO_DIRNAME.'/include/common.php';
	$contact_handler = icms_getModuleHandler("contact", PORTFOLIO_DIRNAME, "portfolio");
	$block['portfolio_contacts'] = $contact_handler->getContacts(0, $options[0]);
	return $block;
}

function b_portfolio_recent_contacts_edit($options) {
	include_once ICMS_ROOT_PATH . '/modules/' . PORTFOLIO_DIRNAME . '/include/common.php';
	$limit = new icms_form_elements_Text("", "options[0]", 7, 10, $options[0]);
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td>' . _MB_PORTFOLIO_PORTFOLIO_RECENT_LIMIT . '</td>';
	$form .= '<td>' . $limit->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}