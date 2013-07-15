<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /include/autotasks/autotask_optimize_db.php
 *
 * trigger all tool tasks at once
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

defined('ICMS_ROOT_PATH') or die("Access Denied");
defined('TOOLS_DIRNAME') or define('TOOLS_DIRNAME', basename(dirname(dirname(dirname(__FILE__)))));
include_once ICMS_ROOT_PATH.'/modules/'.TOOLS_DIRNAME.'/include/common.php';
require_once ICMS_ROOT_PATH.'/modules/'.TOOLS_DIRNAME.'/class/Tools.php';

mod_tools_Tools::instance();
mod_tools_Tools::maintainDB();