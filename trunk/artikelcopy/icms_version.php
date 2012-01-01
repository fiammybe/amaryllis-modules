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
				);

/** other possible types: testers, translators, documenters and other */
$modversion['people']['developers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1314]QM-B[/url]";

/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=Artikel' target='_blank'>English</a>";

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
$modversion['object_items'][$i] = 'article';
$i++;
$modversion['object_items'][$i] = 'resources';
$i++;
$modversion['object_items'][$i] = 'reviews';
$i++;
$modversion['object_items'][$i] = 'indexpage';
$i++;
$modversion['object_items'][$i] = 'tags';
$i++;
$modversion['object_items'][$i] = 'log';

$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_index.html',
										'description'	=> _MI_ARTIKEL_INDEX_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_article.html',
										'description'	=> _MI_ARTIKEL_ARTICLE_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_category.html',
										'description'	=> _MI_ARTIKEL_CATEGORY_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_forms.html',
										'description'	=> _MI_ARTIKEL_FORMS_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_singlearticle.html',
										'description'	=> _MI_ARTIKEL_SINGLEARTICLE_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_admin.html',
										'description'	=> _MI_ARTIKEL_ADMIN_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_requirements.html',
										'description'	=> _MI_ARTIKEL_REQUIREMENTS_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_header.html',
										'description'	=> _MI_ARTIKEL_HEADER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'artikel_footer.html',
										'description'	=> _MI_ARTIKEL_FOOTER_TPL
								);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent files block
$i++;
$modversion['blocks'][$i]['file']			= 'artikel_recent_artikel.php';
$modversion['blocks'][$i]['name']			= _MI_ARTIKEL_BLOCK_RECENT_ARTICLE;
$modversion['blocks'][$i]['description']	= _MI_ARTIKEL_BLOCK_RECENT_ARTICLE_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_artikel_recent_article_show';
$modversion['blocks'][$i]['edit_func']		= 'b_artikel_recent_article_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'artikel_block_recent_article.html';
$modversion['blocks'][$i]['can_clone']		= true ;
// recent updated block
$i++;
$modversion['blocks'][$i]['file']			= 'artikel_recent_updated.php';
$modversion['blocks'][$i]['name']			= _MI_ARTIKEL_BLOCK_RECENT_UPDATED;
$modversion['blocks'][$i]['description']	= _MI_ARTIKEL_BLOCK_RECENT_UPDATED_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_artikel_recent_updated_show';
$modversion['blocks'][$i]['edit_func']		= 'b_artikel_recent_updated_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'artikel_block_recent_updated.html';
$modversion['blocks'][$i]['can_clone']		= true ;
// most popular block
$i++;
$modversion['blocks'][$i]['file']			= 'artikel_most_popular.php';
$modversion['blocks'][$i]['name']			= _MI_ARTIKEL_BLOCK_MOST_POPULAR;
$modversion['blocks'][$i]['description']	= _MI_ARTIKEL_BLOCK_MOST_POPULAR_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_artikel_most_popular_show';
$modversion['blocks'][$i]['edit_func']		= 'b_artikel_most_popular_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'artikel_block_most_popular.html';
$modversion['blocks'][$i]['can_clone']		= true ;
// category menu block
$i++;
$modversion['blocks'][$i]['file']			= 'artikel_category_menu.php';
$modversion['blocks'][$i]['name']			= _MI_ARTIKEL_BLOCK_CATEGORY_MENU;
$modversion['blocks'][$i]['description']	= _MI_ARTIKEL_BLOCK_CATEGORY_MENU_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_artikel_category_menu_show';
$modversion['blocks'][$i]['edit_func']		= 'b_artikel_category_menu_edit';
$modversion['blocks'][$i]['options']		= 'category_title|ASC|1|0';
$modversion['blocks'][$i]['template']		= 'artikel_block_category_menu.html';
$modversion['blocks'][$i]['can_clone']		= true ;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'singlearticle.php';
$modversion['comments']['itemName'] = 'article_id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment.inc.php';
$modversion['comments']['callback']['approve'] = 'artikel_com_approve';
$modversion['comments']['callback']['update'] = 'artikel_com_update';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;

$i++;
$modversion['config'][$i] = array(
								'name'			=> 'artikel_allowed_groups',
								'title'			=> '_MI_ARTIKEL_AUTHORIZED_GROUPS',
								'description'	=> '_MI_ARTIKEL_AUTHORIZED_GROUPS_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'artikel_dateformat',
								'title' 		=> '_MI_ARTIKEL_DATE_FORMAT',
								'description' 	=> '_MI_ARTIKEL_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'string',
								'default' 		=> 'j/n/Y'
							);

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_ARTIKEL_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_ARTIKEL_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_categories',
								'title'			=> '_MI_ARTIKEL_SHOW_CATEGORIES',
								'description' 	=> '_MI_ARTIKEL_SHOW_CATEGORIES_DSC',
								'formtype' 		=> 'textbox',
								'valuetype'		=> 'int',
								'default' 		=> 15
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_category_columns',
								'title'			=> '_MI_ARTIKEL_SHOW_CATEGORY_COLUMNS',
								'description' 	=> '_MI_ARTIKEL_SHOW_CATEGORY_COLUMNS_DSC',
								'formtype' 		=> 'select',
								'valuetype'		=> 'int',
								'options'		=> array('1' => 1, '2' => 2, '3' => 3, '4' => 4),
								'default' 		=> 2
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_articles',
								'title' 		=> '_MI_ARTIKEL_SHOW_ARTIKEL',
								'description'	=> '_MI_ARTIKEL_SHOW_ARTIKEL_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 20
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_ARTIKEL_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_ARTIKEL_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 110
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_ARTIKEL_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_ARTIKEL_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 150
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_width',
								'title' 		=> '_MI_ARTIKEL_DISPLAY_WIDTH',
								'description' 	=> '_MI_ARTIKEL_DISPLAY_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 110
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_height',
								'title' 		=> '_MI_ARTIKEL_DISPLAY_HEIGHT',
								'description'	=> '_MI_ARTIKEL_DISPLAY_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 150
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_width',
								'title' 		=> '_MI_ARTIKEL_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_ARTIKEL_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 1024
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_height',
								'title' 		=> '_MI_ARTIKEL_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_ARTIKEL_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 768
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'upload_file_size',
								'title' 		=> '_MI_ARTIKEL_UPLOAD_FILE_SIZE',
								'description' 	=> '_MI_ARTIKEL_UPLOAD_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 2097152 // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_file_size',
								'title' 		=> '_MI_ARTIKEL_DISPLAY_FILE_SIZE',
								'description' 	=> '_MI_ARTIKEL_DISPLAY_FILE_SIZE_DSC',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'text',
								'options'		=> array("byte" => 1, "kb" => 2, "mb" => 3, "gb" => 4),
								'default' 		=> 2
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_upl_disclaimer',
								'title' 		=> '_MI_ARTIKEL_SHOWDISCLAIMER',
								'description' 	=> '_MI_ARTIKEL_SHOWDISCLAIMER_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'upl_disclaimer',
								'title' 		=> '_MI_ARTIKEL_DISCLAIMER',
								'description' 	=> '',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'text',
								'default' 		=> _MI_ARTIKEL_UPL_DISCLAIMER_TEXT
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_down_disclaimer',
								'title' 		=> '_MI_ARTIKEL_SHOW_DOWN_DISCL',
								'description' 	=> '_MI_ARTIKEL_SHOW_DOWN_DISCL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'down_disclaimer',
								'title' 		=> '_MI_ARTIKEL_DOWN_DISCLAIMER',
								'description' 	=> '',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'text',
								'default' 		=> _MI_ARTIKEL_DOWN_DISCLAIMER_TEXT
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'downloads_license',
								'title' 		=> '_MI_ARTIKEL_LICENSE',
								'description' 	=> '_MI_ARTIKEL_LICENSE_DSC',
								'formtype' 		=> 'textsarea',
								'valuetype' 	=> 'text',
								'default' 		=> 'None
,Apache License (v. 1.1)
,Apple Public Source License (v. 2.0)
,Berkeley Database License
,BSD License (Original)
,Common Public License
,Creative Commons (CC) 3.0 (by)
,Creative Commons (CC) 3.0 (by-nd)
,Creative Commons (CC) 3.0 (by-nc)
,Creative Commons (CC) 3.0 (by-nc-nd)
,Creative Commons (CC) 3.0 (by-nc-sa)
,Creative Commons (CC) 3.0 (by-sa)
,FreeBSD Copyright (Modifizierte BSD-Lizenz)
,GNU Emacs General Public License
,GNU Free Documentation License (FDL) (v. 1.2)
,GNU General Public License (GPL) (v. 1.0)
,GNU General Public License (GPL) (v. 2.0)
,GNU General Public License (GPL) (v. 3.0)
,GNU Lesser General Public License (LGPL) (v. 2.1)
,GNU Library General Public License (LGPL) (v.2.0)
,Microsoft Shared Source License
,MIT License
,Mozilla Public License (v. 1.1)
,Open Software License (OSL) (v. 1.0)
,Open Software License (OSL) (v. 1.1)
,Open Software License (OSL) (v. 2.0)
,Open Public License
,Open RTLinux Patent License (v. 1.0)
,PHP License (v. 3.0)
,W3C Software Notice and License
,Wide Open License (WOL)
,X.Net License
,X Window System License');
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_rss',
								'title' 		=> '_MI_ARTIKEL_USE_RSS',
								'description' 	=> '_MI_ARTIKEL_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_downloads',
								'title' 		=> '_MI_ARTIKEL_USE_DOWNLOADS',
								'description' 	=> '_MI_ARTIKEL_USE_DOWNLOADS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_album',
								'title' 		=> '_MI_ARTIKEL_USE_RSS',
								'description' 	=> '_MI_ARTIKEL_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_steps',
								'title' 		=> '_MI_ARTIKEL_NEED_STEPS',
								'description' 	=> '_MI_ARTIKEL_NEED_STEPS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_tips',
								'title' 		=> '_MI_ARTIKEL_NEED_TIPS',
								'description' 	=> '_MI_ARTIKEL_NEED_TIPS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_warnings',
								'title' 		=> '_MI_ARTIKEL_NEED_WARNINGS',
								'description' 	=> '_MI_ARTIKEL_NEED_WARNINGS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_licenses',
								'title' 		=> '_MI_ARTIKEL_NEED_LICENSES',
								'description' 	=> '_MI_ARTIKEL_NEED_LICENSES_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_needed_things',
								'title' 		=> '_MI_ARTIKEL_NEED_NEEDED_THINGS',
								'description' 	=> '_MI_ARTIKEL_NEED_NEEDED_THINGS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_attachments',
								'title' 		=> '_MI_ARTIKEL_NEED_STEPS',
								'description' 	=> '_MI_ARTIKEL_NEED_STEPS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_videos',
								'title' 		=> '_MI_ARTIKEL_NEED_VIDEOS',
								'description' 	=> '_MI_ARTIKEL_NEED_VIDEOS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_history',
								'title' 		=> '_MI_ARTIKEL_NEED_HISTORY',
								'description' 	=> '_MI_ARTIKEL_NEED_HISTORY_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_related',
								'title' 		=> '_MI_ARTIKEL_NEED_RELATED',
								'description' 	=> '_MI_ARTIKEL_NEED_RELATED_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_resources',
								'title' 		=> '_MI_ARTIKEL_NEED_RESOURCES',
								'description' 	=> '_MI_ARTIKEL_NEED_RESOURCES_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'resources_needs_approval',
								'title' 		=> '_MI_ARTIKEL_RESOURCES_APPROVE',
								'description' 	=> '_MI_ARTIKEL_RESOURCES_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_conclusion',
								'title' 		=> '_MI_ARTIKEL_NEED_CONCLUSION',
								'description' 	=> '_MI_ARTIKEL_NEED_CONCLUSION_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_needs_approval',
								'title' 		=> '_MI_ARTIKEL_DOWNLOAD_APPROVE',
								'description' 	=> '_MI_ARTIKEL_DOWNLOAD_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'category_needs_approval',
								'title' 		=> '_MI_ARTIKEL_CATEGORY_APPROVE',
								'description' 	=> '_MI_ARTIKEL_CATEGORY_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guest_vote',
								'title' 		=> '_MI_ARTIKEL_GUEST_CAN_VOTE',
								'description' 	=> '_MI_ARTIKEL_GUEST_CAN_VOTE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_reviews',
								'title' 		=> '_MI_ARTIKEL_SHOW_REVIEWS',
								'description' 	=> '_MI_ARTIKEL_SHOW_REVIEWS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'review_needs_approval',
								'title' 		=> '_MI_ARTIKEL_CATEGORY_APPROVE',
								'description' 	=> '_MI_ARTIKEL_CATEGORY_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guest_review',
								'title' 		=> '_MI_ARTIKEL_GUEST_CAN_REVIEW',
								'description' 	=> '_MI_ARTIKEL_GUEST_CAN_REVIEW_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_reviews_email',
								'title' 		=> '_MI_ARTIKEL_SHOW_REVIEWS_EMAIL',
								'description' 	=> '_MI_ARTIKEL_SHOW_REVIEWS_EMAIL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_reviews_email',
								'title' 		=> '_MI_ARTIKEL_DISPLAY_REVIEWS_EMAIL',
								'description' 	=> '_MI_ARTIKEL_DISPLAY_REVIEWS_EMAIL_DSC',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options'		=> array("_MI_ARTIKEL_DISPLAY_REVEMAIL_SPAMPROT" => 1, "_MI_ARTIKEL_DISPLAY_REVEMAIL_IMGPROT" => 2, "_MI_ARTIKEL_DISPLAY_REVEMAIL_SPAMPROT_BANNED" => 3, "_MI_ARTIKEL_DISPLAY_REVEMAIL_IMGPROT_BANNED" => 4),
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_reviews_avatar',
								'title' 		=> '_MI_ARTIKEL_SHOW_REVIEWS_AVATAR',
								'description' 	=> '_MI_ARTIKEL_SHOW_REVIEWS_AVATAR_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_reviews_count',
								'title' 		=> '_MI_ARTIKEL_REVIEWS_COUNT',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'review_order',
								'title' 		=> '_MI_ARTIKEL_REVIEWS_ORDER',
								'description' 	=> '',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'text',
								'options' 		=> array("DESC" => 1, "ASC" => 2),
								'default'		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'tags_needs_approval',
								'title' 		=> '_MI_ARTIKEL_TAGS_APPROVE',
								'description' 	=> '_MI_ARTIKEL_TAGS_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_teaser',
								'title' 		=> '_MI_ARTIKEL_DISPLAY_TEASER',
								'description' 	=> '_MI_ARTIKEL_DISPLAY_TEASER_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_popular',
								'title' 		=> '_MI_ARTIKEL_POPULAR',
								'description' 	=> '',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options' 		=> array('0' => 0, '5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000),
								'default' 		=> 100
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_daysnew',
								'title' 		=> '_MI_ARTIKEL_DAYSNEW',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_daysupdated',
								'title' 		=> '_MI_ARTIKEL_DAYSUPDATED',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);







