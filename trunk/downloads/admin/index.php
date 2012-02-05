<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /admin/index.php
 * 
 * index page in ACP
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */

include_once "admin_header.php";

$clean_op = $clean_download_id = $clean_category_id = $valid_op = $downloads_download_handler = $downloads_category_handler= '';

$valid_op = array ('mod', 'changedField', 'adddownload', 'del', 'view', 'visible', 'changeShow','changeApprove', 'changeWeight', '');

if (isset($_GET['op'])) $clean_op = htmlentities($_GET['op']);
if (isset($_POST['op'])) $clean_op = htmlentities($_POST['op']);

$downloads_download_handler = icms_getModuleHandler('download', basename(dirname(dirname(__FILE__))), 'downloads');
$downloads_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'downloads');

$clean_download_id = isset($_GET['download_id']) ? (int)$_GET['download_id'] : 0 ;
$clean_category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0 ;

icms_cp_header();
downloads_adminmenu(0, _MI_DOWNLOADS_MENU_INDEX);
global $downloadsConfig;
//check broken downloads
$criteria = '';
$criteria = new icms_db_criteria_Compo();
$criteria->add(new icms_db_criteria_Item('download_broken', TRUE));
$broken = $downloads_download_handler->getCount($criteria, TRUE, FALSE);


// get all files count
$totalfiles = $downloads_download_handler->getCount();
// get all cats count
$totalcats = $downloads_category_handler->getCount();

// check files to approve
if ($downloadsConfig['downloads_needs_approve'] == 1) {
	$criteria2 = '';
	$criteria2 = new icms_db_criteria_Compo();
	$criteria2 -> add(new icms_db_criteria_Item('download_approve', 0));
	$download_approve = $downloads_download_handler->getCount($criteria2, TRUE, FALSE);
}

// check mirrors to approve
	$criteria3 = '';
	$criteria3 = new icms_db_criteria_Compo();
	$criteria3->add(new icms_db_criteria_Item('download_mirror_approve', 0));
	$mirrors = $downloads_download_handler->getCount($criteria3, TRUE, FALSE);


//check categories to approve
if ($downloadsConfig['category_needs_approve'] == 1) {
	$criteria4 = '';
	$criteria4 = new icms_db_criteria_Compo();
	$criteria4 -> add(new icms_db_criteria_Item('category_approve', 0));
	$category_approve = $downloads_category_handler->getCount($criteria4, TRUE, FALSE);
}

function getMimeTypes() {
	$mimetype_handler = icms_getModuleHandler('mimetype', 'system');
	$criteria = "";
	$criteria = new icms_db_criteria_Compo();
	$mimetypeObjects = $mimetype_handler->getObjects($criteria, TRUE, FALSE);
	$mimetype = '';
	foreach (array_keys($mimetypeObjects) as $key => $mimetypeObj) {
		if(in_array(icms::$module->getVar("dirname"), array($mimetypeObj['dirname'])))	{
			$mimetype .= $mimetypeObj . ', ';
		}
	}
	return $mimetype;
	
}

$mimetypes = getMimeTypes();

//$mimetypes = $downloads_download_handler->checkMimeType();
echo ' <div style="margin: 2em 0em;"><p>' . _AM_DOWNLOADS_INDEX_WARNING . '</p></div>';
$dir = ICMS_ROOT_PATH . '/modules/sitemap/plugins';
if(is_dir($dir)) {
	echo "Dir found on server!";
}

echo '	<fieldset style="border: #E8E8E8 1px solid;">
			<legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_DOWNLOADS_INDEX . '</legend>
			
			<div style="display: table; padding: 8px;">
				
				
				<div style="display: table-row;">
					<div style="display: table-cell">'
						. _AM_DOWNLOADS_INDEX_TOTAL .
					'</div>
					<div style="display: table-cell;">'
						. $totalfiles . _AM_DOWNLOADS_FILES_IN . $totalcats . _AM_DOWNLOADS_CATEGORIES .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_DOWNLOADS_INDEX_BROKEN_FILES .
					'</div>
					<div style="display: table-cell">'
						. $broken .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_DOWNLOADS_INDEX_NEED_APPROVAL_FILES .
					'</div>
					<div style="display: table-cell;">'
						. $download_approve .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_DOWNLOADS_INDEX_NEED_APPROVAL_MIRRORS .
					'</div>
					<div style="display: table-cell;">'
						. $mirrors .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_DOWNLOADS_INDEX_NEED_APPROVAL_CATS .
					'</div>
					<div style="display: table-cell;">'
						. $category_approve .
					'</div>
				</div>
				
			</div>
		</fieldset>
		<br />';



icms_cp_footer();