<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google categorys, too
 *
 * File: /admin/manual.php
 * 
 * Module Manual
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

include_once 'admin_header.php';

icms_cp_header();
icms::$module->displayAdminMenu( -1, _MI_EVENT_MENU_MANUAL);
$file = isset($_GET['file']) ? filter_input(INPUT_GET, "file") : "manual.html";
$lang = "language/" . $icmsConfig['language'];
$manual = EVENT_ROOT_PATH . "$lang/$file";
if (!file_exists($manual)) {
	$lang = 'language/english';
	$manual = EVENT_ROOT_PATH . "$lang/$file";
}
$icmsAdminTpl->assign("manual_path", $manual);
$icmsAdminTpl->display('db:event_admin.html');
icms_cp_footer();