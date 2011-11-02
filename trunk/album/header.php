<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /header.php
 *
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B
 * @version		$Id$
 * @package		album
 *
 */

include "../../mainfile.php";

include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/common.php';

// Include the main language file of the module
icms_loadLanguageFile('album', 'main');