<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /blocks/guestbook_recent_guestbooks.php
 *
 * block to show recent guestbooks
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 * 
 */

 if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function b_guestbook_recent_entries_show($options) {
	global $guestbookConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$guestbook_guestbook_handler = icms_getModuleHandler('guestbook', basename(dirname(dirname(__FILE__))), 'guestbook');

	$block['guestbook_entries'] = $guestbook_guestbook_handler->getEntries(TRUE, 0, 0, $options[0]);
	
	return $block;
}

function b_guestbook_recent_entries_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$guestbook_guestbook_handler = icms_getModuleHandler('guestbook', basename(dirname(dirname(__FILE__))), 'guestbook');
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_GUESTBOOK_GUESTBOOK_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}