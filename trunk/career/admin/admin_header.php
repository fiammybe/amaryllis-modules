<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /admin/admin_header.php
 * 
 * header file included in all admin files
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */

include_once "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/include/common.php";
if (!defined("CAREER_ADMIN_URL")) define("CAREER_ADMIN_URL", CAREER_URL . "admin/");
include_once CAREER_ROOT_PATH . "include/requirements.php";