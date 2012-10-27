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
function b_portfolio_spotlight_show($options) {
	global $portfolioConfig, $xoTheme;
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$portfolio_portfolio_handler = icms_getModuleHandler('portfolio', 'portfolio');
	$portfolios = $portfolio_portfolio_handler->getPortfolios(TRUE, "portfolio_p_date", "DESC", 0, $options[0], $options[1]);
	$block['thumbnail_width'] = $portfolioConfig['thumbnail_width'];
	$block['thumbnail_height'] = $portfolioConfig['thumbnail_height'];
	$block['portfolio_spotlight'] = $portfolios;
	return $block;
}
function b_portfolio_spotlight_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$portfolio_portfolio_handler = icms_getModuleHandler('portfolio', $moddir, 'portfolio');
	$portfolio_category_handler = icms_getModuleHandler('category', $moddir, 'portfolio');
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($portfolio_category_handler->getCategoryList(TRUE, TRUE));
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_PORTFOLIO_PORTFOLIO_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[0]" value="' . $options[0] . '"/></td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_PORTFOLIO_CATEGORY_CATSELECT . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}