<?php
/**
 * 'Guestbook' is a small, light weight guestbook module for ImpressCMS
 *
 * File: /admin/import.php
 * 
 * import script for xfguestbook
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Guestbook
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		guestbook
 *
 */
ini_set('max_execution_time', 0);

ini_set('memory_limit', '256M');

/**
 * import xfguestbook entries
 */
function store_xfguestbook_msg($row) {
	global $guestbook_guestbook_handler;
	
	$obj = $guestbook_guestbook_handler->create(TRUE);
	$obj->setVar("guestbook_id", $row['msg_id']);
	$obj->setVar("guestbook_title", $row['title']);
	$obj->setVar("guestbook_uid", $row['user_id']);
	$obj->setVar("guestbook_name", $row['uname']);
	$obj->setVar("guestbook_email", $row['email']);
	$obj->setVar("guestbook_url", $row['url']);
	$obj->setVar("guestbook_image", $row['photo']);
	if($row['note'] == "") {
		$obj->setVar("guestbook_entry", $row['message']);
	} else {
		$message = $row['message'];
		$message .= '<br />';
		$message .= '<i>EDIT:<br /> ' . $row['note'] . '</i>';
		$obj->setVar("guestbook_entry", $message);
	}
	$obj->setVar("guestbook_pid", 0);
	$obj->setVar("guestbook_ip", $row['poster_ip']);
	$obj->setVar("guestbook_approve", 1);
	$obj->setVar("guestbook_published_date", (int)$row['post_time']);
	
	$guestbook_guestbook_handler->insert($obj, TRUE);
	unset($row);
}

function guestbook_import_xfguestbook_msg() {
	
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
	echo '<code><b>Messages from xfguestbook_msg succesfully imported.</b><br />';
	echo '<b>xfguestbook_msg table successfully dropped.</b></code><br />';
	$table->dropTable ();
	unset($table);
}

include_once 'admin_header.php';

$valid_op = array ('1', '2', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

if(in_array($clean_op, $valid_op, TRUE)) {
	$guestbook_guestbook_handler = icms_getModuleHandler("guestbook", GUESTBOOK_DIRNAME, "guestbook");
	switch ($clean_op) {
		case '1':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			guestbook_import_xfguestbook_msg();
			
			echo '<br /><br /><a class="formButton" href="' . GUESTBOOK_ADMIN_URL . 'import.php">Go Back</a>';
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