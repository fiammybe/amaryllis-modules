<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /comment_new.php
 * 
 * new comments
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

include_once "header.php";
$com_itemid = isset($_GET["com_itemid"]) ? (int)$_GET["com_itemid"] : 0;
if ($com_itemid > 0) {
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	$eventObj = $event_handler->get($com_itemid);
	if ($eventObj && !$eventObj->isNew()) {
		$com_replytext = "";
		$bodytext = $eventObj->summary();
		if ($bodytext != "") {
			$com_replytext .= "<br /><br />".$bodytext;
		}
		$com_replytitle = $eventObj->title();
		include_once ICMS_ROOT_PATH . "/include/comment_new.php";
	}
}