<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * module informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion = array(
					'name'						=> _MI_GUESTBOOK_NAME,
					'version'					=> 1.0,
					'description'				=> _MI_GUESTBOOK_DSC,
					'author'					=> "QM-B &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';",
					'credits'					=> "",
					'help'						=> "admin/manual.php",
					'license'					=> "GNU General Public License (GPL)",
					'official'					=> 0,
					'dirname'					=> basename( dirname( __FILE__ ) ),
					'modname'					=> "guestbook",

					/**  Images information  */
					'iconsmall'					=> "images/guestbook_icon_small.png",
					'iconbig'					=> "images/guestbook.png",
					'image'						=> "images/guestbook.png", /* for backward compatibility */

					/**  Development information */
					'status_version'			=> "1.0",
					'status'					=> "beta",
					'date'						=> "Unreleased",
					'author_word'				=> "",
					'warning'					=> _CO_ICMS_WARNING_BETA,

					/** Contributors */
					'developer_website_url' 	=> "http://code.google.com/p/amaryllis-modules/",
					'developer_website_name' 	=> "Amaryllis Modules",
					'developer_email' 			=> "qm-b@hotmail.de",
					
					/* search information */
					'hasSearch'					=> 0,
					
					/* comments */
					'hasComments'				=> 0,
					
					/* notifications */
					'hasNotification'			=> 0,
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
$modversion['object_items'][$i] = 'guestbook';
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


$modversion['templates'][1] = array(
										'file'			=> 'guestbook_guestbook.html',
										'description'	=> _MI_GUESTBOOK_GUESTBOOK_TPL
								);
$modversion['templates'][2] = array(
										'file'			=> 'guestbook_admin.html',
										'description'	=> _MI_GUESTBOOK_ADMIN_TPL
								);
$modversion['templates'][3] = array(
										'file'			=> 'guestbook_requirements.html',
										'description'	=> _MI_GUESTBOOK_REQUIREMENTS_TPL
								);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;
/**
// Recent entries block
$i++;
$modversion['blocks'][$i]['file']			= 'guestbook_recent_entries.php';
$modversion['blocks'][$i]['name']			= _MI_GUESTBOOK_BLOCK_RECENT_ENTRIES;
$modversion['blocks'][$i]['description']	= _MI_GUESTBOOK_BLOCK_RECENT_ENTRIES_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_guestbook_recent_entries_show';
$modversion['blocks'][$i]['edit_func']		= 'b_guestbook_recent_entries_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'guestbook_block_recent_entries.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;
**/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guestbook_dateformat',
								'title' 		=> '_MI_GUESTBOOK_DATE_FORMAT',
								'description' 	=> '_MI_GUESTBOOK_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'string',
								'default' 		=> 'j/n/Y'
							);

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_GUESTBOOK_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_GUESTBOOK_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_entries',
								'title'			=> '_MI_GUESTBOOK_SHOW_ENTRIES',
								'description' 	=> '_MI_GUESTBOOK_SHOW_ENTRIES_DSC',
								'formtype' 		=> 'textbox',
								'valuetype'		=> 'int',
								'default' 		=> 15
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_moderation',
								'title' 		=> '_MI_GUESTBOOK_USE_MODERATION',
								'description' 	=> '_MI_GUESTBOOK_USE_MODERATION_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_avatar',
								'title' 		=> '_MI_GUESTBOOK_SHOW_AVATAR',
								'description' 	=> '_MI_GUESTBOOK_SHOW_AVATAR_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'needs_approval',
								'title' 		=> '_MI_GUESTBOOK_NEEDS_APPROVAL',
								'description' 	=> '_MI_GUESTBOOK_NEEDS_APPROVAL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'allow_imageupload',
								'title' 		=> '_MI_GUESTBOOK_ALLOW_IMAGEUPLOAD',
								'description' 	=> '_MI_GUESTBOOK_ALLOW_IMAGEUPLOAD_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_width',
								'title' 		=> '_MI_GUESTBOOK_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_GUESTBOOK_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '600'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_height',
								'title' 		=> '_MI_GUESTBOOK_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_GUESTBOOK_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '400'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_file_size',
								'title' 		=> '_MI_GUESTBOOK_IMAGE_FILE_SIZE',
								'description' 	=> '_MI_GUESTBOOK_IMAGE_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_GUESTBOOK_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_GUESTBOOK_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '110'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_GUESTBOOK_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_GUESTBOOK_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '150'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guest_entry',
								'title' 		=> '_MI_GUESTBOOK_GUEST_CAN_SUBMIT',
								'description' 	=> '_MI_GUESTBOOK_GUEST_CAN_SUBMIT_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_email',
								'title' 		=> '_MI_GUESTBOOK_SHOW_EMAIL',
								'description' 	=> '_MI_GUESTBOOK_SHOW_EMAIL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_email',
								'title' 		=> '_MI_GUESTBOOK_DISPLAY_EMAIL',
								'description' 	=> '_MI_GUESTBOOK_DISPLAY_EMAIL_DSC',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options'		=> array("_MI_GUESTBOOK_DISPLAY_MAIL_SPAMPROT" => 1, "_MI_GUESTBOOK_DISPLAY_MAIL_IMGPROT" => 2, "_MI_GUESTBOOK_DISPLAY_MAIL_SPAMPROT_BANNED" => 3, "_MI_GUESTBOOK_DISPLAY_MAIL_IMGPROT_BANNED" => 4),
								'default' 		=> 1
							);
