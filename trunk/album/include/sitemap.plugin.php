<?php
/**
 * 'Tutorials' is a tutorial/article/content module for ImpressCMS
 *
 * File: /include/sitemap.plugin.php
 *
 * holds sitemap informations
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tutorials
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: sitemap.plugin.php 190 2013-06-14 09:28:42Z qm-b $
 * @package		tutorials
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("ALBUM_DIRNAME")) define("ALBUM_DIRNAME", basename(dirname(dirname(__FILE__))));

function b_sitemap_album() {
	$url = 'index.php?page=';
	if(icms_get_module_status("album")) {
		$albumModule = icms_getModuleInfo("album");
		$albumConfig = icms_getModuleConfig("album");
		$url = ($albumConfig['use_main'] == 1) ? ICMS_URL.'/'.$albumModule->getVar("dirname").'.php?album=' : ICMS_MODULES_URL.'/'.$albumModule->getVar("dirname").'/index.php?album=';
	}
	$block = sitemap_get_categoires_map( icms::$xoopsDB->prefix('album_album'), 'album_id', 'album_pid', 'album_title', $url, 'weight', "short_url");
	return $block;
}