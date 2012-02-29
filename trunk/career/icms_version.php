<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * holding module configurations and informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Career
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		career
 *
 */


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion = array(
					'name'						=> _MI_CAREER_NAME,
					'version'					=> 1.0,
					'description'				=> _MI_CAREER_DSC,
					'author'					=> "QM-B &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';",
					'credits'					=> "",
					'help'						=> "",
					'license'					=> "GNU General Public License (GPL)",
					'official'					=> 1,
					'dirname'					=> basename( dirname( __FILE__ ) ),
					'modname'					=> "career",

					/**  Images information  */
					'iconsmall'					=> "images/career_icon_small.png",
					'iconbig'					=> "images/career_icon.png",
					'image'						=> "images/career_icon.png", /* for backward compatibility */

					/**  Development information */
					'status_version'			=> "1.0",
					'status'					=> "Final",
					'date'						=> "28.02.2012",
					'author_word'				=> "",
					'warning'					=> _CO_ICMS_WARNING_FINAL,

					/** Contributors */
					'developer_website_url' 	=> "http://code.google.com/p/amaryllis-modules/",
					'developer_website_name' 	=> "Amaryllis Modules",
					'developer_email' 			=> "qm-b@hotmail.de",
					
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
$modversion['object_items'][$i] = 'career';
$i++;
$modversion['object_items'][$i] = 'department';
$i++;
$modversion['object_items'][$i] = 'message';
$i++;
$modversion['object_items'][$i] = 'indexpage';

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
$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_index.html',
										'description'	=> _MI_CAREER_INDEX_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_career.html',
										'description'	=> _MI_CAREER_CAREER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_message.html',
										'description'	=> _MI_CAREER_MESSAGE_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_header.html',
										'description'	=> _MI_CAREER_HEADER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_footer.html',
										'description'	=> _MI_CAREER_FOOTER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_print.html',
										'description'	=> ''
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_admin.html',
										'description'	=> _MI_CAREER_ADMIN_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'career_requirements.html',
										'description'	=> _MI_CAREER_REQUIREMENTS_TPL
								);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent entries block
$i++;
$modversion['blocks'][$i]['file']			= 'career_recent_careers.php';
$modversion['blocks'][$i]['name']			= _MI_CAREER_BLOCK_RECENT_CAREERS;
$modversion['blocks'][$i]['description']	= _MI_CAREER_BLOCK_RECENT_CAREERS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_career_recent_careers_show';
$modversion['blocks'][$i]['edit_func']		= 'b_career_recent_careers_edit';
$modversion['blocks'][$i]['options']		= '10|0|career_title|ASC';
$modversion['blocks'][$i]['template']		= 'career_block_recent_careers.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
$i++;
$modversion['blocks'][$i]['file']			= 'career_recent_messages.php';
$modversion['blocks'][$i]['name']			= _MI_CAREER_BLOCK_RECENT_MESSAGES;
$modversion['blocks'][$i]['description']	= _MI_CAREER_BLOCK_RECENT_MESSAGES_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_career_recent_messages_show';
$modversion['blocks'][$i]['edit_func']		= 'b_career_recent_messages_edit';
$modversion['blocks'][$i]['options']		= '10|0|message_title|ASC';
$modversion['blocks'][$i]['template']		= 'career_block_recent_messages.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
$i++;
$modversion['blocks'][$i]['file']			= 'career_departments.php';
$modversion['blocks'][$i]['name']			= _MI_CAREER_BLOCK_DEPARTMENTS;
$modversion['blocks'][$i]['description']	= _MI_CAREER_BLOCK_DEPARTMENTS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_career_departments_show';
$modversion['blocks'][$i]['edit_func']		= 'b_career_departments_edit';
$modversion['blocks'][$i]['options']		= 'department_title|ASC';
$modversion['blocks'][$i]['template']		= 'career_block_departments.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// SEARCH //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


/** Search information */
$modversion['hasSearch'] = 1;
$modversion['search'] ['file'] = 'include/search.inc.php';
$modversion['search'] ['func'] = 'career_search';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'message.php';
$modversion['comments']['itemName'] = 'message_id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment.inc.php';
$modversion['comments']['callback']['approve'] = 'career_com_approve';
$modversion['comments']['callback']['update'] = 'career_com_update';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'career_dateformat',
								'title' 		=> '_MI_CAREER_DATE_FORMAT',
								'description' 	=> '_MI_CAREER_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'string',
								'default' 		=> 'j/n/Y'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_CAREER_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_CAREER_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'career_display_company',
								'title' 		=> '_MI_CAREER_DISPLAY_COMPANY',
								'description' 	=> '_MI_CAREER_DISPLAY_COMPANY_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'text',
								'default' 		=> ''
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'logo_upload_width',
								'title' 		=> '_MI_CAREER_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_CAREER_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '1024'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'logo_upload_height',
								'title' 		=> '_MI_CAREER_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_CAREER_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '768'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'logo_file_size',
								'title' 		=> '_MI_CAREER_IMAGE_FILE_SIZE',
								'description' 	=> '_MI_CAREER_IMAGE_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'career_file_size',
								'title' 		=> '_MI_CAREER_UPLOAD_FILE_SIZE',
								'description' 	=> '_MI_CAREER_UPLOAD_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'career_daysnew',
								'title' 		=> '_MI_CAREER_DAYSNEW',
								'description' 	=> '_MI_CAREER_DAYSNEW_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'career_daysupdated',
								'title' 		=> '_MI_CAREER_DAYSUPDATED',
								'description' 	=> '_MI_CAREER_DAYSUPDATED_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_rss',
								'title' 		=> '_MI_CAREER_USE_RSS',
								'description' 	=> '_MI_CAREER_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guest_apply',
								'title' 		=> '_MI_CAREER_GUEST_CAN_APPLY',
								'description' 	=> '_MI_CAREER_GUEST_CAN_APPLY_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'career_print_footer',
								'title' 		=> '_MI_CAREER_PRINT_FOOTER',
								'description' 	=> '_MI_CAREER_PRINT_FOOTER_DSC',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'txt',
								'default' 		=> ''
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'career_print_logo',
								'title' 		=> '_MI_CAREER_PRINT_LOGO',
								'description' 	=> '_MI_CAREER_PRINT_LOGO_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'txt',
								'default' 		=> ''
							);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// NOTIFICATIONS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'career_notify_iteminfo';

$i = 0;
$i++;
$modversion['notification']['category'][$i]['name'] = 'global';
$modversion['notification']['category'][$i]['title'] = _MI_CAREER_GLOBAL_NOTIFY;
$modversion['notification']['category'][$i]['description'] = _MI_CAREER_GLOBAL_NOTIFY_DSC;
$modversion['notification']['category'][$i]['item_name'] = '';
$modversion['notification']['category'][$i]['subscribe_from'] = array('index.php');
$i++;
$modversion['notification']['category'][$i]['name'] = 'career';
$modversion['notification']['category'][$i]['title'] = _MI_CAREER_CAREER_NOTIFY;
$modversion['notification']['category'][$i]['description'] = _MI_CAREER_CAREER_NOTIFY_DSC;
$modversion['notification']['category'][$i]['subscribe_from'] = array('index.php', 'career.php');
$modversion['notification']['category'][$i]['item_name'] = 'career_id';
$modversion['notification']['category'][$i]['allow_bookmark'] = 1;

$i++;
$modversion['notification']['event'][$i]['name'] = 'new_career';
$modversion['notification']['event'][$i]['category'] = 'global';
$modversion['notification']['event'][$i]['title'] = _MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'global_career_new';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_CAREER_GLOBAL_NEW_CAREER_NOTIFY_SBJ;
$i++;
$modversion['notification']['event'][$i]['name'] = 'career_modified';
$modversion['notification']['event'][$i]['category'] = 'career';
$modversion['notification']['event'][$i]['title'] = _MI_CAREER_CAREER_MODIFIED_NOTIFY;
$modversion['notification']['event'][$i]['caption'] = _MI_CAREER_CAREER_MODIFIED_NOTIFY_CAP;
$modversion['notification']['event'][$i]['description'] = _MI_CAREER_CAREER_MODIFIED_NOTIFY_DSC;
$modversion['notification']['event'][$i]['mail_template'] = 'career_modified';
$modversion['notification']['event'][$i]['mail_subject'] = _MI_CAREER_CAREER_MODIFIED_NOTIFY_SBJ;
