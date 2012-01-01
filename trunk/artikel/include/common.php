<?php
/**
 * Common file of the module included on all pages of the module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		article
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

if (!defined("ARTICLE_DIRNAME")) define("ARTICLE_DIRNAME", $modversion["dirname"] = basename(dirname(dirname(__FILE__))));
if (!defined("ARTICLE_URL")) define("ARTICLE_URL", ICMS_URL."/modules/".ARTICLE_DIRNAME."/");
if (!defined("ARTICLE_ROOT_PATH")) define("ARTICLE_ROOT_PATH", ICMS_ROOT_PATH."/modules/".ARTICLE_DIRNAME."/");
if (!defined("ARTICLE_IMAGES_URL")) define("ARTICLE_IMAGES_URL", ARTICLE_URL."images/");
if (!defined("ARTICLE_ADMIN_URL")) define("ARTICLE_ADMIN_URL", ARTICLE_URL."admin/");

// Include the common language file of the module
icms_loadLanguageFile("article", "common");