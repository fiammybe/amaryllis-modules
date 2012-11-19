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
header("Content-Type: multipart/form-data");
header("Content-Disposition: form-data");
$moddir = basename(dirname(__FILE__));
include_once "../../mainfile.php";
include_once ICMS_ROOT_PATH.'/modules/'.$moddir.'/include/common.php';
icms::$logger->disableLogger();
$valid_op = array ('addentry', 'approve');
$clean_op = (isset($_POST['op'])) ? filter_input(INPUT_POST, "op") : FALSE;
if(!$clean_op) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
if(in_array($clean_op, $valid_op, TRUE)) {
	$guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(__FILE__)), "guestbook");
	switch ($clean_op) {
		case 'addentry':
			global $guestbookConfig;
			$guestbook_pid = isset($_POST['guestbook_pid']) ? filter_input(INPUT_POST, 'guestbook_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			if($guestbook_pid != 0 && !$guestbook_handler->canModerate()) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			//$captcha = icms_form_elements_captcha_Object::instance();
			//if(!$captcha->verify(TRUE)) {echo json_encode(array("status" => "error", "message" => "Verification Failed"));unset($_POST); exit;}
			
			$val = "";
			if(isset($_POST['xoops_upload_file']) && !empty($_FILES) && $guestbookConfig['allow_imageupload'] == 1) {
				$path = ICMS_UPLOAD_PATH.'/'.GUESTBOOK_DIRNAME.'/'.$guestbook_handler->_itemname;
				$mimetypes = array("image/jpg", "image/jpeg", "image/gif", "image/png");
				$uploader = new icms_file_MediaUploadHandler($path,$mimetypes, $guestbookConfig['image_file_size'],$guestbookConfig['image_upload_width'], $guestbookConfig['image_upload_height']);
					if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
						$uploader->setPrefix('img_'.time());
						if ($uploader->upload()) {
							$val = $uploader->getSavedFileName();
						} else {
							echo json_encode(array("status" => "error", "message" => $uploader->getErrors())); unset($_POST); exit;
						}
					} else {
						echo json_encode(array("status" => "error", "message" => $uploader->getErrors())); unset($_POST); exit;
					}
			}
			
			$entry = filter_input(INPUT_POST, "guestbook_entry");
			$entry = strip_tags(icms_core_DataFilter::undoHtmlSpecialChars($entry),'<b><i><a><br>');
			
			$guestbookObj = $guestbook_handler->create(TRUE);
			$guestbookObj->setVar("guestbook_title", filter_input(INPUT_POST, "guestbook_title"));
			$guestbookObj->setVar("guestbook_name", filter_input(INPUT_POST, "guestbook_name"));
			$guestbookObj->setVar("guestbook_email", filter_input(INPUT_POST, "guestbook_email", FILTER_VALIDATE_EMAIL));
			$guestbookObj->setVar("guestbook_url", filter_input(INPUT_POST, "guestbook_url"));
			$guestbookObj->setVar("guestbook_entry", $entry);
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
			$message = ($guestbookConfig["needs_approval"] && !$guestbook_isAdmin) ? _THANKS_SUBMISSION_APPROVAL : _THANKS_SUBMISSION;
			echo json_encode(array("status" => "success", "message" => '<p>'.$message.'</p>')); unset($_POST); exit;
			break;
		case 'approve':
			if(!$guestbook_isAdmin) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			$guestbook_id = isset($_POST['guestbook_id']) ? filter_input(INPUT_POST, 'guestbook_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			if($guestbook_id == 0) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			$obj = $guestbook_handler->get($guestbook_id);
			if(!is_object($obj) || $obj->isNew()) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			$obj->setVar("guestbook_approve", TRUE);
			$obj->_updating = TRUE;
			$guestbook_handler->insert($obj);
			$obj->sendMessageApproved();
			echo json_encode(array("status" => "success", "message" => '<p>'._CO_ENTRY_HAS_APPROVED.'</p>')); unset($_POST); exit;
			break;
	}
} else {
	echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;
}