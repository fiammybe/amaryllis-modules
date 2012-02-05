<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /class/IndexpageHandler.php
 * 
 * Classes responsible for managing Portfolio indexpage objects
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class PortfolioCategoryHandler extends icms_ipf_Handler {
	
	public $_moduleName;
	
	public $_uploadPath;
	
	public function __construct(&$db) {
		global $portfolioConfig;
		parent::__construct($db, "category", "category_id", "category_title", "category_summary", "portfolio");
		$this->_uploadPath = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/categoryimages/';
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $portfolioConfig['logo_file_size'], $portfolioConfig['logo_upload_width'], $portfolioConfig['logo_upload_height']);
		
	}
	
	public function getImagePath() {
		$dir = $this->_uploadPath;
		if (!file_exists($dir)) {
			$moddir = basename(dirname(dirname(__FILE__)));
			icms_core_Filesystem::mkdir($dir, "0777", '' );
		}
		return $dir . "/";
	}
	
	public function getCategoryList($active = FALSE, $shownull = FALSE) {
		$crit = new icms_db_criteria_Compo();
		if($active) $crit->add(new icms_db_criteria_Item("category_active", TRUE));
		$categorys = &$this->getObjects($crit, TRUE);
		$ret = array();
		if($shownull) {$ret[] = '-----------';}
		foreach(array_keys($categorys) as $i) {
			$ret[$i] = $categorys[$i]->getVar("category_title", "e");
		}
		return $ret;
	}
	
	public function getCategories($active = FALSE, $order = "weight", $sort = "ASC", $start = 0, $limit = 0) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($active) $criteria->add(new icms_db_criteria_Item("category_active", TRUE));
		$categorys = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($categorys as $key => $category) {
			$ret[$category['category_id']] = $category;
		}
		return $ret;
	}
	
	static public function getImageList() {
		$logos = array();
		$logos = icms_core_Filesystem::getFileList(PORTFOLIO_UPLOAD_ROOT . 'categoryimages/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($logos) as $i ) {
			$ret[$i] = $logos[$i];
		}
		return $ret;
	}
	
	public function makeLink($category) {
		$count = $this->getCount(new icms_db_criteria_Item("short_url", $category->getVar("short_url", "e")));
		if ($count > 1) {
			return $category->getVar("category_id", "e");
		} else {
			$seo = str_replace(" ", "-", $category->getVar("short_url"));
			return $seo;
		}
	}
	
	//set category online/offline
	public function changeVisible($category_id) {
		$visibility = '';
		$categoryObj = $this->get($category_id);
		if ($categoryObj->getVar("category_active", "e") == TRUE) {
			$categoryObj->setVar("category_active", 0);
			$visibility = 0;
		} else {
			$categoryObj->setVar("category_active", 1);
			$visibility = 1;
		}
		$this->insert($categoryObj, TRUE);
		return $visibility;
	}
	
	public function category_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}

	//update hit-counter
	public function updateCounter($category_id) {
		global $portfolio_isAdmin;
		$categoryObj = $this->get($category_id);
		if (!is_object($categoryObj)) return FALSE;
		if (isset($categoryObj->vars['counter']) && !is_object(icms::$user) || (!$portfolio_isAdmin && $categoryObj->getVar("category_submitter", "e") != icms::$user->getVar("uid"))) {
			$new_counter = $categoryObj->getVar("counter", "e") + 1;
			$sql = 'UPDATE ' . $this->table . ' SET counter=' . $new_counter
				. ' WHERE ' . $this->keyName . '=' . $categoryObj->id();
			$this->query($sql, NULL, TRUE);
		}
		return TRUE;
	}
	
	// some related functions for storing
	protected function beforeSave(&$obj) {
		//check, if a new logo is uploaded. If so, set new logo
		$logo_upl = $obj->getVar("category_logo_upl", "e");
		if ($logo_upl != '') {
			$obj->setVar("category_logo", $logo_upl);
		}
		// check, if email is valid
		$mail = $obj->getVar("category_mail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("category_mail", $mail);
		// check summary for valid html input
		$summary = $obj->getVar("category_summary", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("category_summary", $summary);
		return TRUE;
	}
}