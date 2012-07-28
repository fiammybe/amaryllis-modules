<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /admin/about.php
 * 
 * about page of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */

include_once "admin_header.php";
$aboutObj = new icms_ipf_About();
$aboutObj->render();