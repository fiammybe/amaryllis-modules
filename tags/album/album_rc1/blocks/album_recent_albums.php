<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /blocks/album_recent_albums.php
 *
 * block to show recent albums
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * 
 */

 if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function b_album_album_recent_show($options) {
	global $albumConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$album_album_handler = icms_getModuleHandler('album', basename(dirname(dirname(__FILE__))), 'album');

	$block['album_album'] = $album_album_handler->getAlbumsForBlocks(0, $options[0]);
	
	return $block;
}

function b_album_album_recent_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$album_album_handler = icms_getModuleHandler('album', basename(dirname(dirname(__FILE__))), 'album');
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_ALBUM_ALBUM_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}