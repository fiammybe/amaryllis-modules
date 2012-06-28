<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /admin/about.php
 * 
 * about page
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id: admin_header.php 11 2012-06-27 12:30:05Z qm-b $
 * @package		icmspoll
 *
 */

include_once "admin_header.php";
$aboutObj = new icms_ipf_About();
$aboutObj->render();