<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /class/IndexpageHandler.php
 * 
 * Classes responsible for managing Career indexpage objects
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

class CareerDepartmentHandler extends icms_ipf_Handler {
	
	public $_moduleName;
	
	public $_uploadPath;
	
	public function __construct(&$db) {
		global $careerConfig;
		parent::__construct($db, "department", "department_id", "department_title", "department_summary", "career");
		$mimetypes = array('image/jpeg', 'image/png', 'image/gif');
		$this->enableUpload($mimetypes, $careerConfig['logo_file_size'], $careerConfig['logo_upload_width'], $careerConfig['logo_upload_height']);
	}

	public function getDepartmentList($active = FALSE, $shownull = FALSE) {
		$crit = new icms_db_criteria_Compo();
		if($active) $crit->add(new icms_db_criteria_Item("department_active", TRUE));
		$departments = &$this->getObjects($crit, TRUE);
		$ret = array();
		if($shownull) {$ret[] = '-----------';}
		foreach(array_keys($departments) as $i) {
			$ret[$i] = $departments[$i]->getVar("department_title", "e");
		}
		return $ret;
	}
	
	public function getDepartments($active = FALSE, $order = "weight", $sort = "ASC", $start = 0, $limit = 0) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($active) $criteria->add(new icms_db_criteria_Item("department_active", TRUE));
		$departments = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($departments as $key => $department) {
			$ret[$department['department_id']] = $department;
		}
		return $ret;
	}
	
	static public function getImageList() {
		$logos = array();
		$logos = icms_core_Filesystem::getFileList(CAREER_UPLOAD_ROOT . 'department/', '', array('gif', 'jpg', 'png'));
		$ret = array();
		$ret[0] = '-----------------------';
		foreach(array_keys($logos) as $i ) {
			$ret[$i] = $logos[$i];
		}
		return $ret;
	}
	
	public function makeLink($department) {
		$seo = str_replace(" ", "-", $department->getVar("short_url"));
		return $seo;
	}
	
	//set category online/offline
	public function changeVisible($department_id) {
		$visibility = '';
		$departmentObj = $this->get($department_id);
		if ($departmentObj->getVar("department_active", "e") == TRUE) {
			$departmentObj->setVar("department_active", 0);
			$visibility = 0;
		} else {
			$departmentObj->setVar("department_active", 1);
			$visibility = 1;
		}
		$this->insert($departmentObj, TRUE);
		return $visibility;
	}
	
	public function department_active_filter() {
		return array(0 => 'Offline', 1 => 'Online');
	}

	//update hit-counter
	public function updateCounter($department_id) {
		global $career_isAdmin;
		$departmentObj = $this->get($department_id);
		if (!is_object($departmentObj)) return FALSE;
		if (isset($departmentObj->vars['counter']) && !is_object(icms::$user) || (!$career_isAdmin && $departmentObj->getVar("department_submitter", "e") != icms::$user->getVar("uid"))) {
			$new_counter = $departmentObj->getVar("counter", "e") + 1;
			$sql = 'UPDATE ' . $this->table . ' SET counter=' . $new_counter
				. ' WHERE ' . $this->keyName . '=' . $departmentObj->id();
			$this->query($sql, NULL, TRUE);
		}
		return TRUE;
	}
	
	// some related functions for storing
	protected function beforeSave(&$obj) {
		//check, if a new logo is uploaded. If so, set new logo
		$logo_upl = $obj->getVar("department_logo_upl", "e");
		if ($logo_upl != '') {
			$obj->setVar("department_logo", $logo_upl);
		}
		// check, if email is valid
		$mail = $obj->getVar("department_mail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("department_mail", $mail);
		// check summary for valid html input
		$summary = $obj->getVar("department_summary", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("department_summary", $summary);
		return TRUE;
	}
}