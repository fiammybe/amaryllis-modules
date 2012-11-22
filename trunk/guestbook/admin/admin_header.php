<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /admin/admin_header.php
 * 
 * header file, which is included in all admin sites
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

include_once "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/include/common.php";
if (!defined("GUESTBOOK_ADMIN_URL")) define("GUESTBOOK_ADMIN_URL", GUESTBOOK_URL . "admin/");
include_once GUESTBOOK_ROOT_PATH . "include/requirements.php";