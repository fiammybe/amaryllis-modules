<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /admin/admin_header.php
 * 
 * header file, which is included in all admin sites
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */

include_once "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/include/common.php";
if (!defined("VISITORVOICE_ADMIN_URL")) define("VISITORVOICE_ADMIN_URL", VISITORVOICE_URL . "admin/");
include_once VISITORVOICE_ROOT_PATH . "include/requirements.php";