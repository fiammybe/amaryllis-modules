<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/admin_footer.php
 * 
 * footer File included in all admin pages
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

$footer = "<div style='margin: 2em auto; text-align: center; font-size: 1.5em;'>";
$footer .= "If you need help with the module, please check the <a href='" . ICMSPOLL_ADMIN_URL . "manual.php' title='manual' style='color: #336699;'>manual</a>";
$footer .= "</div>";

echo $footer;

icms_cp_footer();