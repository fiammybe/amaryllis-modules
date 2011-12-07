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

include_once "admin_header.php";

$clean_review_id = isset($_GET['review_id']) ? (int)$_GET['review_id'] : 0 ;

$downloads_review_handler = icms_getModuleHandler("review", basename(dirname(dirname(__FILE__))), "downloads");

$valid_op = array ('del', 'view', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

if (in_array($clean_op, $valid_op, TRUE)){
	switch ($clean_op) {
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
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_item_id', 'center', 50, 'review_item_id' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_name', FALSE, FALSE, 'getReviewName' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_email', FALSE, FALSE, 'getReviewEmail' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_message',FALSE, FALSE, 'getReviewMessage'));
			$objectTable->addColumn( new icms_ipf_view_Column( 'review_date', 'center', 50, 'getReviewDate' ) );			
			$icmsAdminTpl->assign( 'downloads_review_table', $objectTable->fetch() );
			$icmsAdminTpl->display( 'db:downloads_admin.html' );
			break;
	}
	icms_cp_footer();
}