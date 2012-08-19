<?php
/**
 * New comment form
 *
 * This file holds the configuration information of this module
 *
 * @copyright	
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		event
 * @version		$Id$
 */

include_once "header.php";
$com_itemid = isset($_GET["com_itemid"]) ? (int)$_GET["com_itemid"] : 0;
if ($com_itemid > 0) {
	$event_post_handler = icms_getModuleHandler("post", basename(dirname(__FILE__)), "event");
	$postObj = $event_post_handler->get($com_itemid);
	if ($postObj && !$postObj->isNew()) {
		$com_replytext = "test...";
		$bodytext = $postObj->getPostLead();
		if ($bodytext != "") {
			$com_replytext .= "<br /><br />".$bodytext;
		}
		$com_replytitle = $postObj->getVar("post_title");
		include_once ICMS_ROOT_PATH . "/include/comment_new.php";
	}
}