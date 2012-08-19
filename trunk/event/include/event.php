<?php
/**
 * -----------------------------------------------------------------------------
 * About this sitemap plug-in : events for Sitemap
 *
 * Name					: 	event.php
 * Author				: 	QM-B
 *
 * Necessary modules	:	Sitemap 1.40+
 *							event 1.0
 *
 * -----------------------------------------------------------------------------
**/

function b_sitemap_event() {
	$block = sitemap_get_categoires_map( icms::$xoopsDB -> prefix( 'event_category' ), 'category_id', FALSE, 'category_name', 'index.php?cat=', 'short_url');
	return $block;
}
?>