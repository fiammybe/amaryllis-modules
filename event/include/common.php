<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /include/common.php
 *
 * module common file
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

if(!defined("EVENT_URL")) define("EVENT_URL", ICMS_URL . '/modules/' . EVENT_DIRNAME . '/');

if(!defined("EVENT_ROOT_PATH")) define("EVENT_ROOT_PATH", ICMS_ROOT_PATH.'/modules/' . EVENT_DIRNAME . '/');

if(!defined("EVENT_IMAGES_URL")) define("EVENT_IMAGES_URL", EVENT_URL . 'images/');

if(!defined("EVENT_ADMIN_URL")) define("EVENT_ADMIN_URL", EVENT_URL . 'admin/');

if(!defined("EVENT_SCRIPT_URL")) define("EVENT_SCRIPT_URL", EVENT_URL . 'scripts/');

if(!defined("EVENT_IMAGES_ROOT")) define("EVENT_IMAGES_ROOT", EVENT_ROOT_PATH . 'images/');

if(!defined("EVENT_SCRIPT_ROOT")) define("EVENT_SCRIPT_ROOT", EVENT_ROOT_PATH . 'scripts/');

if(!defined("EVENT_UPLOAD_ROOT")) define("EVENT_UPLOAD_ROOT", ICMS_ROOT_PATH . '/uploads/' . EVENT_DIRNAME . '/');

if(!defined("EVENT_UPLOAD_URL")) define("EVENT_UPLOAD_URL", ICMS_URL . '/uploads/' . EVENT_DIRNAME . '/');

// Include the common language file of the module
icms_loadLanguageFile('event', 'common');

//include_once EVENT_ROOT_PATH . 'include/functions.php';

$eventModule = icms_getModuleInfo( EVENT_DIRNAME );
if (is_object($eventModule)) {
	$event_moduleName = $eventModule->getVar('name');
}

$event_isAdmin = icms_userIsAdmin( EVENT_DIRNAME );

$eventModule->registerClassPath(TRUE);

$eventConfig = icms_getModuleConfig( EVENT_DIRNAME );

if(icms_get_module_status("index")) {
	$indexModule = icms_getModuleInfo("index");
	include_once ICMS_ROOT_PATH . '/modules/'.$indexModule->getVar("dirname").'/include/common.php';
}