<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/download.php
 *
 * download admin backup
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		CC Attribution-ShareAlike 3.0 Unported (CC BY-SA 3.0)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		Downloads 2.00
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

#checks the referer of the script
function getReferer() {
	preg_match('@^(?:http://)?([^/]+)@i',$_SERVER['HTTP_REFERER'], $match);
	return $match[1];
}

#checks if referer domain is okay
function hotlink_check() {
	global $allowed_domains;
	$allowed_domains.=','.$_SERVER['HTTP_HOST'];
	$domains=explode(',',str_replace(' ','',$allowed_domains));
	$referer=getReferer();
	$site=array();
	foreach ($domains as $value) {
		$site[] = '^'.str_replace('*','([0-9a-zA-Z]|\-|\_)+',str_replace('.','\.',$value)).'$';
	}
	foreach ($site as $pattern) {
		if(eregi($pattern,$referer)) $MATCH=TRUE;
		if($MATCH==TRUE) break;
	}
	return ($MATCH==TRUE) ? TRUE : FALSE;
}

include_once 'admin_header.php';
icms::$logger->disableLogger();

$clean_file = isset($_GET['file']) ? StopXSS(filter_input(INPUT_GET, "file", FILTER_SANITIZE_STRING)) : FALSE;
if(!$clean_file || !is_string($clean_file)) {die("No valid File");}

define('HOTLINK_PROTECTION',TRUE); // enable hotlinking?  true/false

$hotlink_url = TOOLS_ADMIN_URL.'backup.php';

define('HOTLINK_PAGE_URL',$hotlink_url); // Hotlink URL

if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
	$pro = 'https';
} else {
	$pro = 'http';
}
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
$current_url =  $pro."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
$asterisk_url = str_replace($pro."://".$_SERVER['SERVER_NAME'].$port, "*", ICMS_URL);
$allowed_domains="$asterisk_url";

$allowed_ext = icms_Utils::mimetypes();

if(!is_object(icms::$user) || !icms_userIsAdmin(TOOLS_DIRNAME)) die("Access denied");

if(in_array($clean_file, array("backup", "db_backup"), FALSE)) {$folder = 'backup';$ext = 'zip';}
else {$folder = 'logs';$ext = 'php';}

$file = TOOLS_TRUST_PATH."$folder/$clean_file.$ext";

define('HOTLINK_PASS',hotlink_check());
if(HOTLINK_PROTECTION&&!HOTLINK_PASS) {
	header('HTTP/1.1 403 Forbidden');
	header('Location: '.HOTLINK_PAGE_URL);
	die();
}

set_time_limit(0);

if (!is_file($file)) die("\nFile could not be found. Make sure you did a backup before.");
$fsize = filesize($file);
$fname = basename($file);
$fext = "zip";

// get mime type
if ($allowed_ext[$fext] == '') {
	$mtype = '';
	if (function_exists('mime_content_type')) $mtype = mime_content_type($file_path);
	else if (function_exists('finfo_file')) {
		$finfo = finfo_open(FILEINFO_MIME);
		$mtype = finfo_file($finfo, $file_path);
		finfo_close($finfo);
	}
	if ($mtype=='') $mtype="application/octet-stream";

} else $mtype = $allowed_ext[$fext];

// set headers
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$fname\"");
header("Content-Transfer-Encoding: binary");
//header("Content-Length: ".$fsize);
ob_end_flush();
@readfile($file);