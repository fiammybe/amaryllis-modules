<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /blocks/icmspoll_recent_polls.php
 * 
 * block for recent polls
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

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
/**
 * display recent polls block
 */
function b_icmspoll_recent_polls_show($options) {
	global $icmspollConfig;
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
	$block["icmspoll_polls"] = $polls_handler->getPolls(0, $options[0], $options = "end_time", $sort = "DESC", $uid = FALSE, $expired = FALSE, $inBlocks = FALSE);
}

/**
 * edit recent polls block
 */
function b_icmspoll_recent_polls_edit($options) {
	10|0|0|0|ASC|weight'; // Limit|uid|expired|random|sort|order|
}
