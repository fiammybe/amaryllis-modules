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

class mod_portfolio_CategoryHandler extends icms_ipf_Handler {
	
	public $_moduleName;
	private $_userArray;
	private $_catArray;
	
	public function __construct(&$db) {
		global $portfolioConfig;
		parent::__construct($db, "category", "category_id", "category_title", "category_summary", "portfolio");
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $portfolioConfig['logo_file_size'], $portfolioConfig['logo_upload_width'], $portfolioConfig['logo_upload_height']);
	}
	
	public function loadUsers() {
		if(!count($this->_userArray)) {
			$member_handler = icms::handler('icms_member_user');
			$users = $member_handler->getObjects(FALSE, TRUE);
			foreach (array_keys($users) as $key) {
				$this->_userArray[$key] = $users[$key]->getVar("uname") ;
			}
		}
		return $this->_userArray;
	}
	
	public function getCatBySeo($seo) {
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", trim($seo)));
		$cats = $this->getObjects($criteria, FALSE, TRUE);
		if(!$cats) return FALSE;
		return $cats[0];
	}

	public function getCategoryList($active = FALSE, $shownull = FALSE) {
		if(!count($this->_catArray)) {
			$crit = new icms_db_criteria_Compo();
			if($active) $crit->add(new icms_db_criteria_Item("category_active", TRUE));
			$categorys = $this->getObjects($crit, TRUE, FALSE);
			if($shownull) {$this->_catArray[0] = '-----------';}
			foreach($categorys as $key => $value) {
				$this->_catArray[$key] = $value['category_title'];
			}
		}
		return $this->_catArray;
	}
	
	public function getCategoriesCriterias($active = FALSE, $order = "weight", $sort = "ASC", $start = 0, $limit = 0) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		if ($order) $criteria->setSort($order);
		if($sort) $criteria->setOrder($sort);
		if($active) $criteria->add(new icms_db_criteria_Item("category_active", TRUE));
		return $criteria;
	}
	
	public function getCategories($active = FALSE, $order = "weight", $sort = "ASC", $start = 0, $limit = 0) {
		$criteria = $this->getCategoriesCriterias($active, $order, $sort, $start, $limit);
		$categorys = $this->getObjects($criteria, TRUE, FALSE);
		foreach ($categorys as $key => $category) {
			$ret[$key] = $category;
		}
		return $ret;
	}
	
	public function getCategoriesCount($active = FALSE, $order = "weight", $sort = "ASC", $start = 0, $limit = 0) {
		$criteria = $this->getCategoriesCriterias($active, $order, $sort, $start, $limit);
		return $this->getCount($criteria);
	}
	
	static public function getImageList() {
		$logos = array();
		$logos = icms_core_Filesystem::getFileList(PORTFOLIO_UPLOAD_ROOT . 'category/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($logos) as $i ) {
			$ret[$i] = $logos[$i];
		}
		return $ret;
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
		if(!is_object($categoryObj)) return FALSE;
		if(!is_object(icms::$user) || (!$portfolio_isAdmin && $categoryObj->getVar("category_submitter", "e") != icms::$user->getVar("uid"))) {
			$new_counter = $categoryObj->getVar("counter", "e") + 1;
			$categoryObj->setVar("counter", $new_counter);
			$categoryObj->_updating = TRUE;
			$this->insert($categoryObj);
		}
		return TRUE;
	}
	
	protected function beforeInsert(&$obj) {
		if($obj->_updating) return TRUE;
		$mail = $obj->getVar("category_mail", "e");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("category_mail", $mail);
		$summary = $obj->getVar("category_summary", "e");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("category_summary", $summary);
		if ($obj->getVar('category_logo_upl') != '') {
			$obj->setVar('index_image', $obj->getVar('category_logo_upl') );
			$obj->setVar('category_logo_upl', "" );
		}
		//check, id seo exists
		$seo = trim($obj->short_url());
		if($seo == "") $seo = icms_ipf_Metagen::generateSeoTitle(trim($obj->title()), FALSE);
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", $seo));
		if($this->getCount($criteria)) {
			$seo = $seo . '_' . time();
			$obj->setVar("short_url", $seo);
		}
		return TRUE;
	}
	
	protected function beforeUpdate(&$obj) {
		if($obj->_updating) return TRUE;
		$mail = $obj->getVar("category_mail", "e");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("category_mail", $mail);
		$summary = $obj->getVar("category_summary", "e");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("category_summary", $summary);
		if ($obj->getVar('category_logo_upl') != '') {
			$obj->setVar('index_image', $obj->getVar('category_logo_upl') );
			$obj->setVar('category_logo_upl', "" );
		}
		return TRUE;
	}
	
	protected function afterDelete(&$obj) {
		$portfolio_handler = icms_getModuleHandler("portfolio", PORTFOLIO_DIRNAME, "portfolio");
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("portflio_cid", $obj->id()));
		$portfolio_handler->deleteAll($criteria);
		unset($portfolio_handler, $criteria);
		return TRUE;
	}
}