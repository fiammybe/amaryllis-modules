<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /admin/message.php
 * 
 * add, edit and delete message objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'career_message.html';

include_once ICMS_ROOT_PATH . '/header.php';

if(!$career_isAdmin) {
	redirect_header(CAREER_URL . 'index.php', 3, _NO_PERM);
} else {
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$clean_index_key = isset($_GET['index_id']) ? filter_input(INPUT_GET, 'index_id', FILTER_SANITIZE_NUMBER_INT) : 1;
	$career_indexpage_handler = icms_getModuleHandler( "indexpage", icms::$module -> getVar( 'dirname' ), "career" );
	
	$indexpageObj = $career_indexpage_handler->get($clean_index_key);
	$index = $indexpageObj->toArray();
	$icmsTpl->assign('career_index', $index);
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$valid_op = array ('del', 'view', 'changeApprove','changeFavorite', '');
	
	$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
	if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');
	
	$career_message_handler = icms_getModuleHandler("message", basename(dirname(__FILE__)), "career");
	
	$clean_message_id = isset($_GET['message_id']) ? filter_input(INPUT_GET, 'message_id', FILTER_SANITIZE_NUMBER_INT) : 0;
	$clean_message_id = ($clean_message_id == 0 && isset($_POST['message_id'])) ? filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT) : $clean_message_id;
	
	if (in_array($clean_op, $valid_op, TRUE)) {
		switch ($clean_op) {
			case 'del':
				$controller = new icms_ipf_Controller($career_message_handler);
				$controller->handleObjectDeletionFromUserside();
				break;
	
			case 'view' :
				$messageObj = $career_message_handler->get($clean_message_id);
				$message = $messageObj->toArray();
				$icmsTpl->assign("message", $message);
				
				/**
				 * include the comment rules
				 */
				if ($downloadsConfig['com_rule']) {
					$icmsTpl->assign('career_message_comment', TRUE);
					include_once ICMS_ROOT_PATH . '/include/comment_view.php';
				}
				
				/**
				 * check, if breadcrumb should be displayed
				 */
				if ($careerConfig['show_breadcrumbs'] == 1){
					$icmsTpl->assign('career_cat_path', _MD_CAREER_MESSAGES_BC . "&nbsp;:&nbsp;" . $messageObj->getVar("message_title"));
				}else{
					$icmsTpl->assign('career_cat_path',FALSE);
				}
				break;
			
			case 'changeApprove':
				$visibility = $career_message_handler->changeVisible($clean_message_id);
				$ret = 'message.php';
				if ($visibility == 0) {
					redirect_header( CAREER_URL . $ret, 2, _CO_CAREER_MESSAGE_REJECTED);
				} else {
					redirect_header( CAREER_URL . $ret, 2, _CO_CAREER_MESSAGE_POSSIBLE);
				}
				break;
			
			case 'changeFavorite':
				$visibility = $career_message_handler->changeFavorite($clean_message_id);
				$ret = 'message.php';
				if ($visibility == 0) {
					redirect_header( CAREER_URL . $ret, 2, _CO_CAREER_MESSAGE_NEUTRAL);
				} else {
					redirect_header( CAREER_URL . $ret, 2, _CO_CAREER_MESSAGE_FAVORITE);
				}
				break;
				
			default:
				$criteria = '';
				if ($clean_message_id) {
					$messageObj = $career_message_handler->get($clean_message_id);
					if ($messageObj->id()) {
						$messageObj->displaySingleObject();
					}
				}
				if (empty($criteria)) {
					$criteria = null;
				}
				// create message table
				$objectTable = new icms_ipf_view_Table($career_message_handler, $criteria, array('delete'));
				$objectTable->isForUserSide();
				$objectTable->addColumn( new icms_ipf_view_Column('message_approve', 'center', FALSE, 'message_approve_userside'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_favorite', 'center', FALSE, 'message_favorite_userside'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_title', FALSE, FALSE, 'getPreviewItemLink'));
				$objectTable->addColumn(new icms_ipf_view_Column("message_cid", FALSE, FALSE, 'getMessageCid'));
				$objectTable->addColumn(new icms_ipf_view_Column("message_did", FALSE, FALSE, 'getMessageDepartment'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_date', 'center', 100, "getMessageDate"));
				$objectTable->addColumn( new icms_ipf_view_Column('message_submitter', 'center', TRUE, 'getMessageSubmitter'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_email', 'center', TRUE, 'getMessageMail'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_phone', 'center', TRUE));
				
				$objectTable->addFilter('message_cid', 'getCareers');
				$objectTable->addFilter('message_did', 'getDepartments');
				$objectTable->addFilter('message_approve', 'message_approve_filter');
				$objectTable->addFilter('message_favorite', 'message_favorite_filter');
				
				$icmsTpl->assign('career_message_table', $objectTable->fetch());
				
				/**
				 * check, if breadcrumb should be displayed
				 */
				if ($careerConfig['show_breadcrumbs'] == 1){
					$icmsTpl->assign('career_cat_path', _MD_CAREER_MESSAGES_BC);
				}else{
					$icmsTpl->assign('career_cat_path',FALSE);
				}
				break;
		}
	}
}
if( $careerConfig['show_breadcrumbs'] == TRUE ) {
	$icmsTpl->assign('career_show_breadcrumb', TRUE);
} else {
	$icmsTpl->assign('career_show_breadcrumb', FALSE);
}
include_once 'footer.php';