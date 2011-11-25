<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /Download.php
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
 
function editdownload($download_id = 0) {
	global $downloads_download_handler, $icmsTpl, $downloadsConfig;
	
	if (!$downloadObj->isNew()){
		$downloadObj->hideFieldFromForm(array('download_updated', 'download_broken','download_mirror_approve', 'meta_description', 'meta_keywords', 'download_updated', 'download_publisher', 'download_submitter', 'download_approve', 'download_published_date', 'download_updated_date' ) );
		$downloadObj->setVar( 'download_updated_date', (time() - 100) );
		$downloadObj->setVar('download_updated', TRUE );
		$sform = $downloadObj->getSecureForm(_MD_DOWNLOADS_DOWNLOAD_EDIT, 'adddownload');
		$sform->assign($icmsTpl, 'downloads_download_form');
		$icmsTpl->assign('downloads_cat_path', $downloadObj->getVar('download_title') . ' > ' . _EDIT);
	} else {
		redirect_header (DOWNLOADS_URL, 3, _NO_PERM);
	}
}

include_once "header.php";

$xoopsOption["template_main"] = "downloads_singledownload.html";
include_once ICMS_ROOT_PATH . "/header.php";

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

$valid_op = array ('getFile', 'changeField', 'adddownload', '');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');


$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(__FILE__)), "downloads");

$downloadObj = $downloads_download_handler->get($clean_download_id);

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case('getFile'):
			
			if((strpos($_SERVER['HTTP_REFERER'], ICMS_URL) !== FALSE) && (strpos($_SERVER['HTTP_REFERER'], DOWNLOADS_URL . '/ajax.php') === TRUE ) ) {
				// @TODO : add download-link
			} else {
				redirect_header (DOWNLOADS_URL . 'download.php', 3, _NO_PERM);
			}
			break;
			
		case('changeField'):
			editdownload($clean_download_id);
			break;
		case('adddownload'):
			if (!icms::$security->check()) {
				redirect_header('index.php', 3, _MD_DOWNLOADS_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
			}
			$controller = new icms_ipf_Controller($downloads_download_handler);
			$controller->storeFromDefaultForm(_MD_DOWNLOADS_DOWNLOAD_CREATED, _MD_DOWNLOADS_DOWNLOAD_MODIFIED);
			break;
		default:
			if($downloadObj && !$downloadObj->isNew() && $downloadObj->accessGranted()) {
				$file = $downloadObj->toArray();
				
				$icmsTpl->assign("file", $file);
	
				$icmsTpl->assign("broken_link", DOWNLOADS_URL . "ajax.php?op=report_broken&download_id=" . $downloadObj->id() );
	
				if($downloadsConfig['use_mirror'] == 1) {
					$icmsTpl->assign('show_mirror', true);
				} else {
					$icmsTpl->assign('show_mirror', false);
				}
				if($downloadsConfig['downloads_show_down_disclaimer'] == 1) {
					$icmsTpl->assign('show_down_disclaimer', $downloadsConfig['downloads_show_down_disclaimer'] );
					$icmsTpl->assign('down_disclaimer', $downloadsConfig['downloads_down_disclaimer']);
				} else {
					$icmsTpl->assign('show_down_disclaimer', false);
				}
				$albumModule = icms_getModuleInfo('album');
				if ($downloadsConfig['use_album'] == 1 && $albumModule){
					$icmsTpl->assign('album_module', true);
				} else {
					$icmsTpl->assign('album_module', false );
				}
				$icms_metagen = new icms_ipf_Metagen($downloadObj->getVar("download_title"), $downloadObj->getVar("meta_keywords", "n"), $downloadObj->getVar("meta_description", "n"));
				$icms_metagen->createMetaTags();
			} else {
				redirect_header (DOWNLOADS_URL, 3, _NO_PERM);
			}
			$icmsTpl->assign('downloads_show_breadcrumb', $downloadsConfig['show_breadcrumbs'] == true);
	}
}

include_once "footer.php";