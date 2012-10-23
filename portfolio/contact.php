<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /contact.php
 * 
 * display contacts
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

include_once 'header.php';

$xoopsOption['template_main'] = 'portfolio_contact.html';

include_once ICMS_ROOT_PATH . '/header.php';

if(!$portfolio_isAdmin) {
	redirect_header(PORTFOLIO_URL . 'index.php', 3, _NOPERM);
} else {
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$portfolio_indexpage_handler = icms_getModuleHandler( "indexpage", icms::$module -> getVar( 'dirname' ), "portfolio" );
	$indexpageObj = $portfolio_indexpage_handler->get(1);
	$index = $indexpageObj->toArray();
	$icmsTpl->assign('portfolio_index', $index);
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$valid_op = array ('del', 'view','changeNew', '');
	
	$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
	$clean_op = (isset($_POST['op'])) ? filter_input(INPUT_POST, 'op') : $clean_op;
	
	$portfolio_contact_handler = icms_getModuleHandler("contact", PORTFOLIO_DIRNAME, "portfolio");
	
	$clean_contact_id = isset($_GET['contact_id']) ? filter_input(INPUT_GET, 'contact_id', FILTER_SANITIZE_NUMBER_INT) : 0;
	$clean_contact_id = ($clean_contact_id == 0 && isset($_POST['contact_id'])) ? filter_input(INPUT_POST, 'contact_id', FILTER_SANITIZE_NUMBER_INT) : $clean_contact_id;
	
	if (in_array($clean_op, $valid_op, TRUE)) {
		switch ($clean_op) {
			case 'del':
				$controller = new icms_ipf_Controller($portfolio_contact_handler);
				$controller->handleObjectDeletionFromUserside();
				break;
				
			case 'changeNew':
				$visibility = $portfolio_contact_handler -> changeNew( $clean_contact_id );
				$ret = 'contact.php';
				if ($visibility == 0) {
					redirect_header( PORTFOLIO_URL . $ret, 2, _CO_PORTFOLIO_CONTACT_UNREAD );
				} else {
					redirect_header( PORTFOLIO_URL . $ret, 2, _CO_PORTFOLIO_CONTACT_READ );
				}
				break;
	
			case 'view' :
				$contactObj = $portfolio_contact_handler->get($clean_contact_id);
				$contactObj->setVar("contact_isnew", 1);
				$contactObj->store(TRUE);
				$contact = $contactObj->toArray();
				$icmsTpl->assign("contact", $contact);
				
				/**
				 * include the comment rules
				 */
				if ($portfolioConfig['com_rule']) {
					$icmsTpl->assign('portfolio_contact_comment', TRUE);
					include_once ICMS_ROOT_PATH . '/include/comment_view.php';
				}
				
				/**
				 * check, if breadcrumb should be displayed
				 */
				$path = "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/contact.php'>" ._MD_PORTFOLIO_CONTACTS_BC . "</a>";
				if ($portfolioConfig['show_breadcrumbs'] == 1){
					$icmsTpl->assign('portfolio_cat_path', $path . "&nbsp;:&nbsp;" . $contactObj->getVar("contact_title"));
				}else{
					$icmsTpl->assign('portfolio_cat_path',FALSE);
				}
				break;
			
			default:
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
				$objectTable->isForUserSide();
				$objectTable->addColumn(new icms_ipf_view_Column('contact_isnew', 'center', 50, 'contact_isnew_userside'));
				$objectTable->addColumn( new icms_ipf_view_Column('contact_title', FALSE, 150, 'getPreviewItemLink'));
				$objectTable->addColumn( new icms_ipf_view_Column('contact_date', 'center', 50, 'getContactDate'));
				
				$objectTable->setDefaultOrder("DESC");
				$objectTable->setDefaultSort("contact_date");
				
				$icmsTpl->assign('portfolio_contact_table', $objectTable->fetch());
				
				/**
				 * check, if breadcrumb should be displayed
				 */
				$path = "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/contact.php'>" ._MD_PORTFOLIO_CONTACTS_BC . "</a>";
				if ($portfolioConfig['show_breadcrumbs'] == 1){
					$icmsTpl->assign('portfolio_cat_path', $path);
				}else{
					$icmsTpl->assign('portfolio_cat_path',FALSE);
				}
				break;
		}
	}
}
include_once 'footer.php';