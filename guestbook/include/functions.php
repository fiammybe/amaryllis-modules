<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /submit.php
 * 
 * submit entries
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */

function writeJsonRequest($content) {
	$path = ICMS_TRUST_PATH.'/modules/'.GUESTBOOK_DIRNAME.'/cache';
	if(!is_dir($path)) mkdir($path, 0777, TRUE);
	$filename = $path.'/guestbook_cache.json';
    if(!$file = fopen($filename,"w")) {
        echo 'failed open file';
        return FALSE;
    }
    if(fwrite($file, var_export($content, TRUE)) == - 1) {
        echo 'failed write file';
        return FALSE;
    }
    fclose ($file);
    return TRUE;
}