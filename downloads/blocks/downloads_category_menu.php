<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /blocks/downloads_category_menu.php
 * 
 * block to show recent albums
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

function b_downloads_category_menu_show($options) {
	global $downloadsConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');

	$block['downloads_category'] = $downloads_category_handler->getCategoryListForMenu($start = 0, $limit = 0, $order = $options[0], $sort = $options[1],$groups = array(), $perm = 'category_grpperm', $status = true,$approved = true,$inblocks = true, $category_id = $options[3]);
	
	return $block;
}

function b_downloads_category_menu_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');
	
	$sort = array('weight' => _CO_DOWNLOADS_CATEGORY_WEIGHT, 'category_title' => _CO_DOWNLOADS_CATEGORY_CATEGORY_TITLE);
	$selsort = new icms_form_elements_Select('', 'options[0]', $options[0]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selorder->addOptionArray($order);
	$showsubs = new icms_form_elements_Radioyn('', 'options[2]', $options[2]);
	$selcats = new icms_form_elements_Select('', 'options[3]', $options[3]);
	$selcats->addOptionArray($downloads_category_handler->getCategoryListForPid($groups = array(), $perm = 'category_grpperm', $status = true,$approved = true,$inblocks = true, false, $showNull = true));
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_DOWNLOADS_CATEGORY_CATSELECT . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_DOWNLOADS_CATEGORY_SHOWSUBS . '</td>';
	$form .= '<td>' . $showsubs->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_DOWNLOADS_CATEGORY_SORT . '</td>';
	$form .= '<td>' . $selsort->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_DOWNLOADS_CATEGORY_ORDER . '</td>';
	$form .= '<td>' . $selorder->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';

	return $form;
}