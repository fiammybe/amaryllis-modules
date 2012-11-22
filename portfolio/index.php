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
if(icms::$module->config['default_startpage'] == 1) header("location: category.php");
$xoopsOption['template_main'] = 'portfolio_index.html';

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

$portfolio_portfolio_handler = icms_getModuleHandler( "portfolio", icms::$module->getVar('dirname'), "portfolio");
$columns = $portfolioConfig['show_portfolio_columns'];
$rows = $portfolioConfig['show_portfolio_rows'];
$limit = ($columns > 0 && $rows > 0) ? (int)$columns * (int)$rows : FALSE;
$portfolios = $portfolio_portfolio_handler->getPortfolios(TRUE, "weight", "DESC", 0, $limit, FALSE);
$portfolio_columns = ($columns > 0  && $rows > 0) ? array_chunk($portfolios, $columns) : FALSE;

$icmsTpl->assign("portfolio_columns", $portfolio_columns);
$icmsTpl->assign("portfolios", $portfolios);

include_once 'footer.php';