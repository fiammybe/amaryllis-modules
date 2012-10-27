<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /blocks/portfolio_recent_portfolios.php
 * 
 * recent portfolios block
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
function b_portfolio_recent_portfolios_show($options) {
	global $portfolioConfig;
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$portfolio_portfolio_handler = icms_getModuleHandler('portfolio', $moddir, 'portfolio');
	$portfolios = $portfolio_portfolio_handler->getPortfolios(TRUE,$options[2], $options[3], 0, $options[0], $options[1]);
	$block['portfolio_portfolios'] = $portfolios;
	return $block;
}
function b_portfolio_recent_portfolios_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$portfolio_portfolio_handler = icms_getModuleHandler('portfolio', $moddir, 'portfolio');
	$portfolio_category_handler = icms_getModuleHandler('category', $moddir, 'portfolio');
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($portfolio_category_handler->getCategoryList(TRUE, TRUE));
	$sort = array('weight' => _CO_PORTFOLIO_PORTFOLIO_WEIGHT, 'portfolio_title' => _CO_PORTFOLIO_PORTFOLIO_PORTFOLIO_TITLE, 'portfolio_p_date' => _CO_PORTFOLIO_PORTFOLIO_PORTFOLIO_P_DATE);
	$selsort = new icms_form_elements_Select('', 'options[2]', $options[2]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[3]', $options[3]);
	$selorder->addOptionArray($order);
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_PORTFOLIO_PORTFOLIO_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[0]" value="' . $options[0] . '"/></td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_PORTFOLIO_CATEGORY_CATSELECT . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_PORTFOLIO_SORT . '</td>';
	$form .= '<td>' . $selsort->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_PORTFOLIO_ORDER . '</td>';
	$form .= '<td>' . $selorder->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}