<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /admin/review.php
 * 
 * edit & view Downloads reviews
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

function editreview($review_id = 0) {
	global $downloads_review_handler, $icmsAdminTpl;
	
	$reviewObj = $downloads_review_handler->get($review_id);
	
	if (!$reviewObj->isNew()){
		$reviewObj->hideFieldFromForm(array( 'review_ip', 'review_date', 'review_uid' ) );
		downloads_adminmenu( 4, _MI_DOWNLOADS_MENU_REVIEW  . " > " . _CO_DOWNLOADS_EDIT);
		$sform = $reviewObj->getForm(_CO_DOWNLOADS_EDIT, 'addreview');
		$sform->assign($icmsAdminTpl);
	} else {
		exit;
	}
	$icmsAdminTpl->display('db:downloads_admin.html');
}
 
include_once "admin_header.php";

$clean_review_id = isset($_GET['review_id']) ? (int)$_GET['review_id'] : 0 ;

$downloads_review_handler = icms_getModuleHandler("review", basename(dirname(dirname(__FILE__))), "downloads");

$valid_op = array ('mod', 'del', 'view', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if (in_array($clean_op, $valid_op, TRUE)){
	switch ($clean_op) {
		case 'mod':
			icms_cp_header();
			editreview($clean_review_id);
			break;
		
		case 'del':
			$controller = new icms_ipf_Controller($downloads_review_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$reviewObj = $downloads_review_handler->get($clean_review_id);
			icms_cp_header();
			downloads_adminmenu( 4, _MI_DOWNLOADS_MENU_REVIEW );
			$reviewObj->displaySingleObject();
			break;
		
		default:
			icms_cp_header();
			downloads_adminmenu( 4, _MI_DOWNLOADS_MENU_REVIEW );
			$criteria = '';
			if ($clean_review_id) {
				$reviewObj = $downloads_review_handler->get($clean_review_id);
				if ($reviewObj->id()) {
					$reviewObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create downloads table
			$objectTable = new icms_ipf_view_Table($downloads_review_handler, $criteria);
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_item_id', 'center', 50, 'getReviewItem' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_name', FALSE, FALSE, 'getReviewName' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_email') );
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_message',FALSE, FALSE, 'getReviewMessage'));
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_date', 'center', 50, 'getReviewDate' ) );			
			$icmsAdminTpl->assign( 'downloads_review_table', $objectTable->fetch() );
			$icmsAdminTpl->display( 'db:downloads_admin.html' );
			break;
	}
	icms_cp_footer();
}