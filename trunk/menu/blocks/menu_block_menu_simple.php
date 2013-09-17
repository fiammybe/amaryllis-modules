<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /blocks/menu_block_menu_simple.php
 *
 * simple menu block
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function b_menu_menu_simple_show($options) {
	global $xoTheme, $icmsConfig;
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_MODULES_PATH . '/' . $moddir . '/include/common.php';
	$menu_handler = icms_getModuleHandler('menu', MENU_DIRNAME, 'menu');
	$item_handler = icms_getModuleHandler('item', MENU_DIRNAME, 'menu');
	$block["current_url"] = $current_url;
	$block["home_link"] = ICMS_URL.'/index.php';
	$menuObj = $menu_handler->get($options[0]);
	$menu = $item_handler->_currentMenu = $menuObj->toArray();
	$urls = icms_getCurrentUrls();
	$block['is_home'] = $urls['isHomePage'];
	$block['menu_menu'] = $menu;
	$block['menu_items'] = $item_handler->getItems(TRUE, NULL, $options[0], FALSE,FALSE,"item_view", $menuObj->getOrder(), $menuObj->getSort(), $icmsConfig['language']);
	$block['jsfile'] = ($options[1] !== 0) ? $options[1] : FALSE;
	$block['script_url'] = MENU_URL . "scripts/";
	$block['block_id'] = $options[3];
	($options[3] != 0) ? $xoTheme->addStylesheet('/modules/' . MENU_DIRNAME . '/scripts/' . $options[2]) : $block['nocss'] = TRUE;
	return $block;
}

function b_menu_menu_simple_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_MODULES_PATH . '/' . $moddir . '/include/common.php';
	$clean_bid = isset($_GET["bid"]) ? filter_input(INPUT_GET, "bid", FILTER_SANITIZE_NUMBER_INT) : 0 ;

	$menu_handler = icms_getModuleHandler('menu', MENU_DIRNAME, 'menu');

	$selmenu = new icms_form_elements_Select("", "options[0]", $options[0]);
	$selmenu->addOptionArray($menu_handler->getList());

	$jsfiles = getFileList("js");
	$jsselect = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$jsselect->addOptionArray($jsfiles);

	$cssfiles = getFileList("css");
	$cssselect = new icms_form_elements_Select('', 'options[2]', $options[2]);
	$cssselect->addOptionArray($cssfiles);

	$hidden = new icms_form_elements_Hidden("options[3]", $clean_bid);

	$form = '<table>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_SELECT_MENU . '</td>';
	$form .= '<td>' . $selmenu->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_JSSELECT . '</td>';
	$form .= '<td>' . $jsselect->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_CSSSELECT . '</td>';
	$form .= '<td>' . $cssselect->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . $hidden->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}


function getFileList($src = "") {
	$filesList = icms_core_Filesystem::getFileList(ICMS_MODULES_PATH . '/' . MENU_DIRNAME . '/scripts/', '', array($src));
	$files[0] = '-----------------------';
	foreach(array_keys($filesList) as $i ) {
		$files[$i] = $filesList[$i];
	}
	return $files;
}