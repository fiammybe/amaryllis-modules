<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /blocks/article_spotlight.php
 * 
 * spotlight block for recent articles
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');
if(!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", basename(dirname(dirname(__FILE__))));
function b_article_spotlight_image_show($options) {
	global $articleConfig, $xoTheme;
	
	include_once ICMS_ROOT_PATH . '/modules/' . ARTICLE_DIRNAME . '/include/common.php';
	$article_handler = icms_getModuleHandler('article', ARTICLE_DIRNAME, 'article');
	
	$articles = $article_handler->getArticles(TRUE, TRUE, FALSE, FALSE, $options[1], FALSE, FALSE, FALSE,0, $options[0], "article_published_date", "DESC", TRUE);
	$block['view_all'] = ARTICLE_URL . 'index.php?op=viewRecentArticles&category_id=' . $options[1];
	$block['show_view_all'] = $options[3];
	$block['showteaser'] = $options[2];
	$block['article_gallery'] = $articles;

	$xoTheme->addStylesheet('/modules/' . ARTICLE_DIRNAME . '/module_article_block.css');
	
	return $block;
}

function b_article_spotlight_image_edit($options) {
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$article_handler = icms_getModuleHandler('article', ARTICLE_DIRNAME, 'article');
	$category_handler = icms_getModuleHandler('category', INDEX_DIRNAME, 'index');
	$limit = new icms_form_elements_Text("", 'options[0]', 7, 40, $options[0]);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($category_handler->getCategoryListForPid());
	$showsubs = new icms_form_elements_Radioyn('', 'options[2]', $options[2]);
	$showmore = new icms_form_elements_Radioyn('', 'options[3]', $options[3]);
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ARTICLE_ARTICLE_RECENT_LIMIT . '</td>';
	$form .= '<td>' . $limit->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_ARTICLE_CATEGORY_CATSELECT . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ARTICLE_SHOWTEASER . '</td>';
	$form .= '<td>' . $showsubs->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ARTICLE_SHOWMORE . '</td>';
	$form .= '<td>' . $showmore->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}