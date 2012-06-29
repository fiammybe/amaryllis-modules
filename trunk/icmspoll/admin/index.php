<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/index.php
 * 
 * ACP index file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

include_once "admin_header.php";

$polls_handler = icms_getModuleHandler('polls', basename(dirname(dirname(__FILE__))), 'icmspoll');
$options_handler = icms_getModuleHandler('options', basename(dirname(dirname(__FILE__))), 'icmspoll');

icms_cp_header();
icms::$module->displayAdminMenu(0, _MI_ICMSPOLL_MENU_INDEX);
global $icmspollConfig;

$active_polls = $polls_handler->getPollsCount(FALSE, FALSE, TRUE);
$expired_polls = $polls_handler->getPollsCount(TRUE, FALSE, FALSE);

include_once 'admin_footer.php';