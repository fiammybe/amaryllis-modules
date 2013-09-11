<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /icms_version.php
 * 
 * module informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

include_once ICMS_ROOT_PATH . '/modules/' . basename(dirname(dirname(__FILE__))) . '/include/common.php';

function icmspoll_search($queryarray, $andor, $limit, $offset, $userid) {
	$icmspoll_poll_handler = icms_getModuleHandler('polls', ICMSPOLL_DIRNAME, 'icmspoll');
	$pollsArray = $icmspoll_poll_handler->getPollsForSearch($queryarray, $andor, $limit, $offset, $userid);

	$ret = array();

	foreach ($pollsArray as $pollArray) {
		$item['image'] = "images/icmspoll_icon_search.png";
		$item['link'] = $pollArray['itemURL'];
		$item['title'] = $pollArray['question'];
		$item['time'] = strtotime($pollArray['start_time']);
		$item['uid'] = $pollArray['user_id'];
		$ret[] = $item;
		unset($item);
	}
	return $ret;
}