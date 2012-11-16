<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /submit.php
 * 
 * submit entries
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

$moddir = basename(dirname(__FILE__));
include_once "../../mainfile.php";
include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
icms::$logger->disableLogger();
$valid_op = array ('addentry', 'addreply', );
$clean_op = (isset($_POST['op'])) ? filter_input(INPUT_POST, "op") : FALSE;
if(!$clean_op) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addentry':
			global $guestbookConfig;
			$guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(__FILE__)), "guestbook");
			$guestbook_pid = isset($_POST['guestbook_pid']) ? filter_input(INPUT_POST, 'guestbook_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			if($guestbook_pid != 0 && !$guestbook_handler->canModerate()) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			$captcha = icms_form_elements_captcha_Object::instance();
			if(!$captcha->verify(TRUE)) {echo json_encode(array("status" => "error", "message" => "Verification Failed"));unset($_POST); exit;}
			
			$val = "";
			if(!empty($_POST['guestbook_image']) && $guestbookConfig['allow_imageupload'] == 1) {
				$path = ICMS_UPLOAD_PATH.'/'.GUESTBOOK_DIRNAME.'/'.$guestbook_handler->_itemname;
				$mimetypes = array("image/jpg", "image/jpeg", "image/gif", "image/png");
				$uploader = new icms_file_MediaUploadHandler($path,$mimetypes, $guestbookConfig['image_file_size'],$guestbookConfig['image_upload_width'], $guestbookConfig['image_upload_height']);
					if ($uploader->fetchMedia($_POST['guestbook_image'])) {
						$uploader->setPrefix('img_'.time());
						if ($uploader->upload()) {
							$val = $uploader->getSavedFileName();
						} else {
							echo $uploader->getErrors();
						}
					} else {
						echo $uploader->getErrors();
					}
			}
			
			$guestbookObj = $guestbook_handler->create(TRUE);
			$guestbookObj->setVar("guestbook_title", filter_input(INPUT_POST, "guestbook_title"));
			$guestbookObj->setVar("guestbook_name", filter_input(INPUT_POST, "guestbook_name"));
			$guestbookObj->setVar("guestbook_email", filter_input(INPUT_POST, "guestbook_email", FILTER_VALIDATE_EMAIL));
			$guestbookObj->setVar("guestbook_url", filter_input(INPUT_POST, "guestbook_url"));
			$guestbookObj->setVar("guestbook_entry", filter_input(INPUT_POST, "guestbook_entry"));
			$guestbookObj->setVar("guestbook_pid", $guestbook_pid);
			$guestbookObj->setVar("guestbook_ip", getenv('REMOTE_ADDR'));
			$guestbookObj->setVar("guestbook_fprint", $_SESSION['icms_fprint']);
			$guestbookObj->setVar("guestbook_published_date", time());
			$guestbookObj->setVar("guestbook_image", $val);
			$guestbookObj->setVar("guestbook_uid", $uid);
			if($guestbookConfig["needs_approval"] == 1) {
				$guestbookObj->setVar("guestbook_approve", icms_userIsAdmin(GUESTBOOK_DIRNAME) ? TRUE : FALSE);
			} else {
				$guestbookObj->setVar("guestbook_approve", TRUE);
			}
			if(!$guestbook_handler->insert($guestbookObj)) {echo json_encode(array("status" => "error", "message" => $guestbookObj->getHtmlErrors())); unset($_POST); exit;}
			echo json_encode(array("status" => "success", "message" => _THANKS_SUBMISSION)); unset($_POST); exit;
			break;
		case 'addreply':
			
			break;
	}
} else {
	echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;
}