<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /comment_new.php
 * 
 * New Comment
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

include '../../mainfile.php';
$com_itemid = isset($_GET['com_itemid']) ? (int)($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
	$polls_handler = icms_getModuleHandler('polls', basename(dirname(__FILE__)),'icmspoll');
	$pollObj = $polls_handler->get($com_itemid);
	if ($pollObj && !$pollObj->isNew()) {
		$bodytext = $pollObj->getVar('description', 's');
		$bodytext = icms_core_DataFilter::checkVar($bodytext, "html", "output");
		if ($bodytext != '') {
			$com_replytext .= $bodytext;
		}
		$com_replytitle = $pollObj->getVar('question');
		include_once ICMS_ROOT_PATH .'/include/comment_new.php';
	}
}