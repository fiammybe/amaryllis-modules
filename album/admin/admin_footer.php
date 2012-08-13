<?php
/**
 * 'Shop' is a php shop module for ImpressCMS
 *
 * File: /admin/admin_footer.php
 * 
 * Footer-file included in all admin pages
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Shop
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		shop
 *
 */
$version = number_format(icms::$module->getVar('version')/100, 2);
$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;

$footer = "<div style='margin: 2em auto; text-align: center; font-size: 1em;'>";
$footer .= "If you need help with the module, please check the <a href='manual.php' title='manual' style='color: #336699;'>manual</a>.";
$footer .= "&nbsp;Powered by <a href='about.php'>Album ".$version."</a>";
$footer .= "</div>";
echo $footer;
icms_cp_footer();