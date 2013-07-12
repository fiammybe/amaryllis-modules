<?php
/**
 * 'Tools' is a small admin-tool-module to provide some autotasks for icms and some more..
 *
 * File: /admin/backup.php
 *
 * Admin backup
 *
 * @copyright	Copyright QM-B (Steffen Flohrer) 2013
 * @license		http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Tools
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @version		$Revision$
 * @package		tools
 *
 */

include_once 'admin_header.php';
icms_cp_header();
icms::$module->displayAdminMenu( 2, _MI_TOOLS_MENU_MODULESADD);
icms::$module->setVar("ipf", TRUE);
icms::$module->registerClassPath(TRUE);
$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, "op", FILTER_SANITIZE_STRING) : "";
$clean_op = isset($_POST['op']) ? filter_input(INPUT_POST, "op", FILTER_SANITIZE_STRING) : $clean_op;

$valid_op = array("add_module", "module_ok", "");

if(in_array($clean_op, $valid_op, TRUE)) {
	$icmsAdminTpl->assign("tools_title", _MI_TOOLS_MENU_MODULESADD);
	$icmsAdminTpl->assign("tools_url", TOOLS_URL);
	$icmsAdminTpl->assign("tools_admin_url", TOOLS_ADMIN_URL);
	switch ($clean_op) {
		case 'add_module':
			echo "add_modul triggered";
			if (!icms::$security->check()) {
				redirect_header('modulesadd.php',3,_AM_TOOLS_SECURITY_CHECK_FAILED."<br />".implode('<br />', icms::$security->getErrors()));
				break;
			}
			$uploader = new icms_file_MediaUploadHandler(ICMS_UPLOAD_PATH, array('application/zip'), 2000000);
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				$uploader->setPrefix('tmod');
				if ($uploader->upload()) {
					$zipfile = $uploader->getSavedDestination();
					mod_tools_Zip::instance();
					mod_tools_Zip::openZip($zipfile, FALSE);
					$module = mod_tools_Zip::getNameIndex(0);
					if($module[strlen($module)-1] == "/") $moddir = substr($module, 0, -1);
					else $moddir = $module;
					$path = ICMS_MODULES_PATH.'/';
					$path = str_replace("\\","/",$path);
					$update = (is_dir($path.$moddir) === TRUE && icms_get_module_status($moddir) === TRUE) ? "update" : "install";
					mod_tools_Zip::extractZip($path);
					mod_tools_Zip::closeZip();
					$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ICMS_MODULES_PATH.'/'.$module), RecursiveIteratorIterator::SELF_FIRST);
					foreach ($files as $k => $mfile) {
						@chmod($mfile, 0777);
					}
					@unlink($uploader->getSavedDestination());
					if($module[strlen($module)-1] == "/") $module = substr($module, 0, -1);
					redirect_header("modulesadd.php?op=module_ok&module=".$module."&trigger=".$update);
				} else {
					redirect_header("modulesadd.php", 5, $uploader->getErrors());
				}
			} else {
				redirect_header("modulesadd.php", 5, $uploader->getErrors());
			}
			break;
		case 'module_ok':
		default:
			$icmsAdminTpl->display("db:tools_admin.html");
			if($clean_op == "module_ok") {
				$clean_module = isset($_GET['module']) ? filter_input(INPUT_GET, "module", FILTER_SANITIZE_STRING) : "";
				$clean_trigger = isset($_GET['trigger']) ? filter_input(INPUT_GET, "trigger", FILTER_SANITIZE_STRING) : "";
				echo '<div class="tools_ok"><p>'.
							_AM_TOOLS_MODULES_INSTALL_OK.
							'</p><p><a class="tools_backup" href="'.ICMS_MODULES_URL.'/system/admin.php?fct=modulesadmin&op='.$clean_trigger.'&module='.$clean_module.'" title="'._AM_TOOLS_MODULES_GOTO.
							'">'._AM_TOOLS_MODULES_GOTO.' &raquo;</a></p>'.
					'</p></div>';
			}
			if(!is_writable(ICMS_ROOT_PATH.'/modules')) {
				if(@chmod(ICMS_MODULES_PATH, 0777) === FALSE)
				echo "<div class='tools_attention'>"._AM_TOOLS_MODULES_FAIL_WRITABLE.'</div>';
			} else {
				$form = new icms_form_Theme(_AM_TOOLS_MODULES_UPLOAD_FORM, "addmodule", $_SERVER['PHP_SELF'], "post", TRUE);
				$form->setExtra('enctype="multipart/form-data"');
				$form->addElement(new icms_form_elements_File(_AM_TOOLS_MODULES_UPLOAD_FILE, "add_file", 20000000));
				$form->addElement(new icms_form_elements_Hidden("op", "add_module"));
				$form->addElement(new icms_form_elements_Button("", "submit", _SUBMIT, 'submit'));
				$form->display();
			}
			break;
	}
}
include_once 'admin_footer.php';