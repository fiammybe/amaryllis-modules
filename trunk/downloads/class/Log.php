<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/Log.php
 * 
 * Class representing Download log objects
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

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

/**
 * Class for download log
 */
class DownloadsLog extends icms_ipf_Object {
	
	function __construct(&$handler) {
		icms_ipf_object::__construct($handler);
		
		$this->quickInitVar('log_id', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('log_ip', XOBJ_DTYPE_INT);
		$this->quickInitVar('log_uid', XOBJ_DTYPE_INT);
		$this->quickInitVar('log_item_id', XOBJ_DTYPE_INT);
		$this->quickInitVar('log_item', XOBJ_DTYPE_INT); // file = 0; category = 1
		$this->quickInitVar('log_case', XOBJ_DTYPE_INT); // download = 0; upload/create = 1; delete = 2;
		
	}
}


