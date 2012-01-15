<?php
/**
 * -----------------------------------------------------------------------------
 * About this sitemap plug-in : career for Sitemap
 *
 * Name					: 	career.php
 * Author				: 	QM-B
 *
 * Necessary modules	:	Sitemap 1.40+
 *							career 1.0
 *
 * -----------------------------------------------------------------------------
**/

function b_sitemap_career() {
	$block = sitemap_get_categoires_map( icms::$xoopsDB->prefix('career_department' ), 'department_id', FALSE, 'department_title', 'index.php?did=', 'department_id');
	return $block;
}
?>