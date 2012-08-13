<?php
/**
 * 'Album' is a light weight gallery module
 *
 * File: /blocks/album_recent_images.php
 *
 * block to show recent albums
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				album
 * @since		1.10
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		album
 * 
 */

 if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function b_album_recent_images_show($options) {
	global $albumConfig;
	$moddir = basename(dirname(dirname(__FILE__)));
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$album_images_handler = icms_getModuleHandler('images', $moddir, 'album');

	$block['album_images'] = $album_images_handler->getImages(TRUE, TRUE, $options[1], FALSE, $options[2], 0, $options[0], $options[3], $options[4]);
	$block['display_width'] = $albumConfig['image_display_width'];
	$block['display_height'] = $albumConfig['image_display_height'];
	$block['horizontal'] = $options[5];
	$block['autoscroll'] = $options[6];
	$block['img_dsc'] = $options[7];
    $block['block_id'] = $options[8];
	return $block;
}

function b_album_recent_images_edit($options) {
	$moddir = basename(dirname(dirname(__FILE__)));
    $bid = isset($_GET['bid']) ? filter_input(INPUT_GET, "bid", FILTER_SANITIZE_NUMBER_INT) : 0;
	include_once ICMS_ROOT_PATH . '/modules/' . $moddir . '/include/common.php';
	$album_album_handler = icms_getModuleHandler('album', $moddir, 'album');
	$limit = new icms_form_elements_Text('', 'options[0]', 60, 255, $options[0]);
	$selcats = new icms_form_elements_Select('', 'options[1]', $options[1]);
	$selcats->addOptionArray($album_album_handler->getAlbumListForPid());
	$publisher = new icms_form_elements_select_User('', 'options[2]', TRUE, $options[2]);
	$sort = array('weight' => _CO_ALBUM_ALBUM_WEIGHT, 'img_published_date' => _CO_ALBUM_IMAGES_IMG_PUBLISHED_DATE, 'RAND()' => _MB_ALBUM_IMAGE_RANDOM);
	$selsort = new icms_form_elements_Select('', 'options[3]', $options[3]);
	$selsort->addOptionArray($sort);
	$order = array('ASC' => 'ASC' , 'DESC' => 'DESC');
	$selorder = new icms_form_elements_Select('', 'options[4]', $options[4]);
	$selorder->addOptionArray($order);
	$display_block = array('1' => _MB_ALBUM_DISPLAY_SINGLE_HORIZONTAL, "2" => _MB_ALBUM_DISPLAY_GALLERY_HORIZONTAL, "3" => _MB_ALBUM_DISPLAY_SINGLE_VERTICAL,
							'4' => _MB_ALBUM_DISPLAY_GALLERY_VERTICAL, '5' => _MB_ALBUM_DISPLAY_CAROUSEL);
	$horizontal = new icms_form_elements_Select('', 'options[5]', $options[5]);
	$horizontal->addOptionArray($display_block);
	$autoscroll = new icms_form_elements_Radioyn('', 'options[6]', $options[6]);
	$display_dsc = new icms_form_elements_Radioyn('', 'options[7]', $options[7]);
    
    $hidden = new icms_form_elements_Hidden("options[8]", $bid);
    
	$form = '<table>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ALBUM_ALBUM_RECENT_LIMIT . '</td>';
	$form .= '<td>' . $limit->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_ALBUM_SELECT_ALBUM . '</td>';
	$form .= '<td>' . $selcats->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td width="30%">' . _MB_ALBUM_SELECT_PUBLISHER . '</td>';
	$form .= '<td>' . $publisher->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ALBUM_SORT . '</td>';
	$form .= '<td>' . $selsort->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ALBUM_ORDER . '</td>';
	$form .= '<td>' . $selorder->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ALBUM_HORIZONTAL . '</td>';
	$form .= '<td>' . $horizontal->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ALBUM_AUTOSCROLL . '</td>';
	$form .= '<td>' . $autoscroll->render() . '</td>';
	$form .= '</tr>';
	$form .= '<tr>';
	$form .= '<td>' . _MB_ALBUM_DISPLAY_DSC . '</td>';
	$form .= '<td>' . $display_dsc->render() . '</td>';
	$form .= '</tr>';
    $form .= '<tr>';
    $form .= '<td>' . $hidden->render() . '</td>';
    $form .= '</tr>';
	$form .= '</table>';
	return $form;
}