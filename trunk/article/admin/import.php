<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/import.php
 * 
 * import script for smartsection
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Article
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		article
 *
 */

function article_import_smartsection_articles() {
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
	$gperm_handler = icms::handler('icms_member_groupperm');
	$mid_sql = "SELECT `mid` FROM" . icms::$xoopsDB->prefix('modules') . "WHERE dirname = smartsection";
	$mid = icms::$xoopsDB->query($mid_sql);
	$table = new icms_db_legacy_updater_Table('smartsection_items');
	if ($table->exists()) {
		echo '<code><b>Importing data from smartsection article table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('smartsection_items');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $article_article_handler->create(TRUE);
			$obj->setVar('article_title', $row['title']);
			$obj->setVar('article_cid', explode(",", $row['categoryid']));
			$obj->setVar('short_url', $row['short_url']);
			$obj->setVar('article_teaser', $row['summary']);
			$obj->setVar('article_show_teaser', $row['display_summary']);
			$obj->setVar('article_body', $row['body']);
			$obj->setVar('article_img', $row['image']);
			$obj->setVar('article_publisher', explode(",", $row['uid']));
			$obj->setVar('article_submitter', $row['uid']);
			$obj->setVar('article_published_date', (int)$row['datesub']);
			$obj->setVar('article_cancomment', $row['cancomment']);
			$obj->setVar('article_comments', $row['comments']);
			$obj->setVar('article_notification_sent', $row['notifypub']);
			$obj->setVar('article_tags', explode(",", $row['item_tag']));
			$obj->setVar('dohtml', $row['dohtml']);
			$obj->setVar('dobr', $row['dobr']);
			$obj->setVar('doimage', $row['doimage']);
			$obj->setVar('dosmiley', $row['dosmiley']);
			$obj->setVar('doxcode', $row['doxcode']);
			$obj->setVar('counter', $row['counter']);
			$obj->setVar('weight', $row['weight']);
			$obj->setVar('meta_keywords', $row['meta_keywords']);
			$obj->setVar('meta_description', $row['meta_description']);
			$obj->setVar('article_inblocks', 1);
			$obj->setVar('article_broken_file', 0);
			$obj->setVar('article_updated', 0);
			if($row['status'] == 4) {
				$obj->setVar('article_approve', 0);
			} elseif($row['status'] == 3) {
				$obj->setVar('article_active', 0);
			} else {
				$obj->setVar('article_active', 1);
				$obj->setVar('article_approve', 1);
			}
			$groups = $gperm_handler->getGroupIds('item_read', $row['itemid']);
			$obj->setVar("article_grpperm", implode(",", $groups));
			
			$article_article_handler->insert($obj, TRUE);
			
			/**
			 * delet all old permissions from smartsection items
			 */
			$criteria = new icms_db_criteria_Compo();
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('gperm_name', 'item_read'));
			$criteria->add($crit);
			$criteria->add(new icms_db_criteria_Item('gperm_itemid', $row['itemid']));
			$criteria->add(new icms_db_criteria_Item('gperm_modid', $mid));
			$gperm_handler->deleteAll($criteria);
			
			
			echo '&nbsp;&nbsp;-- <b>' . $row['title'] . '</b> successfully imported!<br />';
		}
		echo '</code>';
		echo '<code><b>Smartsection item table successfully dropped.</b></code><br />';
	}
	unset($table);

	$feedback = ob_get_clean();
	if (method_exists(icms::$module, "setMessage")) {
		icms::$module->messages = icms::$module->setMessage($feedback);
	} else {
		echo $feedback;
	}
	return TRUE;
}

function article_import_smartsection_categories() {
	$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
	$gperm_handler = icms::handler('icms_member_groupperm');
	$mid_sql = "SELECT `mid` FROM" . icms::$xoopsDB->prefix('modules') . "WHERE dirname = smartsection";
	
	$table = new icms_db_legacy_updater_Table('smartsection_categories');
	if ($table->exists()) {
		echo '<code><b>Importing data from smartsection category table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('smartsection_categories');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $article_category_handler->create(TRUE);
			$obj->setVar('category_title', $row['name']);
			$obj->setVar('category_pid', $row['parentid']);
			$obj->setVar('category_description', $row['description']);
			$obj->setVar('category_image', $row['image']);
			$obj->setVar('weight', $row['weight']);
			$obj->setVar('category_published_date', (int)$row['created']);
			$obj->setVar('short_url', 'short_url');
			$groups = $gperm_handler->getGroupIds('category_read', $row['categoryid']);
			$obj->setVar("category_grpperm", implode(",", $groups));
			
			$submitter = $gperm_handler->getGroupIds('item_submit', $row['categoryid']);
			$obj->setVar("category_grpperm", implode(",", $submitter));
			
			$article_category_handler->insert($obj, TRUE);
			
			/**
			 * delet all old permissions from smartsection items
			 */
			$criteria = new icms_db_criteria_Compo();
			$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('gperm_name', 'category_read'));
			$criteria->add($crit);
			$criteria->add(new icms_db_criteria_Item('gperm_itemid', $row['categoryid']));
			$criteria->add(new icms_db_criteria_Item('gperm_modid', $mid));
			$gperm_handler->deleteAll($criteria);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['name'] . '</b> successfully imported!<br />';
		}
		echo '</code>';
		echo '<code><b>Smartsection categories table successfully dropped.</b></code><br />';
	}
	
	unset($table);

	$feedback = ob_get_clean();
	if (method_exists(icms::$module, "setMessage")) {
		icms::$module->messages = icms::$module->setMessage($feedback);
	} else {
		echo $feedback;
	}
	return TRUE;
}

function article_import_smartsection_files() {
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
	$file_handler = icms::handler("icms_data_file");
	$module = icms::handler('icms_module')->getByDirname(basename(dirname(dirname(__FILE__))));
	$mid = $module->getVar('mid');
	$url = ICMS_URL . '/uploads/article/article/';
	$table = new icms_db_legacy_updater_Table('smartsection_files');
	if ($table->exists()) {
		echo '<code><b>Importing data from smartsection files table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('smartsection_files');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $file_handler->create(TRUE);
			$obj->setVar('mid', $mid);
			$obj->setVar('caption', '');
			$obj->setVar('description', '');
			$obj->setVar('url', $url . $row['filename']);
			
			$file_handler->insert($obj, TRUE);
			$file_id = mysql_insert_id();
			$articleObj = $article_article_handler->get($row['itemid']);
			$articleObj->setVar('article_attachment', $file_id);
			$article_article_handler->insert($articleObj, TRUE);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['filename'] . '</b> successfully imported!<br />';
		}	
		echo '</code>';
		echo '<code><b>Smartsection files table successfully dropped.</b></code><br />';
	}
	unset($table);

	$feedback = ob_get_clean();
	if (method_exists(icms::$module, "setMessage")) {
		icms::$module->messages = icms::$module->setMessage($feedback);
	} else {
		echo $feedback;
	}
	return TRUE;
}

function article_import_linked_tags() {
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
	$sprockets_taglink_handler = icms_getModuleHandler("taglink", basename(dirname(dirname(__FILE__))), "article");
	$mid_sql = "SELECT `mid` FROM" . icms::$xoopsDB->prefix('modules') . "WHERE dirname = smartsection";
	$mid = icms::$xoopsDB->query($mid_sql);
	
	$articleObjects = $article_article_handler->getObjects(FALSE, TRUE, FALSE);
	foreach ($articleObjects as $key => $object) {
		$criteria = new icms_db_criteria_Compo();
		$criteria->add(new icms_db_criteria_Item("mid", (int)$mid));
		$criteria->add(new icms_db_criteria_Item("iid", $object->getVar("article_id")));
		$tagObjects = $sprockets_taglink_handler->getObjects($criteria, TRUE, FALSE);
		$tags = array();
		foreach ($tagObjects as $key => $tagObj) {
			$tags = $tagObj->getVar("tid", "e");
		}
		$object->setVar("article_tags", $tags);
	}

	$feedback = ob_get_clean();
	if (method_exists(icms::$module, "setMessage")) {
		icms::$module->messages = icms::$module->setMessage($feedback);
	} else {
		echo $feedback;
	}
	return TRUE;

}

include_once 'admin_header.php';

$valid_op = array ('1', '2', '3', '4', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op') : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

$article_category_handler = icms_getModuleHandler('category', basename(dirname(dirname(__FILE__))), 'article');

if(in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case '1':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			// at first import smartsection articles
			article_import_smartsection_articles();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		case '2':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			// import articles
			article_import_smartsection_categories();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		case '3':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			// import files
			article_import_smartsection_files();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		case '4':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			// import files
			article_import_linked_tags();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
		
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			echo ' <div style="margin: 2em 0em; color: red; font-weight: bold;"><p>' . _AM_ARTICLE_IMPORT_SMARTSECTION_WARNING . '</p></div>';
			
			 //ask what to do
	        $form = new icms_form_Theme('Importing',"form", $_SERVER['REQUEST_URI']);
	        // for article table
	        $sql = "SELECT * FROM " . icms::$xoopsDB->prefix('smartsection_items');
			$result = icms::$xoopsDB->query($sql);
	        if ($result) {
	            $button = new icms_form_elements_Button("Import data from smartsection_items", "button", "Import", "submit");
	            $button->setExtra("onclick='document.forms.form.op.value=\"1\"'");
	            $form->addElement($button);
	        } else {
	            $label = new icms_form_elements_Label("Import data from smartsection_items", "smartsection_items tables not found on this site.");
	            $form->addElement($label);
	        }
			
			//for category table
			$sql2 = "SELECT * FROM " . icms::$xoopsDB->prefix('smartsection_categories');
			$result2 = icms::$xoopsDB->query($sql2);
	        if ($result2) {
	            $button2 = new icms_form_elements_Button("Import data from smartsection_categories", "cat_button", "Import", "submit");
	            $button2->setExtra("onclick='document.forms.form.op.value=\"2\"'");
	            $form->addElement($button2);
	        } else {
	            $label2 = new icms_form_elements_Label("Import data from smartsection_categories", "smartsection_categories tables not found on this site.");
	            $form->addElement($label2);
	        }
			
			// for files
			$sql3 = "SELECT * FROM " . icms::$xoopsDB->prefix('smartsection_files');
			$result3 = icms::$xoopsDB->query($sql3);
	        if ($result3) {
	            $button3 = new icms_form_elements_Button("Import data from smartsection_files", "files_button", "Import", "submit");
	            $button3->setExtra("onclick='document.forms.form.op.value=\"3\"'");
	            $form->addElement($button3);
	        } else {
	            $label3 = new icms_form_elements_Label("Import data from smartsection_files", "smartsection_categories tables not found on this site.");
	            $form->addElement($label3);
	        }
			
			// for tags
			$sql4 = "SELECT * FROM " . icms::$xoopsDB->prefix('sprockets_taglink');
			$result4 = icms::$xoopsDB->query($sql4);
	        if ($result4) {
	            $button4 = new icms_form_elements_Button("Import data from sprockets taglinks", "tags_button", "Import", "submit");
	            $button4->setExtra("onclick='document.forms.form.op.value=\"4\"'");
	            $form->addElement($button4);
	        } else {
	            $label4 = new icms_form_elements_Label("Import data from sprockets taglinks", "sprockets_taglink tables not found on this site.");
	            $form->addElement($label4);
	        }
			
			$form->addElement(new icms_form_elements_Hidden('op', 0));
        	$form->display();
			
			break;
	}
	icms_cp_footer();
}