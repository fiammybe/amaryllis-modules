<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /blocks/downloads_category_menu.php
 * 
 * block to show category menu
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
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$uid = is_object(icms::$user) ? icms::$user->getVar('uid') : 0;
	$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
	
	$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');

	//$block['downloads_category'] = $downloads_category_handler->getCategoryListForMenu($options[0], $options[1], TRUE, TRUE, TRUE, $options[3], $options[2]);
	$block['downloads_category'] = getDownloadCategories($options[1],$options[2],$options[3],$options[0]);
	return $block;
}

function b_downloads_category_menu_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');
	
	$sort = array('weight' => _CO_DOWNLOADS_CATEGORY_WEIGHT, 'category_title' => _CO_DOWNLOADS_CATEGORY_CATEGORY_TITLE);
	$selsort = new icms_form_elements_Select('', 'options[2]', $options[2]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[3]', $options[3]);
	$selorder->addOptionArray($order);
	$showsubs = new icms_form_elements_Radioyn('', 'options[1]', $options[1]);
	$selcats = new icms_form_elements_Select('', 'options[0]', $options[0]);
	$selcats->addOptionArray($downloads_category_handler->getCategoryListForPid($groups = array(), 'category_grpperm', TRUE, TRUE, null, TRUE));
	
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
/**
 * original by content menu
 */


function getDownloadCategories($showsubs = TRUE, $sort='weight', $order='ASC', $category_id = 0 ) {
	global $downloads_category_handler;
	$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');
	$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
	$criteria = new icms_db_criteria_Compo(new icms_db_criteria_Item('category_inblocks', 1));
	
	$criteria->add(new icms_db_criteria_Item('category_pid', $category_id));
	
	$criteria->add(new icms_db_criteria_Item('category_approve', TRUE));
	$crit = new icms_db_criteria_Compo();
	$crit->add(new icms_db_criteria_Item('category_active', TRUE));
	$criteria->add($crit);
	$criteria->setSort($sort);
	$criteria->setOrder($order);
	$impress_category = $downloads_category_handler->getObjects($criteria);
	$i = 0;
	$categories = array();
	foreach ($impress_category as $category){
		if (icms::handler('icms_member_groupperm')->checkRight('category_read', $category->getVar('category_id'), $groups, $module->getVar('mid'))){
			$categories[$i]['title'] = $category->getVar('category_title');
			$categories[$i]['itemLink'] = DOWNLOADS_URL . "index.php?category_id=" . $category->getVar("category_id");
			if ($showsubs){
				$subs = getDownloadCategories($showsubs, $sort, $order, $category->getVar('category_id'));
				if (count($subs) > 0){
					$categories[$i]['hassubs'] = 1;
					$categories[$i]['subcategories'] = $subs;
				}else{
					$categories[$i]['hassubs'] = 0;
				}
			}
			$i++;
		}
	}

	return $categories;
}
