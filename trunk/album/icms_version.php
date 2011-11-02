<?php
/**
 * 'Album' is a light weight gallery module
 * 
 * File: /icms_version.php
 * 
 * module informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * --------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.00
 * @author		QM-B
 * @package		album
 * @version		$Id$
 * 
 */


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion = array(
					'name'						=> _MI_ALBUM_NAME,
					'version'					=> 1.0,
					'description'				=> _MI_ALBUM_DSC,
					'author'					=> "QM-B &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';",
					'credits'					=> "",
					'help'						=> "",
					'license'					=> "GNU General Public License (GPL)",
					'official'					=> 0,
					'dirname'					=> basename( dirname( __FILE__ ) ),
					'modname'					=> "album",

					/**  Images information  */
					'iconsmall'					=> "images/album_icon_small.png",
					'iconbig'					=> "images/album_icon.png",
					'image'						=> "images/album_icon.png", /* for backward compatibility */

					/**  Development information */
					'status_version'			=> "1.0",
					'status'					=> "beta",
					'date'						=> "Unreleased",
					'author_word'				=> "",
					'warning'					=> _CO_ICMS_WARNING_BETA,

					/** Contributors */
					'developer_website_url' 	=> "http://code.google.com/p/amaryllis-modules/",
					'developer_website_name' 	=> "Amaryllis Modules",
					'developer_email' 			=> "qm-b@hotmail.de");

$modversion['people']['developers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>';";


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// ADMINISTRATIVE INFORMATION ////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['hasMain'] 		= 1;
$modversion['hasAdmin'] 	= 1;
$modversion['adminindex']	= 'admin/album.php';
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
$modversion['object_items'][$i] = 'album';
$i++;
$modversion['object_items'][$i] = 'images';
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
										'file'			=> 'album_index.html',
										'description'	=> _MI_ALBUM_INDEX_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'album_header.html',
										'description'	=> _MI_ALBUM_HEADER_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'album_footer.html',
										'description'	=> _MI_ALBUM_FOOTER_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'album_album.html',
										'description'	=> _MI_ALBUM_ALBUM_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'album_admin_album.html',
										'description'	=> _MI_ALBUM_ADMIN_FORM_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'album_admin_images.html',
										'description'	=> _MI_ALBUM_ADMIN_FORM_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'album_admin_indexpage.html',
										'description'	=> _MI_ALBUM_ADMIN_FORM_TPL
								);
$modversion['templates'][] = array(
										'file'			=> 'album_requirements.html',
										'description'	=> _AM_ALBUM_REQUIREMENTS_TPL
								);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent albums block
$i++;
$modversion['blocks'][$i]['file']			= 'album_recent_albums.php';
$modversion['blocks'][$i]['name']			= _MI_ALBUM_BLOCK_RECENT_ALBUMS;
$modversion['blocks'][$i]['description']	= _MI_ALBUM_BLOCK_RECENT_ALBUMS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_album_album_recent_show';
$modversion['blocks'][$i]['edit_func']		= 'b_album_album_recent_edit';
$modversion['blocks'][$i]['options']		= '10';
$modversion['blocks'][$i]['template']		= 'album_block_recent_albums.html';
$modversion['blocks'][$i]['can_clone']		= true ;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// SEARCH //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


/** Search information */
$modversion['hasSearch'] = 0;
//$modversion['search'] ['file'] = 'include/search.inc.php';
//$modversion['search'] ['func'] = 'album_search';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Comments
$modversion['hasComments'] = 0;
$modversion['comments']['pageName'] = 'album.php';
$modversion['comments']['itemName'] = 'album_id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'album_com_approve';
$modversion['comments']['callback']['update'] = 'album_com_update';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'uploader_groups',
								'title'			=> '_MI_ALBUM_AUTHORIZED_UPLOADER',
								'description'	=> '_MI_ALBUM_AUTHORIZED_UPLOADER_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> '1'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_ALBUM_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_ALBUM_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_albums',
								'title'			=> '_MI_ALBUM_SHOW_ALBUMS',
								'description' 	=> '_MI_ALBUM_SHOW_ALBUMS_DSC',
								'formtype' 		=> 'textbox',
								'valuetype'		=> 'text',
								'default' 		=> 15
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_images',
								'title' 		=> '_MI_ALBUM_SHOW_IMAGES',
								'description'	=> '_MI_ALBUM_SHOW_IMAGES_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '20'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_images_per_row',
								'title' 		=> '_MI_ALBUM_SHOW_IMAGES_ROW',
								'description' 	=> '_MI_ALBUM_SHOW_IMAGES_ROW_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=>  '4'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_ALBUM_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '110'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_ALBUM_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '150'
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'thumbnail_margin_top',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_MARGIN_TOP',
								'description' 	=> '_MI_ALBUM_THUMBNAIL_MARGIN_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '10'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_margin_right',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_MARGIN_RIGHT',
								'description' 	=> '_MI_ALBUM_THUMBNAIL_MARGIN_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '15'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_margin_bottom',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_MARGIN_BOTTOM',
								'description'	=> '_MI_ALBUM_THUMBNAIL_MARGIN_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '10'
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'thumbnail_margin_left',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_MARGIN_LEFT',
								'description'	=> '_MI_ALBUM_THUMBNAIL_MARGIN_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '15'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_width',
								'title' 		=> '_MI_ALBUM_IMAGE_WIDTH',
								'description' 	=> '_MI_ALBUM_IMAGE_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '1024'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_height',
								'title' 		=> '_MI_ALBUM_IMAGE_HEIGHT',
								'description' 	=> '_MI_ALBUM_IMAGE_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '768'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_width',
								'title' 		=> '_MI_ALBUM_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_ALBUM_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '1024'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_height',
								'title' 		=> '_MI_ALBUM_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_ALBUM_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '768'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_file_size',
								'title' 		=> '_MI_ALBUM_IMAGE_FILE_SIZE',
								'description' 	=> '_MI_ALBUM_IMAGE_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> '2097152' // 2MB default max upload size
							);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// NOTIFICATIONS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


$modversion['hasNotification'] = 0;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'album_notify_iteminfo';
/**
$modversion['notification']['category'][1] = array(
													'name'				=> 'global',
													'title'				=> _MI_ALBUM_GLOBAL_NOTIFY,
													'description'		=> '',
													'subscribe_from'	=> array('index.php')
												);
$modversion['notification']['category'][] = array(
													'name'				=> 'album',
													'title'				=> _MI_ALBUM_ALBUM_NOTIFY,
													'item_name'			=> 'album',
													'description'		=> '',
													'subscribe_from'	=> array('index.php')
												);
$modversion['notification']['category'][] = array(
													'name'				=> 'picture',
													'title'				=> _MI_ALBUM_PICTURE_NOTIFY,
													'description'		=> '',
													'item_name'			=> 'id',
													'subscribe_from'	=> array('album.php')
												);
$modversion['notification']['event'][1] = array(
													'name'				=> 'new',
													'category'			=> 'global',
													'admin_only'		=> 1,
													'title'				=> _MI_ALBUM_NEWPOST_NOTIFY,
													'caption'			=> _MI_ALBUM_NEWPOST_NOTIFY_CAP,
													'description'		=> '',
													'mail_template'		=> 'notify',
													'mail_subject'		=> _MI_ALBUM_NEWPOST_SUBJECT
												);
$modversion['notification']['event'][] = array(
													'name'				=> 'new',
													'category'			=> 'ALBUM',
													'title'				=> _MI_ALBUM_NEWPOST_NOTIFY,
													'caption'			=> _MI_ALBUM_NEWPOST_NOTIFY_CAP,
													'description'		=> '',
													'mail_template'		=> 'notify',
													'mail_subject'		=> _MI_ALBUM_NEWPOST_SUBJECT
											);
$modversion['notification']['event'][] = array(
													'name'				=> 'PICTURE',
													'category'			=> 'picture',
													'title'				=> _MI_ALBUM_STATUS_NOTIFY,
													'caption'			=> _MI_ALBUM_STATUS_NOTIFY_CAP,
													'description'		=> '',
													'mail_template'		=> 'picture_notify',
													'mail_subject'		=> _MI_ALBUM_STATUS_SUBJECT
											);
**/