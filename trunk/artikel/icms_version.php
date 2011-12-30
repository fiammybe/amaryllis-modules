<?php
/**
 * 'Artikel' is an article management module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * hold the configuration information about the module
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
	"name"						=> _MI_ARTIKEL_MD_NAME,
	"version"					=> 1.0,
	"description"				=> _MI_ARTIKEL_MD_DESC,
	"author"					=> "QM-B",
	"credits"					=> "",
	"help"						=> "",
	"license"					=> "GNU General Public License (GPL)",
	"official"					=> 0,
	"dirname"					=> basename(dirname(__FILE__)),
	"modname"					=> "artikel",

/**  Images information  */
	"iconsmall"					=> "images/icon_small.png",
	"iconbig"					=> "images/icon_big.png",
	"image"						=> "images/icon_big.png", /* for backward compatibility */

/**  Development information */
	"status_version"			=> "1.0",
	"status"					=> "Beta",
	"date"						=> "Unreleased",
	"author_word"				=> "",
	"warning"					=> _CO_ICMS_WARNING_BETA,

/** Contributors */
	"developer_website_url"		=> "http://code.google.com/p/amaryllis-modules/",
	"developer_website_name"	=> "Amaryllis Modules",
	"developer_email"			=> "qm-b@hotmail.de",

/** Administrative information */
	"hasAdmin"					=> 1,
	"adminindex"				=> "admin/index.php",
	"adminmenu"					=> "admin/menu.php",

/** Install and update informations */
	"onInstall"					=> "include/onupdate.inc.php",
	"onUpdate"					=> "include/onupdate.inc.php",

/** Search information */
	"hasSearch"					=> 0,
	"search"					=> array("file" => "include/search.inc.php", "func" => "artikel_search"),

/** Menu information */
	"hasMain"					=> 1,

/** Comments information */
	"hasComments"				=> 1,
	"comments"					=> array(
									"itemName" => "post_id",
									"pageName" => "post.php",
									"callbackFile" => "include/comment.inc.php",
									"callback" => array("approve" => "artikel_com_approve",
														"update" => "artikel_com_update")));

/** other possible types: testers, translators, documenters and other */
$modversion['people']['developers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1314]QM-B[/url]";

/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=Artikel' target='_blank'>English</a>";

/** Database information */
$modversion['object_items'][1] = 'category';
$modversion['object_items'][] = 'article';
$modversion['object_items'][] = 'indexpage';
$modversion['object_items'][] = 'tags';
$modversion['object_items'][] = 'log';

$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

/** Templates information */
$modversion['templates'] = array(
	array("file" => "artikel_admin_category.html", "description" => "category Admin Index"),
	array("file" => "artikel_category.html", "description" => "category Index"),
	array("file" => "artikel_admin_article.html", "description" => "article Admin Index"),
	array("file" => "artikel_article.html", "description" => "article Index"),
	array("file" => "artikel_admin_indexpage.html", "description" => "indexpage Admin Index"),
	array("file" => "artikel_indexpage.html", "description" => "indexpage Index"),
	array("file" => "artikel_admin_tags.html", "description" => "tags Admin Index"),
	array("file" => "artikel_tags.html", "description" => "tags Index"),
	array("file" => "artikel_admin_log.html", "description" => "log Admin Index"),
	array("file" => "artikel_log.html", "description" => "log Index"),

	array('file' => 'artikel_header.html', 'description' => 'Module Header'),
	array('file' => 'artikel_footer.html', 'description' => 'Module Footer'));

/** Blocks information */
/** To come soon in imBuilding... */

/** Preferences information */
/** To come soon in imBuilding... */

/** Notification information */
/** To come soon in imBuilding... */