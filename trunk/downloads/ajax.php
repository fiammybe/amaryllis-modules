<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /ajax.php
 * 
 * managing ajax requests in frontend
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';

$valid_op = array ('report_broken', 'getFile', 'getFileMirror', 'addreview');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'report_broken':
			$download_id = (int)filter_input(INPUT_GET, 'download_id');
			if ($download_id <= 0) return FALSE;
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(__FILE__)),'downloads');
			$downloadObj = $downloads_download_handler->get($download_id);
			if ($downloadObj->isNew()) return FALSE;
			$downloadObj->setVar('download_broken', TRUE);
			$downloadObj->store(TRUE);
			return redirect_header(icms_getPreviousPage(), 3, _MD_DOWNLOADS_BROKEN_REPORTED);
			break;
	
		case 'getFile':
			$download_id = (int)filter_input(INPUT_GET, 'download_id');
			if ($download_id <= 0) return FALSE;
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(__FILE__)),'downloads');
			$downloadObj = $downloads_download_handler->get($download_id);
			if ($downloadObj->isNew()) return FALSE;
			if (!is_object(icms::$user)) {
				$log_uid = 0;
			} else {
				$log_uid = icms::$user->getVar("uid");
			}
			$downloads_log_handler = icms_getModuleHandler('log', basename(dirname(__FILE__)),'downloads');
			$logObj = $downloads_log_handler->create();
			$logObj->setVar('log_item_id', $download_id );
			$logObj->setVar('log_date', (time()-200) );
			$logObj->setVar('log_uid', $log_uid);
			$logObj->setVar('log_item', 0 );
			$logObj->setVar('log_case', 0 );
			$logObj->setVar('log_ip', $_SERVER['REMOTE_ADDR'] );
			$logObj->store(TRUE);
			
			if((strpos($_SERVER['HTTP_REFERER'], ICMS_URL) !== FALSE) ) {
				return redirect_header (DOWNLOADS_URL . 'singledownload.php?op=downfile&amp;download_id=' . $download_id, 3, _MD_DOWNLOADS_DOWNLOAD_START);
			} else {
				return redirect_header (DOWNLOADS_URL . 'singledownload.php', 3, _NO_PERM);
			}
			break;
			
		case 'getFileMirror':
			$download_id = (int)filter_input(INPUT_GET, 'download_id');
			if ($download_id <= 0) return FALSE;
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(__FILE__)),'downloads');
			$downloadObj = $downloads_download_handler->get($download_id);
			if ($downloadObj->isNew()) return FALSE;
			if (!is_object(icms::$user)) {
				$log_uid = 0;
			} else {
				$log_uid = icms::$user->getVar("uid");
			}
			$downloads_log_handler = icms_getModuleHandler('log', basename(dirname(__FILE__)),'downloads');
			$logObj = $downloads_log_handler->create();
			$logObj->setVar('log_item_id', $download_id );
			$logObj->setVar('log_date', (time()-200) );
			$logObj->setVar('log_uid', $log_uid);
			$logObj->setVar('log_item', 0 );
			$logObj->setVar('log_case', 4 );
			$logObj->setVar('log_ip', $_SERVER['REMOTE_ADDR'] );
			$logObj->store(TRUE);
			
			if((strpos($_SERVER['HTTP_REFERER'], ICMS_URL) !== FALSE) ) {
				return redirect_header (DOWNLOADS_URL . 'singledownload.php?op=downfileMirror&amp;download_id=' . $download_id, 3, _MD_DOWNLOADS_DOWNLOAD_START);
			} else {
				return redirect_header (DOWNLOADS_URL . 'singledownload.php', 3, _NO_PERM);
			}
			break;
			
		case 'addreview':
			global $downloadsConfig;
			$download_id = (int)filter_input(INPUT_GET, 'download_id');
			if ($download_id <= 0) return FALSE;
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(__FILE__)),'downloads');
			$downloadObj = $downloads_download_handler->get($download_id);
			if ($downloadObj->isNew()) return FALSE;
			$clean_review_id = isset($_GET['review_id']) ? filter_input(INPUT_GET, 'review_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$downloads_review_handler = icms_getModuleHandler("review", basename(dirname(__FILE__)), "downloads");
			$reviewObj = $downloads_review_handler->get($clean_review_id);
			if($reviewObj->isNew() ) {
				$reviewObj->setVar('review_uid', icms::$user->getVar("uid"));
				$reviewObj->setVar('review_item_id', $download_id );
				$reviewObj->setVar('review_date', (time()-200) );
				$reviewObj->setVar('review_ip', $_SERVER['REMOTE_ADDR'] );
				if (!icms::$security->check()) {
					redirect_header('singledownload.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
				$controller = new icms_ipf_Controller($downloads_review_handler);
				$controller->storeFromDefaultForm(_MD_DOWNLOADS_REVIEW_SUBMITTED, _MD_DOWNLOADS_REVIEW_SUBMITTED);
				return redirect_header(DOWNLOADS_URL . 'singledownload.php?download_id=' . $download_id, 3, _THANKS_SUBMISSION);
			} else {
				redirect_header(DOWNLOADS_URL, 3, _NO_PERM);
			}
			break;
	}
}