<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/phpinfo.php
 *
 * display phpinfo()
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
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
icms_cp_header();
icms::$module->displayAdminMenu( 0, _MI_TOOLS_MENU_TOOLS);
phpinfo();
include_once 'admin_footer.php';