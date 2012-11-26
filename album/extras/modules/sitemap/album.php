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

function b_sitemap_album() {
	$block = sitemap_get_categoires_map( icms::$xoopsDB -> prefix( 'album_album' ), 'album_id', 'album_pid', 'album_title', 'index.php?album_id=', 'album_id');
	return $block;
}
?>