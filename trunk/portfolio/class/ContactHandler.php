<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /class/ContactHandler.php
 * 
 * Classes responsible for managing Portfolio contact objects
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

class PortfolioContactHandler extends icms_ipf_Handler {
	
	public function __construct(&$db) {
		global $portfolioConfig;
		parent::__construct($db, "contact", "contact_id", "contact_title", "contact_body", "portfolio");
	}
	
	public function getContacts($start = 0, $limit = 0, $order = "contact_date", $sort = "DESC") {
		$criteria = new icms_db_criteria_Compo();
		if ($start) $criteria->setStart($start);
		if ($limit) $criteria->setLimit((int)$limit);
		$criteria->setSort($order);
		$criteria->setOrder($sort);
		
		$contacts = $this->getObjects($criteria, TRUE, FALSE);
		$ret = array();
		foreach ($contacts as $key => $contact) {
			$ret[$contact['contact_id']] = $contact;
		}
		return $ret;
	}
	
	public function changeNew($contact_id) {
		$new = '';
		$contactObj = $this->get($contact_id);
		if ($contactObj->getVar('contact_isnew', 'e') == TRUE) {
			$contactObj->setVar('contact_isnew', 0);
			$new = 0;
		} else {
			$contactObj->setVar('contact_isnew', 1);
			$new = 1;
		}
		$this->insert($contactObj, TRUE);
		return $new;
	}
	
	// some related functions for storing
	protected function beforeInsert(&$obj) {
		// check, if email is valid
		$mail = $obj->getVar("contact_mail", "s");
		$mail = icms_core_DataFilter::checkVar($mail, "email", 0, 0);
		$obj->setVar("contact_mail", $mail);
		// check summary for valid html input
		$summary = $obj->getVar("contact_body", "s");
		$summary = icms_core_DataFilter::checkVar($summary, "html", "input");
		$obj->setVar("contact_body", $summary);
		return TRUE;
	}
}
