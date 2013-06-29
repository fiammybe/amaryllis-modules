<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /submit.php
 *
 * submit entries
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
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
	$visitorvoice_handler = icms_getModuleHandler("visitorvoice", basename(dirname(__FILE__)), "visitorvoice");
	switch ($clean_op) {
		case 'addentry':
			global $visitorvoiceConfig;
			$visitorvoice_pid = isset($_POST['visitorvoice_pid']) ? filter_input(INPUT_POST, 'visitorvoice_pid', FILTER_SANITIZE_NUMBER_INT) : 0;
			$uid = is_object(icms::$user) ? icms::$user->getVar("uid") : 0;
			if($visitorvoice_pid != 0 && !$visitorvoice_handler->canModerate()) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			//$captcha = icms_form_elements_captcha_Object::instance();
			//if(!$captcha->verify(TRUE)) {echo json_encode(array("status" => "error", "message" => "Verification Failed"));unset($_POST); exit;}

			$val = "";
			if(isset($_POST['xoops_upload_file']) && !empty($_FILES) && $visitorvoiceConfig['allow_imageupload'] == 1) {
				$path = ICMS_UPLOAD_PATH.'/'.VISITORVOICE_DIRNAME.'/'.$visitorvoice_handler->_itemname;
				$mimetypes = array("image/jpg", "image/jpeg", "image/gif", "image/png");
				$uploader = new icms_file_MediaUploadHandler($path,$mimetypes, $visitorvoiceConfig['image_file_size'],$visitorvoiceConfig['image_upload_width'], $visitorvoiceConfig['image_upload_height']);
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

			$entry = filter_input(INPUT_POST, "visitorvoice_entry");
			$entry = strip_tags(icms_core_DataFilter::undoHtmlSpecialChars($entry),'<b><i><a><br>');

			$visitorvoiceObj = $visitorvoice_handler->create(TRUE);
			$visitorvoiceObj->setVar("visitorvoice_title", StopXSS(filter_input(INPUT_POST, "visitorvoice_title", FILTER_SANITIZE_STRING)));
			$visitorvoiceObj->setVar("visitorvoice_name", StopXSS(filter_input(INPUT_POST, "visitorvoice_name", FILTER_SANITIZE_STRING)));
			$visitorvoiceObj->setVar("visitorvoice_email", filter_input(INPUT_POST, "visitorvoice_email", FILTER_VALIDATE_EMAIL));
			$visitorvoiceObj->setVar("visitorvoice_url", filter_input(INPUT_POST, "visitorvoice_url"));
			$visitorvoiceObj->setVar("visitorvoice_entry", $entry);
			$visitorvoiceObj->setVar("visitorvoice_pid", $visitorvoice_pid);
			$visitorvoiceObj->setVar("visitorvoice_ip", getenv('REMOTE_ADDR'));
			$visitorvoiceObj->setVar("visitorvoice_fprint", $_SESSION['icms_fprint']);
			$visitorvoiceObj->setVar("visitorvoice_published_date", time());
			$visitorvoiceObj->setVar("visitorvoice_image", $val);
			$visitorvoiceObj->setVar("visitorvoice_uid", $uid);
			if($visitorvoiceConfig["needs_approval"] == 1) {
				$visitorvoiceObj->setVar("visitorvoice_approve", icms_userIsAdmin(VISITORVOICE_DIRNAME) ? TRUE : FALSE);
			} else {
				$visitorvoiceObj->setVar("visitorvoice_approve", TRUE);
			}
			if(!$visitorvoice_handler->insert($visitorvoiceObj)) {echo json_encode(array("status" => "error", "message" => $visitorvoiceObj->getHtmlErrors())); unset($_POST); exit;}
			$message = ($visitorvoiceConfig["needs_approval"] && !$visitorvoice_isAdmin) ? _THANKS_SUBMISSION_APPROVAL : _THANKS_SUBMISSION;
			echo json_encode(array("status" => "success", "message" => '<p>'.$message.'</p>')); unset($_POST); exit;
			break;
		case 'approve':
			if(!$visitorvoice_isAdmin) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			$visitorvoice_id = isset($_POST['visitorvoice_id']) ? filter_input(INPUT_POST, 'visitorvoice_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			if($visitorvoice_id == 0) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			$obj = $visitorvoice_handler->get($visitorvoice_id);
			if(!is_object($obj) || $obj->isNew()) {echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;}
			$obj->setVar("visitorvoice_approve", TRUE);
			$obj->_updating = TRUE;
			$visitorvoice_handler->insert($obj);
			$obj->sendMessageApproved();
			echo json_encode(array("status" => "success", "message" => '<p>'._CO_ENTRY_HAS_APPROVED.'</p>')); unset($_POST); exit;
			break;
	}
} else {
	echo json_encode(array("status" => "error", "message" => _NOPERM));unset($_POST); exit;
}