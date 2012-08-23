<?php
/**
 * 'Event' is an event/event module for ImpressCMS, which can display google events, too
 *
 * File: /icms_version.php
 * 
 * holds the module informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// GENERAL INFORMATION ////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**  General Information  */
$modversion = array(
                        "name"                      => _MI_EVENT_MD_NAME,
                        "version"                   => 1.0,
                        "description"               => _MI_EVENT_MD_DESC,
                        "author"                    => "QM-B",
                        "author_realname"           => "Steffen Flohrer",
                        "credits"                   => "<a href='http://code.google.com/p/amaryllis-modules/' title='Amaryllis Modules'>Amaryllis Modules</a>",
                        "help"                      => "admin/manual.php",
                        "license"                   => "GNU General Public License (GPL)",
                        "official"                  => 0,
                        "dirname"                   => basename(dirname(__FILE__)),
                        "modname"                   => "event",
                    
                    /**  Images information  */
                        "iconsmall"                 => "images/icon_small.png",
                        "iconbig"                   => "images/icon_big.png",
                        "image"                     => "images/icon_big.png", /* for backward compatibility */
                    
                    /**  Development information */
                        "status_version"            => "1.0",
                        "status"                    => "Beta",
                        "date"                      => "00:00 XX.XX.2012",
                        "author_word"               => "",
                        "warning"                   => _CO_ICMS_WARNING_BETA,
                    
                    /** Contributors */
                        "developer_website_url"     => "http://code.google.com/p/amaryllis-modules/",
                        "developer_website_name"    => "Amaryllis Modules",
                        "developer_email"           => "qm-b@hotmail.de",
                    
                    /** Administrative information */
                        "hasAdmin"                  => 1,
                        "adminindex"                => "admin/index.php",
                        "adminmenu"                 => "admin/menu.php",
                    
                    /** Install and update informations */
                        "onInstall"                 => "include/onupdate.inc.php",
                        "onUpdate"                  => "include/onupdate.inc.php",
                        "onUninstall"               => "include/onupdate.inc.php",
                    
                    /** Search information */
                        "hasSearch"                 => 0,
                        "search"                    => array("file" => "include/search.inc.php", "func" => "event_search"),
                    
                    /** Menu information */
                        "hasMain"                   => 1,
                    
                    /** Notification and comment information */
                        "hasNotification"           => 1,
                        "hasComments"               => 1
                );

$modversion['people']['developers'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a> &nbsp;&nbsp;<span style='font-size: smaller;'>( qm-b [at] hotmail [dot] de )</span>";
$modversion['people']['documenters'][] = "<a href='http://community.impresscms.org/userinfo.php?uid=1314' target='_blank'>QM-B</a>";

/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=event' target='_blank'>English</a>";
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
$modversion['object_items'][$i] = 'category';
$i++;
$modversion['object_items'][$i] = 'event';
$i++;
$modversion['object_items'][$i] = 'calendar';

$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

/** Templates information */
$modversion['templates'] = array(
	array("file" => "event_admin.html", "description" => "event Admin view"),
	array("file" => "event_admin.html", "description" => "event Admin forms"),
	array("file" => "event_event.html", "description" => "event single event"),
	array("file" => "event_index.html", "description" => "event index"),
    array("file" => "event_calconf.html", "description" => "js configuration for calendar"),
	array('file' => 'event_header.html', 'description' => 'Module Header'),
	array('file' => 'event_footer.html', 'description' => 'Module Footer'),
    array("file" => "event_requirements.html", "description" => "event requirements")
	);
	

/** Blocks information */
/** To come soon in imBuilding... */

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// COMMENTS /////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Comments
$modversion['comments']['pageName'] = 'event.php';
$modversion['comments']['itemName'] = 'event_id';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment.inc.php';
$modversion['comments']['callback']['approve'] = 'event_com_approve';
$modversion['comments']['callback']['update'] = 'event_com_update';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// CONFIGURATION ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
icms_loadLanguageFile("event", "common");
$i = 0;
$i++;
$modversion['config'][$i] = array(
                                'name'          => 'default_view',
                                'title'         => '_MI_EVENT_CONFIG_DEFAULT_VIEW',
                                'description'   => '_MI_EVENT_CONFIG_DEFAULT_VIEW_DSC',
                                'formtype'      => 'select',
                                'valuetype'     => 'text',
                                'default'       => 'month',
                                'options'       => array( _CO_EVENT_MONTH => "month", _CO_EVENT_WEEK => "agendaWeek", _CO_EVENT_DAY => "agendaDay")
                            );
$i++;
$modversion['config'][$i] = array(
                                'name'          => 'first_day',
                                'title'         => '_MI_EVENT_CONFIG_FIRST_DAY',
                                'description'   => '_MI_EVENT_CONFIG_FIRST_DAY_DSC',
                                'formtype'      => 'select',
                                'valuetype'     => 'int',
                                'default'       => 1,
                                'options'       => array( _CO_EVENT_MONDAY => 1, _CO_EVENT_SUNDAY => 0)
                            );
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'display_weekend',
								'title' 		=> '_MI_EVENT_CONFIG_DISPLAY_WEEKEND',
								'description' 	=> '_MI_EVENT_CONFIG_DISPLAY_WEEKEND_DSC',
								'formtype' 		=> 'yesno',
								'valuetype' 	=> 'int',
								'default' 		=> 1
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'agenda_start',
								'title' 		=> '_MI_EVENT_CONFIG_AGENDA_START',
								'description'	=> '_MI_EVENT_CONFIG_AGENDA_START_DSC',
								'formtype'      => 'select',
                                'valuetype'     => 'int',
                                'default'       => 6,
                                'options'       => array( "0" => 0, "1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "11" => 11, "12" => 12,
															"13" => 13, "14" => 14, "15" => 15, "16" => 16, "17" => 17, "18" => 18, "19" => 19, "20" => 20, "21" => 21, "22" => 22, "23" => 23)
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'agenda_min',
								'title' 		=> '_MI_EVENT_CONFIG_AGENDA_MIN',
								'description'	=> '_MI_EVENT_CONFIG_AGENDA_MIN_DSC',
								'formtype'      => 'select',
                                'valuetype'     => 'int',
                                'default'       => 0,
                                'options'       => array( "0" => 0, "1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "11" => 11, "12" => 12,
															"13" => 13, "14" => 14, "15" => 15, "16" => 16, "17" => 17, "18" => 18, "19" => 19, "20" => 20, "21" => 21, "22" => 22, "23" => 23)
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'agenda_max',
								'title' 		=> '_MI_EVENT_CONFIG_AGENDA_MAX',
								'description'	=> '_MI_EVENT_CONFIG_AGENDA_MAX_DSC',
								'formtype'      => 'select',
                                'valuetype'     => 'int',
                                'default'       => 24,
                                'options'       => array("1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "10" => 10, "11" => 11, "12" => 12,"13" => 13,
														"14" => 14, "15" => 15, "16" => 16, "17" => 17, "18" => 18, "19" => 19, "20" => 20, "21" => 21, "22" => 22, "23" => 23, "24" => 24)
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'agenda_slot',
								'title' 		=> '_MI_EVENT_CONFIG_AGENDA_SLOT',
								'description'	=> '_MI_EVENT_CONFIG_AGENDA_SLOT_DSC',
								'formtype'      => 'select',
                                'valuetype'     => 'int',
                                'default'       => 30,
                                'options'       => array( "10" => 10, "15" => 15, "20" => 20, "30" => 30, "60" => 60 )
							);
$i++;
$modversion['config'][$i] = array(
								'name' 			=> 'event_minutes',
								'title' 		=> '_MI_EVENT_CONFIG_EVENT_MINUTES',
								'description'	=> '_MI_EVENT_CONFIG_EVENT_MINUTES_DSC',
								'formtype' 		=> 'textbox',
								'valuetype' 	=> 'int',
								'default' 		=> 120
							);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////// NOTIFICATIONS ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'event_notify_iteminfo';

$modversion['notification']['category'][] = array (
													'name'				=> 'global',
													'title'				=> _MI_EVENT_GLOBAL_NOTIFY,
													'description'		=> _MI_EVENT_GLOBAL_NOTIFY_DSC,
													'subscribe_from'	=> array('index.php')
												);
$modversion['notification']['event'][] = array(
													'name'				=> 'event_published',
													'category'			=> 'global',
													'title'				=> _MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY,
													'caption'			=> _MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_CAP,
													'description'		=> _MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_DSC,
													'mail_template'		=> 'global_event_published',
													'mail_subject'		=> _MI_EVENT_GLOBAL_EVENT_PUBLISHED_NOTIFY_SBJ
												);