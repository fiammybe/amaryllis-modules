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

function b_portfolio_recent_contacts_show($options) {
	global $portfolioConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$uid = is_object(icms::$user) ? icms::$user->getVar('uid') : 0;
	$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
	$portfolio_contact_handler = icms_getModuleHandler("contact", basename(dirname(dirname(__FILE__))), "portfolio");
	$block['portfolio_contacts'] = $portfolio_contact_handler->getContacts(0, $options[0]);
	return $block;
}

function b_portfolio_recent_contacts_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td>' . _MB_PORTFOLIO_PORTFOLIO_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[0]" value="' . $options[0] . '"/></td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}