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

class PortfolioPortfolioHandler extends icms_ipf_Handler {
	
	public function __construct(&$db) {
		global $portfolioConfig;
		parent::__construct($db, "portfolio", "portfolio_id", "portfolio_title", "portfolio_summary", "portfolio");
		$this->_uploadPath = ICMS_ROOT_PATH . '/uploads/' . basename(dirname(dirname(__FILE__))) . '/portfolio/';
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
	
	public function getPortfolioList($active = FALSE) {
		$crit = new icms_db_criteria_Compo();
		if($active) $crit->add(new icms_db_criteria_Item("portfolio_active", TRUE));
		$portfolios = $this->getObjects($crit, TRUE, FALSE);
		$ret[] = '-----------';
		foreach(array_keys($portfolios) as $i) {
			$ret[$i] = $portfolios[$i]->getVar("portfolio_title", "e");
		}
		return $ret;
	}
	
	public function getPortfolios($active = FALSE, $order = "portfolio_title", $sort = "ASC", $start = 0, $limit = 0, $category = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		if($order)$criteria->setSort($order);
		if($sort)$criteria->setOrder($sort);
		if($active) $criteria->add(new icms_db_criteria_Item("portfolio_active", TRUE));
		if($category) $criteria->add(new icms_db_criteria_Item("portfolio_cid", $category));
		$portfolios = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($portfolios as $key => $portfolio) {
			$ret[$portfolio['portfolio_id']] = $portfolio;
		}
		return $ret;
	}
	
	public function makeLink($portfolio) {
		$count = $this->getCount(new icms_db_criteria_Item("short_url", $portfolio->getVar("short_url", "e")));
		if ($count > 1) {
			return $portfolio->getVar("portfolio_id", "e");
		} else {
			$seo = str_replace(" ", "-", $portfolio->getVar("short_url"));
			return $seo;
		}
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
		$portfolio_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "portfolio");
		$categorys = $portfolio_category_handler->getObjects(FALSE, TRUE);
		$ret = array();
		foreach (array_keys($categorys) as $i) {
			$ret[$categorys[$i]->getVar('category_id')] = $categorys[$i]->getVar('category_title');
		}
		return $ret;
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
		if (isset($portfolioObj->vars['counter']) && !is_object(icms::$user) || (!$portfolio_isAdmin && $portfolioObj->getVar("portfolio_submitter", "e") != icms::$user->getVar("uid"))) {
			$new_counter = $portfolioObj->getVar("counter", "e") + 1;
			$sql = 'UPDATE ' . $this->table . ' SET counter=' . $new_counter
				. ' WHERE ' . $this->keyName . '=' . $portfolioObj->id();
			$this->query($sql, NULL, TRUE);
		}
		return TRUE;
	}
	
	protected function beforeInsert(&$obj) {
		// check summary for valid html input
		$summary = $obj->getVar("portfolio_summary", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("portfolio_summary", $summary);
		// check, if email is valid
		$mail = $obj->getVar("portfolio_cemail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("portfolio_cemail", $mail);
		return TRUE;
		
	}
	
}
