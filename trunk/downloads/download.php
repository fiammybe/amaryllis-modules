<?php
/**
* Download page
*
* @copyright	Copyright QM-B (Steffen Flohrer) 2011
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		QM-B <qm-b@hotmail.de>
* @package		downloads
* @version		$Id$
*/

include_once "header.php";

$xoopsOption["template_main"] = "downloads_download.html";
include_once ICMS_ROOT_PATH . "/header.php";

$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_download_id = isset($_GET["download_id"]) ? (int)$_GET["download_id"] : 0 ;
$downloadObj = $downloads_download_handler->get($clean_download_id);

if($downloadObj && !$downloadObj->isNew()) {
	$icmsTpl->assign("downloads_download", $downloadObj->toArray());

	$icms_metagen = new icms_ipf_Metagen($downloadObj->getVar("download_title"), $downloadObj->getVar("meta_keywords", "n"), $downloadObj->getVar("meta_description", "n"));
	$icms_metagen->createMetaTags();
} else {
	$icmsTpl->assign("downloads_title", _MD_DOWNLOADS_ALL_DOWNLOADS);

	$objectTable = new icms_ipf_view_Table($downloads_download_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("download_title"));
	$icmsTpl->assign("downloads_download_table", $objectTable->fetch());
}

$icmsTpl->assign("downloads_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";