<?php
/**
 * About page of the module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 */

include_once "admin_header.php";
$aboutObj = new icms_ipf_About();
$aboutObj->render();