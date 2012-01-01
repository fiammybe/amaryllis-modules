<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /admin/admin_header.php
 * 
 * Header-file included in all admin pages
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Artikel
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		artikel
 *
 */

include_once "../../../include/cp_header.php";
include_once ICMS_ROOT_PATH . "/modules/" . basename(dirname(dirname(__FILE__))) . "/include/common.php";
if (!defined("ARTIKEL_ADMIN_URL")) define("ARTIKEL_ADMIN_URL", ARTIKEL_URL . "admin/");
include_once ARTIKEL_ROOT_PATH . "include/requirements.php";