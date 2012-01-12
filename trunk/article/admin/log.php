<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/log.php
 * 
 * Log of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

include_once "admin_header.php";

$valid_op = array ('del', 'view', '');
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';

$clean_log_id = isset($_GET['log_id']) ? filter_input(INPUT_GET, 'log_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$article_log_handler = icms_getModuleHandler("log", basename(dirname(dirname(__FILE__))), "article");

if (in_array($clean_op, $valid_op, TRUE)){
	switch ($clean_op) {
		case 'del':
			$controller = new icms_ipf_Controller($article_log_handler);
			$controller->handleObjectDeletion();
			break;

		case 'view':
			$logObj = $article_log_handler->get($clean_log_id);
			icms_cp_header();
			downloads_adminmenu( 0, _MI_DOWNLOADS_MENU_LOG );
			$logObj->displaySingleObject();
			break;
		
		default:
			icms_cp_header();
			downloads_adminmenu( 0, _MI_DOWNLOADS_MENU_LOG );
			$criteria = '';
			
			if (empty($criteria)) {
				$criteria = null;
			}
			// create article log table
			$objectTable = new icms_ipf_view_Table($article_log_handler, $criteria, array('delete'));
			$objectTable->addColumn( new icms_ipf_view_Column( 'log_item_id', FALSE, FALSE, 'getLogItemId' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'log_item', FALSE, FALSE, 'getLogItem' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'log_case',FALSE, FALSE, 'getLogCase' ) );
			$objectTable->addColumn( new icms_ipf_view_Column( 'log_date', 'center', FALSE, 'getLogDate' ) );
			$objectTable->setDefaultOrder("DESC");
			$objectTable->setDefaultSort("log_date");
			$icmsAdminTpl->assign( 'article_log_table', $objectTable->fetch() );
			$icmsAdminTpl->display( 'db:article_admin.html' );
			break;
	}
	icms_cp_footer();
}