<?php
/**
 * 'Career' is an career management module for ImpressCMS
 *
 * File: /blocks/career_recent_messages.php
 * 
 * block to display recent messages
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

defined('ICMS_ROOT_PATH') or die('ICMS root path not defined');

function b_career_recent_messages_show($options) {
	global $careerConfig;
	
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$groups = is_object(icms::$user) ? icms::$user->getGroups() : array(ICMS_GROUP_ANONYMOUS);
	$uid = is_object(icms::$user) ? icms::$user->getVar('uid') : 0;
	$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
	$career_message_handler = icms_getModuleHandler("message", basename(dirname(dirname(__FILE__))), "career");
	$block['career_messages'] = $career_message_handler->getMessages(FALSE, $options[0], $options[1], $options[2], 0, $options[3]);
	return $block;
}

function b_career_recent_messages_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$career_department_handler = icms_getModuleHandler("department", basename(dirname(dirname(__FILE__))), "career");
	$sort = array('message_title' => _CO_CAREER_MESSAGE_MESSAGE_TITLE, 'message_date' => _CO_CAREER_MESSAGE_MESSAGE_DATE);
	$selsort = new icms_form_elements_Select('', 'options[2]', $options[2]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[3]', $options[3]);
	$selorder->addOptionArray($order);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($career_department_handler->getDepartmentList(TRUE, TRUE));
	
	
	$form = '<table width="100%">';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_CAREER_DEPARTMENT_SELECT . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_CAREER_DEPARTMENT_SORT . '</td>';
	$form .= '<td>' . $selsort->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_CAREER_DEPARTMENT_ORDER . '</td>';
	$form .= '<td>' . $selorder->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_CAREER_CAREER_RECENT_LIMIT . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}
