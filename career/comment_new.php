<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /comment_new.php
 * 
 * add comments
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

include_once 'header.php';

$com_itemid = isset($_GET['com_itemid']) ? filter_input(INPUT_GET, 'com_itemid', FILTER_SANITIZE_NUMBER_INT) : 0;
if ($com_itemid > 0) {
	$career_message_handler = icms_getModuleHandler("message", basename(dirname(__FILE__)),"career");
	$messageObj = $career_message_handler->get($com_itemid);
	if ($messageObj && !$messageObj->isNew()) {
		$com_replytext = "";
		$bodytext = $messageObj->getVar('message_body');
		if ($bodytext != '') {
			$com_replytext .= $bodytext;
		}
		$com_replytitle = $messageObj->getVar('message_title');
		include_once ICMS_ROOT_PATH .'/include/comment_new.php';
	}
}