<?php
/**
 * -----------------------------------------------------------------------------
 * About this sitemap plug-in : article for Sitemap
 *
 * Name					: 	article.php
 * Author				: 	QM-B
 *
 * Necessary modules	:	Sitemap 1.40+
 *							article 1.0
 *
 * -----------------------------------------------------------------------------
**/

function b_sitemap_article() {
	$block = sitemap_get_categoires_map( icms::$xoopsDB -> prefix( 'article_category' ), 'category_id', 'category_pid', 'category_title', 'index.php?category_id=', 'category_id');
	return $block;
}
?>