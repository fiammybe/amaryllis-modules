<?php
/**
 * "Downloads" is a light weight download handling module for ImpressCMS
 *
 * File: /class/Review.php
 * 
 * Class representing Download review objects
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class DownloadsReview extends icms_ipf_Object {
	
	public function __construct(&$handler) {
		parent::__construct($handler);

		$this->quickInitVar("review_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("review_item_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("review_uid", XOBJ_DTYPE_INT);
		$this->quickInitVar("review_name", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("review_email", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("review_message", XOBJ_DTYPE_TXTAREA, TRUE);
		$this->quickInitVar("review_ip", XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar("review_date",XOBJ_DTYPE_LTIME);
		
		$this->setVar("review_message", array("name" => "textarea", "form_editor" => "htmlarea"));
		
		$this->hideFieldFromForm(array("review_item_id", "review_uid", "review_ip", "review_date" ));
		
	}
	/**
	 * message output -> filter again
	 */
	public function getReviewMessage(){
		$message = icms_core_DataFilter::checkVar($this->getVar("review_message", "s"), "str", "encodelow");
		return $message;
	}
	/**
	 * output of email should be qm-b at hotmail dot com, using no banned list
	 */
	
	public function getReviewEmail(){
		global $downloadsConfig;
		$email = $this->getVar("review_email", "s");
		if($downloadsConfig['display_reviews_email'] == 1) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 0);
		} elseif($downloadsConfig['display_reviews_email'] == 2) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		} elseif($downloadsConfig['display_reviews_email'] == 3) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 1);
		} elseif($downloadsConfig['display_reviews_email'] == 4) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 1);
		}
		return $email;
	}
	
	public function getReviewPublishedDate() {
		global $downloadsConfig;
		$date = '';
		$date = $this->getVar('review_date', 'e');
		
		return date($downloadsConfig['downloads_dateformat'], $date);
	}
	
	public function getReviewItem() {
		$item_id = $this->getVar("review_item_id", "e");
		$downloads_download_handler = icms_getModuleHandler("download", basename(dirname(dirname(__FILE__))), "downloads");
		$file = $downloads_download_handler->get($item_id);
		$filename = $file->getVar("download_title", "s");
		$url = DOWNLOADS_URL . 'singledownload.php?download_id=' . $item_id;
		return '<a href="' . $url . '" title="' . $filename . '">' . $filename . '</a>';
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['date'] = $this->getReviewPublishedDate();
		$ret['message'] = $this->getReviewMessage();
		$ret['name'] = $this->getVar("review_name", "s");
		$ret['email'] = $this->getReviewEmail();
		return $ret;
	}
	
}