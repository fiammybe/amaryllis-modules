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
function b_portfolio_categories_show($options) {
	global $portfolioConfig;
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$uid = is_object(icms::$user) ? icms::$user->getVar('uid') : 0;
	$module = icms::handler('icms_module')->getByDirname($moddir);
	$portfolio_category_handler = icms_getModuleHandler('category', $moddir, 'portfolio');
	$block['portfolio_category'] = $portfolio_category_handler->getCategories(TRUE, $options[0], $options[1]);
	return $block;
}
function b_portfolio_categories_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$portfolio_category_handler = icms_getModuleHandler('category', $moddir, 'portfolio');
	$sort = array('weight' => _CO_PORTFOLIO_CATEGORY_WEIGHT, 'category_title' => _CO_PORTFOLIO_CATEGORY_CATEGORY_TITLE, 'category_p_date' => _CO_PORTFOLIO_CATEGORY_CATEGORY_P_DATE);
	$selsort = new icms_form_elements_Select('', 'options[0]', $options[0]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selorder->addOptionArray($order);
	$form = '<table>';
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
