<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /blocks/portfolio_spotlight.php
 * 
 * spotlight block
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

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("PORTFOLIO_DIRNAME")) define("PORTFOLIO_DIRNAME",basename(dirname(dirname(__FILE__))));

function b_portfolio_spotlight_show($options) {
	global $portfolioConfig, $xoTheme;
	include_once ICMS_ROOT_PATH . '/modules/' . PORTFOLIO_DIRNAME . '/include/common.php';
	$portfolio_handler = icms_getModuleHandler('portfolio', PORTFOLIO_DIRNAME, 'portfolio');
	$portfolios = $portfolio_handler->getPortfolios(TRUE, "portfolio_p_date", "DESC", 0, $options[0], $options[1]);
	$block['thumbnail_width'] = $portfolioConfig['thumbnail_width'];
	$block['thumbnail_height'] = $portfolioConfig['thumbnail_height'];
	$block['portfolio_spotlight'] = $portfolios;
	return $block;
}

function b_portfolio_spotlight_edit($options) {
	include_once ICMS_ROOT_PATH . '/modules/' . PORTFOLIO_DIRNAME . '/include/common.php';
	$portfolio_handler = icms_getModuleHandler('portfolio', PORTFOLIO_DIRNAME, 'portfolio');
	$category_handler = icms_getModuleHandler('category', PORTFOLIO_DIRNAME, 'portfolio');
	$limit = new icms_form_elements_Text("", "options[0]", 7, 10, $options[0]);
	
	$groups = (is_object(icms::$user)) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($category_handler->getCategoryList(TRUE, TRUE));
	$form = '<table>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_PORTFOLIO_PORTFOLIO_RECENT_LIMIT . '</td>';
	$form .= '<td>' . $limit->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_PORTFOLIO_CATEGORY_CATSELECT . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}