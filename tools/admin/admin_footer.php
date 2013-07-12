<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/admin_footer.php
 *
 * Admin footer file
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$version = number_format(icms::$module->getVar('version')/100, 2);
$version = !substr($version, -1, 1) ? substr($version, 0, 3) : $version;

$footer = "<div style='margin: 2em auto; text-align: center; font-size: .9em;'><p>";
$footer .= _AM_TOOLS_ADMIN_FOOTER;
$footer .= " Powered by <a href='about.php'>Tools ".$version."</a>";
$footer .= "</p></div>";
echo $footer;
icms_cp_footer();