<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/admin_header.php
 * 
 * Header File included in all admin pages
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: admin_header.php 11 2012-06-27 12:30:05Z qm-b $
 * @package		icmspoll
 *
 */
 
include_once '../../../include/cp_header.php';

$moddir = icms::$module->getVar('dirname');

include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
include_once ICMSPOLL_ROOT_PATH . 'include/requirements.php';

global $icmsConfig;
icms_loadLanguageFile("icmspoll", "common");
icms_loadLanguageFile("icmspoll", "modinfo");