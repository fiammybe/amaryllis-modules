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
 * @author		QM-B <qm-b@hotmail.de>
 * @package		album
 * @version		$Id$
 *
 */


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**  General Information  */
$modversion = array(
						"name"						=> _MI_ALBUM_NAME,
						"version"					=> 1.3,
						"description"				=> _MI_ALBUM_DSC,
						"author"					=> "QM-B",
						"author_realname"			=> "Steffen Flohrer",
						"credits"					=> "<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Amaryllis Modules</a>",
						"help"						=> "admin/manual.php",
						"license"					=> "GNU General Public License (GPL)",
						"official"					=> 1,
						"dirname"					=> basename(dirname(__FILE__)),
						"modname"					=> "album",

					/**  Images information  */
						'iconsmall'					=> "images/album_icon_small.png",
						'iconbig'					=> "images/album_icon.png",
						'image'						=> "images/album_icon.png", /* for backward compatibility */

					/**  Development information */
						"status_version"			=> "1.3",
						"status"					=> "Beta",
						"date"						=> "01:46 05.02.2012",
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
						"onUninstall"				=> "include/onupdate.inc.php",

					/** Search information */
						"hasSearch"					=> 1,
						"search"					=> array("file" => "include/search.inc.php", "func" => "album_search"),

					/** Menu information */
						"hasMain"					=> 1,
						"mainpage"					=> "index.php",

					/** Notification and comment information */
						"hasNotification"			=> 1,
						"hasComments"				=> 1
				);

$modversion['people']['developers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>";
$modversion['people']['documenters'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1314]QM-B[/url]";
$modversion['people']['testers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=412]Claudia[/url]";
$modversion['people']['testers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=365]Thomas[/url]";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1295]Lotus[/url]";

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
$modversion['object_items'][$i] = 'album';
$i++;
$modversion['object_items'][$i] = 'images';
$i++;
$modversion['object_items'][$i] = 'message';
	$i++;
	$modversion['object_items'][$i] = 'indexpage';
$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// MAINMENU INFORMATION ///////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (is_object(icms::$module) && icms::$module->getVar('dirname') == $modversion['dirname']) {
	global $album_isAdmin;
	$album_handler = icms_getModuleHandler('album', $modversion['dirname'], 'album');
	$images_handler = icms_getModuleHandler('images', $modversion['dirname'], 'album');
	$i = 0;
	$imagesbyuser = $images_handler->filterUsers(FALSE);
	if($imagesbyuser !== "") {
		foreach ($imagesbyuser as $link => $value) {
			$i++;
			$modversion['sub'][$i]['name'] = _MD_ALBUM_GET_BY_PUBLISHER . " " . $value;
			$modversion['sub'][$i]['url'] = 'index.php?view=byPublisher&uid=' . $link;
		}
		unset($imagesbyuser, $images_handler);
	}
	if ($album_handler->userCanSubmit()) {
		$i++;
		$modversion['sub'][$i]['name'] = _MI_ALBUM_MENUMAIN_ADDALBUM;
		$modversion['sub'][$i]['url'] = 'index.php?view=modAlbum';
	}
	if($album_isAdmin) {
		$i++;
		$modversion['sub'][$i]['name'] = _MI_ALBUM_MENUMAIN_ADDIMAGES;
		$modversion['sub'][$i]['url'] = 'index.php?view=modImages';
	}
	unset($album_handler);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_index.html',
										'description'	=> _MI_ALBUM_INDEX_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_label.html',
										'description'	=> 'Albums and Images by label'
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_slabel.html',
										'description'	=> 'front-end label select'
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_header.html',
										'description'	=> _MI_ALBUM_HEADER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_footer.html',
										'description'	=> _MI_ALBUM_FOOTER_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_album.html',
										'description'	=> _MI_ALBUM_ALBUM_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_salbum.html',
										'description'	=> _MI_ALBUM_ALBUM_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_images.html',
										'description'	=> _MI_ALBUM_ALBUM_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_forms.html',
										'description'	=> _MI_ALBUM_FORMS_TPL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'album_admin.html',
										'description'	=> _MI_ALBUM_ADMIN_FORM_TPL
								);
$i++;
$modversion['templates'][$i] = array(
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
$modversion['blocks'][$i]['can_clone']		= TRUE;

// Recent images block
$i++;
$modversion['blocks'][$i]['file']			= 'album_recent_images.php';
$modversion['blocks'][$i]['name']			= _MI_ALBUM_BLOCK_RECENT_IMAGES;
$modversion['blocks'][$i]['description']	= _MI_ALBUM_BLOCK_RECENT_IMAGES_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_album_recent_images_show';
$modversion['blocks'][$i]['edit_func']		= 'b_album_recent_images_edit';
$modversion['blocks'][$i]['options']		= '10|0|0|weight|ASC|1|1|1';	//Limit|Album|Publisher|sort|order|width|height|horizontal|autoscroll|Description
$modversion['blocks'][$i]['template']		= 'album_block_recent_images.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;

// single image block
$i++;
$modversion['blocks'][$i]['file']			= 'album_single_image.php';
$modversion['blocks'][$i]['name']			= _MI_ALBUM_BLOCK_SINGLE_IMAGE;
$modversion['blocks'][$i]['description']	= _MI_ALBUM_BLOCK_SINGLE_IMAGE_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_album_single_image_show';
$modversion['blocks'][$i]['edit_func']		= 'b_album_single_image_edit';
$modversion['blocks'][$i]['options']		= '1|260|160|500|300|1|0'; //Image|Thumb width|Tuhumb height|Img Width|Image Height|Display DSC|Display Messages
$modversion['blocks'][$i]['template']		= 'album_block_single_image.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Comments
$modversion['comments']['pageName'] = 'index.php';
$modversion['comments']['itemName'] = 'album_id';
$modversion['comments']['extraParams'][] = 'album';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment.inc.php';
$modversion['comments']['callback']['approve'] = 'album_com_approve';
$modversion['comments']['callback']['update'] = 'album_com_update';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $icmsConfig;

$i=0;
$i++;
$modversion['config'][$i]['name']			= 'use_main';
$modversion['config'][$i]['title']			= '_MI_ALBUM_CONFIG_USE_MAIN';
$modversion['config'][$i]['description']	= '_MI_ALBUM_CONFIG_USE_MAIN_DSC';
$modversion['config'][$i]['formtype'] 		= 'yesno';
$modversion['config'][$i]['valuetype'] 		= 'int';
$modversion['config'][$i]['default'] 		= 0;
$i++;
$modversion['config'][$i]['name']			= 'use_rewrite';
$modversion['config'][$i]['title']			= '_MI_ALBUM_CONFIG_USE_REWRITE';
$modversion['config'][$i]['description']	= '_MI_ALBUM_CONFIG_USE_REWRITE_DSC';
$modversion['config'][$i]['formtype'] 		= 'hidden';
$modversion['config'][$i]['valuetype'] 		= 'int';
$modversion['config'][$i]['default'] 		= 0;
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'uploader_groups',
								'title'			=> '_MI_ALBUM_AUTHORIZED_UPLOADER',
								'description'	=> '_MI_ALBUM_AUTHORIZED_UPLOADER_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'album_needs_approval',
								'title' 		=> '_MI_ALBUM_NEEDS_APPROVAL',
								'description' 	=> '_MI_ALBUM_NEEDS_APPROVAL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_needs_approval',
								'title' 		=> '_MI_IMAGE_NEEDS_APPROVAL',
								'description' 	=> '_MI_IMAGE_NEEDS_APPROVAL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'album_show_upl_disclaimer',
								'title' 		=> '_MI_ALBUM_SHOWDISCLAIMER',
								'description' 	=> '_MI_ALBUM_SHOWDISCLAIMER_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'album_upl_disclaimer',
								'title' 		=> '_MI_ALBUM_DISCLAIMER',
								'description' 	=> '',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'text',
								'default' 		=> _MI_ALBUM_UPL_DISCLAIMER_TEXT
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'album_dateformat',
								'title' 		=> '_MI_ALBUM_DATE_FORMAT',
								'description' 	=> '_MI_ALBUM_DATE_FORMAT_DSC',
								'formtype' 		=> 'text',
								'valuetype' 	=> 'text',
								'default' 		=> 'j/n/Y'
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
								'default' 		=> 20
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_width',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_WIDTH',
								'description' 	=> '_MI_ALBUM_THUMBNAIL_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 110
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'thumbnail_height',
								'title' 		=> '_MI_ALBUM_THUMBNAIL_HEIGHT',
								'description'	=> '_MI_ALBUM_THUMBNAIL_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 150
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_width',
								'title' 		=> '_MI_ALBUM_IMAGE_UPLOAD_WIDTH',
								'description' 	=> '_MI_ALBUM_IMAGE_UPLOAD_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 1024
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_upload_height',
								'title' 		=> '_MI_ALBUM_IMAGE_UPLOAD_HEIGHT',
								'description'	=> '_MI_ALBUM_IMAGE_UPLOAD_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 768
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_display_width',
								'title' 		=> '_MI_ALBUM_IMAGE_DISPLAY_WIDTH',
								'description' 	=> '_MI_ALBUM_IMAGE_DISPLAY_WIDTH_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 500
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_display_height',
								'title' 		=> '_MI_ALBUM_IMAGE_DISPLAY_HEIGHT',
								'description'	=> '_MI_ALBUM_IMAGE_DISPLAY_HEIGHT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 300
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'image_file_size',
								'title' 		=> '_MI_ALBUM_IMAGE_FILE_SIZE',
								'description' 	=> '_MI_ALBUM_IMAGE_FILE_SIZE_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 2097152 // 2MB default max upload size
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'img_use_copyright',
								'title' 		=> '_MI_ALBUM_CONF_IMG_USE_COPYR',
								'description' 	=> '',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'img_default_copyright',
								'title' 		=> '_MI_ALBUM_CONF_IMG_DEFAULT_COPYR',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'text',
								'default' 		=> "&copy; ".date("Y")
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'img_allow_uploader_copyright',
								'title' 		=> '_MI_ALBUM_CONF_IMG_ALLOW_UPLOADER_COPYR',
								'description' 	=> '_MI_ALBUM_CONF_IMG_ALLOW_UPLOADER_COPYR_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'albums_popular',
								'title' 		=> '_MI_ALBUM_POPULAR',
								'description' 	=> '',
								'formtype' 		=> 'select',
								'valuetype' 	=> 'int',
								'options' 		=> array('0' => 0, '5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000),
								'default' 		=> 100
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'albums_daysnew',
								'title' 		=> '_MI_ALBUM_DAYSNEW',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'albums_daysupdated',
								'title' 		=> '_MI_ALBUM_DAYSUPDATED',
								'description' 	=> '',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_messages',
								'title' 		=> '_MI_ALBUM_USE_MESSAGES',
								'description' 	=> '_MI_ALBUM_USE_MESSAGES_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'message_needs_approval',
								'title' 		=> '_MI_ALBUM_MESSAGE_NEEDS_APPROVAL',
								'description' 	=> '_MI_ALBUM_MESSAGE_NEEDS_APPROVAL_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'need_image_links',
								'title' 		=> '_MI_ALBUM_NEED_IMAGE_LINKS',
								'description' 	=> '_MI_ALBUM_NEED_IMAGE_LINKS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  0
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'album_default_order',
								'title'			=> '_MI_ALBUM_CONFIG_DEFAULT_ORDER',
								'description'	=> '_MI_ALBUM_CONFIG_DEFAULT_ORDER_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=>"weight",
								'options'		=> array( _MI_ALBUM_CONF_DEFAULT_ORDER_WEIGHT => "weight",
													_MI_ALBUM_CONF_DEFAULT_ORDER_CREATIONDATE => "album_published_date",
													_MI_ALBUM_CONF_DEFAULT_ORDER_TITLE => "album_title" )
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'album_default_sort',
								'title'			=> '_MI_ALBUM_CONFIG_DEFAULT_SORT',
								'description'	=> '_MI_ALBUM_CONFIG_DEFAULT_SORT_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> "ASC",
								'options'		=> array( _ASCENDING => "ASC", _DESCENDING => "DESC")
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'img_default_order',
								'title'			=> '_MI_ALBUM_CONFIG_DEFAULT_ORDER_IMG',
								'description'	=> '_MI_ALBUM_CONFIG_DEFAULT_ORDER_IMG_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> "weight",
								'options'		=> array( _MI_ALBUM_CONF_DEFAULT_ORDER_WEIGHT => "weight",
													_MI_ALBUM_CONF_DEFAULT_ORDER_CREATIONDATE => "img_published_date",
													_MI_ALBUM_CONF_DEFAULT_ORDER_TITLE => "img_title" )
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'img_default_sort',
								'title'			=> '_MI_ALBUM_CONFIG_DEFAULT_SORT_IMG',
								'description'	=> '_MI_ALBUM_CONFIG_DEFAULT_SORT_IMG_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> "ASC",
								'options'		=> array( _ASCENDING => "ASC", _DESCENDING => "DESC")
							);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// NOTIFICATIONS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'album_notify_iteminfo';

$modversion['notification']['category'][] = array (
													'name'				=> 'global',
													'title'				=> _MI_ALBUM_GLOBAL_NOTIFY,
													'description'		=> _MI_ALBUM_GLOBAL_NOTIFY_DSC,
													'subscribe_from'	=> array('index.php')
												);
$modversion['notification']['event'][] = array(
													'name'				=> 'album_published',
													'category'			=> 'global',
													'title'				=> _MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY,
													'caption'			=> _MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY_CAP,
													'description'		=> _MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY_DSC,
													'mail_template'		=> 'global_album_published',
													'mail_subject'		=> _MI_ALBUM_GLOBAL_ALBUM_PUBLISHED_NOTIFY_SBJ
												);