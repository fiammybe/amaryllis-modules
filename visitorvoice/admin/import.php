<?php
/**
 * 'Visitorvoice' is a small, light weight visitorvoice module for ImpressCMS
 *
 * File: /admin/import.php
 * 
 * import script for xfvisitorvoice
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Visitorvoice
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		visitorvoice
 *
 */
ini_set('max_execution_time', 0);

ini_set('memory_limit', '256M');
 
/**
 * import xfguestbook entries
 */
function store_xfguestbook_msg($row) {
	global $visitorvoice_visitorvoice_handler;
	
	$obj = $visitorvoice_visitorvoice_handler->create(TRUE);
	$obj->setVar("visitorvoice_id", $row['msg_id']);
	$obj->setVar("visitorvoice_title", $row['title']);
	$obj->setVar("visitorvoice_uid", $row['user_id']);
	$obj->setVar("visitorvoice_name", $row['uname']);
	$obj->setVar("visitorvoice_email", $row['email']);
	$obj->setVar("visitorvoice_url", $row['url']);
	$obj->setVar("visitorvoice_image", $row['photo']);
	if($row['note'] == "") {
		$obj->setVar("visitorvoice_entry", $row['message']);
	} else {
		$message = $row['message'];
		$message .= '<br />';
		$message .= '<i>EDIT:<br /> ' . $row['note'] . '</i>';
		$obj->setVar("visitorvoice_entry", $message);
	}
	$obj->setVar("visitorvoice_pid", 0);
	$obj->setVar("visitorvoice_ip", $row['poster_ip']);
	$obj->setVar("visitorvoice_approve", 1);
	$obj->setVar("visitorvoice_published_date", (int)$row['post_time']);
	
	$visitorvoice_visitorvoice_handler->insert($obj, TRUE);
	unset($row);
}

function visitorvoice_import_xfguestbook_msg() {
	
	$table = new icms_db_legacy_updater_Table('xfguestbook_msg');
	if ($table->exists()) {
		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('xfguestbook_msg');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			store_xfguestbook_msg($row);
		}
		mysql_free_result($result);
		echo '</code>';
	}
	
	echo '<code> messages from xfguestbook_msg succesfully imported.<br />';
	echo '<b>xfguestbook_msg table successfully dropped.</b></code><br />';
	$table->dropTable ();
	unset($table);
}

include_once 'admin_header.php';

$valid_op = array ('1', '2', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

if(in_array($clean_op, $valid_op, TRUE)) {
	$visitorvoice_visitorvoice_handler = icms_getModuleHandler("visitorvoice", VISITORVOICE_DIRNAME, "visitorvoice");
	switch ($clean_op) {
		case '1':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			visitorvoice_import_xfguestbook_msg();
			
			echo '<br /><br /><a class="formButton" href="' . VISITORVOICE_ADMIN_URL . 'import.php">Go Back</a>';
			break;
		
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			
			 //ask what to do
	        $form = new icms_form_Theme('Importing from xfguestbook',"form", $_SERVER['REQUEST_URI']);
			
			// for article table
	        $sql = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('xfguestbook_msg');
			$result = icms::$xoopsDB->query($sql);
			list($count) = icms::$xoopsDB->fetchRow($result);
	        if ($result > 0) {
	            $button = new icms_form_elements_Button("Import " . $count . " entries from xfguestbook_msg", "button", "Import", "submit");
	            $button->setExtra("onclick='document.forms.form.op.value=\"1\"'");
	            $form->addElement($button);
	        } else {
	            $label = new icms_form_elements_Label("Import data from xfguestbook_msg", "xfguestbook_msg table not found on this site.");
	            $form->addElement($label);
	        }
			$form->addElement(new icms_form_elements_Hidden('op', 0));
        	$form->display();
			break;
	}
	icms_cp_footer();
}