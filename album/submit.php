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

include_once ICMS_ROOT_PATH . '/header.php';

$valid_op = array ('addcomment', 'addmycomment', 'addcommentByPublisher');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addcommentByPublisher':
		case 'addmycomment':
		case 'addcomment':
			$clean_album_id = isset($_GET['album_id']) ? filter_input(INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_img_id = isset($_GET['img_id']) ? filter_input(INPUT_GET, 'img_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_tag_id = isset($_GET['tag']) ? filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_uid = isset($_GET['uid']) ? filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$clean_img_start = isset($_GET['img_nav']) ? (int)($_GET['img_nav']) : 0;
			$body = filter_input(INPUT_POST, 'img_comment');
			$album_images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
			$imagesObj = $album_images_handler->get($clean_img_id);
			if(is_object($imagesObj) && !$imagesObj->isNew() && is_object(icms::$user)) {
				$album_message_handler = icms_getModuleHandler("message", ALBUM_DIRNAME, "album");
				$messageObj = $album_message_handler->create();
				$messageObj->setVar("message_uid", icms::$user->getVar("uid"));
				$messageObj->setVar("message_item",$clean_img_id);
				$messageObj->setVar("message_body", $body);
				$messageObj->setVar("message_date", time());
				if($albumConfig['message_needs_approval'] == 1) {
					$messageObj->setVar("message_approve", 0);
				} else {
					$messageObj->setVar("message_approve", 1);
				}
				$album_message_handler->insert($messageObj, TRUE);
				if($clean_op == 'addmycomment') {
					if($albumConfig['message_needs_approval'] == 0) {
						return redirect_header(ALBUM_URL . 'index.php?op=getByTags&tag=' . $clean_tag_id . '&img_nav=' . $clean_img_start . '&imglink=' . $clean_img_id, 3, _MD_ALBUM_MESSAGE_THANKS);
					} else {
						return redirect_header(ALBUM_URL . 'index.php?op=getByTags&tag=' . $clean_tag_id . '&img_nav=' . $clean_img_start . '&imglink=' . $clean_img_id, 5, _MD_ALBUM_MESSAGE_THANKS_APPROVAL);
					}
				} elseif ($clean_op == 'addcommentByPublisher') {
					if($albumConfig['message_needs_approval'] == 0) {
						return redirect_header(ALBUM_URL . 'index.php?op=getByPublisher&uid=' . $clean_uid . '&img_nav=' . $clean_img_start . '&imglink=' . $clean_img_id, 3, _MD_ALBUM_MESSAGE_THANKS);
					} else {
						return redirect_header(ALBUM_URL . 'index.php?op=getByPublisher&uid=' . $clean_uid . '&img_nav=' . $clean_img_start . '&imglink=' . $clean_img_id, 5, _MD_ALBUM_MESSAGE_THANKS_APPROVAL);
					}
				} else {
					if($albumConfig['message_needs_approval'] == 0) {
						return redirect_header(ALBUM_URL . 'index.php?album_id=' . $clean_album_id . '&img_nav=' . $clean_img_start . '&imglink=' . $clean_img_id, 3, _MD_ALBUM_MESSAGE_THANKS);
					} else {
						return redirect_header(ALBUM_URL . 'index.php?album_id=' . $clean_album_id . '&img_nav=' . $clean_img_start . '&imglink=' . $clean_img_id, 5, _MD_ALBUM_MESSAGE_THANKS_APPROVAL);
					}
				}
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _NOPERM);
			}
			break;
	}
} else {
	return redirect_header(icms_getPreviousPage(), 3, _NOPERM);
}