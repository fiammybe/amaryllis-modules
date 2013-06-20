<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /submit.php
 *
 * submit comments for images
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

include_once 'header.php';

$valid_op = array ('addcomment', 'addmycomment', 'addcommentByPublisher', 'getDisclaimer');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op', FILTER_SANITIZE_STRING) : FALSE;
$clean_op = isset($_POST['op']) ? filter_input(INPUT_POST, 'op', FILTER_SANITIZE_STRING) : FALSE;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addcommentByPublisher':
		case 'addmycomment':
		case 'addcomment':
			$clean_img_id = isset($_POST['img_id']) ? filter_input(INPUT_POST, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_label = isset($_GET['label']) ? filter_input(INPUT_GET, 'label', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_img_start = isset($_GET['img_nav']) ? filter_input(INPUT_GET, 'img_nav', FILTER_SANITIZE_NUMBER_INT) : 0;
			$body = StopXSS(filter_input(INPUT_POST, 'img_comment', FILTER_SANITIZE_STRING));
			$album_images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
			$imagesObj = $album_images_handler->get($clean_img_id);
			if(is_object($imagesObj) && !$imagesObj->isNew() && is_object(icms::$user)) {
				$album_message_handler = icms_getModuleHandler("message", ALBUM_DIRNAME, "album");
				$messageObj = $album_message_handler->create();
				$messageObj->setVar("message_uid", icms::$user->getVar("uid"));
				$messageObj->setVar("message_item",$clean_img_id);
				$messageObj->setVar("message_album",$imagesObj->getVar("a_id", "e"));
				$messageObj->setVar("message_body", $body);
				$messageObj->setVar("message_date", time());
				if($albumConfig['message_needs_approval'] == 1 && !$album_isAdmin) {
					$messageObj->setVar("message_approve", 0);
				} else {
					$messageObj->setVar("message_approve", 1);
				}
				$album_message_handler->insert($messageObj);
				$imagesObj->setVar("img_hasmsg", 1);
				$imagesObj->_updating = TRUE;
				$album_images_handler->insert($imagesObj, TRUE);
				if($albumConfig['message_needs_approval'] == 1 && !$album_isAdmin) {
					$retm = _MD_ALBUM_MESSAGE_THANKS_APPROVAL;
				} else {
					$retm = _MD_ALBUM_MESSAGE_THANKS;
				}
				return redirect_header(icms_getPreviousPage().'&imglink='.$clean_img_id, 3, $retm);
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _NOPERM);
			}
			break;
		case 'getDisclaimer':
			$discl = str_replace('{X_SITENAME}', $icmsConfig['sitename'], $albumConfig['album_upl_disclaimer']);
			echo $discl;
			break;
	}
} else {
	return redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}