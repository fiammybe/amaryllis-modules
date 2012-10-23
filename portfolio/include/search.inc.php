<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /include/search.inc.php
 * 
 * holding search informations
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
include_once ICMS_ROOT_PATH . '/modules/' . basename(dirname(dirname(__FILE__))) . '/include/common.php';

function portfolio_search($queryarray, $andor, $limit, $offset, $userid) {
	$portfolio_portfolio_handler = icms_getModuleHandler('portfolio', PORTFOLIO_DIRNAME, 'portfolio');
	$portfoliosArray = $portfolio_portfolio_handler->getPortfolioForSearch($queryarray, $andor, $limit, $offset, $userid);
	$ret = array();
	foreach ($portfoliosArray as $portfolioArray) {
		$item['image'] = "images/portfolio_icon.png";
		$item['link'] = $portfolioArray['itemURL'];
		$item['title'] = $portfolioArray['portfolio_title'];
		$item['time'] = strtotime($portfolioArray['portfolio_p_date']);
		$item['uid'] = $portfolioArray['portfolio_submitter'];
		$ret[] = $item;
		unset($item);
	}
	return $ret;
}