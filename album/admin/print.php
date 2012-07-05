<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/print.php
 *
 * print support for album Manual
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Album
 * @since		1.20
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

include_once 'admin_header.php';

icms::$logger->disableLogger();

$clean_print = isset($_GET['print']) ? filter_input(INPUT_GET, 'print') : 'manual';

$valid_print = array("manual");

if(in_array($clean_print, $valid_print, TRUE)) {
	switch ($clean_print) {
		case 'manual':
			global $icmsConfig;
			$file = "/manual.html";
			$lang = "language/" . $icmsConfig['language'];
			$manual = ALBUM_ROOT_PATH . "$lang/$file";
			if (!file_exists($manual)) {
				$lang = 'language/english';
				$manual = ALBUM_ROOT_PATH . "$lang/$file";
			}
			$title = _MI_ALBUM_NAME . "&nbsp;&raquo;" . _MI_ALBUM_MENU_MANUAL . "&laquo;";
			$dsc = _MI_ALBUM_DSC;
			$content = file_get_contents($manual);
			$print = icms_view_Printerfriendly::generate($content, $title, $dsc, $title);
			return $print;
			break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}
