<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /class/CareerHandler.php
 * 
 * Classes responsible for managing Career career objects
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class CareerCareerHandler extends icms_ipf_Handler {
	
	public function __construct(&$db) {
		parent::__construct($db, "career", "career_id", "career_title", "career_summary", "career");
	}
	
	public function getCareerList($active = FALSE) {
		$crit = new icms_db_criteria_Compo();
		if($active) $crit->add(new icms_db_criteria_Item("career_active", TRUE));
		$careers = $this->getObjects($crit, TRUE, FALSE);
		$ret[] = '-----------';
		foreach(array_keys($careers) as $i) {
			$ret[$i] = $careers[$i]->getVar("career_title", "e");
		}
		return $ret;
	}
	
	public function getCareers($active = FALSE, $order = "career_title", $sort = "ASC", $start = 0, $limit = 0, $department = FALSE) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($active) $criteria->add(new icms_db_criteria_Item("career_active", TRUE));
		if($department) $criteria->add(new icms_db_criteria_Item("career_did", $department));
		$careers = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($careers as $key => $career) {
			$ret[$career['career_id']] = $career;
		}
		return $ret;
	}
	
	public function makeLink($career) {
		$count = $this->getCount(new icms_db_criteria_Item("short_url", $career->getVar("short_url", "e")));
		if ($count > 1) {
			return $career->getVar("career_id", "e");
		} else {
			$seo = str_replace(" ", "-", $career->getVar("short_url"));
			return $seo;
		}
	}
	
	//set category online/offline
	public function changeVisible($career_id) {
		$visibility = '';
		$careerObj = $this->get($career_id);
		if ($careerObj->getVar("career_active", "e") == TRUE) {
			$careerObj->setVar("career_active", 0);
			$visibility = 0;
		} else {
			$careerObj->setVar("career_active", 1);
			$visibility = 1;
		}
		$this->insert($careerObj, TRUE);
		return $visibility;
	}
	
	public function career_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}
	
	public function getDepartmentList() {
		$career_department_handler = icms_getModuleHandler("department", basename(dirname(dirname(__FILE__))), "career");
		$departments = $career_department_handler->getObjects(FALSE, TRUE);
		$ret = array();
		foreach (array_keys($departments) as $i) {
			$ret[$departments[$i]->getVar('department_id')] = $departments[$i]->getVar('department_title');
		}
		return $ret;
	}
	
	// some fuctions related to icms core functions
	public function getCareerForSearch($queryarray, $andor, $limit, $offset, $userid) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->setStart($offset);
		$criteria->setLimit($limit);
		if ($userid != 0) $criteria->add(new icms_db_criteria_Item('career_submitter', $userid));

		if ($queryarray) {
			$criteriaKeywords = new icms_db_criteria_Compo();
			for($i = 0; $i < count($queryarray); $i ++) {
				$criteriaKeyword = new icms_db_criteria_Compo();
				$criteriaKeyword->add(new icms_db_criteria_Item('career_title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new icms_db_criteria_Item('career_description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
			$criteria->add($criteriaKeywords);
		}
		$criteria->add(new icms_db_criteria_Item('career_active', TRUE));
		return $this->getObjects($criteria, TRUE, FALSE);
	}

	//update hit-counter
	public function updateCounter($career_id) {
		global $career_isAdmin;
		$careerObj = $this->get($career_id);
		if (!is_object($careerObj)) return FALSE;
		if (isset($careerObj->vars['counter']) && !is_object(icms::$user) || (!$career_isAdmin && $careerObj->getVar("career_submitter", "e") != icms::$user->getVar("uid"))) {
			$new_counter = $careerObj->getVar("counter", "e") + 1;
			$sql = 'UPDATE ' . $this->table . ' SET counter=' . $new_counter
				. ' WHERE ' . $this->keyName . '=' . $careerObj->id();
			$this->query($sql, NULL, TRUE);
		}
		return TRUE;
	}
	
	protected function beforeInsert(&$obj) {
		// check summary for valid html input
		$summary = $obj->getVar("career_summary", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("career_summary", $summary);
		// check, if email is valid
		$mail = $obj->getVar("career_cemail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("career_cemail", $mail);
		return TRUE;
	}
	
	protected function afterSave(&$obj) {
		if($obj->isNew()) {
			$obj->sendCareerNotification('new_career');
		} else {
			$obj->sendCareerNotification('career_modified');
		}
		return TRUE;
	}
	
}
