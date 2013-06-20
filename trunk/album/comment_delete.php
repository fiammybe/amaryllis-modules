<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /comment_delete.php
 *
 * delete comments
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * --------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 *
 */

if(file_exists("../../mainfile.php")) include_once "../../mainfile.php";
else if (file_exists("mainfile.php")) include_once "mainfile.php";
include_once ICMS_ROOT_PATH."/modules/".basename(dirname(__FILE__))."/include/common.php";
include_once ICMS_ROOT_PATH . "/include/comment_delete.php";