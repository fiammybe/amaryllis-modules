<?php
/**
 * New comment post
 *
 * This file holds the configuration information of this module
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 */

if(file_exists("../../mainfile.php")) include_once "../../mainfile.php";
else if (file_exists("mainfile.php")) include_once "mainfile.php";
include_once ICMS_ROOT_PATH."/modules/".basename(dirname(__FILE__))."/include/common.php";
include_once ICMS_ROOT_PATH . "/include/comment_post.php";