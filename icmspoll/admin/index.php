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
 * @version		$Id: index.php 11 2012-06-27 12:30:05Z qm-b $
 * @package		icmspoll
 *
 */

include_once "admin_header.php";

$polls_handler = icms_getModuleHandler('polls', basename(dirname(dirname(__FILE__))), 'icmspoll');
$options_handler = icms_getModuleHandler('options', basename(dirname(dirname(__FILE__))), 'icmspoll');

icms_cp_header();
icms::$module->displayAdminMenu(0, _MI_ICMSPOLL_MENU_INDEX);
global $icmspollConfig;


include_once 'admin_footer.php';