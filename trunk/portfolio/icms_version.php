<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * holding module configurations and informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS_ROOT_PATH not defined");
 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**  General Information  */
$modversion = array(
                        "name"                      => _MI_PORTFOLIO_NAME,
                        "version"                   => 1.1,
                        "description"               => _MI_PORTFOLIO_DSC,
                        "author"                    => "QM-B",
                        "author_realname"           => "Steffen Flohrer",
                        "credits"                   => "<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Amaryllis Modules</a>",
                        "help"                      => "admin/manual.php",
                        "license"                   => "GNU General Public License (GPL)",
                        "official"                  => 1,
                        "dirname"                   => basename(dirname(__FILE__)),
                        "modname"                   => "portfolio",
                    
                    /**  Images information  */
                        "iconsmall"                 => "images/icon_small.png",
                        "iconbig"                   => "images/icon_big.png",
                        "image"                     => "images/icon_big.png", /* for backward compatibility */
                    
                    /**  Development information */
                        "status_version"            => "1.1",
                        "status"                    => "RC",
                        "date"                      => "00:00 XX.XX.2012",
                        "author_word"               => "",
                        "warning"                   => _CO_ICMS_WARNING_RC,
                    
                    /** Contributors */
                        "developer_website_url"     => "http://code.google.com/p/amaryllis-modules/",
                        "developer_website_name"    => "Amaryllis Modules",
                        "developer_email"           => "qm-b@hotmail.de",
                    
                    /** Administrative information */
                        "hasAdmin"                  => 1,
                        "adminindex"                => "admin/portfolio.php",
                        "adminmenu"                 => "admin/menu.php",
                    
                    /** Install and update informations */
                        "onInstall"                 => "include/onupdate.inc.php",
                        "onUpdate"                  => "include/onupdate.inc.php",
                        "onUninstall"               => "include/onupdate.inc.php",
                    
                    /** Search information */
                        "hasSearch"                 => 1,
                        "search"                    => array("file" => "include/search.inc.php", "func" => "portfolio_search"),
                    
                    /** Menu information */
                        "hasMain"                   => 1,
                    
                    /** Notification and comment information */
                        "hasNotification"           => 0,
                        "hasComments"               => 1
                );

$modversion['people']['developers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>";
$modversion['people']['testers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=462' target='_blank'>David</a>";
$modversion['people']['testers'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=243' target='_blank'>optimistdd</a>";

$modversion['people']['translators'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>";
$modversion['people']['translators'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=462' target='_blank'>David</a>";
$modversion['people']['translators'][] = "<a href='http://www.impresscms.de/userinfo.php?uid=243' target='_blank'>optimistdd</a>";

/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=forms' target='_blank'>English</a>";
$modversion['manual'][][] = "<a href='manual.php' target='_blank'>Manual</a>";
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
$modversion['object_items'][$i] = 'portfolio';
$i++;
$modversion['object_items'][$i] = 'category';
$i++;
$modversion['object_items'][$i] = 'contact';
$i++;
$modversion['object_items'][$i] = 'indexpage';

$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_index.html',
										'description'	=> _MI_PORTFOLIO_INDEX_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_category.html',
										'description'	=> _MI_PORTFOLIO_INDEX_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_portfolio.html',
										'description'	=> _MI_PORTFOLIO_PORTFOLIO_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_contact.html',
										'description'	=> _MI_PORTFOLIO_CONTACT_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_header.html',
										'description'	=> _MI_PORTFOLIO_HEADER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_footer.html',
										'description'	=> _MI_PORTFOLIO_FOOTER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_admin.html',
										'description'	=> _MI_PORTFOLIO_ADMIN_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_requirements.html',
										'description'	=> _MI_PORTFOLIO_REQUIREMENTS_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'portfolio_contactform.html',
										'description'	=> 'js for contact form'
								);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

$i++;
$modversion['blocks'][$i]['file']			= 'portfolio_recent_portfolios.php';
$modversion['blocks'][$i]['name']			= _MI_PORTFOLIO_BLOCK_RECENT_PORTFOLIOS;
$modversion['blocks'][$i]['description']	= _MI_PORTFOLIO_BLOCK_RECENT_PORTFOLIOS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_portfolio_recent_portfolios_show';
$modversion['blocks'][$i]['edit_func']		= 'b_portfolio_recent_portfolios_edit';
$modversion['blocks'][$i]['options']		= '10|0|portfolio_title|ASC';
$modversion['blocks'][$i]['template']		= 'portfolio_block_recent_portfolios.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
$i++;
$modversion['blocks'][$i]['file']			= 'portfolio_recent_contacts.php';
$modversion['blocks'][$i]['name']			= _MI_PORTFOLIO_BLOCK_RECENT_CONTACTS;
$modversion['blocks'][$i]['description']	= _MI_PORTFOLIO_BLOCK_RECENT_CONTACTS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_portfolio_recent_contacts_show';
$modversion['blocks'][$i]['edit_func']		= 'b_portfolio_recent_contacts_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'portfolio_block_recent_messages.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
$i++;
$modversion['blocks'][$i]['file']			= 'portfolio_categories.php';
$modversion['blocks'][$i]['name']			= _MI_PORTFOLIO_BLOCK_CATEGORIES;
$modversion['blocks'][$i]['description']	= _MI_PORTFOLIO_BLOCK_CATEGORIES_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_portfolio_categories_show';
$modversion['blocks'][$i]['edit_func']		= 'b_portfolio_categories_edit';
$modversion['blocks'][$i]['options']		= 'category_title|ASC';
$modversion['blocks'][$i]['template']		= 'portfolio_block_categories.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// portfolio spotlight block
$i++;
$modversion['blocks'][$i]['file']			= 'portfolio_spotlight.php';
$modversion['blocks'][$i]['name']			= _MI_PORTFOLIO_BLOCK_SPOTLIGHT;
$modversion['blocks'][$i]['description']	= _MI_PORTFOLIO_BLOCK_SPOTLIGHT_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_portfolio_spotlight_show';
$modversion['blocks'][$i]['edit_func']		= 'b_portfolio_spotlight_edit';
$modversion['blocks'][$i]['options']		= '10|0';
$modversion['blocks'][$i]['template']		= 'portfolio_block_portfolio_spotlight.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
// portfolio spotlight block
$i++;
$modversion['blocks'][$i]['file']			= 'portfolio_random_portfolios.php';
$modversion['blocks'][$i]['name']			= _MI_PORTFOLIO_BLOCK_RANDOM_PORTFOLIOS;
$modversion['blocks'][$i]['description']	= _MI_PORTFOLIO_BLOCK_RANDOM_PORTFOLIOS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_portfolio_random_portfolios_show';
$modversion['blocks'][$i]['edit_func']		= 'b_portfolio_random_portfolios_edit';
$modversion['blocks'][$i]['options']		= '10|0';
$modversion['blocks'][$i]['template']		= 'portfolio_block_random_portfolios.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Comments
$modversion['comments']['pageName'] = 'portfolio.php';
$modversion['comments']['itemName'] = 'portfolio_id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment.inc.php';
$modversion['comments']['callback']['approve'] = 'portfolio_com_approve';
$modversion['comments']['callback']['update'] = 'portfolio_com_update';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'portfolio_dateformat',
								'title' 		=> '_MI_PORTFOLIO_DATE_FORMAT',
								'description' 	=> '_MI_PORTFOLIO_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'text',
								'default' 		=> 'j/n/Y'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_PORTFOLIO_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_PORTFOLIO_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_PORTFOLIO_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_PORTFOLIO_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 280
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_PORTFOLIO_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_PORTFOLIO_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 160
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_width',
								'title' 		=> '_MI_PORTFOLIO_DISPLAY_WIDTH',
								'description' 	=> '_MI_PORTFOLIO_DISPLAY_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 600
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_height',
								'title' 		=> '_MI_PORTFOLIO_DISPLAY_HEIGHT',
								'description'	=> '_MI_PORTFOLIO_DISPLAY_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 550
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'logo_upload_width',
								'title' 		=> '_MI_PORTFOLIO_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_PORTFOLIO_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '1024'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'logo_upload_height',
								'title' 		=> '_MI_PORTFOLIO_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_PORTFOLIO_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '768'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'logo_file_size',
								'title' 		=> '_MI_PORTFOLIO_IMAGE_FILE_SIZE',
								'description' 	=> '_MI_PORTFOLIO_IMAGE_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_portfolio_columns',
								'title'			=> '_MI_PORTFOLIO_SHOW_PORTFOLIO_COLUMNS',
								'description' 	=> '_MI_PORTFOLIO_SHOW_PORTFOLIO_COLUMNS_DSC',
								'formtype' 		=> 'select',
								'valuetype'		=> 'int',
								'options'		=> array('-' => 0, '2' => 2, '3' => 3),
								'default' 		=> 2
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_portfolio_rows',
								'title'			=> '_MI_PORTFOLIO_SHOW_PORTFOLIO_ROWS',
								'description' 	=> '_MI_PORTFOLIO_SHOW_PORTFOLIO_ROWS_DSC',
								'formtype' 		=> 'select',
								'valuetype'		=> 'int',
								'options'		=> array('-' => 0, '2' => 2, '3' => 3),
								'default' 		=> 2
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_rss',
								'title' 		=> '_MI_PORTFOLIO_USE_RSS',
								'description' 	=> '_MI_PORTFOLIO_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_album',
								'title' 		=> '_MI_PORTFOLIO_USE_ALBUM',
								'description' 	=> '_MI_PORTFOLIO_USE_ALBUM_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guest_contact',
								'title' 		=> '_MI_PORTFOLIO_GUEST_CAN_CONTACT',
								'description' 	=> '_MI_PORTFOLIO_GUEST_CAN_CONTACT_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'display_twitter',
								'title'			=> '_MI_PORTFOLIO_DISPLAY_TWITTER',
								'description'	=> '_MI_PORTFOLIO_DISPLAY_TWITTER_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 0,
								'options'		=> array( _NONE => 0, _MI_PORTFOLIO_DEFAULT => 1, _MI_PORTFOLIO_HORIZONTAL => 2, _MI_PORTFOLIO_VERTICAL => 3 )
							);	
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'display_fblike',
								'title'			=> '_MI_PORTFOLIO_DISPLAY_FBLIKE',
								'description'	=> '_MI_PORTFOLIO_DISPLAY_FBLIKE_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 0,
								'options'		=> array( _NONE => 0, _MI_PORTFOLIO_HORIZONTAL => 1, _MI_PORTFOLIO_VERTICAL => 2 ) 
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'display_gplus',
								'title'			=> '_MI_PORTFOLIO_DISPLAY_GPLUS',
								'description'	=> '_MI_PORTFOLIO_DISPLAY_GPLUS_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 0,
								'options'		=> array( _NONE => 0, _MI_PORTFOLIO_DEFAULT => 1, _MI_PORTFOLIO_HORIZONTAL => 2, _MI_PORTFOLIO_VERTICAL => 3 ) 
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'default_startpage',
								'title'			=> '_MI_PORTFOLIO_DEFAULT_STARTPAGE',
								'description'	=> '_MI_PORTFOLIO_DEFAULT_STARTPAGE_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'int',
								'default'		=> 0,
								'options'		=> array( _MI_PORTFOLIO_DEFAULT_STARTPAGE_DEF => 0, _MI_PORTFOLIO_DEFAULT_STARTPAGE_CAT => 1) 
							);