<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /icms_version.php
 *
 * holds module informations
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**  General Information  */
$modversion = array(
						"name"						=> _MI_TOOLS_MD_NAME,
						"version"					=> 1.0,
						"description"				=> _MI_TOOLS_MD_DESC,
						"author"					=> "QM-B",
						"author_realname"			=> "Steffen Flohrer",
						"credits"					=> "<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Amaryllis Modules</a>",
						"help"						=> "admin/manual.php",
						"license"					=> "GNU General Public License (GPL)",
						"official"					=> 0,
						"dirname"					=> basename(dirname(__FILE__)),
						"modname"					=> "tools",

					/**  Images information  */
						"iconsmall"					=> "images/icon_small.png",
						"iconbig"					=> "images/icon_big.png",
						"image"						=> "images/icon_big.png", /* for backward compatibility */

					/**  Development information */
						"status_version"			=> "1.0",
						"status"					=> "alpha",
						"date"						=> "00:00 XX.XX.2013",
						"author_word"				=> "",
						"warning"					=> _CO_ICMS_WARNING_ALPHA,

					/** Contributors */
						"developer_website_url"		=> "http://code.google.com/p/amaryllis-modules/",
						"developer_website_name"	=> "Amaryllis Modules",
						"developer_email"			=> "qm-b@hotmail.de",

					/** Administrative information */
						"hasAdmin"					=> 1,
						"adminindex"				=> "admin/tools.php",
						"adminmenu"					=> "admin/admin_menu.php",

					/** Install and update informations */
						"onInstall"					=> "include/onupdate.inc.php",
						"onUpdate"					=> "include/onupdate.inc.php",
						"onUninstall"				=> "include/onupdate.inc.php",

					/** Search information */
						"hasSearch"					=> 0,

					/** Menu information */
						"hasMain"					=> 0,

					/** Notification and comment information */
						"hasNotification"			=> 0,
						"hasComments"				=> 0
				);

$modversion['people']['developers'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=264' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>";
$modversion['people']['documenters'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=264' target='_blank'>QM-B</a>";

$modversion['people']['translators'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=264' target='_blank'>QM-B</a>";
$modversion['people']['testers'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=243' target='_blank'>optimistdd</a>";
$modversion['people']['testers'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=67' target='_blank'>lotus</a>";
$modversion['people']['testers'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=36' target='_blank'>bleekk</a>";
$modversion['people']['testers'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=2' target='_blank'>sato-san</a>";
/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=event' target='_blank'>English</a>";
$modversion['manual'][][] = "<a href='manual.php' target='_blank'>Manual</a>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// SUPPORT //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['submit_bug'] = 'http://code.google.com/p/amaryllis-modules/issues/entry?template=Defect%20report%20from%20user';
$modversion['submit_feature'] = 'http://code.google.com/p/amaryllis-modules/issues/entry?template=Defect%20report%20from%20user';
$modversion['support_site_url'] = 'http://www.impresscms.de/modules/forum/viewforum.php?forum=30';
$modversion['support_site_name']= 'ImpressCMS Community Forum';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'tools_admin.html',
										'description'	=> "Admin-Template"
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'tools_requirements.html',
										'description'	=> "Requirements check"
								);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;
$i++;
$modversion['config'][$i]['name']			= 'enable_ftp';
$modversion['config'][$i]['title']			= '_MI_TOOLS_CONFIG_ENABLE_FTP';
$modversion['config'][$i]['description']	= '_MI_TOOLS_CONFIG_ENABLE_FTP_DSC';
$modversion['config'][$i]['formtype'] 		= 'yesno';
$modversion['config'][$i]['valuetype'] 		= 'int';
$modversion['config'][$i]['default'] 		= 0;
$i++;
$modversion['config'][$i]['name']			= 'ftp_url';
$modversion['config'][$i]['title']			= '_MI_TOOLS_CONFIG_FTP_URL';
$modversion['config'][$i]['description']	= '_MI_TOOLS_CONFIG_FTP_URL_DSC';
$modversion['config'][$i]['formtype'] 		= 'textbox';
$modversion['config'][$i]['valuetype'] 		= 'text';
$modversion['config'][$i]['default'] 		= '';
$i++;
$modversion['config'][$i]['name']			= 'ftp_user';
$modversion['config'][$i]['title']			= '_MI_TOOLS_CONFIG_FTP_USER';
$modversion['config'][$i]['description']	= '_MI_TOOLS_CONFIG_FTP_USER_DSC';
$modversion['config'][$i]['formtype'] 		= 'textbox';
$modversion['config'][$i]['valuetype'] 		= 'text';
$modversion['config'][$i]['default'] 		= '';
$i++;
$modversion['config'][$i]['name']			= 'ftp_pass';
$modversion['config'][$i]['title']			= '_MI_TOOLS_CONFIG_FTP_PASS';
$modversion['config'][$i]['description']	= '_MI_TOOLS_CONFIG_FTP_PASS_DSC';
$modversion['config'][$i]['formtype'] 		= 'password';
$modversion['config'][$i]['valuetype'] 		= 'text';
$modversion['config'][$i]['default'] 		= '';
$i++;
$modversion['config'][$i]['name']			= 'ftp_path';
$modversion['config'][$i]['title']			= '_MI_TOOLS_CONFIG_FTP_PATH';
$modversion['config'][$i]['description']	= '_MI_TOOLS_CONFIG_FTP_PATH_DSC';
$modversion['config'][$i]['formtype'] 		= 'textbox';
$modversion['config'][$i]['valuetype'] 		= 'text';
$modversion['config'][$i]['default'] 		= '/';
$i++;
$modversion['config'][$i]['name']			= 'require_cli';
$modversion['config'][$i]['title']			= '_MI_TOOLS_CONFIG_REQUIRE_CLI';
$modversion['config'][$i]['description']	= '_MI_TOOLS_CONFIG_REQUIRE_CLI_DSC';
$modversion['config'][$i]['formtype'] 		= 'yesno';
$modversion['config'][$i]['valuetype'] 		= 'int';
$modversion['config'][$i]['default'] 		= 0;
$i++;
$modversion['config'][$i]['name']			= 'last_backup';
$modversion['config'][$i]['title']			= '';
$modversion['config'][$i]['description']	= '';
$modversion['config'][$i]['formtype'] 		= 'hidden';
$modversion['config'][$i]['valuetype'] 		= 'int';
$modversion['config'][$i]['default'] 		= 0;
$i++;
$modversion['config'][$i]['name']			= 'last_mc';
$modversion['config'][$i]['title']			= '';
$modversion['config'][$i]['description']	= '';
$modversion['config'][$i]['formtype'] 		= 'hidden';
$modversion['config'][$i]['valuetype'] 		= 'int';
$modversion['config'][$i]['default'] 		= 0;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// AUTOTASKS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$modversion['autotasks'][$i]['enabled']		= '0';
$modversion['autotasks'][$i]['repeat']		= '0';
$modversion['autotasks'][$i]['interval']	= 1440*7;
$modversion['autotasks'][$i]['onfinish']	= '0';
$modversion['autotasks'][$i]['name']		= _MI_TOOLS_AUTOTASK_OPTIMIZE_DB;
$modversion['autotasks'][$i]['code']		= 'include/autotasks/autotask_optimize_db.php';
$i++;
$modversion['autotasks'][$i]['enabled']		= '0';
$modversion['autotasks'][$i]['repeat']		= '0';
$modversion['autotasks'][$i]['interval']	= 1440*7;
$modversion['autotasks'][$i]['onfinish']	= '0';
$modversion['autotasks'][$i]['name']		= _MI_TOOLS_AUTOTASK_CLEAR_SESSION;
$modversion['autotasks'][$i]['code']		= 'include/autotasks/autotask_clear_session.php';
$i++;
$modversion['autotasks'][$i]['enabled']		= '0';
$modversion['autotasks'][$i]['repeat']		= '0';
$modversion['autotasks'][$i]['interval']	= 1440*7;
$modversion['autotasks'][$i]['onfinish']	= '0';
$modversion['autotasks'][$i]['name']		= _MI_TOOLS_AUTOTASK_CLEAR_CACHE;
$modversion['autotasks'][$i]['code']		= 'include/autotasks/autotask_clear_cache.php';
$i++;
$modversion['autotasks'][$i]['enabled']		= '0';
$modversion['autotasks'][$i]['repeat']		= '0';
$modversion['autotasks'][$i]['interval']	= 1440*7;
$modversion['autotasks'][$i]['onfinish']	= '0';
$modversion['autotasks'][$i]['name']		= _MI_TOOLS_AUTOTASK_ALL_TOOLS;
$modversion['autotasks'][$i]['code']		= 'include/autotasks/autotask_all_tools.php';
