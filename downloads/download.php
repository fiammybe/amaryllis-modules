<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /download.php
 * 
 * single Downloads download object
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
 
function editdownload($downloadObj) {
	global $downloads_download_handler, $icmsTpl, $downloadsConfig;
	
	if (!$downloadObj->isNew()){
		$downloadObj->hideFieldFromForm(array('download_updated', 'download_broken','download_mirror_approve', 'meta_description', 'meta_keywords', 'download_updated', 'download_publisher', 'download_submitter', 'download_approve', 'download_published_date', 'download_updated_date' ) );
		$downloadObj->setVar( 'download_updated_date', (time() - 100) );
		$downloadObj->setVar('download_updated', TRUE );
		$sform = $downloadObj->getSecureForm(_MD_DOWNLOADS_DOWNLOAD_EDIT, 'adddownload');
		$sform->assign($icmsTpl, 'downloads_download_form');
		$icmsTpl->assign('downloads_cat_path', $downloadObj->getVar('download_title') . ' > ' . _EDIT);
	} else {
		$downloadObj->hideFieldFromForm(array('download_updated', 'download_broken','download_mirror_approve', 'meta_description', 'meta_keywords', 'download_updated', 'download_publisher', 'download_submitter', 'download_approve', 'download_published_date', 'download_updated_date' ) );
		$downloadObj->setVar('download_published_date', (time() - 100) );
		if($downloadsConfig['downloads_needs_approve'] == 1) {
			$downloadObj->setVar('download_approve', FALSE );
		} else {
			$downloadObj->setVar('download_approve', TRUE );
		}
		if($downloadsConfig['mirror_needs_approve'] == 1) {
			$downloadObj->setVar('download_mirror_approve', FALSE );
		} else {
			$downloadObj->setVar('download_mirror_approve', TRUE );
		}
		$downloadObj->setVar('download_submitter', icms::$user->getVar("uid"));
		$downloadObj->setVar('download_publisher', icms::$user->getVar("uid"));
		$sform = $downloadObj->getSecureForm(_MD_DOWNLOADS_DOWNLOAD_CREATE, 'adddownload');
		$sform->assign($icmsTpl, 'downloads_download_form');
		$icmsTpl->assign('downloads_cat_path', _SUBMIT);
	}
} 
 
include_once 'header.php';

$xoopsOption['template_main'] = 'downloads_download.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_index_key = $indexpageObj = $downloads_indexpage_handler = $indexpageObj = '';
$clean_index_key = isset($_GET['index_key']) ? filter_input(INPUT_GET, 'index_key', FILTER_SANITIZE_NUMBER_INT) : 1;
$downloads_indexpage_handler = icms_getModuleHandler( 'indexpage', icms::$module -> getVar( 'dirname' ), 'downloads' );

$indexpageObj = $downloads_indexpage_handler->get($clean_index_key);
$index = $indexpageObj->toArray();
$icmsTpl->assign('downloads_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$clean_download_id = isset($_GET['download_id']) ? filter_input(INPUT_GET, 'download_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$valid_op = array ('mod', 'adddownload', 'del');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');


$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case('mod'):
			$downloadObj = $downloads_download_handler->get($clean_download_id);
			if ($clean_download_id > 0 && $downloadObj->isNew()) {
				redirect_header(DOWNLOADS_URL, 3, _NOPERM);
			}
			editdownload($downloadObj);
			break;
		
		case('adddownload'):
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($downloads_download_handler);
			$controller->storeFromDefaultForm(_MD_DOWNLOADS_DOWNLOAD_CREATED, _MD_DOWNLOADS_DOWNLOAD_MODIFIED);
			break;
		case('del'):
			if (!$downloadObj->userCanEditAndDelete()) {
				redirect_header($categoryObj->getItemLink(true), 3, _NOPERM);
			}
			if (isset($_POST['confirm'])) {
				if (!icms::$security->check()) {
					redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
			}
			$controller = new icms_ipf_Controller($downloads_download_handler);
			$controller->handleObjectDeletionFromUserSide();
			$icmsTpl->assign('downloads_cat_path', $downloads_download_handler->getBreadcrumbForPid($downloadObj->getVar('category_id', 'e'), 1) . ' > ' . _DELETE);
			break;
	}
} else {
	redirect_header(DOWNLOADS_URL, 3, _NOPERM);
}

if( $downloadsConfig['show_breadcrumbs'] == true ) {
	$icmsTpl->assign('downloads_show_breadcrumb', true);
} else {
	$icmsTpl->assign('downloads_show_breadcrumb', false);
}

include_once "footer.php";