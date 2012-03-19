<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * hold the configuration information about the module
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

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
						"name"						=> _MI_ARTICLE_MD_NAME,
						"version"					=> 1.0,
						"description"				=> _MI_ARTICLE_MD_DSC,
						"author"					=> "QM-B",
						"credits"					=> "Thanks to Lotus for his testings and McDonald for the nice Layer for the index-Image",
						"help"						=> "",
						"license"					=> "GNU General Public License (GPL)",
						"official"					=> 0,
						"dirname"					=> basename(dirname(__FILE__)),
						"modname"					=> "article",
					
					/**  Images information  */
						"iconsmall"					=> "images/article_icon_small.png",
						"iconbig"					=> "images/article_icon_big.png",
						"image"						=> "images/article_icon_big.png", /* for backward compatibility */
					
					/**  Development information */
						"status_version"			=> "1.0",
						"status"					=> "Final",
						"date"						=> "13.03.2012",
						"author_word"				=> "",
						"warning"					=> _CO_ICMS_WARNING_FINAL,
					
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
						"hasSearch"					=> 1,
						"search"					=> array("file" => "include/search.inc.php", "func" => "article_search"),
					
					/** Menu information */
						"hasMain"					=> 1,
				);

/** other possible types: testers, translators, documenters and other */
$modversion['people']['developers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1314]QM-B[/url]";
$modversion['people']['testers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";

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
$modversion['object_items'][$i] = 'indexpage';

$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_header.html',
										'description'	=> _MI_ARTICLE_HEADER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'article_footer.html',
										'description'	=> _MI_ARTICLE_HEADER_TPL
								);
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
										'file'			=> 'article_print.html',
										'description'	=> _MI_ARTICLE_PRINT_TPL
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


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent articles block
$i++;
$modversion['blocks'][$i]['file']			= 'article_recent_articles.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_RECENT_ARTICLE;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_RECENT_ARTICLE_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_recent_article_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_recent_article_edit';
$modversion['blocks'][$i]['options']		= '10|0|1';
$modversion['blocks'][$i]['template']		= 'article_block_recent_articles.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;
// Recent articles block
$i++;
$modversion['blocks'][$i]['file']			= 'article_recent_articles_list.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_RECENT_ARTICLE_LIST;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_RECENT_ARTICLE_LIST_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_recent_article_list_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_recent_article_list_edit';
$modversion['blocks'][$i]['options']		= '10|0';
$modversion['blocks'][$i]['template']		= 'article_block_recent_articles_list.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// recent updated block
$i++;
$modversion['blocks'][$i]['file']			= 'article_recent_updated.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_RECENT_UPDATED;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_RECENT_UPDATED_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_recent_updated_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_recent_updated_edit';
$modversion['blocks'][$i]['options']		= '10|0|1';
$modversion['blocks'][$i]['template']		= 'article_block_recent_updated.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// most popular block
$i++;
$modversion['blocks'][$i]['file']			= 'article_most_popular.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_MOST_POPULAR;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_MOST_POPULAR_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_most_popular_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_most_popular_edit';
$modversion['blocks'][$i]['options']		= '10|0|1';
$modversion['blocks'][$i]['template']		= 'article_block_most_popular.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// category menu block
$i++;
$modversion['blocks'][$i]['file']			= 'article_category_menu.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_CATEGORY_MENU;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_CATEGORY_MENU_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_category_menu_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_category_menu_edit';
$modversion['blocks'][$i]['options']		= 'category_title|ASC|1|0';
$modversion['blocks'][$i]['template']		= 'article_block_category_menu.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// article spotlight block
$i++;
$modversion['blocks'][$i]['file']			= 'article_spotlight.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_SPOTLIGHT;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_SPOTLIGHT_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_spotlight_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_spotlight_edit';
$modversion['blocks'][$i]['options']		= '10|0|1';
$modversion['blocks'][$i]['template']		= 'article_block_article_spotlight.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// article random block
$i++;
$modversion['blocks'][$i]['file']			= 'article_random_articles.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_RANDOM_ARTICLES;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_RANDOM_ARTICLES_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_random_articles_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_random_articles_edit';
$modversion['blocks'][$i]['options']		= '10|0|1';
$modversion['blocks'][$i]['template']		= 'article_block_random_articles.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// article gallery block
$i++;
$modversion['blocks'][$i]['file']			= 'article_spotlight_gallery.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_SPOTLIGHT_IMAGE;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_SPOTLIGHT_IMAGE_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_spotlight_image_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_spotlight_image_edit';
$modversion['blocks'][$i]['options']		= '10|0|1|1';
$modversion['blocks'][$i]['template']		= 'article_block_article_gallery.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// article most commented
$i++;
$modversion['blocks'][$i]['file']			= 'article_most_commented.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_MOST_COMMENTED;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_MOST_COMMENTED_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_most_commented_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_most_commented_edit';
$modversion['blocks'][$i]['options']		= '10|0|1';
$modversion['blocks'][$i]['template']		= 'article_block_most_commented.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// article newsticker
$i++;
$modversion['blocks'][$i]['file']			= 'article_newsticker.php';
$modversion['blocks'][$i]['name']			= _MI_ARTICLE_BLOCK_NEWSTICKER;
$modversion['blocks'][$i]['description']	= _MI_ARTICLE_BLOCK_NEWSTICKER_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_article_newsticker_show';
$modversion['blocks'][$i]['edit_func']		= 'b_article_newsticker_edit';
$modversion['blocks'][$i]['options']		= '10|0';
$modversion['blocks'][$i]['template']		= 'article_block_newsticker.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;

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
								'default' 		=> 150
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_ARTICLE_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_ARTICLE_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 110
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_width',
								'title' 		=> '_MI_ARTICLE_DISPLAY_WIDTH',
								'description' 	=> '_MI_ARTICLE_DISPLAY_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 260
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_height',
								'title' 		=> '_MI_ARTICLE_DISPLAY_HEIGHT',
								'description'	=> '_MI_ARTICLE_DISPLAY_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 160
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
								'title' 		=> '_MI_ARTICLE_UPLOAD_ARTICLE_SIZE',
								'description' 	=> '_MI_ARTICLE_UPLOAD_ARTICLE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 2097152 // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_file_size',
								'title' 		=> '_MI_ARTICLE_DISPLAY_ARTICLE_SIZE',
								'description' 	=> '_MI_ARTICLE_DISPLAY_ARTICLE_SIZE_DSC',
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
								'title' 		=> '_MI_ARTICLE_NEED_ATTACHMENTS',
								'description' 	=> '_MI_ARTICLE_NEED_ATTACHMENTS_DSC',
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
								'title' 		=> '_MI_ARTICLE_ARTICLE_APPROVE',
								'description' 	=> '_MI_ARTICLE_ARTICLE_APPROVE_DSC',
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
								'name' 			=> 'article_popular',
								'title' 		=> '_MI_ARTICLE_POPULAR',
								'description' 	=> '',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options' 		=> array('0' => 0, '5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000, '1500' => 1500, '2000' => 2000, '3000' => 3000),
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
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'display_twitter',
								'title'			=> '_MI_ARTICLE_DISPLAY_TWITTER',
								'description'	=> '_MI_ARTICLE_DISPLAY_TWITTER_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 0,
								'options'		=> array( _NONE => 0, _MI_ARTICLE_DEFAULT => 1, _MI_ARTICLE_HORIZONTAL => 2, _MI_ARTICLE_VERTICAL => 3 )
							);	
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'display_fblike',
								'title'			=> '_MI_ARTICLE_DISPLAY_FBLIKE',
								'description'	=> '_MI_ARTICLE_DISPLAY_FBLIKE_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 0,
								'options'		=> array( _NONE => 0, _MI_ARTICLE_HORIZONTAL => 1, _MI_ARTICLE_VERTICAL => 2 ) 
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'display_gplus',
								'title'			=> '_MI_ARTICLE_DISPLAY_GPLUS',
								'description'	=> '_MI_ARTICLE_DISPLAY_GPLUS_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 0,
								'options'		=> array( _NONE => 0, _MI_ARTICLE_DEFAULT => 1, _MI_ARTICLE_HORIZONTAL => 2, _MI_ARTICLE_VERTICAL => 3 ) 
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_print_footer',
								'title' 		=> '_MI_ARTICLE_PRINT_FOOTER',
								'description' 	=> '_MI_ARTICLE_PRINT_FOOTER_DSC',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'txt',
								'default' 		=> ''
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_print_logo',
								'title' 		=> '_MI_ARTICLE_PRINT_LOGO',
								'description' 	=> '_MI_ARTICLE_PRINT_LOGO_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'txt',
								'default' 		=> ''
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_newsticker',
								'title' 		=> '_MI_ARTICLE_DISPLAY_NEWSTICKER',
								'description' 	=> '_MI_ARTICLE_DISPLAY_NEWSTICKER_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_demo_link',
								'title' 		=> '_MI_ARTICLE_NEED_DEMO',
								'description' 	=> '_MI_ARTICLE_NEED_DEMO_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_conclusion',
								'title' 		=> '_MI_ARTICLE_NEED_CONCLUSION',
								'description' 	=> '_MI_ARTICLE_NEED_CONCLUSION_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'article_rss_limit',
								'title' 		=> '_MI_ARTICLE_RSSLIMIT',
								'description' 	=> '_MI_ARTICLE_RSSLIMIT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// NOTIFICATIONS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion['hasNotification'] = 0;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'article_notify_iteminfo';

$i = 0;
$i++;
$modversion['notification']['category'][$i]['name'] = 'global';
$modversion['notification']['category'][$i]['title'] = _MI_ARTICLE_GLOBAL_NOTIFY;
$modversion['notification']['category'][$i]['description'] = _MI_ARTICLE_GLOBAL_NOTIFY_DSC;
$modversion['notification']['category'][$i]['item_name'] = '';
$modversion['notification']['category'][$i]['subscribe_from'] = array('index.php', 'singlearticle.php');
$i++;
$modversion['notification']['category'][$i]['name'] = 'category';
$modversion['notification']['category'][$i]['title'] = _MI_ARTICLE_CATEGORY_NOTIFY;
$modversion['notification']['category'][$i]['description'] = _MI_ARTICLE_CATEGORY_NOTIFY_DSC;
$modversion['notification']['category'][$i]['subscribe_from'] = array('index.php');
$modversion['notification']['category'][$i]['item_name'] = 'category_id';
$modversion['notification']['category'][$i]['allow_bookmark'] = 1;
$i++;
$modversion['notification']['category'][$i]['name'] = 'article';
$modversion['notification']['category'][$i]['title'] = _MI_ARTICLE_ARTICLE_NOTIFY;
$modversion['notification']['category'][$i]['description'] = _MI_ARTICLE_ARTICLE_NOTIFY_DSC;
$modversion['notification']['category'][$i]['subscribe_from'] = array('index.php', 'singlearticle.php');
$modversion['notification']['category'][$i]['item_name'] = 'article_id';
$modversion['notification']['category'][$i]['allow_bookmark'] = 1;

$i++;
$modversion['notification']['event'][$i]['name'] = 'new_category';
$modversion['notification']['event'][$i]['category'] = 'global';
$modversion['notification']['event'][$i]['title'] = _MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'global_category_published';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_SBJ;
$i++;
$modversion['notification']['event'][$i]['name'] = 'category_modified';
$modversion['notification']['event'][$i]['category'] = 'global';
$modversion['notification']['event'][$i]['admin_only'] = 1;
$modversion['notification']['event'][$i]['title'] = _MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_ARTICLE_GLOBAL_CATEGORYMODIFIED_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'global_category_modified';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_ARTICLE_GLOBAL_NEWCATEGORY_NOTIFY_SBJ;
$i++;
$modversion['notification']['event'][$i]['name'] = 'new_article';
$modversion['notification']['event'][$i]['category'] = 'global';
$modversion['notification']['event'][$i]['title'] = _MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'global_article_new';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_ARTICLE_GLOBAL_NEWARTICLE_NOTIFY_SBJ;
$i++;
$modversion['notification']['event'][$i]['name'] = 'new_article';
$modversion['notification']['event'][$i]['category'] = 'category';
$modversion['notification']['event'][$i]['title'] = _MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'category_article_new';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_ARTICLE_CATEGORY_NEWARTICLE_NOTIFY_SBJ;
$i++;
$modversion['notification']['event'][$i]['name'] = 'article_modified';
$modversion['notification']['event'][$i]['category'] = 'article';
$modversion['notification']['event'][$i]['title'] = _MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'article_modified';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_ARTICLE_ARTICLE_ARTICLEMODIFIED_NOTIFY_SBJ;
$i++;
$modversion['notification']['event'][$i]['name'] = 'article_modified';
$modversion['notification']['event'][$i]['category'] = 'category';
$modversion['notification']['event'][$i]['title'] = _MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'category_article_modified';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_ARTICLE_CATEGORY_ARTICLEMODIFIED_NOTIFY_SBJ;
$i++;
$modversion['notification']['event'][$i]['name'] = 'article_modified';
$modversion['notification']['event'][$i]['category'] = 'global';
$modversion['notification']['event'][$i]['title'] = _MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'global_article_modified';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_ARTICLE_GLOBAL_ARTICLEMODIFIED_NOTIFY_SBJ;