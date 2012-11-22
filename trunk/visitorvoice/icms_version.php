<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /icms_version.php
 * 
 * module informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion = array(
					'name'						=> _MI_VISITORVOICE_NAME,
					'version'					=> 1.1,
					'description'				=> _MI_VISITORVOICE_DSC,
					'author'					=> "QM-B &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';",
					'credits'					=> "",
					'help'						=> "admin/manual.php",
					'license'					=> "GNU General Public License (GPL)",
					'official'					=> 0,
					'dirname'					=> basename( dirname( __FILE__ ) ),
					'modname'					=> "visitorvoice",

					/**  Images information  */
					'iconsmall'					=> "images/icon_small.png",
					'iconbig'					=> "images/icon_big.png",
					'image'						=> "images/icon_big.png", /* for backward compatibility */

					/**  Development information */
					'status_version'			=> "1.1",
					'status'					=> "RC",
					'date'						=> "XX.XX.2012",
					'author_word'				=> "",
					'warning'					=> _CO_ICMS_WARNING_RC,

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
					/* update/install/uninstall */
					'onUpdate'					=> 'include/onupdate.inc.php',
					'onInstall'					=> 'include/onupdate.inc.php',
					'onUninstall'				=> 'include/onupdate.inc.php'
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
$modversion['object_items'][$i] = 'visitorvoice';
$i++;
$modversion['object_items'][$i] = 'indexpage';

$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'visitorvoice_visitorvoice.html',
										'description'	=> _MI_VISITORVOICE_VISITORVOICE_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'visitorvoice_singleentry.html',
										'description'	=> _MI_VISITORVOICE_VISITORVOICE_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'visitorvoice_admin.html',
										'description'	=> _MI_VISITORVOICE_ADMIN_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'visitorvoice_requirements.html',
										'description'	=> _MI_VISITORVOICE_REQUIREMENTS_TPL
								);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent entries block
$i++;
$modversion['blocks'][$i]['file']			= 'visitorvoice_recent_entries.php';
$modversion['blocks'][$i]['name']			= _MI_VISITORVOICE_BLOCK_RECENT_ENTRIES;
$modversion['blocks'][$i]['description']	= _MI_VISITORVOICE_BLOCK_RECENT_ENTRIES_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_visitorvoice_recent_entries_show';
$modversion['blocks'][$i]['edit_func']		= 'b_visitorvoice_recent_entries_edit';
$modversion['blocks'][$i]['options']		= '10|1';
$modversion['blocks'][$i]['template']		= 'visitorvoice_block_recent_entries.html';
$modversion['blocks'][$i]['can_clone']		= TRUE ;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'visitorvoice_dateformat',
								'title' 		=> '_MI_VISITORVOICE_DATE_FORMAT',
								'description' 	=> '_MI_VISITORVOICE_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'text',
								'default' 		=> 'j/n/Y'
							);

$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_VISITORVOICE_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_VISITORVOICE_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_entries',
								'title'			=> '_MI_VISITORVOICE_SHOW_ENTRIES',
								'description' 	=> '_MI_VISITORVOICE_SHOW_ENTRIES_DSC',
								'formtype' 		=> 'textbox',
								'valuetype'		=> 'int',
								'default' 		=> 15
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_moderation',
								'title' 		=> '_MI_VISITORVOICE_USE_MODERATION',
								'description' 	=> '_MI_VISITORVOICE_USE_MODERATION_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'can_moderate',
								'title' 		=> '_MI_VISITORVOICE_CAN_MODERATE',
								'description' 	=> '_MI_VISITORVOICE_CAN_MODERATE_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_avatar',
								'title' 		=> '_MI_VISITORVOICE_SHOW_AVATAR',
								'description' 	=> '_MI_VISITORVOICE_SHOW_AVATAR_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'avatar_dimensions',
								'title' 		=> '_MI_VISITORVOICE_AVATAR_DIMENSIONS',
								'description' 	=> '_MI_VISITORVOICE_AVATAR_DIMENSIONS_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '32'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'needs_approval',
								'title' 		=> '_MI_VISITORVOICE_NEEDS_APPROVAL',
								'description' 	=> '_MI_VISITORVOICE_NEEDS_APPROVAL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'allow_imageupload',
								'title' 		=> '_MI_VISITORVOICE_ALLOW_IMAGEUPLOAD',
								'description' 	=> '_MI_VISITORVOICE_ALLOW_IMAGEUPLOAD_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'can_upload',
								'title' 		=> '_MI_VISITORVOICE_CAN_UPLOAD',
								'description' 	=> '_MI_VISITORVOICE_CAN_UPLOAD_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_width',
								'title' 		=> '_MI_VISITORVOICE_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_VISITORVOICE_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '600'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_height',
								'title' 		=> '_MI_VISITORVOICE_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_VISITORVOICE_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '400'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_file_size',
								'title' 		=> '_MI_VISITORVOICE_IMAGE_FILE_SIZE',
								'description' 	=> '_MI_VISITORVOICE_IMAGE_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_VISITORVOICE_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_VISITORVOICE_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '110'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_VISITORVOICE_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_VISITORVOICE_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '150'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_width',
								'title' 		=> '_MI_VISITORVOICE_DISPLAY_WIDTH',
								'description' 	=> '_MI_VISITORVOICE_DISPLAY_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '850'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_height',
								'title' 		=> '_MI_VISITORVOICE_DISPLAY_HEIGHT',
								'description'	=> '_MI_VISITORVOICE_DISPLAY_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '750'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'guest_entry',
								'title' 		=> '_MI_VISITORVOICE_GUEST_CAN_SUBMIT',
								'description' 	=> '_MI_VISITORVOICE_GUEST_CAN_SUBMIT_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_email',
								'title' 		=> '_MI_VISITORVOICE_SHOW_EMAIL',
								'description' 	=> '_MI_VISITORVOICE_SHOW_EMAIL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 0
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_email',
								'title' 		=> '_MI_VISITORVOICE_DISPLAY_EMAIL',
								'description' 	=> '_MI_VISITORVOICE_DISPLAY_EMAIL_DSC',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options'		=> array("_MI_VISITORVOICE_DISPLAY_MAIL_SPAMPROT" => 1, "_MI_VISITORVOICE_DISPLAY_MAIL_IMGPROT" => 2, "_MI_VISITORVOICE_DISPLAY_MAIL_SPAMPROT_BANNED" => 3, "_MI_VISITORVOICE_DISPLAY_MAIL_IMGPROT_BANNED" => 4),
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_rss',
								'title' 		=> '_MI_VISITORVOICE_USE_RSS',
								'description' 	=> '_MI_VISITORVOICE_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'visitorvoice_rss_limit',
								'title' 		=> '_MI_VISITORVOICE_RSSLIMIT',
								'description' 	=> '_MI_VISITORVOICE_RSSLIMIT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);