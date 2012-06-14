<?php
/**
 * 'Article' is an category management module for ImpressCMS
 *
 * File: /admin/permissions.php
 * 
 * modinfo language file
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		category
 *
 */

include_once 'admin_header.php';
icms_cp_header();

icms::$module->displayAdminMenu(4, _MI_ALBUM_MENU_PERMISSIONS);
$op = isset($_REQUEST['op']) ? trim($_REQUEST['op']) : '';
switch ($op) {
	case 'viewalbum':
		$title_of_form = _AM_ALBUM_PREMISSION_ALBUM_VIEW;
		$perm_name = "album_grpperm";
		$restriction = "";
		$anonymous = TRUE;
		break;
		
	case 'submitimages':
		$title_of_form = _AM_ALBUM_PREMISSION_IMAGES_SUBMIT;
		$perm_name = "album_uplperm";
		$restriction = "";
		$anonymous = TRUE;
		break;
}

$opform = new icms_form_Simple('', 'opform', 'permissions.php', "get");
$op_select = new icms_form_elements_Select("", 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOption('--------------', '');
$op_select->addOption('viewalbum', _AM_ALBUM_PREMISSION_ALBUM_VIEW);
$op_select->addOption('submitimages', _AM_ALBUM_PREMISSION_IMAGES_SUBMIT);
$opform->addElement($op_select);
$opform->display();

$valid_op = array('viewalbum', 'submitimages');
if(in_array($op, $valid_op, TRUE)) {
	$form = new icms_form_Groupperm($title_of_form, icms::$module->getVar('mid'), $perm_name, '', 'admin/permissions.php', $anonymous);
	
	if($op == 'viewalbum') {
		$album_album_handler = icms_getmodulehandler("album", ALBUM_DIRNAME, "album");
		$albums = $album_album_handler->getObjects(FALSE, TRUE);
		foreach (array_keys($albums) as $i) {
			if ($restriction == "") {
				$form->addItem($albums[$i]->getVar('album_id'),
				$albums[$i]->getVar('album_title'));
			}
		}
	} elseif ($op == 'submitimages') {
		$album_album_handler = icms_getmodulehandler("album", ALBUM_DIRNAME, "album");
		$albums = $album_album_handler->getObjects(FALSE, TRUE);
		foreach (array_keys($albums) as $i) {
			if ($restriction == "") {
				$form->addItem($albums[$i]->getVar('album_id'),
				$albums[$i]->getVar('album_title'));
			}
		}
	}
	$form->display();
}
icms_cp_footer();