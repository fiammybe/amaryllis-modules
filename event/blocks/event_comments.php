<?php
/**
 * 'Event' is an event/category module for ImpressCMS, which can display google calendars, too
 *
 * File: /blocks/event_list.php
 * 
 * Block holding the events for selected timezone
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Event
 * @since		1.2
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		event
 *
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");
if(!defined("EVENT_DIRNAME")) define("EVENT_DIRNAME", basename(dirname(dirname(__FILE__))));

function b_event_comments_show($options) {
	global $eventConfig, $xoTheme;
	include_once ICMS_MODULES_PATH.'/'.EVENT_DIRNAME.'/include/common.php';
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	$comment_handler = icms_getModuleHandler("comment", EVENT_DIRNAME, "event");
	
	$uid = (is_object(icms::$user)) ? icms::$user->getVar("uid") : 0;
	
	$block['recent_comments'] = implode(" ", $comment_handler->getComments(TRUE, FALSE, FALSE, FALSE, 0, $options[0], "comment_pdate", "DESC", FALSE, TRUE));
	$block['my_recent_comments'] = (is_object(icms::$user)) ? implode(" ", $comment_handler->getComments(TRUE, FALSE, FALSE, $uid, 0, $options[0], "comment_pdate", "DESC", FALSE, TRUE)) : FALSE;
	$block['admin_comments'] = (icms_userIsAdmin( EVENT_DIRNAME )) ? implode(" ", $comment_handler->getComments(FALSE, FALSE, FALSE, FALSE, 0, $options[0], "comment_pdate", "DESC", TRUE, TRUE)) : FALSE;
	$block['event_url'] = ICMS_MODULES_URL . "/" . EVENT_DIRNAME . "/" ;
	$block['isRTL'] = (defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? 'true' : 'false';
	
	$xoTheme->addStylesheet(ICMS_MODULES_URL . '/' . EVENT_DIRNAME . '/scripts/module_event_blocks.css');
	
	return $block;
}

function b_event_comments_edit($options) {
	global $eventConfig, $xoTheme;
	icms_loadCommonLanguageFile("event");
	$event_handler = icms_getModuleHandler("event", EVENT_DIRNAME, "event");
	
	$limit = new icms_form_elements_Text("", "options[0]", 10, 20, $options[0]);
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td>' . _MB_EVENT_LIMIT . '</td>';
	$form .= '<td>' . $limit->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}