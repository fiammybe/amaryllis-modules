<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /class/Review.php
 * 
 * Class representing Article review objects
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

class ArticleReview extends icms_ipf_Object {
	
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
		$this->initCommonVar('dohtml', FALSE, 1);
		
		$this->hideFieldFromForm(array("review_item_id", "review_uid", "review_ip", "review_date" ));
		
	}
	/**
	 * message output -> filter again
	 */
	public function getReviewMessage(){
		
		$message = icms_core_DataFilter::checkVar($this->getVar("review_message", "s"), "html", "output");
		return $message;
	}
	
	public function getReviewEmail(){
		global $downloadsConfig;
		$email = $this->getVar("review_email", "s");
		return $email;
	}
	
	public function getReviewPublishedDate() {
		global $downloadsConfig;
		$date = '';
		$date = $this->getVar('review_date', 'e');
		
		return date($downloadsConfig['article_dateformat'], $date);
	}
	
	public function getReviewAvatar() {
		$review_uid = $this->getVar("review_uid", "e");
		if(intval($review_uid > 0)) {
			$review_user = icms::handler("icms_member")->getUser($review_uid);
			$review_avatar = $review_user->getVar("user_avatar");
			$avatar_image = "<img src='" . ICMS_UPLOAD_URL . "/" . $review_user->getVar("user_avatar") . "' alt='avatar' />";
			return $avatar_image;
		} else {
			$review_avatar = "blank.gif";
			$avatar_image = "<img src='" . ICMS_UPLOAD_URL . "/" . $review_avatar . "' alt='avatar' />";
			return $avatar_image;
		}
	}
	
	public function getReviewItem() {
		$item_id = $this->getVar("review_item_id", "e");
		$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
		$file = $article_article_handler->get($item_id);
		$filename = $file->getVar("article_title", "s");
		$url = ARTICLE_URL . 'singlearticle.php?article_id=' . $item_id;
		return '<a href="' . $url . '" title="' . $filename . '">' . $filename . '</a>';
	}
	
	function toArray() {
		$ret = parent::toArray();
		$ret['date'] = $this->getReviewPublishedDate();
		$ret['message'] = $this->getReviewMessage();
		$ret['name'] = $this->getVar("review_name", "s");
		$ret['email'] = $this->getVar("review_email"); //getReviewEmail();
		$ret['avatar'] = $this->getReviewAvatar();
		return $ret;
	}
	
}