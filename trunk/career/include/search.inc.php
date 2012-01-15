<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /include/search.inc.php
 * 
 * holding search informations
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


include_once ICMS_ROOT_PATH . '/modules/' . basename(dirname(dirname(__FILE__))) . '/include/common.php';

function career_search($queryarray, $andor, $limit, $offset, $userid) {
	$career_career_handler = icms_getModuleHandler('career', basename(dirname(dirname(__FILE__))), 'career');
	$careersArray = $career_career_handler->getCareerForSearch($queryarray, $andor, $limit, $offset, $userid);

	$ret = array();

	foreach ($careersArray as $careerArray) {
		$item['image'] = "images/career_icon.png";
		$item['link'] = $careerArray['itemURL'];
		$item['title'] = $careerArray['career_title'];
		$item['time'] = strtotime($careerArray['career_p_date']);
		$item['uid'] = $careerArray['career_submitter'];
		$ret[] = $item;
		unset($item);
	}
	return $ret;
}