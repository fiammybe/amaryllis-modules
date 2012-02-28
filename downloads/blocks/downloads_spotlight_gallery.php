<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /blocks/downloads_spotlight_gallery.php
 * 
 * Gallery Block for downloads
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

function b_downloads_spotlight_image_show($options) {
	global $downloadsConfig, $xoTheme;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');
	
	$downloadsConfig = icms_getModuleConfig(basename(dirname(dirname(__FILE__))));
	$downloads = $downloads_download_handler->getDownloadsForBlocks(0, $options[0], FALSE, FALSE, $options[5], $options[6], $options[1], TRUE);
	$block['view_all'] = DOWNLOADS_URL . 'index.php?op=viewRecentDownloads&category_id=' . $options[1];
	$block['show_view_all'] = $options[3];
	$block['showteaser'] = $options[2];
	$block['display_width'] = $options[4];
	$block['downloads_gallery'] = $downloads;

	$xoTheme->addStylesheet('/modules/' . DOWNLOADS_DIRNAME . '/module_downloads_blocks.css');
	
	return $block;
}

function b_downloads_spotlight_image_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$limit = new icms_form_elements_Text('', 'options[0]', 60, 255, $options[0]);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($downloads_category_handler->getCategoryListForPid());
	$showsubs = new icms_form_elements_Radioyn('', 'options[2]', $options[2]);
	$showmore = new icms_form_elements_Radioyn('', 'options[3]', $options[3]);
	$display_size = new icms_form_elements_Text('', 'options[4]', 60, 255, $options[4]);
	
	$sort = array('weight' => _CO_DOWNLOADS_CATEGORY_WEIGHT, 'download_published_date' => _CO_DOWNLOADS_DOWNLOAD_DOWNLOAD_PUBLISHED_DATE);
	$selsort = new icms_form_elements_Select('', 'options[5]', $options[5]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[6]', $options[6]);
	$selorder->addOptionArray($order);
	
	$form = '<table>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_DOWNLOADS_DOWNLOAD_RECENT_LIMIT . '</td>';
	$form .= '<td>' . $limit->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_DOWNLOADS_CATEGORY_CATSEL . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_DOWNLOADS_SHOWTEASER . '</td>';
	$form .= '<td>' . $showsubs->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_DOWNLOADS_SHOWMORE . '</td>';
	$form .= '<td>' . $showmore->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_DOWNLOADS_DISPLAY_SIZE . '</td>';
	$form .= '<td>' . $display_size->render() . '</td>';
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