<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /admin/admin_header.php
 * 
 * header file, which is included into all admin-pages
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

include_once '../../../include/cp_header.php';

$moddir = icms::$module -> getVar( 'dirname' );

include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';

if (!defined('DOWNLOADS_ADMIN_URL')) define('DOWNLOADS_ADMIN_URL', DOWNLOAD_URL . 'admin/');
include_once DOWNLOADS_ROOT_PATH . 'include/requirements.php';

global $icmsConfig;
icms_loadLanguageFile("downloads", "common");
icms_loadLanguageFile("downloads", "modinfo");