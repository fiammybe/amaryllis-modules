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

include_once 'admin_header.php';

$valid_op = array ('del', 'view', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$career_message_handler = icms_getModuleHandler('message', basename(dirname(dirname(__FILE__))), 'career');

$clean_message_id = isset($_GET['message_id']) ? filter_input(INPUT_GET, 'message_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_message_id = ($clean_message_id == 0 && isset($_POST['message_id'])) ? filter_input(INPUT_POST, 'message_id', FILTER_SANITIZE_NUMBER_INT) : $clean_message_id;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'del':
			$controller = new icms_ipf_Controller($career_message_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view' :
			$messageObj = $career_message_handler->get($clean_message_id);
			icms_cp_header();
			career_adminmenu( 2, _MI_CAREER_MENU_MESSAGE );
			$messageObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			career_adminmenu( 2, _MI_CAREER_MENU_MESSAGE );
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
			$objectTable->addColumn( new icms_ipf_view_Column('message_title', FALSE, FALSE, 'getPreviewItemLink'));
			$objectTable->addColumn(new icms_ipf_view_Column("message_cid", FALSE, FALSE, 'getMessageCid'));
			$objectTable->addColumn(new icms_ipf_view_Column("message_did", FALSE, FALSE, 'getMessageDepartment'));
			$objectTable->addColumn( new icms_ipf_view_Column('message_date', 'center', 100, "getMessageDate"));
			$objectTable->addColumn( new icms_ipf_view_Column('message_submitter', 'center', TRUE, 'getMessageSubmitter'));
			$objectTable->addColumn( new icms_ipf_view_Column('message_email', 'center', TRUE, 'getMessageMail'));
			$objectTable->addColumn( new icms_ipf_view_Column('message_phone', 'center', TRUE));
			
			$objectTable->addFilter('message_cid', 'getCareers');
			$objectTable->addFilter('message_did', 'getDepartments');
			
			$objectTable->addCustomAction('getViewItemLink');
			
			$icmsAdminTpl->assign('career_message_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:career_admin.html');
			break;
	}
	icms_cp_footer();
}