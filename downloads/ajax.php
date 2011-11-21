<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /ajax.php
 * 
 * managing ajax requests in frontend
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

include_once "../../mainfile.php";
include_once dirname(__FILE__) . '/include/common.php';

$valid_op = array ('report_broken');
$clean_op = (isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '');

if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case 'report_broken':
			$download_id = (int)filter_input(INPUT_GET, 'download_id');
			if ($download_id <= 0) return FALSE;
			$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))),'downloads');
			$downloadObj = $downloads_download_handler->get($download_id);
			if ($downloadObj->isNew()) return FALSE;
			$downloadObj->setVar('download_broken', TRUE);
			$downloadObj->store(TRUE);
			return JSON (data(_MD_DOWNLOADS_REPORTED));
			break;
	}
}