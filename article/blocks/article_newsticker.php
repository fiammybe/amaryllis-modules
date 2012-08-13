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
function b_article_newsticker_show($options) {
	global $xoTheme;
	include_once ICMS_ROOT_PATH . '/modules/' . ARTICLE_DIRNAME . '/include/common.php';
	$article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
	
	$articles = $article_handler->getArticles(TRUE, TRUE, FALSE, FALSE, $options[1],  FALSE, FALSE, FALSE, 0, $options[0], 'article_published_date', 'DESC', TRUE, FALSE);
	$block['article_newsticker'] = $articles;
	
	$xoTheme->addStylesheet('/modules/' . ARTICLE_DIRNAME . '/module_article_block.css');
	
	return $block;
}

function b_article_newsticker_edit($options) {
	include_once ICMS_ROOT_PATH . '/modules/' . ARTICLE_DIRNAME . '/include/common.php';
	$article_handler = icms_getModuleHandler('article', ARTICLE_DIRNAME, 'article');
	$category_handler = icms_getModuleHandler('category', INDEXD_DIRNAME, 'index');
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($category_handler->getCategoryListForPid($groups=array(), 'category_grpperm', TRUE, TRUE, TRUE, NULL, TRUE));
	
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_ARTICLE_ARTICLE_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[0]" value="' . $options[0] . '"/></td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_ARTICLE_CATEGORY_CATSELECT . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}