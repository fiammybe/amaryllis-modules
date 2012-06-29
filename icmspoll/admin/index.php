<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/index.php
 * 
 * ACP index file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

include_once "admin_header.php";

$polls_handler = icms_getModuleHandler('polls', basename(dirname(dirname(__FILE__))), 'icmspoll');
$options_handler = icms_getModuleHandler('options', basename(dirname(dirname(__FILE__))), 'icmspoll');

icms_cp_header();
icms::$module->displayAdminMenu(0, _MI_ICMSPOLL_MENU_INDEX);
global $icmspollConfig;

$total_polls = $polls_handler->getCount(FALSE);
$ative_polls = $polls_handler->getPollsCount(FALSE, FALSE, TRUE);
$expired_polls = $polls_handler->getPollsCount(TRUE, FALSE, TRUE);

$sitemapModule = icms_get_module_status("sitemap");
if($sitemapModule) {
	$sitemap_module = _AM_ICMSPOLL_SITEMAP_INSTALLED;
	$file = 'icmspoll.php';
	$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
	if(!is_file($plugin_folder . $file)) {
		$sitemap_plugin = _AM_ICMSPOLL_SITEMAP_PLUGIN_NOTFOUND;
	} else {
		$sitemap_plugin = _AM_ICMSPOLL_SITEMAP_PLUGIN_FOUND;
	}
} else {
	$sitemap_module = _AM_ICMSPOLL_SITEMAP_NOTINSTALLED;
	$sitemap_plugin = "";
}

echo '	<fieldset style="border: #E8E8E8 1px solid; width: 550px;">
			<legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_ICMSPOLL_INDEX . '</legend>
			
			<div style="display: table; padding: 8px;">
				
				
				<div style="display: table-row;">
					<div style="display: table-cell; width: 250px;">'
						. _AM_ICMSPOLL_INDEX_TOTAL .
					'</div>
					<div style="display: table-cell;">'
						. $total_polls  .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ICMSPOLL_INDEX_ACTIVE_POLLS .
					'</div>
					<div style="display: table-cell">'
						. $ative_polls .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ICMSPOLL_INDEX_EXPIRED_POLLS .
					'</div>
					<div style="display: table-cell;">'
						. $expired_polls .
					'</div>
				</div>
				
			</div>
		</fieldset>
		<br />';

echo '	<fieldset style="border: #E8E8E8 1px solid; width: 550px;">
			<legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_ICMSPOLL_ADDITIONAL . '</legend>
			
			<div style="display: table; padding: 8px;">
				
				
				<div style="display: table-row;">
					<div style="display: table-cell; width: 250px;">'
						. _AM_ICMSPOLL_SITEMAP_MODULE .
					'</div>
					<div style="display: table-cell;">'
						. $sitemap_module  . ' ' . $sitemap_plugin .
					'</div>
				</div>
				
			</div>
		</fieldset>
		<br />';

include_once 'admin_footer.php';