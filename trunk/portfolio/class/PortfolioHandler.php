<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /class/PortfolioHandler.php
 * 
 * Classes responsible for managing Portfolio portfolio objects
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
if(!defined("PORTFOLIO_DIRNAME")) define("PORTFOLIO_DIRNAME",basename(dirname(dirname(__FILE__))));

class mod_portfolio_PortfolioHandler extends icms_ipf_Handler {
	
	private $_portfolioArray;
	private $_catArray;
	private $_userArray;
	
	public function __construct(&$db) {
		global $portfolioConfig;
		parent::__construct($db, "portfolio", "portfolio_id", "portfolio_title", "portfolio_summary", PORTFOLIO_DIRNAME);
		$mimetypes = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $portfolioConfig['logo_file_size'], $portfolioConfig['logo_upload_width'], $portfolioConfig['logo_upload_height']);
	}
	
	public function loadUsers() {
		if(!count($this->_userArray)) {
			$member_handler = icms::handler('icms_member_user');
			$users = $member_handler->getObjects(FALSE, TRUE);
			foreach (array_keys($users) as $key) {
				$this->_userArray[$key] = $users[$key]->getVar("uname");
			}
		}
		return $this->_userArray;
	}

	public function getPortfolioList($active = FALSE) {
		if(!count($this->_portfolioArray)) {
			$crit = new icms_db_criteria_Compo();
			if($active) $crit->add(new icms_db_criteria_Item("portfolio_active", TRUE));
			$portfolios = $this->getObjects($crit, TRUE, FALSE);
			$this->_portfolioArray[0] = '-----------';
			foreach($portfolios as $key => $value) {
				$this->_portfolioArray[$key] = $value["portfolio_title"];
			}
		}
		return $this->_portfolioArray;
	}
	
	public function getPortfolioCriterias($active = FALSE, $order = "portfolio_title", $sort = "ASC", $start = 0, $limit = 0, $category = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		if($order)$criteria->setSort($order);
		if($sort)$criteria->setOrder($sort);
		if($active) $criteria->add(new icms_db_criteria_Item("portfolio_active", TRUE));
		if($category) $criteria->add(new icms_db_criteria_Item("portfolio_cid", $category));
		return $criteria;
	}
	
	public function getPortfolios($active = FALSE, $order = "portfolio_title", $sort = "ASC", $start = 0, $limit = 0, $category = FALSE) {
		$criteria = $this->getPortfolioCriterias($active, $order, $sort, $start, $limit, $category);
		$portfolios = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($portfolios as $key => $portfolio) {
			$ret[$key] = $portfolio;
		}
		return $ret;
	}
	
	public function getPortfoliosCount($active = FALSE, $order = "portfolio_title", $sort = "ASC", $start = 0, $limit = 0, $category = FALSE) {
		$criteria = $this->getPortfolioCriterias($active, $order, $sort, $start, $limit, $category);
		return $this->getCount($criteria);
	}
	
	public function getPortfolioBySeo($seo) {
		$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item("short_url", trim($seo)));
		$portfolios = $this->getObjects($criteria, FALSE, TRUE);
		if(!$portfolios) return FALSE;
		return $portfolios[0];
	}	
	
	//set category online/offline
	public function changeVisible($portfolio_id) {
		$visibility = '';
		$portfolioObj = $this->get($portfolio_id);
		if ($portfolioObj->getVar("portfolio_active", "e") == TRUE) {
			$portfolioObj->setVar("portfolio_active", 0);
			$visibility = 0;
		} else {
			$portfolioObj->setVar("portfolio_active", 1);
			$visibility = 1;
		}
		$this->insert($portfolioObj, TRUE);
		return $visibility;
	}
	
	public function portfolio_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function getCategoryList() {
		if(!count($this->_catArray)) {
			$category_handler = icms_getModuleHandler("category", PORTFOLIO_DIRNAME, "portfolio");
			$categorys = $category_handler->getObjects(FALSE, TRUE);
			foreach ($categorys as $key => $value) {
				$this->_catArray[$key] = $value['title'];
			}
		}
		return $this->_catArray;
	}
	
	// some fuctions related to icms core functions
	public function getPortfolioForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart($offset);
		$criteria->setLimit($limit);
		if ($userid != 0) $criteria->add(new icms_db_criteria_Item('portfolio_submitter', $userid));

		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('portfolio_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('portfolio_description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$criteria->add(new icms_db_criteria_Item('portfolio_active', TRUE));
		return $this->getObjects($criteria, TRUE, FALSE);
	}

	//update hit-counter
	public function updateCounter($portfolio_id) {
		global $portfolio_isAdmin;
		$portfolioObj = $this->get($portfolio_id);
		if (!is_object($portfolioObj)) return FALSE;
		if (!is_object(icms::$user) || (!$portfolio_isAdmin && $portfolioObj->getVar("portfolio_submitter", "e") != icms::$user->getVar("uid"))) {
			$new_counter = $portfolioObj->getVar("counter", "e") + 1;
			$portfolioObj->setVar("counter", $new_counter);
			$portfolioObj->_updating = TRUE;
			$this->insert($portfolioObj);
		}
		return TRUE;
	}
	
	protected function beforeInsert(&$obj) {
		if($obj->_updating) return TRUE;
		// check summary for valid html input
		$summary = $obj->getVar("portfolio_summary", "e");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("portfolio_summary", $summary);
		// check, if email is valid
		$mail = $obj->getVar("portfolio_cemail", "e");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("portfolio_cemail", $mail);
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
	
	protected function afterDelete(&$obj) {
		$img = $obj->getVar("portfolio_img", "e");
		$path = ICMS_UPLOAD_PATH.'/'.PORTFOLIO_DIRNAME.'/'.$this->_itemname.'/';
		if($img != "") icms_core_Filesystem::deleteFile($path.$img);
		return TRUE;
	}
}
