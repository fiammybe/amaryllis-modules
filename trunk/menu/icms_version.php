<?php
/**
 * 'Menu' is a menu module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * menu version infomation
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Menu
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		menu
 *
 */
 
defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**  General Information  */
$modversion = array(
						"name"						=> _MI_MENU_MD_NAME,
						"version"					=> 1.0,
						"description"				=> _MI_MENU_MD_DESC,
						"author"					=> "QM-B",
						"author_realname"			=> "Steffen Flohrer",
						"credits"					=> "<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Amaryllis Modules</a>",
						"help"						=> "admin/manual.php",
						"license"					=> "GNU General Public License (GPL)",
						"official"					=> 0,
						"dirname"					=> basename(dirname(__FILE__)),
						"modname"					=> "menu",
					
					/**  Images information  */
						"iconsmall"					=> "images/menu_icon_small.png",
						"iconbig"					=> "images/menu_icon.png",
						"image"						=> "images/menu_icon.png", /* for backward compatibility */
					
					/**  Development information */
						"status_version"			=> "1.0",
						"status"					=> "Beta",
						"date"						=> "00:00 XX.XX.2012",
						"author_word"				=> "",
						"warning"					=> _CO_ICMS_WARNING_BETA,
					
					/** Contributors */
						"developer_website_url"		=> "http://code.google.com/p/amaryllis-modules/",
						"developer_website_name"	=> "Amaryllis Modules",
						"developer_email"			=> "qm-b@hotmail.de",
					
					/** Administrative information */
						"hasAdmin"					=> 1,
						"adminindex"				=> "admin/menu.php",
						"adminmenu"					=> "admin/acp_menu.php",
					
					/** Install and update informations */
						"onInstall"					=> "include/onupdate.inc.php",
						"onUpdate"					=> "include/onupdate.inc.php",
						"onUninstall"				=> "include/onupdate.inc.php",
					
					/** Search information */
						"hasSearch"					=> 0,
						"search"					=> array(),
					
					/** Menu information */
						"hasMain"					=> 0,
					
					/** Notification and comment information */
						"hasNotification"			=> 0,
						"hasComments"				=> 0
				);

$modversion['people']['developers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>";
$modversion['people']['documenters'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a>";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";
$modversion['people']['others'][] = "Templates by: [url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// SUPPORT //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['submit_bug'] = 'http://code.google.com/p/amaryllis-modules/issues/entry?template=Defect%20report%20from%20user';
$modversion['submit_feature'] = 'http://code.google.com/p/amaryllis-modules/issues/entry?template=Defect%20report%20from%20user';
$modversion['support_site_url'] = 'http://community.impresscms.org/modules/newbb/viewforum.php?forum=9';
$modversion['support_site_name']= 'ImpressCMS Community Forum';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// DATABASE /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i= 0;
$i++;
$modversion['object_items'][$i] = 'menu';
$i++;
$modversion['object_items'][$i] = 'item';

$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'menu_index.html',
										'description'	=> _MI_MENU_TPL_INDEX
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'menu_single_item.html',
										'description'	=> _MI_MENU_TPL_MENU_SINGLE_ITEM
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'menu_admin.html',
										'description'	=> _MI_MENU_TPL_ADMIN
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'menu_requirements.html',
										'description'	=> _MI_MENU_TPL_REQUIREMENTS
								);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Menu Block
$i++;
$modversion['blocks'][$i]['file']			= 'menu_block_menu_simple.php';
$modversion['blocks'][$i]['name']			= _MI_MENU_BLOCK_MENU_SIMPLE;
$modversion['blocks'][$i]['description']	= _MI_MENU_BLOCK_MENU_SIMPLE_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_menu_menu_simple_show';
$modversion['blocks'][$i]['edit_func']		= 'b_menu_menu_simple_edit';
$modversion['blocks'][$i]['options']		= '1|weight|ASC|0|0'; // menu id|order|sort|js|css
$modversion['blocks'][$i]['template']		= 'menu_block_menu_simple.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;
