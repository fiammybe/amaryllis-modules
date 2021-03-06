<?php
/**
 * 'Icmspoll' is a poll module for ImpressCMS and iforum
 *
 * File: /blocks/icmspoll_recent_results.php
 * 
 * block for recent results
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

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
/**
 * display recent polls block
 */
function b_icmspoll_recent_results_show($options) {
	global $icmspollConfig;
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
	$block["icmspoll_results"] = $polls_handler->getPolls(0, $options[0], $options[2], $options[3], $options[1], TRUE, TRUE);
	return $block;
}


function b_icmspoll_recent_results_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$polls_handler = icms_getModuleHandler("polls", ICMSPOLL_DIRNAME, "icmspoll");
	
	$limit = new icms_form_elements_Text('', 'options[0]', 20, 40, $options[0]);
	$uids = $polls_handler->filterUsers(TRUE);
	$seluids = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$seluids->addOptionArray($uids);
	
	$sort = array('weight' => _CO_ICMSPOLL_POLLS_WEIGHT, 'question' => _CO_ICMSPOLL_POLLS_QUESTION, 'created_on' => _CO_ICMSPOLL_POLLS_CREATED_ON, 'RAND()' => 'RAND()');
	$selsort = new icms_form_elements_Select('', 'options[3]', $options[3]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[4]', $options[4]);
	$selorder->addOptionArray($order);
	
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_ICMSPOLL_BLOCK_LIMIT . '</td>';
	$form .= '<td>' . $limit->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_ICMSPOLL_BLOCK_SELUSER . '</td>';
	$form .= '<td>' . $seluids->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ICMSPOLL_BLOCK_SORT . '</td>';
	$form .= '<td>' . $selsort->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ICMSPOLL_BLOCK_ORDER . '</td>';
	$form .= '<td>' . $selorder->render() . '</td>';
	$form .= '</tr>';
	$form .= '</table>';
	return $form;
}