<?php
/**
 * Header page included at the begining of each page on user side of the mdoule
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		downloads
 * @version		$Id$
 */

include_once "../../mainfile.php";
include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/common.php';

// Include the main language file of the module
icms_loadLanguageFile('downloads', 'main');