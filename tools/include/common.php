<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /language/english/modinfo.php
 *
 * English modinfo language file
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

defined('TOOLS_DIRNAME') or define("TOOLS_DIRNAME", basename(dirname(dirname(__FILE__))));
define("TOOLS_URL", ICMS_MODULES_URL.'/'.TOOLS_DIRNAME.'/');
define("TOOLS_ADMIN_URL", TOOLS_URL.'admin/');
define("TOOLS_ROOT_PATH", ICMS_MODULES_PATH.'/'.TOOLS_DIRNAME.'/');
define("TOOLS_TRUST_PATH", ICMS_TRUST_PATH.'/modules/'.TOOLS_DIRNAME.'/');
