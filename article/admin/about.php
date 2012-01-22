<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/about.php
 * 
 * About Page of the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

include_once "admin_header.php";
$aboutObj = new icms_ipf_About();
$aboutObj->render();