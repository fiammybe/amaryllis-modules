<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /header.php
 * 
 * Frontend header
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

include_once "../../mainfile.php";
include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/common.php';

// Include the main language file of the module
icms_loadLanguageFile('downloads', 'main');