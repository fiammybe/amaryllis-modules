<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /header.php
 * 
 * header included in frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';
if(icms_get_module_status("index")) {
	$indexModule = icms_getModuleInfo("index");
	include_once ICMS_ROOT_PATH . "/modules/" . $indexModule->getVar("dirname") . "/include/common.php";
}
icms_loadLanguageFile("article", "main");