<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /submit.php
 * 
 * submit entries
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';

$valid_op = array ('addentry');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');
if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'addentry':
			global $guestbookConfig;
			$guestbook_id = isset($_GET['guestbook_id']) ? filter_input(INPUT_GET, 'guestbook_id', FILTER_SANITIZE_NUMBER_INT) : 0;
			$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", basename(dirname(__FILE__)), "guestbook");
			$guestbookObj = $guestbook_guestbook_handler->get($guestbook_id);
			if($guestbookObj->isNew() ) {
				if (!icms::$security->check()) {
					redirect_header(GUESTBOOK_URL, 3, _MD_GUESTBOOK_SECURITY_CHECK_FAILED . implode('<br />', icms::$security->getErrors()));
				}
				$controller = new icms_ipf_Controller($guestbook_guestbook_handler);
				$controller->storeFromDefaultForm(_MD_GUESTBOOK_CREATED, _MD_GUESTBOOK_MODIFIED);
				return redirect_header(GUESTBOOK_URL, 3, _THANKS_SUBMISSION);
			} else {
				redirect_header(GUESTBOOK_URL, 3, _NO_PERM);
			}
			break;
	}
} else {
	redirect_header(GUESTBOOK_URL, 3, _NO_PERM);
}