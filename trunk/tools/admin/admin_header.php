<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/admin_header.php
 *
 * holds module informations
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

include_once "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/include/common.php";
if (!defined("TOOLS_ADMIN_URL")) define("TOOLS_ADMIN_URL", TOOLS_URL . "admin/");
include_once TOOLS_ROOT_PATH . "include/requirements.php";
icms_loadLanguageFile("tools", "modinfo");
$toolsConfig = icms_getModuleConfig(TOOLS_DIRNAME);