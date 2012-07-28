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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("MENU_DIRNAME")) define("MENU_DIRNAME", basename(dirname(dirname(__FILE__))));
 
function b_menu_megamenu_show($options) {
	global $xoTheme;
	include_once ICMS_MODULES_PATH . '/' . MENU_DIRNAME . '/include/common.php';
	
	$menu_handler = icms_getModuleHandler("menu", MENU_DIRNAME, "menu");
	$item_handler = icms_getModuleHandler("item", MENU_DIRNAME, "menu");
	
	$menuObj = $menu_handler->get($options[0]);
	
	$block['megamenu'] = $menuObj->toArray();
	$block['mega_items'] = $item_handler->getItems(TRUE, NULL, $options[0], FALSE,FALSE,$options[1],$options[2],"item_view");
	
	
	$menu_kind = $menuObj->getVar("menu_kind");
	if($menu_kind == "dynamic_horizontal" || $menu_kind == "dynamic_vertical") {
		if(icms_get_module_status("index")) {
			$category_handler = icms_getModuleHandler("category", $moddir, "index");
			$block['index_megamenu'] = $category_handler->getCategories(FALSE, TRUE, TRUE, 0, 0, $options[1], $options[2], NULL, FALSE, TRUE, "cat_view");
		}
	}
	
	$block['script_url'] = MENU_URL . "scripts/megamenu/";
	$block['display_images'] = $options[3];
	$block['effect'] = $options[4];
	$block['event'] = $options[5];
	$block['fullWidth'] = ($options[6] == "1") ? TRUE : FALSE;
	$block['direction'] = $options[8];
	
	if($menu_kind == "vertical" || $menu_kind == "dynamic_vertical") {
		$cssfile = "dcverticalmegamenu.css";
		$jsfile = "jquery.dcverticalmegamenu.1.1.js";
		$block['vertical'] = TRUE;
	} elseif ($menu_kind == "horizontal" || $menu_kind == "dynamic_horizontal") {
		$cssfile = "dcmegamenu.css";
		$jsfile = "jquery.dcmegamenu.1.3.3.min.js";
		$block['vertical'] = FALSE;
	}
	$block['script'] = $jsfile;
	
	(!$options[7] == "0" && !$menu_kind == "vertical") ? $xoTheme->addStylesheet('/modules/' . MENU_DIRNAME . '/scripts/megamenu/css/skins/' . $options[7]) : "";
	$xoTheme->addStylesheet('/modules/' . MENU_DIRNAME . '/scripts/megamenu/css/' . $cssfile);
	$block['color_class'] = array_shift(explode(".", $options[7]));
	return $block;
}

function b_menu_megamenu_edit($options) {
	
	include_once ICMS_MODULES_PATH . '/' . MENU_DIRNAME . '/include/common.php';
	
	$menu_handler = icms_getModuleHandler('menu', MENU_DIRNAME, 'menu');
	
	$selmenu = new icms_form_elements_Select("", "options[0]", $options[0]);
	$selmenu->addOptionArray($menu_handler->getList());
	
	$sort = array('weight' => _CO_ICMS_WEIGHT_FORM_CAPTION, 'item_name' => _CO_MENU_ITEM_ITEM_NAME);
	$selsort = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selsort->addOptionArray($sort);
	
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[2]', $options[2]);
	$selorder->addOptionArray($order);
	
	$showimgs = new icms_form_elements_Radioyn('', 'options[3]', $options[3]);
	
	$effects = array('slide' => 'slide' , 'fade' => 'fade', 'show' => 'show');
	$seleffect = new icms_form_elements_Select('', 'options[4]', $options[4]);
	$seleffect->addOptionArray($effects);
	
	$events = array('hover' => 'hover' , 'click' => 'click');
	$selevent = new icms_form_elements_Select('', 'options[5]', $options[5]);
	$selevent->addOptionArray($events);
	
	$fullWidth = new icms_form_elements_Radioyn('', 'options[6]', $options[6]);
	
	$styles = getCssFileList("css");
	$selstyle = new icms_form_elements_Select('', 'options[7]', $options[7]);
	$selstyle->addOptionArray($styles);
	
	$directions = array('left' => 'left' , 'right' => 'right');
	$seldirection = new icms_form_elements_Select('', 'options[8]', $options[8]);
	$seldirection->addOptionArray($directions);
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_SELECT_MENU . '</td>';
	$form .= '<td>' . $selmenu->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_SORT . '</td>';
	$form .= '<td>' . $selsort->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_ORDER . '</td>';
	$form .= '<td>' . $selorder->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_MENU_SHOWIMGS . '</td>';
	$form .= '<td>' . $showimgs->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_SELEFFEKT . '</td>';
	$form .= '<td>' . $seleffect->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_SELEVENT . '</td>';
	$form .= '<td>' . $selevent->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_FULLWIDTH . '</td>';
	$form .= '<td>' . $fullWidth->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_SELSTYLE . '</td>';
	$form .= '<td>' . $selstyle->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_MENU_SELDIRECTION . '</td>';
	$form .= '<td>' . $seldirection->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';

	return $form;
}

function getCssFileList($src = "") {
	$filesList = icms_core_Filesystem::getFileList(ICMS_MODULES_PATH . '/' . MENU_DIRNAME . '/scripts/megamenu/css/skins/', '', array($src));
	$files[0] = '-----------------------';
	foreach(array_keys($filesList) as $i ) {
		$files[$i] = $filesList[$i];
	}
	return $files;
}