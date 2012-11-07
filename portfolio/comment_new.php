<?php
/**
 * 'Career' is an portfolio management module for ImpressCMS
 *
 * File: /comment_new.php
 * 
 * add comments
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

include_once 'header.php';

$com_itemid = isset($_GET['com_itemid']) ? filter_input(INPUT_GET, 'com_itemid', FILTER_SANITIZE_NUMBER_INT) : 0;
if ($com_itemid > 0) {
	$portfolio_handler = icms_getModuleHandler("portfolio", basename(dirname(__FILE__)),"portfolio");
	$portfolioObj = $portfolio_handler->get($com_itemid);
	if ($portfolioObj && !$portfolioObj->isNew()) {
		$com_replytext = "";
		$bodytext = $portfolioObj->getVar('portfolio_body');
		if ($bodytext != '') {
			$com_replytext .= $bodytext;
		}
		$com_replytitle = $portfolioObj->getVar('portfolio_title');
		include_once ICMS_ROOT_PATH .'/include/comment_new.php';
	}
}