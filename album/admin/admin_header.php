<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /admin/admin_header.php
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

include_once '../../../include/cp_header.php';

$moddir = icms::$module -> getVar( 'dirname' );

include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';

if (!defined('ALBUM_ADMIN_URL')) define('ALBUM_ADMIN_URL', ALBUM_URL . 'admin/');
include_once ALBUM_ROOT_PATH . 'include/requirements.php';

global $icmsConfig;
icms_loadLanguageFile("album", "common");
icms_loadLanguageFile("album", "modinfo");