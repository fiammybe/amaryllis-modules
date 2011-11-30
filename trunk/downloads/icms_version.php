<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * module informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion = array(
					'name'						=> _MI_DOWNLOADS_NAME,
					'version'					=> 1.0,
					'description'				=> _MI_DOWNLOADS_DSC,
					'author'					=> "QM-B &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';",
					'credits'					=> "Thanks to Phoenyx for his great help while developing the module and McDonald for the nice layer for my Indeximage.",
					'help'						=> "admin/manual.php",
					'license'					=> "GNU General Public License (GPL)",
					'official'					=> 0,
					'dirname'					=> basename( dirname( __FILE__ ) ),
					'modname'					=> "downloads",

					/**  Images information  */
					'iconsmall'					=> "images/downloads_icon_small.png",
					'iconbig'					=> "images/downloads_icon.png",
					'image'						=> "images/downloads_icon.png", /* for backward compatibility */

					/**  Development information */
					'status_version'			=> "1.0",
					'status'					=> "beta",
					'date'						=> "Unreleased",
					'author_word'				=> "",
					'warning'					=> _CO_ICMS_WARNING_BETA,

					/** Contributors */
					'developer_website_url' 	=> "http://code.google.com/p/amaryllis-modules/",
					'developer_website_name' 	=> "Amaryllis Modules",
					'developer_email' 			=> "qm-b@hotmail.de"
				);

$modversion['people']['developers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';";
$modversion['people']['testers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=462' target='_blank'>David</a>";

$modversion['people']['translators'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';";
$modversion['people']['translators'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=462' target='_blank'>David</a>";


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// ADMINISTRATIVE INFORMATION ////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['hasMain'] 		= 1;
$modversion['hasAdmin'] 	= 1;
$modversion['adminindex']	= 'admin/index.php';
$modversion['adminmenu'] 	= 'admin/menu.php';
	

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// SUPPORT //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion['support_site_url'] = 'http://community.impresscms.org/modules/newbb/viewforum.php?forum=9';
$modversion['support_site_name']= 'ImpressCMS Community Forum';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// DATABASE /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i= 0;
$i++;
$modversion['object_items'][$i] = 'category';
$i++;
$modversion['object_items'][$i] = 'download';
$i++;
$modversion['object_items'][$i] = 'ratings';
$i++;
$modversion['object_items'][$i] = 'indexpage';
$i++;
$modversion['object_items'][$i] = 'log';

$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////// INSTALLATION / UPGRADE //////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// OnUpdate - upgrade DATABASE
$modversion['onUpdate'] = 'include/onupdate.inc.php';

// OnInstall - Insert Sample Form, create folders
$modversion['onInstall'] = 'include/onupdate.inc.php';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion['templates'][1] = array(
										'file'			=> 'downloads_index.html',
										'description'	=> _MI_DOWNLOADS_INDEX_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'downloads_header.html',
										'description'	=> _MI_DOWNLOADS_HEADER_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'downloads_footer.html',
										'description'	=> _MI_DOWNLOADS_FOOTER_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'downloads_category.html',
										'description'	=> _MI_DOWNLOADS_CATEGORY_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'downloads_download.html',
										'description'	=> _MI_DOWNLOADS_DOWNLOAD_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'downloads_singledownload.html',
										'description'	=> _MI_DOWNLOADS_DOWNLOAD_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'downloads_admin.html',
										'description'	=> _MI_DOWNLOADS_ADMIN_FORM_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'downloads_requirements.html',
										'description'	=> _AM_DOWNLOADS_REQUIREMENTS_TPL
								);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent albums block
$i++;
$modversion['blocks'][$i]['file']			= 'downloads_recent_downloads.php';
$modversion['blocks'][$i]['name']			= _MI_DOWNLOADS_BLOCK_RECENT_DOWNLOADS;
$modversion['blocks'][$i]['description']	= _MI_DOWNLOADS_BLOCK_RECENT_DOWNLOADS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_downloads_recent_downloads_show';
$modversion['blocks'][$i]['edit_func']		= 'b_downloads_recent_downloads_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'downloads_block_recent_downloads.html';
$modversion['blocks'][$i]['can_clone']		= true ;
$i++;
$modversion['blocks'][$i]['file']			= 'downloads_category_menu.php';
$modversion['blocks'][$i]['name']			= _MI_DOWNLOADS_BLOCK_CATEGORY_MENU;
$modversion['blocks'][$i]['description']	= _MI_DOWNLOADS_BLOCK_CATEGORY_MENU_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_downloads_category_menu_show';
$modversion['blocks'][$i]['edit_func']		= 'b_downloads_category_menu_edit';
$modversion['blocks'][$i]['options']		= 'category_title|ASC|1|0';
$modversion['blocks'][$i]['template']		= 'downloads_block_category_menu.html';
$modversion['blocks'][$i]['can_clone']		= true ;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// SEARCH //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


/** Search information */
$modversion['hasSearch'] = 1;
$modversion['search'] ['file'] = 'include/search.inc.php';
$modversion['search'] ['func'] = 'downloads_search';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'singlefile.php';
$modversion['comments']['itemName'] = 'download_id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment.inc.php';
$modversion['comments']['callback']['approve'] = 'downloads_com_approve';
$modversion['comments']['callback']['update'] = 'downloads_com_update';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;

$i++;
$modversion['config'][$i] = array(
								'name'			=> 'downloads_allowed_groups',
								'title'			=> '_MI_DOWNLOADS_AUTHORIZED_GROUPS',
								'description'	=> '_MI_DOWNLOADS_AUTHORIZED_GROUPS_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> '1'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_dateformat',
								'title' 		=> '_MI_DOWNLOADS_DATE_FORMAT',
								'description' 	=> '_MI_DOWNLOADS_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'string',
								'default' 		=> 'j/n/Y'
							);

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_DOWNLOADS_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_DOWNLOADS_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_categories',
								'title'			=> '_MI_DOWNLOADS_SHOW_CATEGORIES',
								'description' 	=> '_MI_DOWNLOADS_SHOW_CATEGORIES_DSC',
								'formtype' 		=> 'textbox',
								'valuetype'		=> 'int',
								'default' 		=> 15
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_downloads',
								'title' 		=> '_MI_DOWNLOADS_SHOW_DOWNLOADS',
								'description'	=> '_MI_DOWNLOADS_SHOW_DOWNLOADS_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '20'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_DOWNLOADS_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_DOWNLOADS_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '110'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_DOWNLOADS_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_DOWNLOADS_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '150'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_width',
								'title' 		=> '_MI_DOWNLOADS_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_DOWNLOADS_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '1024'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_height',
								'title' 		=> '_MI_DOWNLOADS_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_DOWNLOADS_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '768'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_file_size',
								'title' 		=> '_MI_DOWNLOADS_IMAGE_FILE_SIZE',
								'description' 	=> '_MI_DOWNLOADS_IMAGE_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_file_size',
								'title' 		=> '_MI_DOWNLOADS_UPLOAD_FILE_SIZE',
								'description' 	=> '_MI_DOWNLOADS_UPLOAD_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_limitations',
								'title' 		=> '_MI_DOWNLOADS_LIMITS',
								'description' 	=> '_MI_DOWNLOADS_LIMITS_DSC',
								'formtype' 		=> 'textsarea',
								'valuetype' 	=> 'text',
								'default' 		=> 'None,Trial,14 day limitation,None Save'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_status_versiontypes',
								'title' 		=> '_MI_DOWNLOADS_VERSIONTYPES',
								'description' 	=> '_MI_DOWNLOADS_VERSIONTYPES_DSC',
								'formtype' 		=> 'textsarea',
								'valuetype' 	=> 'text',
								'default' 		=> 'None,Alpha,Beta,RC,Final'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_show_upl_disclaimer',
								'title' 		=> '_MI_DOWNLOADS_SHOWDISCLAIMER',
								'description' 	=> '_MI_DOWNLOADS_SHOWDISCLAIMER_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_upl_disclaimer',
								'title' 		=> '_MI_DOWNLOADS_DISCLAIMER',
								'description' 	=> '',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'text',
								'default' 		=> _MI_DOWNLOADS_UPL_DISCLAIMER_TEXT
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_show_down_disclaimer',
								'title' 		=> '_MI_DOWNLOADS_SHOW_DOWN_DISCL',
								'description' 	=> '_MI_DOWNLOADS_SHOW_DOWN_DISCL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_down_disclaimer',
								'title' 		=> '_MI_DOWNLOADS_DOWN_DISCLAIMER',
								'description' 	=> '',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'text',
								'default' 		=> _MI_DOWNLOADS_DOWN_DISCLAIMER_TEXT
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_platform',
								'title' 		=> '_MI_DOWNLOADS_PLATFORM',
								'description' 	=> '_MI_DOWNLOADS_PLATFORM_DSC',
								'formtype' 		=> 'textsarea',
								'valuetype' 	=> 'text',
								'default' 		=> 'None,ImpressCMS 1.0,ImpressCMS 1.1,ImpressCMS 1.2.x,ImpressCMS 1.3,Windows,Unix,Mac,Other'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_license',
								'title' 		=> '_MI_DOWNLOADS_LICENSE',
								'description' 	=> '_MI_DOWNLOADS_LICENSE_DSC',
								'formtype' 		=> 'textsarea',
								'valuetype' 	=> 'text',
								'default' 		=> 'None
|Apache License (v. 1.1
|Apple Public Source License (v. 2.0)
|Berkeley Database License
|BSD License (Original)
|Common Public License
|FreeBSD Copyright (Modifizierte BSD-Lizenz)
|GNU Emacs General Public License
|GNU Free Documentation License (FDL) (v. 1.2)
|GNU General Public License (GPL) (v. 1.0)
|GNU General Public License (GPL) (v. 2.0)
|GNU Lesser General Public License (LGPL) (v. 2.1)
|GNU Library General Public License (LGPL) (v.2.0)
|Microsoft Shared Source License
|Mozilla Public License (v. 1.1)
|Open Software License (OSL) (v. 1.0)
|Open Software License (OSL) (v. 1.1)
|Open Software License (OSL) (v. 2.0)
|Open Public License
|Open RTLinux Patent License (v. 1.0)
|PHP License (v. 3.0)
|W3C Software Notice and License
|Wide Open License (WOL)
|X.Net License
|X Window System License'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_rss',
								'title' 		=> '_MI_DOWNLOADS_USE_RSS',
								'description' 	=> '_MI_DOWNLOADS_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_catalogue',
								'title' 		=> '_MI_DOWNLOADS_USE_CATALOGUE',
								'description' 	=> '_MI_DOWNLOADS_USE_CATALOGUE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_album',
								'title' 		=> '_MI_DOWNLOADS_USE_ALBUM',
								'description' 	=> '_MI_DOWNLOADS_USE_ALBUM_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_mirror',
								'title' 		=> '_MI_DOWNLOADS_USE_MIRROR',
								'description' 	=> '_MI_DOWNLOADS_USE_MIRROR_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'mirror_needs_approve',
								'title' 		=> '_MI_DOWNLOADS_MIRROR_APPROVE',
								'description' 	=> '_MI_DOWNLOADS_MIRROR_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_needs_approve',
								'title' 		=> '_MI_DOWNLOADS_DOWNLOAD_APPROVE',
								'description' 	=> '_MI_DOWNLOADS_DOWNLOAD_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'category_needs_approve',
								'title' 		=> '_MI_DOWNLOADS_CATEGORY_APPROVE',
								'description' 	=> '_MI_DOWNLOADS_CATEGORY_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_popular',
								'title' 		=> '_MI_DOWNLOADS_POPULAR',
								'description' 	=> '',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options' 		=> array('0' => 0, '5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000),
								'default' 		=> 100
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_daysnew',
								'title' 		=> '_MI_DOWNLOADS_DAYSNEW',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_daysupdated',
								'title' 		=> '_MI_DOWNLOADS_DAYSUPDATED',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// NOTIFICATIONS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion['hasNotification'] = 0;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'downloads_notify_iteminfo';

$modversion['notification']['category'][] = array (
													'name'				=> 'global',
													'title'				=> _MI_DOWNLOADS_GLOBAL_NOTIFY,
													'description'		=> _MI_DOWNLOADS_GLOBAL_NOTIFY_DSC,
													'subscribe_from'	=> array('index.php', 'album.php')
												);
$modversion['notification']['event'][] = array(
													'name'				=> 'category_published',
													'category'			=> 'global',
													'title'				=> _MI_DOWNLOADS_GLOBAL_CATEGORY_PUBLISHED_NOTIFY,
													'caption'			=> _MI_DOWNLOADS_GLOBAL_CATEGORY_PUBLISHED_NOTIFY_CAP,
													'description'		=> _MI_DOWNLOADS_GLOBAL_CATEGORY_PUBLISHED_NOTIFY_DSC,
													'mail_template'		=> 'global_category_published',
													'mail_subject'		=> _MI_DOWNLOADS_GLOBAL_CATEGORY_PUBLISHED_NOTIFY_SBJ
												);