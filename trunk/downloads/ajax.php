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

$valid_op = array ('report_broken', 'getFile', 'getFileMirror', 'addreview','addtags' , 'vote_down', 'vote_up');
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
			$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
			$logObj->store(TRUE);
			
			$down_counter = $downloadObj->getVar("download_downcounter", "e");
			$downloadObj->setVar("download_downcounter", ((int)($down_counter) + 1));
			$downloadObj->store(TRUE);
			
			if((strpos(xoops_getenv('HTTP_REFERER'), ICMS_URL) !== FALSE) ) {
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
			$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
			$logObj->store(TRUE);
			
			$down_counter = $downloadObj->getVar("download_downcounter", "e");
			$downloadObj->setVar("download_downcounter", ((int)($down_counter) + 1));
			$downloadObj->store(TRUE);
			
			if((strpos(xoops_getenv('HTTP_REFERER'), ICMS_URL) !== FALSE) ) {
				return redirect_header (DOWNLOADS_URL . 'singledownload.php?op=downfileMirror&amp;download_id=' . $download_id, 3, _MD_DOWNLOADS_DOWNLOAD_START);
			} else {
				return redirect_header (DOWNLOADS_URL . 'singledownload.php?download_id=' . $download_id, 3, _NO_PERM);
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
			if(is_object(icms::$user)){
				$review_uid = icms::$user->getVar("uid");
			} else {
				$review_uid = 0;
			}
			if($reviewObj->isNew() ) {
				$reviewObj->setVar('review_uid', $review_uid);
				$reviewObj->setVar('review_item_id', $download_id );
				$reviewObj->setVar('review_date', (time()-200) );
				$reviewObj->setVar('review_ip', xoops_getenv('REMOTE_ADDR') );
				if (!icms::$security->check()) {
					redirect_header('singledownload.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
				$downloadObj->sendDownloadNotification('review_submitted');
				$controller = new icms_ipf_Controller($downloads_review_handler);
				$controller->storeFromDefaultForm(_THANKS_SUBMISSION_REV, _THANKS_SUBMISSION_REV, DOWNLOADS_URL . 'singledownload.php?download_id=' . $download_id);
				return redirect_header (DOWNLOADS_URL . 'singledownload.php?download_id=' . $download_id, 3, _THANKS_SUBMISSION);
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
			}
			break;
		
		case 'addtags':
			global $downloadsConfig;
			$download_id = (int)filter_input(INPUT_GET, 'download_id');
			if ($download_id <= 0) return FALSE;
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(__FILE__)),'downloads');
			$downloadObj = $downloads_download_handler->get($download_id);
			if ($downloadObj->isNew()) return FALSE;
			$downloadsModule = icms_getModuleInfo("downloads");
			$downloads_modid = $downloadsModule->getVar("mid");
			$clean_tag_id = isset($_GET['tag_id']) ? filter_input(INPUT_GET, 'tag_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$sprocketsModule = icms::handler('icms_module')->getByDirname("sprockets");
			$sprockets_tag_handler = icms_getModuleHandler("tag", $sprocketsModule->getVar("dirname"), "sprockets");
			$tagObj = $sprockets_tag_handler->get($clean_tag_id);
			if($tagObj->isNew() ) {
				$tagObj->setVar('label_type', 0);
				$tagObj->setVar('navigation_element', 0);
				
				$sprockets_taglink_handler = icms_getModuleHandler('taglink', $sprocketsModule->getVar("dirname"),'sprockets');
				$taglinkObj = $sprockets_taglink_handler->create();
				$tagObjects = $sprockets_tag_handler->getCount(FALSE);
				$tag_id = (int)($tagObjects) + 1;
				$taglinkObj->setVar('tid', $tag_id );
				$taglinkObj->setVar('mid', $downloads_modid );
				$taglinkObj->setVar('item', $downloadObj->getVar("download_title"));
				$taglinkObj->setVar('iid', $download_id);
				$taglinkObj->store(TRUE);
				
				$mytags = $downloadObj->getVar("download_tags", "s");
				$newtag = $tag_id;
				$merge = array_merge($mytags, array($tag_id));
				$downloadObj->setVar("download_tags", $merge);
				$downloadObj->store(TRUE);
				
				if (!icms::$security->check()) {
					redirect_header('singledownload.php?download_id=' . $download_id, 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
				$controller = new icms_ipf_Controller($sprockets_tag_handler);
				$controller->storeFromDefaultForm(_THANKS_SUBMISSION_TAG, _THANKS_SUBMISSION_TAG, DOWNLOADS_URL . 'singledownload.php?download_id=' . $download_id);
				return redirect_header (DOWNLOADS_URL . 'singledownload.php?download_id=' . $download_id, 3, _THANKS_SUBMISSION);
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
			}
			break;
			
		case 'vote_up':
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(__FILE__)),'downloads');
			$downloads_log_handler = icms_getModuleHandler('log', basename(dirname(__FILE__)),'downloads');
			$download_id = (int)filter_input(INPUT_POST, 'download_id');
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item("log_item_id", $download_id));
			$criteria->add(new icms_db_criteria_Item("log_item", 0));
			$criteria->add(new icms_db_criteria_Item("log_ip", xoops_getenv('REMOTE_ADDR')));
			$crit = new icms_db_criteria_Compo();
			$crit->add(new icms_db_criteria_Item("log_case", 5), "OR");
			$crit->add(new icms_db_criteria_Item("log_case", 6), "OR");
			$criteria->add($crit);
			$count= $downloads_log_handler->getCount($criteria);
			if($count == 0){
				if(is_object(icms::$user)){
					$log_uid = icms::$user->getVar("uid");
				} else {
					$log_uid = 0;
				}
				$logObj = $downloads_log_handler->create();
				$logObj->setVar('log_item_id', $download_id );
				$logObj->setVar('log_date', (time()-200) );
				$logObj->setVar('log_uid', $log_uid);
				$logObj->setVar('log_item', 0 );
				$logObj->setVar('log_case', 5 );
				$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
				$logObj->store(TRUE);
				
				$downloadObj = $downloads_download_handler->get($download_id);
				if ($downloadObj->isNew()) return FALSE;
				$like = $downloadObj->getVar("download_like");
				$downloadObj->setVar('download_like', ((int)($like) + 1));
				$downloadObj->store(TRUE);
				return redirect_header(icms_getPreviousPage(), 3, _MD_DOWNLOADS_THANKS_VOTING);
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _MD_DOWNLOADS_ALLREADY_VOTED);
			}
			break;
			
		case 'vote_down':
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(__FILE__)),'downloads');
			$downloads_log_handler = icms_getModuleHandler('log', basename(dirname(__FILE__)),'downloads');
			$download_id = (int)filter_input(INPUT_POST, 'download_id');
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item("log_item_id", $download_id));
			$criteria->add(new icms_db_criteria_Item("log_item", 0));
			$criteria->add(new icms_db_criteria_Item("log_ip", xoops_getenv('REMOTE_ADDR')));
			$crit = new icms_db_criteria_Compo();
			$crit->add(new icms_db_criteria_Item("log_case", 5), "OR");
			$crit->add(new icms_db_criteria_Item("log_case", 6), "OR");
			$criteria->add($crit);
			$count= $downloads_log_handler->getcount($criteria);
			if($count == 0){
				if(is_object(icms::$user)){
					$log_uid = icms::$user->getVar("uid");
				} else {
					$log_uid = 0;
				}
				$logObj = $downloads_log_handler->create();
				$logObj->setVar('log_item_id', $download_id );
				$logObj->setVar('log_date', (time()-200) );
				$logObj->setVar('log_uid', $log_uid);
				$logObj->setVar('log_item', 0 );
				$logObj->setVar('log_case', 6 );
				$logObj->setVar('log_ip', xoops_getenv('REMOTE_ADDR') );
				$logObj->store(TRUE);
				
				$downloadObj = $downloads_download_handler->get($download_id);
				if ($downloadObj->isNew()) return FALSE;
				$dislike = $downloadObj->getVar("download_dislike");
				$downloadObj->setVar('download_dislike', $dislike + 1);
				$downloadObj->store(TRUE);
				return redirect_header(icms_getPreviousPage(), 3, _MD_DOWNLOADS_THANKS_VOTING);
			} else {
				return redirect_header(icms_getPreviousPage(), 3, _MD_DOWNLOADS_ALLREADY_VOTED);
			}
			break;
	}
} else {
	return redirect_header(icms_getPreviousPage(), 3, _NO_PERM);
}