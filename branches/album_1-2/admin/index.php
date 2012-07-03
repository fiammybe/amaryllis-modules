<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/index.php
 * 
 * ACP-Index - just redirect to album.php
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

include_once 'admin_header.php';

icms_cp_header();
icms::$module->displayAdminmenu(0, _MI_ALBUM_MENU_INDEX);


if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "It looks like GD is installed";
}
$source = ALBUM_UPLOAD_ROOT . 'batch/CIMG2117.jpg';
list($width, $height, $img_type) = getimagesize($source);
echo "width: " . $width;
echo "height: " . $height;
echo "type: " . $img_type;

include_once 'admin_footer.php';
