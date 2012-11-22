<?php
/**
 * -----------------------------------------------------------------------------
 * About this sitemap plug-in : portfolio for Sitemap
 *
 * Name					: 	portfolio.php
 * Author				: 	QM-B
 *
 * Necessary modules	:	Sitemap 1.40+
 *							portfolio 1.0
 *
 * -----------------------------------------------------------------------------
**/

function b_sitemap_portfolio() {
	$block = sitemap_get_categoires_map( icms::$xoopsDB -> prefix( 'portfolio_category' ), 'category_id', FALSE, 'category_title', 'index.php?category_id=', 'category_id');
	return $block;
}
?>