<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/message.php
 *
 * List and delete album message objects
 *
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: message.php 677 2012-07-05 18:10:29Z st.flohrer $
 * @package		album
 *
 */

include_once 'admin_header.php';
/**
 * define a whitelist of valid op's
 */
$valid_op = array ('del', 'changeApprove', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$album_message_handler = icms_getModuleHandler("message", ALBUM_DIRNAME, "album");
$clean_message_id = isset($_GET['message_id']) ? filter_input(INPUT_GET, 'message_id', FILTER_SANITIZE_NUMBER_INT) : 0 ;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'del':
			$controller = new icms_ipf_Controller($album_message_handler);
			$controller->handleObjectDeletion();
			break;
			
		case 'changeApprove':
			$visibility = $album_message_handler -> changeApprove( $clean_message_id );
			$ret = 'message.php';
			if ($visibility == 0) {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _CO_ALBUM_MESSAGE_MESSAGE_DENIED );
			} else {
				redirect_header( ALBUM_ADMIN_URL . $ret, 2, _CO_ALBUM_MESSAGE_MESSAGE_APPROVED );
			}
			break;
		
		default:
			icms_cp_header();
			icms::$module->displayAdminmenu( 3, _MI_ALBUM_MENU_ALBUM );
			$criteria = '';
			if ($clean_message_id) {
				$messageObj = $album_message_handler->get($clean_message_id);
				if ($messageObj->id()) {
					$messageObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create album table
			$objectTable = new icms_ipf_view_Table($album_message_handler, $criteria, array('delete'));
			$objectTable->addColumn(new icms_ipf_view_Column('message_approve', 'center', 50, 'message_approve'));
			$objectTable->addColumn(new icms_ipf_view_Column('message_item', FALSE, 100, 'getItem'));
			$objectTable->addColumn(new icms_ipf_view_Column('message_uid', 'center', 50, 'getPublisher'));
			$objectTable->addColumn(new icms_ipf_view_Column('message_body', FALSE, FALSE, 'getBodyTeaser'));
			$objectTable->addColumn(new icms_ipf_view_Column('message_date', 'center', 50, 'getPublishedDate'));
			$objectTable->setDefaultOrder("DESC");
			$objectTable->setDefaultSort("message_date");
			$objectTable->addFilter('message_approve', 'message_approve_filter');
			$objectTable->addFilter('message_item', 'getImageFilter');

			$icmsAdminTpl->assign('album_message_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:album_admin.html');
			break;
	}
	include_once 'admin_footer.php';
}