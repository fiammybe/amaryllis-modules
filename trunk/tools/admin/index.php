<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/index.php
 *
 * admin file
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

include_once 'admin_header.php';
header("Location: tools.php");
exit;
icms_cp_header();
icms::$module->displayAdminMenu( 0, _MI_TOOLS_MENU_INDEX);
icms::$module->setVar("ipf", TRUE);
icms::$module->registerClassPath(TRUE);
$logPath = TOOLS_TRUST_PATH.'logs/';


include_once 'admin_footer.php';