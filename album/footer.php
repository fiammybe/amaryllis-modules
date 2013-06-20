<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /footer.php
 *
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 *
 */

$icmsTpl->assign('album_show_breadcrumb', TRUE);
$icmsTpl->assign('album_adminpage', '<a href="' . ALBUM_ADMIN_URL . 'index.php" title="admin-link" class="album_admin_link" >' . _MD_ALBUM_ADMIN_PAGE . '</a>' );
$icmsTpl->assign('album_is_admin', $album_isAdmin);
$icmsTpl->assign('album_url', ALBUM_URL);
$icmsTpl->assign('album_real_url', ALBUM_REAL_URL);
$icmsTpl->assign('module_home', '<a href="' . ALBUM_URL . 'index.php" title="'.$album_moduleName.'">'.$album_moduleName.'</a>');
$icmsTpl->assign('album_images_url', ALBUM_IMAGES_URL);
$icmsTpl->assign('module_name', $album_moduleName);
$icmsTpl->assign('config', $albumConfig);
$icmsTpl->assign('use_image_comments', $albumConfig['use_messages']);
$icmsTpl->assign('album_page', $album_page);
/**
 * force js-files to header
 */
$icmsTheme->addScript("/modules/".ALBUM_DIRNAME."/language/".$icmsConfig['language']."/".$icmsConfig['language'].".js", array('type' => 'text/javascript'));
$icmsTheme->addScript('/modules/'.ALBUM_DIRNAME.'/scripts/app/album.js', array('type' => 'text/javascript'));
$icmsTheme->addStylesheet("/modules/".ALBUM_DIRNAME.'/scripts/css/module_album.css');
if($album_handler->_index_module_status) {
	$icmsTheme->addStylesheet("/modules/".$album_handler->_index_module_dirname.'/scripts/css/labels.css');
}
include_once ICMS_ROOT_PATH . '/footer.php';

$icmsTheme->addScript(NULL, array('type' => 'text/javascript'),
	'var albumModule = {'.
		'url: "'.ALBUM_URL.'"'.
		',script_url: "'.ICMS_MODULES_URL.'/'.ALBUM_DIRNAME.'/scripts"'.
		',images_url: "'.ALBUM_IMAGES_URL.'"'.
		',dirname: "'.ALBUM_DIRNAME.'"'.
		',config: "'.json_encode($albumConfig).'"'.
	'};'
	);
