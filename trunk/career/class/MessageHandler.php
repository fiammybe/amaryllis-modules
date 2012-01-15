<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /class/MessageHandler.php
 * 
 * Classes responsible for managing Career message objects
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

class CareerMessageHandler extends icms_ipf_Handler {
	
	public function __construct(&$db) {
		global $careerConfig;
		parent::__construct($db, "message", "message_id", "message_title", "message_body", "career");
		$mimetype = $this->checkMimeType();
		$filesize = $careerConfig['career_file_size'];
		$this->enableUpload($mimetype, $filesize);
	}
	
	public function checkMimeType() {
		global $icmsModule;
		$mimetypeHandler = icms_getModulehandler('mimetype', 'system');
		$modulename = basename(dirname(dirname(__FILE__)));
		if (empty($this->mediaRealType) && empty($this->allowUnknownTypes)) {
			icms_file_MediaUploadHandler::setErrors(_ER_UP_UNKNOWNFILETYPEREJECTED);
			return false;
		}
		$AllowedMimeTypes = $mimetypeHandler->AllowedModules($this->mediaRealType, $modulename);
		if ((!empty($this->allowedMimeTypes) && !in_array($this->mediaRealType, $this->allowedMimeTypes))
				|| (!empty($this->deniedMimeTypes) && in_array($this->mediaRealType, $this->deniedMimeTypes))
				|| (empty($this->allowedMimeTypes) && !$AllowedMimeTypes))
			{
			icms_file_MediaUploadHandler::setErrors(sprintf(_ER_UP_MIMETYPENOTALLOWED, $this->mediaType));
			return false;
		}
		return true;
	}
	
	public function getMessages($cid = FALSE, $did = FALSE, $order = "message_date", $sort = "DESC", $start = 0, $limit = 0) {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		if($cid) $criteria->add(new icms_db_criteria_Item("message_cid", $cid));
		if($did) $criteria->add(new icms_db_criteria_Item("message_did", $did));
		$messages = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($messages as $key => $message) {
			$ret[$message['message_id']] = $message;
		}
	}
	
	public function getCareers() {
		$career_career_handler = icms_getModuleHandler("career", basename(dirname(dirname(__FILE__))), "career");
		$careers = $career_career_handler->getCareerList();
		$ret = array();
		foreach ($careers as $key => $career) {
			$ret[$career['career_id']] = $career;
		}
		return $ret;
	}
	
	public function getDepartments() {
		$career_department_handler = icms_getModuleHandler("department", basename(dirname(dirname(__FILE__))), "career");
		$departments = $career_department_handler->getDepartmentList(TRUE);
		$ret = array();
		foreach ($departments as $key => $department) {
			$ret[$department['department_id']] = $department;
		}
		return $ret;
	}
	
	// some related functions for storing
	protected function beforeInsert(&$obj) {
		// check, if email is valid
		$mail = $obj->getVar("message_mail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("message_mail", $mail);
		// check summary for valid html input
		$summary = $obj->getVar("message_body", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("message_body", $summary);
		return true;
	}
}
