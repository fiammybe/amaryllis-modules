<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /blocks/article_most_popular.php
 * 
 * block for most popular articles
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
function b_article_articles_show($options) {
	global $articleConfig, $xoTheme;
	
	include_once ICMS_ROOT_PATH . '/modules/' . ARTICLE_DIRNAME . '/include/common.php';
	$article_handler = icms_getModuleHandler('article', ARTICLE_DIRNAME, 'article');
	
	$target = switchTarget($options[3]);
	$cattarget = ($options[1] == 0) ? '' : '&category_id=' . $options[1];
	$block['view_all'] = ARTICLE_URL . 'index.php?op=' . $target . $cattarget;
	$block['show_view_all'] = $options[2];
	$updated = ($options[3] == 'article_updated_date') ? TRUE : FALSE;
	$popular = ($options[3] == 'article_comments') ? TRUE : FALSE;
	$block['article_article'] = $article_handler->getArticles(TRUE, TRUE, FALSE, FALSE, $options[1], FALSE, $updated, $popular,0, $options[0], $options[3], $options[4], TRUE);
	
	$xoTheme->addStylesheet('/modules/' . ARTICLE_DIRNAME . '/module_article_block.css');
	
	return $block;
}

function b_article_articles_edit($options) {
	include_once ICMS_ROOT_PATH . '/modules/' . ARTICLE_DIRNAME . '/include/common.php';
	$article_handler = icms_getModuleHandler('article', ARTICLE_DIRNAME, 'article');
	$category_handler = icms_getModuleHandler('category', INDEX_DIRNAME, 'index');
	
	$limit = new icms_form_elements_Text("", 'options[0]', 7, 40, $options[0]);
	
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($category_handler->getCategoryListForPid());
	
	$showmore = new icms_form_elements_Radioyn('', 'options[2]', $options[2]);
	
	$sort = array('weight' => _CO_ICMS_WEIGHT_FORM_CAPTION, 'article_title' => _CO_ARTICLE_ARTICLE_ARTICLE_TITLE, 'counter' => _CO_ICMS_COUNTER_FORM_CAPTION, 'article_comments' => _CO_ARTICLE_ARTICLE_ARTICLE_COMMENTS,
					'RAND()' => 'RAND()', 'article_published_date' => _CO_ARTICLE_ARTICLE_ARTICLE_PUBLISHED_DATE, 'article_updated_date' => _CO_ARTICLE_ARTICLE_ARTICLE_UPDATED_DATE );
	$selsort = new icms_form_elements_Select('', 'options[3]', $options[3]);
	$selsort->addOptionArray($sort);
	
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[4]', $options[4]);
	$selorder->addOptionArray($order);
	
	$showteaser = new icms_form_elements_Radioyn('', 'options[2]', $options[5]);
	
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
	$form .= '<td>' . _MB_ARTICLE_SHOWMORE . '</td>';
	$form .= '<td>' . $showmore->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ARTICLE_SORT . '</td>';
	$form .= '<td>' . $selsort->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ARTICLE_ORDER . '</td>';
	$form .= '<td>' . $selorder->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ARTICLE_SHOWTEASER . '</td>';
	$form .= '<td>' . $showteaser->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}

function switchTarget($case) {
	switch ($case) {
		case 'weight':
		case 'article_title':
		case 'weight':
		case 'article_published_date':
		case 'RAND()':
			$ret = 'viewRecentArticles';
			break;
		case 'article_updated_date':
			$ret = 'viewRecentUpdated';
			break;
		case 'counter':
			$ret = 'getMostPopular';
			break;
		case 'article_comments':
			$ret = 'getMostCommented';
			break;
		return $ret;
	}
}
