<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /blocks/downloads_recent_downloads.php
 * 
 * block to show recent albums
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

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

function b_downloads_recent_downloads_show($options) {
	global $downloadsConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');

	$block['album_album'] = $downloads_download_handler->getAlbumsForBlocks(0, $options[0]);
	
	return $block;
}

function b_downloads_recent_downloads_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_DOWNLOADS_DOWNLOAD_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}