<?php
/**
* Images page
*
* @copyright	Copyright QM-B (Steffen Flohrer) 2011
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		QM-B <qm-b@hotmail.de>
* @package		album
* @version		$Id$
*/

include_once "header.php";

$xoopsOption["template_main"] = "album_images.html";
include_once ICMS_ROOT_PATH . "/header.php";

$album_images_handler = icms_getModuleHandler("images", basename(dirname(__FILE__)), "album");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_images_id = isset($_GET["images_id"]) ? (int)$_GET["images_id"] : 0 ;
$imagesObj = $album_images_handler->get($clean_images_id);

if ($imagesObj && !$imagesObj->isNew()) {
	$icmsTpl->assign("album_images", $imagesObj->toArray());
} else {
	$icmsTpl->assign("album_title", _MD_ALBUM_ALL_IMAGESS);

	$objectTable = new icms_ipf_view_Table($album_images_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("img_id"));
	$icmsTpl->assign("album_images_table", $objectTable->fetch());
}

$icmsTpl->assign("album_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";