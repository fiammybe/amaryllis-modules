<?php
/**
 * Common file of the module included on all pages of the module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		artikel
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

if (!defined("ARTIKEL_DIRNAME")) define("ARTIKEL_DIRNAME", $modversion["dirname"] = basename(dirname(dirname(__FILE__))));
if (!defined("ARTIKEL_URL")) define("ARTIKEL_URL", ICMS_URL."/modules/".ARTIKEL_DIRNAME."/");
if (!defined("ARTIKEL_ROOT_PATH")) define("ARTIKEL_ROOT_PATH", ICMS_ROOT_PATH."/modules/".ARTIKEL_DIRNAME."/");
if (!defined("ARTIKEL_IMAGES_URL")) define("ARTIKEL_IMAGES_URL", ARTIKEL_URL."images/");
if (!defined("ARTIKEL_ADMIN_URL")) define("ARTIKEL_ADMIN_URL", ARTIKEL_URL."admin/");

// Include the common language file of the module
icms_loadLanguageFile("artikel", "common");