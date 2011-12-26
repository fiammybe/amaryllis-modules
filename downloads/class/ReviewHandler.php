<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /class/ReviewHandler.php
 * 
 * Classes responsible for managing Downloads review objects
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

class DownloadsReviewHandler extends icms_ipf_Handler {
	/**
	 * constructor
	 */	
	public function __construct(&$db) {
		parent::__construct($db, "review", "review_id", "review_item_id", "review_message", "downloads");
	}
	
	public function getReviews($start = 0, $limit = 0, $order = 'review_date', $sort = 'DESC' , $review_item_id = null) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		$criteria->add(new icms_db_criteria_Item('review_item_id', $review_item_id));
		$reviews = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($reviews as $review){
			$ret[$review['review_id']] = $review;
		}
		return $ret;
	}

	protected function beforeInsert(& $obj) {
		global $downloadsConfig;
		$message = $obj->getVar("review_message", "s");
		$smessage = strip_tags($message,'<b><i><a><br/>');
		$smessage = icms_core_DataFilter::checkVar($smessage, "html", "input");
		$obj->setVar("review_message", $smessage);

		$email = $obj->getVar("review_email", "s");
		if($downloadsConfig['display_reviews_email'] == 1) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 0);
		} elseif($downloadsConfig['display_reviews_email'] == 2) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 0);
		} elseif($downloadsConfig['display_reviews_email'] == 3) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 1, 1);
		} elseif($downloadsConfig['display_reviews_email'] == 4) {
			$email = icms_core_DataFilter::checkVar($email, 'email', 0, 1);
		}
		$obj->setVar("review_email", $email);
		return TRUE;
	}
}
