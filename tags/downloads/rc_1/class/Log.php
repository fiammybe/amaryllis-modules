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
		$this->quickInitVar('log_ip', XOBJ_DTYPE_OTHER);
		$this->quickInitVar('log_uid', XOBJ_DTYPE_INT);
		$this->quickInitVar('log_item_id', XOBJ_DTYPE_INT);
		$this->quickInitVar('log_date', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('log_item', XOBJ_DTYPE_INT); // file = 0; category = 1
		$this->quickInitVar('log_case', XOBJ_DTYPE_INT); // download = 0; upload/create = 1; delete = 2; updated= 3; download from mirror = 4, vote up = 5, vote down = 6,
		
	}
	
	public function getLogIP() {
		$ip = "";
		$ip = $this->getValueFor("log_ip", "e");
		$ip = icms_core_DataFilter::checkVar($ip, "ip", "ipv4");
		return $ip;
	}
	
	public function getLogDate() {
		global $downloadsConfig;
		$date = '';
		$date = $this->getVar('log_date', 'e');
		
		return date($downloadsConfig['downloads_dateformat'], $date);
	}
	
	public function getLogItemId() {
		$item_id = $this->getVar("log_item_id", "e");
		$item = $this->getVar("log_item", "e");
		$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(dirname(__FILE__))), "downloads");
		$downloads_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "downloads");
		if($item == 0){
			$file = $downloads_download_handler->get($item_id);
			$filename = $file->getVar("download_title", "s");
			$url = DOWNLOADS_URL . 'singledownload.php?download_id=' . $item_id;
			return '<a href="' . $url . '" title="' . $filename . '">' . $filename . '</a>';
		} elseif ($item == 1) {
			$cat = $downloads_category_handler->get($item_id);
			$catname = $cat->getVar("category_title", "s");
			$url = DOWNLOADS_URL . 'index.php?category_id=' . $item_id;
			return '<a href="' . $url . '" title="' . $catname . '">' . $catname . '</a>';
		}
	}
	
	public function getLogItem() {
		$item = $this->getVar("log_item", "e");
		switch ($item) {
			case '0':
				return 'file';
				break;
			
			case '1':
				return 'category';
				break;
		}
	}
	
	public function getLogCase() {
		$item = $this->getVar("log_case", "e");
		switch ($item) {
			case '0':
				return 'download';
				break;
			
			case '1':
				return 'create';
				break;
				
			case '2':
				return 'delete';
				break;
			
			case '3':
				return 'updated';
				break;
				
			case '4':
				return 'download mirror';
				break;
				
			case '5':
				return 'vote up';
				break;
			
			case '6':
				return 'vote down';
				break;
		}
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['date'] = $this->getLogDate();
		$ret['item_id'] = $this->getLogItemId();
		$ret['item'] = $this->getLogItem();
		$ret['case'] = $this->getLogCase();
		return $ret;
	}
}