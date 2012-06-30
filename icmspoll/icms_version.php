<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /icms_version.php
 * 
 * module informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Icmspoll
 * @since		2.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		icmspoll
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
						"name"						=> _MI_ICMSPOLL_MD_NAME,
						"version"					=> 2.0,
						"description"				=> _MI_ICMSPOLL_MD_DSC,
						"author"					=> "QM-B",
						"author_realname"			=> "Steffen Flohrer",
						"credits"					=> "<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Amaryllis Modules</a>",
						"help"						=> "admin/manual.php",
						"license"					=> "GNU General Public License (GPL)",
						"official"					=> 1,
						"dirname"					=> basename(dirname(__FILE__)),
						"modname"					=> "icmspoll",
					
					/**  Images information  */
						"iconsmall"					=> "images/icmspoll_icon_small.png",
						"iconbig"					=> "images/icmspoll_icon_big.png",
						"image"						=> "images/icmspoll_icon_big.png", /* for backward compatibility */
					
					/**  Development information */
						"status_version"			=> "2.0",
						"status"					=> "Beta",
						"date"						=> "XX.07.2012",
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
						"search"					=> array("file" => "include/search.inc.php", "func" => "icmspoll_search"),
					
					/** Menu information */
						"hasMain"					=> 1,
					
					/** Notification information */
						"hasNotification"			=> 1
				);

$modversion['people']['developers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1314]QM-B[/url]";
$modversion['people']['documenters'][] = "[url=http://community.impresscms.org/userinfo.php?uid=1314]QM-B[/url]";
$modversion['people']['testers'][] = "[url=http://community.impresscms.org/userinfo.php?uid=412]Claudia[/url]";
$modversion['people']['testers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=10' target='_blank'>Sato-San</a>";

/** Manual */
$moddir = basename(dirname(__FILE__));
$modversion['manual'][] = "<a href='" . ICMS_URL  . "/modules/" . $moddir . "/admin/manual.php' target='_self'>Module Manual</a>";

/**
 * 
 */
if (is_object(icms::$module) && icms::$module->getVar('dirname') == 'icmspoll') {
	global $icmspoll_isAdmin;
	$polls_handler = icms_getModuleHandler('polls', basename(dirname(__FILE__)), 'icmspoll');
	$i = 0;
	$i++;
	$modversion['sub'][$i]['name'] = _MI_ICMSPOLL_MENUMAIN_VIEWRESULTS;
	$modversion['sub'][$i]['url'] = 'results.php';
	if ($polls_handler->userCanSubmit()) {
		$i++;
		$modversion['sub'][$i]['name'] = _MI_ICMSPOLL_MENUMAIN_ADDPOLL;
		$modversion['sub'][$i]['url'] = 'polls.php?op=mod';
	}
	if($icmspoll_isAdmin) {
		$i++;
		$modversion['sub'][$i]['name'] = _MI_ICMSPOLL_MENUMAIN_VIEW_POLLS_TABLE;
		$modversion['sub'][$i]['url'] = 'polls.php';
		$i++;
		$modversion['sub'][$i]['name'] = _MI_ICMSPOLL_MENUMAIN_VIEW_OPTIONS_TABLE;
		$modversion['sub'][$i]['url'] = 'options.php';
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// SUPPORT //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['submit_bug'] = 'http://code.google.com/p/amaryllis-modules/issues/entry?template=Defect%20report%20from%20user';
$modversion['submit_feature'] = 'http://code.google.com/p/amaryllis-modules/issues/entry?template=Review%20request';
$modversion['support_site_url'] = 'http://community.impresscms.org/modules/newbb/viewforum.php?forum=9';
$modversion['support_site_name']= 'ImpressCMS Community Forum';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// DATABASE /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i= 0;
$i++;
$modversion['object_items'][$i] = 'polls';
$i++;
$modversion['object_items'][$i] = 'options';
$i++;
$modversion['object_items'][$i] = 'log';
$i++;
$modversion['object_items'][$i] = 'indexpage';

$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////// TEMPLATES /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i = 0;
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_index.html',
										'description'	=> _MI_ICMSPOLL_TPL_INDEX
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_header.html',
										'description'	=> _MI_ICMSPOLL_TPL_HEADER
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_footer.html',
										'description'	=> _MI_ICMSPOLL_TPL_FOOTER
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_polls.html',
										'description'	=> _MI_ICMSPOLL_TPL_POLLS
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_singlepoll.html',
										'description'	=> _MI_ICMSPOLL_TPL_SINGLEPOLL
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_results.html',
										'description'	=> _MI_ICMSPOLL_TPL_RESULTS
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_print.html',
										'description'	=> _MI_ICMSPOLL_TPL_PRINT
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_forms.html',
										'description'	=> _MI_ICMSPOLL_TPL_FORMS
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_admin.html',
										'description'	=> _MI_ICMSPOLL_TPL_ADMIN_FORM
								);
$i++;
$modversion['templates'][$i] = array(
										'file'			=> 'icmspoll_requirements.html',
										'description'	=> _MI_ICMSPOLL_TPL_REQUIREMENTS
								);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////// BLOCKS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;

// Recent polls block
$i++;
$modversion['blocks'][$i]['file']			= 'icmspoll_recent_polls.php';
$modversion['blocks'][$i]['name']			= _MI_ICMSPOLL_BLOCK_RECENT_POLLS;
$modversion['blocks'][$i]['description']	= _MI_ICMSPOLL_BLOCK_RECENT_POLLS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_icmspoll_recent_polls_show';
$modversion['blocks'][$i]['edit_func']		= 'b_icmspoll_recent_polls_edit';
$modversion['blocks'][$i]['options']		= '10|0|0|weight|ASC'; // Limit|uid|expired|sort|order|
$modversion['blocks'][$i]['template']		= 'icmspoll_block_recent_polls.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;

// Single Poll block
$i++;
$modversion['blocks'][$i]['file']			= 'icmspoll_single_poll.php';
$modversion['blocks'][$i]['name']			= _MI_ICMSPOLL_BLOCK_SINGLE_POLL;
$modversion['blocks'][$i]['description']	= _MI_ICMSPOLL_BLOCK_SINGLE_POLL_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_icmspoll_single_poll_show';
$modversion['blocks'][$i]['edit_func']		= 'b_icmspoll_single_poll_edit';
$modversion['blocks'][$i]['options']		= '1';
$modversion['blocks'][$i]['template']		= 'icmspoll_block_single_poll.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;
// Recent results block
$i++;
$modversion['blocks'][$i]['file']			= 'icmspoll_recent_results.php';
$modversion['blocks'][$i]['name']			= _MI_ICMSPOLL_BLOCK_RECENT_RESULTS;
$modversion['blocks'][$i]['description']	= _MI_ICMSPOLL_BLOCK_RECENT_RESULTS_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_icmspoll_recent_results_show';
$modversion['blocks'][$i]['edit_func']		= 'b_icmspoll_recent_results_edit';
$modversion['blocks'][$i]['options']		= '10|0|ASC|weight'; // Limit|uid|sort|order|
$modversion['blocks'][$i]['template']		= 'icmspoll_block_recent_results.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;
// Single result block
$i++;
$modversion['blocks'][$i]['file']			= 'icmspoll_single_result.php';
$modversion['blocks'][$i]['name']			= _MI_ICMSPOLL_BLOCK_SINGLE_RESULT;
$modversion['blocks'][$i]['description']	= _MI_ICMSPOLL_BLOCK_SINGLE_RESULT_DSC;
$modversion['blocks'][$i]['show_func']		= 'b_icmspoll_single_result_show';
$modversion['blocks'][$i]['edit_func']		= 'b_icmspoll_single_result_edit';
$modversion['blocks'][$i]['options']		= '1';
$modversion['blocks'][$i]['template']		= 'icmspoll_block_single_result.html';
$modversion['blocks'][$i]['can_clone']		= TRUE;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// CONFIGS //////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$i=0;
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'uploader_groups',
								'title'			=> '_MI_ICMSPOLL_AUTHORIZED_CREATOR',
								'description'	=> '_MI_ICMSPOLL_AUTHORIZED_CREATOR_DSC',
								'formtype'		=> 'group_multi',
								'valuetype'		=> 'array',
								'default'		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'icmspoll_dateformat',
								'title' 		=> '_MI_ICMSPOLL_CONFIG_DATE_FORMAT',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_DATE_FORMAT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'string',
								'default' 		=> 'd/m/Y H:i:s'
							);

$i++;
$modversion['config'][$i] = array(
								'name'      	=> "limit_by_ip",
								'title'     	=> '_MI_ICMSPOLL_CONFIG_LIMITBYIP',
								'description'	=> '_MI_ICMSPOLL_CONFIG_LIMITBYIP_DSC',
								'formtype'		=> 'yesno',
								'valuetype'		=> 'int',
								'default'   	=> '1'
							);
$i++;
$modversion['config'][$i] = array(
								'name'      	=> "limit_by_uid",
								'title'     	=> '_MI_ICMSPOLL_CONFIG_LIMITBYUID',
								'description'	=> '_MI_ICMSPOLL_CONFIG_LIMITBYUID_DSC',
								'formtype'   	=> 'yesno',
								'valuetype'   	=> 'int',
								'default'   	=> '0'
							);
$i++;
$modversion['config'][$i] = array(
								'name'      	=> "limit_by_session",
								'title'     	=> '_MI_ICMSPOLL_CONFIG_LIMITBYSESSION',
								'description'	=> '_MI_ICMSPOLL_CONFIG_LIMITBYSESSION_DSC',
								'formtype'   	=> 'yesno',
								'valuetype'   	=> 'int',
								'default'   	=> '0'
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'show_breadcrumbs',
								'title' 		=> '_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_SHOW_BREADCRUMBS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=>  1
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'show_polls',
								'title'			=> '_MI_ICMSPOLL_CONFIG_SHOW_POLLS',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_SHOW_POLLS_DSC',
								'formtype' 		=> 'textbox',
								'valuetype'		=> 'int',
								'default' 		=> 15
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'polls_default_order',
								'title'			=> '_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER',
								'description'	=> '_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 1,
								'options'		=> array( _MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_WEIGHT => "weight", 
													_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_CREATIONDATE => "created_on",
													_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_STARTDATE => "start_time",
													_MI_ICMSPOLL_CONFIG_DEFAULT_ORDER_ENDDATE => "end_time" )
							);
$i++;
$modversion['config'][$i] = array(
								'name'			=> 'polls_default_sort',
								'title'			=> '_MI_ICMSPOLL_CONFIG_DEFAULT_SORT',
								'description'	=> '_MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DSC',
								'formtype'		=> 'select',
								'valuetype'		=> 'text',
								'default'		=> 1,
								'options'		=> array( _MI_ICMSPOLL_CONFIG_DEFAULT_SORT_ASC => "ASC", _MI_ICMSPOLL_CONFIG_DEFAULT_SORT_DESC => "DESC")
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'allow_init_value',
								'title' 		=> '_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_ALLOW_INIT_VALUE_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'icmspoll_print_footer',
								'title' 		=> '_MI_ICMSPOLL_CONFIG_PRINT_FOOTER',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_PRINT_FOOTER_DSC',
								'formtype' 		=> 'textarea',
								'valuetype' 	=> 'txt',
								'default' 		=> ''
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'icmspoll_print_logo',
								'title' 		=> '_MI_ICMSPOLL_CONFIG_PRINT_LOGO',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_PRINT_LOGO_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'txt',
								'default' 		=> ''
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'use_rss',
								'title' 		=> '_MI_ICMSPOLL_CONFIG_USE_RSS',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_USE_RSS_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'rss_limit',
								'title' 		=> '_MI_ICMSPOLL_CONFIG_RSS_LIMIT',
								'description' 	=> '_MI_ICMSPOLL_CONFIG_RSS_LIMIT_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 10
							);



//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'results.php';
$modversion['comments']['itemName'] = 'poll_id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comments.inc.php';
$modversion['comments']['callback']['approve'] = 'icmspoll_com_approve';
$modversion['comments']['callback']['update'] = 'icmspoll_com_update';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// NOTIFICATIONS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'icmspoll_notify_iteminfo';

$modversion['notification']['category'][] = array (
													'name'				=> 'global',
													'title'				=> _MI_ICMSPOLL_GLOBAL_NOTIFY,
													'description'		=> _MI_ICMSPOLL_GLOBAL_NOTIFY_DSC,
													'subscribe_from'	=> array('index.php')
												);
$modversion['notification']['event'][] = array(
													'name'				=> 'poll_published',
													'category'			=> 'global',
													'title'				=> _MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY,
													'caption'			=> _MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_CAP,
													'description'		=> _MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_DSC,
													'mail_template'		=> 'global_poll_published',
													'mail_subject'		=> _MI_ICMSPOLL_GLOBAL_POLL_PUBLISHED_NOTIFY_SBJ
												);