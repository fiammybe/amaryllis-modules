<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/Log.php
 * 
 * Class representing Article log Objects
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class mod_article_Log extends icms_ipf_Object {
	/**
	 * Constructor
	 *
	 * @param mod_article_Log $handler Object handler
	 */
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("log_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("log_ip", XOBJ_DTYPE_OTHER, FALSE);
		$this->quickInitVar("log_uid", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("log_item_id", XOBJ_DTYPE_INT, FALSE);
		$this->quickInitVar("log_date", XOBJ_DTYPE_LTIME, FALSE);
		$this->quickInitVar("log_item", XOBJ_DTYPE_CURRENCY, FALSE);
		$this->quickInitVar("log_case", XOBJ_DTYPE_INT, FALSE);

	}

	/**
	 * Overriding the icms_ipf_Object::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array())) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
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
				return 'article';
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
				return '';
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