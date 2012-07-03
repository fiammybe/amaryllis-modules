<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/index.php
 * 
 * ACP-Index
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.20
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

include_once 'admin_header.php';

icms_cp_header();
icms::$module->displayAdminmenu(0, _MI_ALBUM_MENU_INDEX);

$album_handler = icms_getModuleHandler("album", ALBUM_DIRNAME, "album");
$images_handler = icms_getModuleHandler("images", ALBUM_DIRNAME, "album");
$message_handler = icms_getModuleHandler("message", ALBUM_DIRNAME, "album");

//count all albums
$total_albums = $album_handler->getCount(FALSE);
// count inactive albums
$crit1 = new icms_db_criteria_Compo(new icms_db_criteria_Item("album_active", 0));
$inactive_albums = $album_handler->getCount($crit1);
$inactive_albums = ($inactive_albums > 0) ? '<span style="font-weight: bold; color: red;">' . $inactive_albums . '</span>' : $inactive_albums;
// count denied albums
$crit2 = new icms_db_criteria_Compo(new icms_db_criteria_Item("album_approve", 0));
$denied_albums = $album_handler->getCount($crit2);
$denied_albums = ($denied_albums > 0) ? '<span style="font-weight: bold; color: red;">' . $denied_albums . '</span>' : $denied_albums;
// count total images
$total_images = $images_handler->getCount(FALSE);
// count inactive images
$crit3 = new icms_db_criteria_Compo(new icms_db_criteria_Item("img_active", 0));
$inactive_images = $images_handler->getCount($crit3);
$inactive_images = ($inactive_images > 0) ? '<span style="font-weight: bold; color: red;">' . $inactive_images . '</span>' : $inactive_images;
//
$crit4 = new icms_db_criteria_Compo(new icms_db_criteria_Item("img_approve", 0));
$denied_images = $images_handler->getCount($crit4);
$denied_images = ($denied_images > 0) ? '<span style="font-weight: bold; color: red;">' . $denied_images . '</span>' : $denied_images;
// count total messages
$total_comments = $message_handler->getCount(FALSE);
// count denied messages
$crit5 = new icms_db_criteria_Compo(new icms_db_criteria_Item("message_approve", 0));
$denied_comments = $message_handler->getCount($crit5);
$denied_comments = ($denied_comments > 0) ? '<span style="font-weight: bold; color: red;">' . $denied_comments . '</span>' : $denied_comments;
// count batchfiles
$folder = ALBUM_UPLOAD_ROOT . "batch/";
$batchfiles = count(icms_core_Filesystem::getFileList($folder, '', array('gif', 'jpg', 'png')));
$batchfiles = ($batchfiles > 0) ? '<span style="font-weight: bold; color: red;">' . $batchfiles . '</span>' : $batchfiles;


$sitemapModule = icms_get_module_status("sitemap");
if($sitemapModule) {
	$sitemap_module = _AM_ALBUM_SITEMAP_INSTALLED;
	$file = 'icmspoll.php';
	$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
	if(!is_file($plugin_folder . $file)) {
		$sitemap_plugin = _AM_ALBUM_SITEMAP_PLUGIN_NOTFOUND;
	} else {
		$sitemap_plugin = _AM_ALBUM_SITEMAP_PLUGIN_FOUND;
	}
} else {
	$sitemap_module = _AM_ALBUM_SITEMAP_NOTINSTALLED;
	$sitemap_plugin = "";
}

if (extension_loaded('gd') && function_exists('gd_info')) {
    $gdlib = _AM_ALBUM_INDEX_GDLIB_FOUND;
} else {
	$gdlib = _AM_ALBUM_INDEX_GDLIB_NOT_FOUND;
}


echo '	<fieldset style="border: #E8E8E8 1px solid; width: 550px;">
			<legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_ALBUM_INDEX . '</legend>
			
			<div style="display: table; padding: 8px;">
				
				
				<div style="display: table-row;">
					<div style="display: table-cell; width: 250px;">'
						. _AM_ALBUM_INDEX_TOTAL .
					'</div>
					<div style="display: table-cell;">'
						. $total_albums  .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_INACTIVE_ALBUMS .
					'</div>
					<div style="display: table-cell">'
						. $inactive_albums .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_DENIED_ALBUMS .
					'</div>
					<div style="display: table-cell;">'
						. $denied_albums . 
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_TOTAL_IMAGES .
					'</div>
					<div style="display: table-cell;">'
						. $total_images .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_INACTIVE_IMAGES .
					'</div>
					<div style="display: table-cell;">'
						. $inactive_images .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_DENIED_IMAGES .
					'</div>
					<div style="display: table-cell;">'
						. $denied_images . 
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_TOTAL_MESSAGES .
					'</div>
					<div style="display: table-cell;">'
						. $total_comments .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_DENIED_MESSAGES .
					'</div>
					<div style="display: table-cell;">'
						. $denied_comments . 
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ALBUM_INDEX_BATCHFILES .
					'</div>
					<div style="display: table-cell;">'
						. $batchfiles .
					'</div>
				</div>
				
			</div>
		</fieldset>
		<br />';
		
echo '	<fieldset style="border: #E8E8E8 1px solid; width: 550px;">
			<legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_ALBUM_ADDITIONAL . '</legend>
			
			<div style="display: table; padding: 8px;">
				
				
				<div style="display: table-row;">
					<div style="display: table-cell; width: 250px;">'
						. _AM_ALBUM_SITEMAP_MODULE .
					'</div>
					<div style="display: table-cell;">'
						. $sitemap_module  . ' ' . $sitemap_plugin .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell; width: 250px;">'
						. _AM_ALBUM_INDEX_GDLIB .
					'</div>
					<div style="display: table-cell;">'
						. $gdlib  . 
					'</div>
				</div>
				
			</div>
		</fieldset>
		<br />';
		

include_once 'admin_footer.php';
