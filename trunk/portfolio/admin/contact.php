<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /admin/contact.php
 * 
 * add, edit and delete contact objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

include_once 'admin_header.php';

$valid_op = array ('del', 'view', 'changeNew', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$portfolio_contact_handler = icms_getModuleHandler('contact', basename(dirname(dirname(__FILE__))), 'portfolio');

$clean_contact_id = isset($_GET['contact_id']) ? filter_input(INPUT_GET, 'contact_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_contact_id = ($clean_contact_id == 0 && isset($_POST['contact_id'])) ? filter_input(INPUT_POST, 'contact_id', FILTER_SANITIZE_NUMBER_INT) : $clean_contact_id;

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'del':
			$controller = new icms_ipf_Controller($portfolio_contact_handler);
			$controller->handleObjectDeletion();
			break;
			
		case 'changeNew':
			$visibility = $portfolio_contact_handler -> changeVisible( $clean_contact_id );
			$ret = 'contact.php';
			if ($visibility == 0) {
				redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _CO_PORTFOLIO_CONTACT_UNREAD );
			} else {
				redirect_header( PORTFOLIO_ADMIN_URL . $ret, 2, _CO_PORTFOLIO_CATEGORY_READ );
			}
			break;

		case 'view' :
			icms_cp_header();
			icms::$module->displayAdminMenu( 2, _MI_PORTFOLIO_MENU_CONTACT );
			
			$contactObj = $portfolio_contact_handler->get($clean_contact_id);
			$contactObj->setVar("contact_isnew", 1);
			$contactObj->store(TRUE);
			$contactObj->displaySingleObject();
			break;

		default:
			icms_cp_header();
			icms::$module->displayAdminMenu( 2, _MI_PORTFOLIO_MENU_CONTACT );
			$criteria = '';
			if ($clean_contact_id) {
				$contactObj = $portfolio_contact_handler->get($clean_contact_id);
				if ($contactObj->id()) {
					$contactObj->displaySingleObject();
				}
			}
			if (empty($criteria)) {
				$criteria = null;
			}
			// create contact table
			$objectTable = new icms_ipf_view_Table($portfolio_contact_handler, $criteria, array('delete'));
			$objectTable->addColumn(new icms_ipf_view_Column('contact_isnew', 'center', 50, 'contact_isnew'));
			$objectTable->addColumn( new icms_ipf_view_Column('contact_title', FALSE, FALSE, 'getPreviewItemLink'));
			$objectTable->addColumn( new icms_ipf_view_Column('contact_date', 'center', 75, "getContactDate"));
			$objectTable->addColumn( new icms_ipf_view_Column('contact_name', FALSE, 100));
			$objectTable->addColumn( new icms_ipf_view_Column('contact_email', 'center', 100, 'getContactMail'));
			$objectTable->addColumn( new icms_ipf_view_Column('contact_phone', 'center', 75));
			
			$objectTable->addCustomAction('getViewItemLink');
			
			$icmsAdminTpl->assign('portfolio_contact_table', $objectTable->fetch());
			$icmsAdminTpl->display('db:portfolio_admin.html');
			break;
	}
	include_once 'admin_footer.php';
}