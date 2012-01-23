<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/manual.php
 * 
 * manual for article module
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


include 'admin_header.php';

global $path, $dirname;
$path = dirname(dirname(__FILE__));
$dirname = icms::$module -> getVar( 'dirname' );

icms_cp_header();
icms::$module->displayAdminMenu( 0, _MI_ARTICLE_MENU_MANUAL);
$file = isset($_GET['file']) ? icms_core_DataFilter::checkVar($_GET['file'], "html", "output") : "manual.html";
display_lang_file($file);
icms_cp_footer();
exit;

// show under language/XX/$file only <body> part.
function display_lang_file($file, $link='') {
    global $icmsConfig;
    if (empty($link)) {
		$link = preg_replace('/[&\?]?file=[^&]*|\?$/', '', $_SERVER['REQUEST_URI']);
		$link .= preg_match('/\?/', $link)?'&':'?';
		$link .= 'file=';
    }
    $file = preg_replace('/^\/+/','',preg_replace('/\/?\\.\\.?\/|\/+/', '/', $file));
    $lang = "language/".$icmsConfig['language'];
    $manual = "../$lang/$file";
    if (!file_exists($manual)) {
		$lang = 'language/english';
		$manual = "../$lang/$file";
    }
    $content = file_get_contents($manual);
    list($h, $b) = preg_split('/<\/?body>/', $content);
    if (empty($b)) $b =& $content;
    $murl = ICMS_URL . '/modules/' . icms::$module->getVar('dirname');

    if (preg_match('/<link[^>]*>/', $b, $match)) {
		foreach ($match as $item) {
	    	if (preg_match('/href=[\"\']?([^\"\']+)/', $item, $d)) {
				$x = preg_replace('/'.preg_quote($d[1],'/').'/', "../$lang/".$d[1], $item);
				$b = preg_replace('/'.preg_quote($item, '/').'/', $x, $b);
	    	}
		}
    }
    $pat = array('/\ssrc=\'([^#][^\':]*)\'/',
		 '/\ssrc="([^#][^":]*)"/',
		 '/\shref=\'([^#\\.][^\':]*)\'/',
		 '/\shref="([^#\\.][^\':]*)"/',
		 '/\shref=([\'"]?)\\.\\.\\/\\.\\.\\//',
	);
    $rep = array(" src='../$lang/\$1'",
		 " src=\"../$lang/\$1\"",
		 " href='$link\$1'",
		 " href=\"$link\$1\"",
		 " href=$1$murl/",
	);
    echo '<div class="manual">'.preg_replace($pat, $rep, $b).'</div>';
}