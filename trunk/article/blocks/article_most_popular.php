<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /blocks/article_most_popular.php
 * 
 * block for most popular articles
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
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

function b_article_most_popular_show($options) {
	global $articleConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$article_article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');

	$block['article_popular'] = $article_article_handler->getArticlesForBlocks(0, $options[0], FALSE, TRUE, "article_published_date", "DESC");
	
	return $block;
}

function b_article_most_popular_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$article_article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_ARTICLE_ARTICLE_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}