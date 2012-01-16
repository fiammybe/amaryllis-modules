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
	
	$valid_op = array ('del', 'view', '');
	
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
				$objectTable = new icms_ipf_view_Table($career_message_handler, $criteria, array());
				$objectTable->isForUserSide();
				$objectTable->addColumn( new icms_ipf_view_Column('message_title', FALSE, FALSE, 'getPreviewItemLink'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_date', 'center', 100, "getMessageDate"));
				$objectTable->addColumn( new icms_ipf_view_Column('message_submitter', 'center', TRUE, 'getMessageSubmitter'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_email', 'center', TRUE, 'getMessageMail'));
				$objectTable->addColumn( new icms_ipf_view_Column('message_phone', 'center', TRUE));
				$objectTable->addColumn( new icms_ipf_view_Column('message_file', 'center', TRUE, 'getMessageFile'));
				
				$icmsTpl->assign('career_message_table', $objectTable->fetch());
				break;
		}
	}
}
include_once 'footer.php';