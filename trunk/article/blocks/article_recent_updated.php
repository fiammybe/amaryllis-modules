<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /blocks/article_recent_updated.php
 * 
 * block for recent updated articles
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

function b_article_recent_updated_show($options) {
	global $articleConfig, $xoTheme;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$article_article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');
	$block['view_all'] = ARTICLE_URL . 'index.php?op=viewRecentUpdated&category_id=' . $options[1];
	$block['article_updated'] = $article_article_handler->getArticlesForBlocks(0, $options[0],$option[1], TRUE, FALSE, "article_updated_date", "DESC");
	
	$xoTheme->addScript('/modules/' . ARTICLE_DIRNAME . '/scripts/article_block.js', array('type' => 'text/javascript'));
	$xoTheme->addStylesheet('/modules/' . ARTICLE_DIRNAME . '/module_article_block.css');
	
	return $block;
}

function b_article_recent_updated_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$article_article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');
	$article_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'article');
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($article_category_handler->getCategoryListForPid($groups=array(), 'category_grpperm', TRUE, TRUE, TRUE, NULL, TRUE));
	
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