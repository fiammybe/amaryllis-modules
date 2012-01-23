<?php
/**
 * -----------------------------------------------------------------------------
 * About this sitemap plug-in : downloads for Sitemap
 *
 * Name					: 	downloads.php
 * Author				: 	QM-B
 *
 * Necessary modules	:	Sitemap 1.40+
 *							downloads 1.0
 *
 * -----------------------------------------------------------------------------
**/

function b_sitemap_downloads() {
	$block = sitemap_get_categoires_map( icms::$xoopsDB -> prefix( 'downloads_category' ), 'category_id', 'category_pid', 'category_title', 'index.php?category_id=', 'category_id');
	return $block;
}
?>