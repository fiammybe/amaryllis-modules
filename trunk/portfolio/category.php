<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /index.php
 * 
 * module home
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

include_once 'header.php';

$xoopsOption['template_main'] = 'portfolio_category.html';

include_once ICMS_ROOT_PATH . '/header.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// MAIN HEADINGS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$portfolio_indexpage_handler = icms_getModuleHandler( "indexpage", icms::$module -> getVar( 'dirname' ), "portfolio" );
$indexpageObj = $portfolio_indexpage_handler->get(1);
$index = $indexpageObj->toArray();
$icmsTpl->assign('portfolio_index', $index);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// MAIN PART /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$portfolio_handler = icms_getModuleHandler( "portfolio", icms::$module->getVar('dirname'), "portfolio");
$category_handler = icms_getModuleHandler("category", icms::$module->getVar("dirname"), "portfolio");
$clean_category_id = isset($_GET['category_id']) ? filter_input(INPUT_GET, 'category_id', FILTER_SANITIZE_NUMBER_INT) : 0;
$clean_category = isset($_GET['category']) ? filter_input(INPUT_GET, 'category') : FALSE;
$clean_start = isset($_GET['start']) ? filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT) : 0;
if($clean_category) {
	$categoryObj = $category_handler->getCatBySeo($clean_category);
} elseif($clean_category_id > 0) {
	$categoryObj = $category_handler->get($clean_category_id);
} else {
	$categoryObj = FALSE;
}
/**
 * retrieve a single category including files of the category and subcategories
 */
if (is_object($categoryObj) && (!$categoryObj->isNew()) && ($categoryObj->accessGranted())) {
	$category_handler->updateCounter($categoryObj->id());
	$category = $categoryObj->toArray();
	$icmsTpl->assign('portfolio_single_cat', $category);
	
	$columns = (int)$portfolioConfig['show_portfolio_columns'];
	$rows = (int)$portfolioConfig['show_portfolio_rows'];
	$limit = ($columns > 0 && $rows > 0) ? $columns * (int)$rows : FALSE;
	
	$portfolios = $portfolio_handler->getPortfolios(TRUE, "weight", "DESC", $clean_start, $limit, FALSE);
	$portfolio_columns = ($columns > 0  && $rows > 0) ? array_chunk($portfolios, $columns) : FALSE;
	$icmsTpl->assign("portfolio_columns", $portfolio_columns);
	if(!$portfolio_columns) $icmsTpl->assign("portfolios", $portfolios);
	
	$count = $portfolio_handler->getPortfoliosCount(TRUE, "weight", "DESC", $clean_start, $limit, FALSE);
	$extra_arg = ($clean_category) ? 'category='.$clean_category : FALSE;
	$pagenav = new icms_view_PageNav($count, $limit, $clean_start, 'start', $extra_arg);
	$icmsTpl->assign('pagenav', $pagenav->renderNav());

	if ($portfolioConfig['show_breadcrumbs']){
		$icmsTpl->assign('portfolio_cat_path', $categoryObj->getItemLink());
	}

	$icms_metagen = new icms_ipf_Metagen($categoryObj->title(), $categoryObj->meta_keywords(), $categoryObj->meta_description());
	$icms_metagen->createMetaTags();
/**
 * if there's no valid category, retrieve a list of all primary categories
 */
} elseif ($clean_category_id == 0 || !$clean_category) {
	$categories = $category_handler->getCategories(TRUE, "weight", "ASC", 0, FALSE);
	$icmsTpl->assign('categories', $categories);
} else {
	redirect_header(PORTFOLIO_URL, 3, _NOPERM);
}
include_once 'footer.php';