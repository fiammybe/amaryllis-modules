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
 * 				download
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @package		download
 * @version		$Id$
 * 
 */

include_once 'header.php';
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
	$downloads_download_handler = icms_getModuleHandler('item', basename(dirname(__FILE__)),'downloads');
	$downloadObj = $downloads_download_handler->get($com_itemid);
	if ($downloadObj && !$downloadObj->isNew()) {
		$bodytext = $downloadObj->getVar('download_description');
		if ($bodytext != '') {
			$com_replytext .= $bodytext;
		}
		$com_replytitle = $downloadObj->getVar('download_title');
		include_once ICMS_ROOT_PATH .'/include/comment_new.php';
	}
}