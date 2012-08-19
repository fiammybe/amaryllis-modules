<?php
/**
 * Footer page included at the end of each page on user side of the mdoule
 *
 * @copyright	
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		event
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");


$icmsTpl->assign("event_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_EVENT_ADMIN_PAGE . "</a>");
$icmsTpl->assign("event_is_admin", icms_userIsAdmin(EVENT_DIRNAME));
$icmsTpl->assign('event_url', EVENT_URL);
$icmsTpl->assign('event_images_url', EVENT_IMAGES_URL);
$icmsTpl->assign('event_script_url', EVENT_SCRIPT_URL);

$xoTheme->addStylesheet(EVENT_URL . 'module' . ((defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? '_rtl' : '') . '.css');
$xoTheme->addStylesheet(EVENT_URL . 'scripts/fullcalendar.css');
$xoTheme->addStylesheet(EVENT_URL . 'scripts/jquery.qtip.min.css');

$rtl = (defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? 'true' : 'false';
$icmsTpl->assign("event_rtl", $rtl);

//$icmsTpl->assign("default_view", $eventConfig['default_view']);
$icmsTpl->assign("first_day", $eventConfig['first_day']);
$icmsTpl->assign("display_weekend", ($eventConfig['display_weekend'] == 1) ? 'true' : 'false');
$icmsTpl->assign("agenda_start", $eventConfig['agenda_start']);
$icmsTpl->assign("agenda_slot", $eventConfig['agenda_slot']);
$icmsTpl->assign("agenda_min", $eventConfig['agenda_min']);
$icmsTpl->assign("agenda_max", $eventConfig['agenda_max']);
$icmsTpl->assign("event_minutes", $eventConfig['event_minutes']);

include_once ICMS_ROOT_PATH . '/footer.php';