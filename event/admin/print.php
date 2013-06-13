<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /admin/manual.php
 * 
 * print support for Module Manual
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

include_once 'admin_header.php';

icms::$logger->disableLogger();

$clean_print = isset($_GET['print']) ? filter_input(INPUT_GET, 'print') : 'manual';

$valid_print = array("manual");

icms_loadLanguageFile("event", "modinfo");

if(in_array($clean_print, $valid_print, TRUE)) {
	switch ($clean_print) {
		case 'manual':
			global $icmsConfig;
			$file = "/manual.html";
			$lang = "language/" . $icmsConfig['language'];
			$manual = EVENT_ROOT_PATH . "$lang/$file";
			if (!file_exists($manual)) {
				$lang = 'language/english';
				$manual = EVENT_ROOT_PATH . "$lang/$file";
			}
			$title = _MI_EVENT_MD_NAME . "&nbsp;&raquo;" . _MI_EVENT_MENU_MANUAL . "&laquo;";
			$dsc = _MI_EVENT_MD_DESC;
			$content = file_get_contents($manual);
			$print = icms_view_Printerfriendly::generate($content, $title, $dsc, $title);
			return $print;
			break;
	}
} else {
	redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}
