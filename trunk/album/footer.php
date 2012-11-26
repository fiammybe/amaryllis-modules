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


if($indexConfig['show_breadcrumbs'] == 1) {
	$icmsTpl->assign('index_show_breadcrumb', TRUE);
	$icmsTpl->assign('index_images_url', INDEX_ICONS_URL);
	$icmsTpl->assign('index_url', INDEX_URL);
	$icmsTpl->assign('index_module_home', '<a href="' . INDEX_URL . 'index.php" title="' . $index_moduleName . '">' . $index_moduleName . '</a>');
}

$icmsTpl->assign('album_adminpage', '<a href="' . ALBUM_ADMIN_URL . 'index.php" title="admin-link" class="album_admin_link" >' . _MD_ALBUM_ADMIN_PAGE . '</a>' );
$icmsTpl->assign('album_is_admin', icms_userIsAdmin(ALBUM_DIRNAME));
$icmsTpl->assign('album_url', ALBUM_URL);
$icmsTpl->assign('module_home', '<a href="' . ALBUM_URL . 'index.php" title="' . $album_moduleName . '">' . $album_moduleName . '</a>');
$icmsTpl->assign('album_images_url', ALBUM_IMAGES_URL);
$icmsTpl->assign('dirname', icms::$module -> getVar( 'dirname' ) );
$icmsTpl->assign('use_image_comments', $albumConfig['use_messages']);
/**
 * force js-files to header
 */
$xoTheme->addScript('/modules/' . ALBUM_DIRNAME . '/scripts/jquery.qtip.min.js', array('type' => 'text/javascript'));
$xoTheme->addStylesheet('/modules/' . ALBUM_DIRNAME . '/scripts/jquery.qtip.min.css');
$xoTheme->addScript('/modules/' . ALBUM_DIRNAME . '/scripts/album.js', array('type' => 'text/javascript'));
$xoTheme->addStylesheet('/modules/' . INDEX_DIRNAME . '/scripts/module_index.css');
$xoTheme->addStylesheet('/modules/' . ALBUM_DIRNAME . '/scripts/module_album.css');
include_once ICMS_ROOT_PATH . '/footer.php';