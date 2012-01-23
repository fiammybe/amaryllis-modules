<?php
/**
 * 
 * File: /admin/import.php
 * 
 * This is an import script for old tags module (aka imtaxonomy) to new sprocketsmodule.
 * - update your site to 1.3 (you will need to disable tag module for this)
 * -- install sprockets
 * --- at first: check, if you have had tags installed in folder tag. If not, check the db tables. Maybe you will need to adjust.
 * ---- remove example tag in sprockets or leave it, but DO NOT ADD MORE TAGS!
 * ---- Copy the script to /modules/sprockets/admin/
 * ----- call the page in your Browser: http://yoursite.com/modules/sprockets/admin/import.php
 * ------ follow the instructions: 
 * ------- import tags
 * -------- import taglinks
 * --------- enjoy sprockets on ImpressCMS 1.3.x ;-)
 * 
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Sprockets
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		sprockets
 *
 */

define("_AM_SPROCKETS_IMPORT_TAGS", "Import from Tag Module");
define("_AM_SPROCKETS_IMPORT_TAGTABLE", "Import Table tag_tag");
define("_AM_SPROCKETS_IMPORT_TAGLINKS", "Import from Table tag_link");
define("_AM_SPROCKETS_IMPORT_TAG_WARNING", "PLEASE; HANDLE THIS IMPORTER CAREFULLY! YOU'LL NEED A CLEAN SPROCKETS INSTALLATION! DO NOT ADD TAGS! AT FIRST IMPORT TAGS, LATER TAGLINKS!");

 
function sprockets_import_imtaxonomy_tags() {
	$sprockets_tag_handler = icms_getModuleHandler("tag", basename(dirname(dirname(__FILE__))), "sprockets");
	$table = new icms_db_legacy_updater_Table('tag_tag');
	if ($table->exists()) {
		echo '<code><b>Importing data from imtaxonomy tag_tag table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('tag_tag');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $sprockets_tag_handler->create(TRUE);
			$obj->setVar('title', $row['tag_term']);
			$obj->setVar('label_type', 0);
			$obj->setVar('parent_id', 0);
			$obj->setVar('description', '');
			$obj->setVar('navigation_element', 0);
			$obj->setVar('rss', 0);
			$sprockets_tag_handler->insert($obj, TRUE);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['tag_term'] . '</b> successfully imported!<br />';
		}
		echo '</code>';
		echo '<code><b>Tag tag table successfully dropped.</b></code><br />';
	}
}

function sprockets_import_imtaxonomy_taglinks() {
	$sprockets_taglink_handler = icms_getModuleHandler("taglink", basename(dirname(dirname(__FILE__))), "sprockets");
	$sprockets_tag_handler = icms_getModuleHandler("tag", basename(dirname(dirname(__FILE__))), "sprockets");
	
	$table = new icms_db_legacy_updater_Table('tag_link');
	if ($table->exists()) {
		echo '<code><b>Importing data from imtaxonomy tag_link table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('tag_link');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $sprockets_taglink_handler->create(TRUE);
			$obj->setVar('tid', ((int)$row['tag_id'] + 1));
			$obj->setVar('mid', $row['tag_modid']);
			$obj->setVar('iid', $row['tag_itemid']);
			
			$tagObj = $sprockets_tag_handler->get(((int)$row['tag_id'] + 1));
			$obj->setVar('item', $tagObj->getVar("title", "e"));
			
			$sprockets_taglink_handler->insert($obj, TRUE);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['tag_id'] . '</b> successfully imported!<br />';
		}
	}
		echo '</code>';
		echo '<code><b>Tag tag_link table successfully dropped.</b></code><br />';
}

include_once 'admin_header.php';

$valid_op = array ('1', '2', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op', FILTER_SANITIZE_NUMBER_INT) : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case '1':
			icms_cp_header();
			icms::$module->displayAdminMenu(0, _AM_SPROCKETS_IMPORT_TAGS . '>' . _AM_SPROCKETS_IMPORT_TAGTABLE);
			// at first import tag tags
			sprockets_import_imtaxonomy_tags();
			
			echo '<a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			
			break;
			
		case '2':
			icms_cp_header();
			icms::$module->displayAdminMenu(0,_AM_SPROCKETS_IMPORT_TAGS . '>' . _AM_SPROCKETS_IMPORT_TAGLINKS);
			// import tag links
			sprockets_import_imtaxonomy_taglinks();
			
			echo '<a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			
			break;
			
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(0, _AM_SPROCKETS_IMPORT_TAGS);
			echo ' <div style="margin: 2em 0em; color: red; font-weight: bold;"><p>' . _AM_SPROCKETS_IMPORT_TAG_WARNING . '</p></div>';
			
			 //ask what to do
	        $form = new icms_form_Theme('Importing',"form", $_SERVER['REQUEST_URI']);
	        // for tag table
	        $sql = "SELECT * FROM " . icms::$xoopsDB->prefix('tag_tag');
			$result = icms::$xoopsDB->query($sql);
	        if ($result) {
	            $button = new icms_form_elements_Button("Import data from tag_tag", "button", "Import", "submit");
	            $button->setExtra("onclick='document.forms.form.op.value=\"1\"'");
	            $form->addElement($button);
	        } else {
	            $label = new icms_form_elements_Label("Import data from tag_tag", "tag_tag table not found on this site.");
	            $form->addElement($label);
	        }
			
			//for taglink table
			$sql2 = "SELECT * FROM " . icms::$xoopsDB->prefix('tag_link');
			$result2 = icms::$xoopsDB->query($sql2);
	        if ($result2) {
	            $button2 = new icms_form_elements_Button("Import data from tag_link", "link_button", "Import", "submit");
	            $button2->setExtra("onclick='document.forms.form.op.value=\"2\"'");
	            $form->addElement($button2);
	        } else {
	            $label2 = new icms_form_elements_Label("Import data from tag_link", "tag_link table not found on this site.");
	            $form->addElement($label2);
	        }
			
			$form->addElement(new icms_form_elements_Hidden('op', 0));
        	$form->display();
			break;
	}
	icms_cp_footer();
}