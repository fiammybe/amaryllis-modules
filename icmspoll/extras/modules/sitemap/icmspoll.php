<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /extras/modules/sitemap/icmspoll.php
 * 
 * Sitemap plugin for icmspoll module. Requires Sitemap 1.40 or above. If does not copy automatically on install, please
 * copy file to /root/modules/sitemap/plugins/
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: icmspoll.php 11 2012-06-27 12:30:05Z qm-b $
 * @package		icmspoll
 *
 */

function b_sitemap_icmspoll() {
	$block = sitemap_get_categoires_map( icms::$xoopsDB->prefix('icmspoll_polls' ), 'poll_id', '', 'question', 'index.php?poll_id=', 'poll_id');
	return $block;
}