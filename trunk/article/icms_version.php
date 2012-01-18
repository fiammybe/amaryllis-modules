<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * hold the configuration information about the module
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
						"name"						=> _MI_ARTICLE_MD_NAME,
						"version"					=> 1.0,
						"description"				=> _MI_ARTICLE_MD_DESC,
						"author"					=> "QM-B",
						"credits"					=> "",
						"help"						=> "",
						"license"					=> "GNU General Public License (GPL)",
						"official"					=> 0,
						"dirname"					=> basename(dirname(__FILE__)),
						"modname"					=> "article",
					
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
						"search"					=> array("file" => "include/search.inc.php", "func" => "article_search"),
					
					/** Menu information */
						"hasMain"					=> 1,
				);

/** other possible types: testers, translators, documenters and other */
$modversion['people']['developers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1314]QM-B[/url]";

/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=Article' target='_blank'>English</a>";

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
$modversion['object_items'][$i] = 'review';
$i++;
$modversion['object_items'][$i] = 'indexpage';
$i++;
$modversion['object_items'][$i] = 'log';

$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_index.html',
										'description'	=> _MI_ARTICLE_INDEX_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_article.html',
										'description'	=> _MI_ARTICLE_ARTICLE_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_category.html',
										'description'	=> _MI_ARTICLE_CATEGORY_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_forms.html',
										'description'	=> _MI_ARTICLE_FORMS_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_singlearticle.html',
										'description'	=> _MI_ARTICLE_SINGLEARTICLE_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_admin.html',
										'description'	=> _MI_ARTICLE_ADMIN_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_requirements.html',
										'description'	=> _MI_ARTICLE_REQUIREMENTS_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_header.html',
										'description'	=> _MI_ARTICLE_HEADER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_footer.html',
										'description'	=> _MI_ARTICLE_FOOTER_TPL
								);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent files block
$i++;
$modversion['blocks'][$i]['file']			= 'article_recent_article.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_RECENT_ARTICLE;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_RECENT_ARTICLE_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_recent_article_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_recent_article_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'article_block_recent_article.html';
$modversion['blocks'][$i]['can_clone']		= true ;
// recent updated block
$i++;
$modversion['blocks'][$i]['file']			= 'article_recent_updated.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_RECENT_UPDATED;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_RECENT_UPDATED_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_recent_updated_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_recent_updated_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'article_block_recent_updated.html';
$modversion['blocks'][$i]['can_clone']		= true ;
// most popular block
$i++;
$modversion['blocks'][$i]['file']			= 'article_most_popular.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_MOST_POPULAR;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_MOST_POPULAR_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_most_popular_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_most_popular_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'article_block_most_popular.html';
$modversion['blocks'][$i]['can_clone']		= true ;
// category menu block
$i++;
$modversion['blocks'][$i]['file']			= 'article_category_menu.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_CATEGORY_MENU;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_CATEGORY_MENU_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_category_menu_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_category_menu_edit';
$modversion['blocks'][$i]['options']		= 'category_title|ASC|1|0';
$modversion['blocks'][$i]['template']		= 'article_block_category_menu.html';
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
$modversion['comments']['callback']['approve'] = 'article_com_approve';
$modversion['comments']['callback']['update'] = 'article_com_update';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;

$i++;
$modversion['config'][$i] = array(
								'name'			=> 'article_allowed_groups',
								'title'			=> '_MI_ARTICLE_AUTHORIZED_GROUPS',
								'description'	=> '_MI_ARTICLE_AUTHORIZED_GROUPS_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_dateformat',
								'title' 		=> '_MI_ARTICLE_DATE_FORMAT',
								'description' 	=> '_MI_ARTICLE_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'string',
								'default' 		=> 'j/n/Y'
							);

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_ARTICLE_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_ARTICLE_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_categories',
								'title'			=> '_MI_ARTICLE_SHOW_CATEGORIES',
								'description' 	=> '_MI_ARTICLE_SHOW_CATEGORIES_DSC',
								'formtype' 		=> 'textbox',
								'valuetype'		=> 'int',
								'default' 		=> 15
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_category_columns',
								'title'			=> '_MI_ARTICLE_SHOW_CATEGORY_COLUMNS',
								'description' 	=> '_MI_ARTICLE_SHOW_CATEGORY_COLUMNS_DSC',
								'formtype' 		=> 'select',
								'valuetype'		=> 'int',
								'options'		=> array('1' => 1, '2' => 2, '3' => 3, '4' => 4),
								'default' 		=> 2
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_articles',
								'title' 		=> '_MI_ARTICLE_SHOW_ARTICLE',
								'description'	=> '_MI_ARTICLE_SHOW_ARTICLE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 20
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_ARTICLE_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_ARTICLE_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 110
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_ARTICLE_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_ARTICLE_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 150
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_width',
								'title' 		=> '_MI_ARTICLE_DISPLAY_WIDTH',
								'description' 	=> '_MI_ARTICLE_DISPLAY_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 110
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_height',
								'title' 		=> '_MI_ARTICLE_DISPLAY_HEIGHT',
								'description'	=> '_MI_ARTICLE_DISPLAY_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 150
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_width',
								'title' 		=> '_MI_ARTICLE_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_ARTICLE_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 1024
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_height',
								'title' 		=> '_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_ARTICLE_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 768
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'upload_file_size',
								'title' 		=> '_MI_ARTICLE_UPLOAD_FILE_SIZE',
								'description' 	=> '_MI_ARTICLE_UPLOAD_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 2097152 // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_file_size',
								'title' 		=> '_MI_ARTICLE_DISPLAY_FILE_SIZE',
								'description' 	=> '_MI_ARTICLE_DISPLAY_FILE_SIZE_DSC',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'text',
								'options'		=> array("byte" => 1, "kb" => 2, "mb" => 3, "gb" => 4),
								'default' 		=> 2
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_upl_disclaimer',
								'title' 		=> '_MI_ARTICLE_SHOWDISCLAIMER',
								'description' 	=> '_MI_ARTICLE_SHOWDISCLAIMER_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'upl_disclaimer',
								'title' 		=> '_MI_ARTICLE_DISCLAIMER',
								'description' 	=> '',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'text',
								'default' 		=> _MI_ARTICLE_UPL_DISCLAIMER_TEXT
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_down_disclaimer',
								'title' 		=> '_MI_ARTICLE_SHOW_DOWN_DISCL',
								'description' 	=> '_MI_ARTICLE_SHOW_DOWN_DISCL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'down_disclaimer',
								'title' 		=> '_MI_ARTICLE_DOWN_DISCLAIMER',
								'description' 	=> '',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'text',
								'default' 		=> _MI_ARTICLE_DOWN_DISCLAIMER_TEXT
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_rss',
								'title' 		=> '_MI_ARTICLE_USE_RSS',
								'description' 	=> '_MI_ARTICLE_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_sprockets',
								'title' 		=> '_MI_ARTICLE_USE_SPROCKETS',
								'description' 	=> '_MI_ARTICLE_USE_SPROCKETS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_attachments',
								'title' 		=> '_MI_ARTICLE_NEED_STEPS',
								'description' 	=> '_MI_ARTICLE_NEED_STEPS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_related',
								'title' 		=> '_MI_ARTICLE_NEED_RELATED',
								'description' 	=> '_MI_ARTICLE_NEED_RELATED_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_needs_approval',
								'title' 		=> '_MI_ARTICLE_DOWNLOAD_APPROVE',
								'description' 	=> '_MI_ARTICLE_DOWNLOAD_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'category_needs_approval',
								'title' 		=> '_MI_ARTICLE_CATEGORY_APPROVE',
								'description' 	=> '_MI_ARTICLE_CATEGORY_APPROVE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guest_vote',
								'title' 		=> '_MI_ARTICLE_GUEST_CAN_VOTE',
								'description' 	=> '_MI_ARTICLE_GUEST_CAN_VOTE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_popular',
								'title' 		=> '_MI_ARTICLE_POPULAR',
								'description' 	=> '',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options' 		=> array('0' => 0, '5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000),
								'default' 		=> 100
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_daysnew',
								'title' 		=> '_MI_ARTICLE_DAYSNEW',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_daysupdated',
								'title' 		=> '_MI_ARTICLE_DAYSUPDATED',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);







