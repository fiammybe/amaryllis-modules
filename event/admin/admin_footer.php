<?php
/**
 * 'Event' is an event/calendar module for ImpressCMS, which can display google calendars, too
 *
 * File: /admin/admin_footer.php
 * 
 * admin footer of the module
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
$version = number_format(icms::$module->getVar('version')/100, 2);
$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;

$footer = "<div style='margin: 2em auto; text-align: center; font-size: .9em;'>";
$footer .= "If you need help with the module, please check the <a href='manual.php' title='manual' style='color: #336699;'>manual</a>.";
$footer .= "&nbsp;Powered by <a href='about.php'>Event ".$version."</a>";
$footer .= "</div>";
echo $footer;
icms_cp_footer();