<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /icms_version.php
 *
 * add new comments
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * --------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 *
 */

if(file_exists("../../mainfile.php")) include_once "../../mainfile.php";
else if (file_exists("mainfile.php")) include_once "mainfile.php";
include_once ICMS_ROOT_PATH."/modules/".basename(dirname(__FILE__))."/include/common.php";
$com_itemid = isset($_GET['com_itemid']) ? filter_input(INPUT_GET, 'com_itemid', FILTER_SANITIZE_NUMBER_INT) : 0;
if ($com_itemid > 0) {
	$album_album_handler = icms_getModuleHandler('album', ALBUM_DIRNAME,'album');
	$albumObj = $album_album_handler->get($com_itemid);
	if ($albumObj && !$albumObj->isNew()) {
		$bodytext = $albumObj->getVar('album_description');
		if ($bodytext != '') {
			$com_replytext .= $bodytext;
		}
		$com_replytitle = $albumObj->getVar('album_title');
		include_once ICMS_ROOT_PATH .'/include/comment_new.php';
	}
}