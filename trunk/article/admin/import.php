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
ini_set('max_execution_time', 0);

ini_set('memory_limit', '512M');

set_time_limit(0);

/**
 * import smartsection articles
 */
function article_import_smartsection_articles() {
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
	$gperm_handler = icms::handler('icms_member_groupperm');
	$mid_sql = "SELECT mid FROM " . icms::$xoopsDB->prefix('modules') . " WHERE dirname = 'smartsection'";
	$result2 = icms::$xoopsDB->query($mid_sql);
	$mid = mysql_fetch_assoc($result2);
	
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
			$criteria->add(new icms_db_criteria_Item('gperm_modid', $mid['']));
			$gperm_handler->deleteAll($criteria);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['title'] . '</b> successfully imported!<br />';
		}
		echo '</code>';
		echo '<code><b>Smartsection item table successfully dropped.</b></code><br />';
	}
	
	return TRUE;
}

/**
 * import smartsection categories
 */
function article_import_smartsection_categories() {
	$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
	$gperm_handler = icms::handler('icms_member_groupperm');
	$mid_sql = "SELECT mid FROM " . icms::$xoopsDB->prefix('modules') . " WHERE dirname = 'smartsection'";
	$result2 = icms::$xoopsDB->query($mid_sql);
	$mid = mysql_fetch_assoc($result2);
	
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
			$criteria->add(new icms_db_criteria_Item('gperm_modid', $mid['mid']));
			$gperm_handler->deleteAll($criteria);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['name'] . '</b> successfully imported!<br />';
		}
		echo '</code>';
		echo '<code><b>Smartsection categories table successfully dropped.</b></code><br />';
	}
}

/**
 * import from smartsection files
 */

function article_import_smartsection_files() {
	$article_article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
	$file_handler = icms::handler("icms_data_file");
	$module = icms::handler('icms_module')->getByDirname(ARTICLE_DIRNAME);
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
}

/**
 * linked tags for smartsection
 */

function article_import_linked_tags() {
	$sprocketsModule = icms_getModuleInfo("sprockets");
	if(icms_get_module_status($sprocketsModule->getVar("dirname"))) {
		$article_article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
		$sprockets_taglink_handler = icms_getModuleHandler("taglink", $sprocketsModule->getVar("dirname"), "sprockets");
		$mid_sql = "SELECT mid FROM " . icms::$xoopsDB->prefix('modules') . " WHERE dirname='smartsection'";
		$result2 = icms::$xoopsDB->query($mid_sql);
		$mid = mysql_fetch_assoc($result2);
		
		$articleObjects = $article_article_handler->getObjects(FALSE, TRUE);
		echo '<code><b>Importing data from sprockets taglink table</b></code><br />';
		foreach ($articleObjects as $key => &$object) {
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item("mid", (int)$mid['mid']));
			$criteria->add(new icms_db_criteria_Item("iid", $object->getVar("article_id")));
			$tagObjects = $sprockets_taglink_handler->getObjects($criteria, TRUE);
			$tags = array();
			foreach ($tagObjects as $key => &$tagObj) {
				$tags = $tagObj->getVar("tid", "e");
			}
			$object->setVar("article_tags", $tags);
			$article_article_handler->insert($object, TRUE);
		}
		echo '<code><b>Sprockets taglinks table successfully imported.</b></code><br />';
	} else {
		echo '<code><b>Sprockets not found.</b></code><br />';
	}
}
/**
 * Import from news topics
 */
function article_import_news_topics() {
	$article_category_handler = icms_getModuleHandler("category", basename(dirname(dirname(__FILE__))), "article");
	
	$table = new icms_db_legacy_updater_Table('topics');
	if ($table->exists()) {
		echo '<code><b>Importing data from News topics table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('topics');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $article_category_handler->create(TRUE);
			$obj->setVar('category_title', $row['topic_title']);
			$obj->setVar('category_pid', $row['topic_pid']);
			$obj->setVar('category_description', $row['topic_description']);
			$obj->setVar('category_image', $row['topic_imgurl']);
			
			$article_category_handler->insert($obj, TRUE);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['topic_title'] . '</b> successfully imported!<br />';
		}
		echo '</code>';
		echo '<code><b>Smartsection item table successfully dropped.</b></code><br />';
	}
	
	return TRUE;
}

/**
 * import news stories
 */
function article_import_news_stories() {
	$article_article_handler = icms_getModuleHandler("article", basename(dirname(dirname(__FILE__))), "article");
	$table = new icms_db_legacy_updater_Table('stories');
	if ($table->exists()) {
		echo '<code><b>Importing data from news stories table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('stories');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $article_article_handler->create(TRUE);
			$obj->setVar('article_title', $row['title']);
			$obj->setVar('article_cid', explode(",", $row['topiccid']));
			$obj->setVar('article_teaser', $row['hometext']);
			$obj->setVar('article_body', $row['bodytext']);
			$obj->setVar('article_img', $row['picture']);
			$obj->setVar('article_publisher', explode(",", $row['uid']));
			$obj->setVar('article_submitter', $row['uid']);
			$obj->setVar('article_published_date', (int)$row['published']);
			$obj->setVar('article_comments', $row['comments']);
			$obj->setVar('article_notification_sent', $row['notifypub']);
			$obj->setVar('article_inblocks', 1);
			$obj->setVar('article_broken_file', 0);
			$obj->setVar('article_updated', 0);
			$article_article_handler->insert($obj, TRUE);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['title'] . '</b> successfully imported!<br />';
		}
		echo '</code>';
		echo '<code><b>News stories table successfully dropped.</b></code><br />';
	}
	
	return TRUE;
}

/**
 * import from news files
 */

function article_import_news_files() {
	$article_article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
	$file_handler = icms::handler("icms_data_file");
	$module = icms::handler('icms_module')->getByDirname(ARTICLE_DIRNAME);
	$mid = $module->getVar('mid');
	$url = ICMS_URL . '/uploads/article/article/';
	$table = new icms_db_legacy_updater_Table('stories_files');
	if ($table->exists()) {
		echo '<code><b>Importing data from smartsection files table</b></code><br />';

		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('stories_files');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			$obj = $file_handler->create(TRUE);
			$obj->setVar('mid', $mid);
			$obj->setVar('caption', '');
			$obj->setVar('description', '');
			$obj->setVar('url', $url . $row['downloadname']);
			
			$file_handler->insert($obj, TRUE);
			$file_id = mysql_insert_id();
			$articleObj = $article_article_handler->get($row['storyid']);
			$articleObj->setVar('article_attachment', $file_id);
			$article_article_handler->insert($articleObj, TRUE);
			
			echo '&nbsp;&nbsp;-- <b>' . $row['downloadname'] . '</b> successfully imported!<br />';
		}	
		echo '</code>';
		echo '<code><b>News files table successfully dropped.</b></code><br />';
	}
}
/**
 * import news view permissions
 */
function import_news_view_permissions() {
	$gperm_handler = icms::handler('icms_member_groupperm');
	$mid_sql = "SELECT mid FROM " . icms::$xoopsDB->prefix('modules') . " WHERE dirname = 'news'";
	$result2 = icms::$xoopsDB->query($mid_sql);
	$mid = mysql_fetch_assoc($result2);
	
	/**
	 * delet all old permissions from smartsection items
	 */
	$criteria = new icms_db_criteria_Compo();
	$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('gperm_name', 'news_view'));
	$criteria->add($crit);
	$criteria->add(new icms_db_criteria_Item('gperm_modid', $mid['mid']));
	$permissions = $gperm_handler->getObjects($criteria, TRUE);
	foreach (array_keys($permissions) as $i) {
		$permissions[$i]->setVar("gperm_modid", icms::$module->getVar("mid"));
		$permissions[$i]->setVar("gperm_name", "article_grpperm");
		$gperm_handler->insert($permissions[$i], TRUE);
	}
}

/**
 * import news submit permissions
 */
function import_news_submit_permissions() {
	$gperm_handler = icms::handler('icms_member_groupperm');
	$mid_sql = "SELECT mid FROM " . icms::$xoopsDB->prefix('modules') . " WHERE dirname = 'news'";
	$result2 = icms::$xoopsDB->query($mid_sql);
	$mid = mysql_fetch_assoc($result2);
	
	/**
	 * delet all old permissions from smartsection items
	 */
	$criteria = new icms_db_criteria_Compo();
	$crit = new icms_db_criteria_Compo(new icms_db_criteria_Item('gperm_name', 'news_submit'));
	$criteria->add($crit);
	$criteria->add(new icms_db_criteria_Item('gperm_modid', $mid['mid']));
	$permissions = $gperm_handler->getObjects($criteria, TRUE);
	foreach (array_keys($permissions) as $i) {
		$permissions[$i]->setVar("gperm_modid", icms::$module->getVar("mid"));
		$permissions[$i]->setVar("gperm_name", "submit_article");
		$gperm_handler->insert($permissions[$i], TRUE);
	}
}

/**
 * linked tags for news
 */

function article_import_linked_news_tags() {
	$sprocketsModule = icms_getModuleInfo("sprockets");
	if(icms_get_module_status("sprockets")) {
		$article_article_handler = icms_getModuleHandler("article", ARTICLE_DIRNAME, "article");
		$sprockets_taglink_handler = icms_getModuleHandler("taglink", $sprocketsModule->getVar("dirname"), "sprockets");
		$mid_sql = "SELECT mid FROM " . icms::$xoopsDB->prefix('modules') . " WHERE dirname='news'";
		$result2 = icms::$xoopsDB->query($mid_sql);
		$mid = mysql_fetch_assoc($result2);
		
		$articleObjects = $article_article_handler->getObjects(FALSE, TRUE);
		echo '<code><b>Importing data from sprockets taglink table</b></code><br />';
		foreach ($articleObjects as $key => &$object) {
			$criteria = new icms_db_criteria_Compo();
			$criteria->add(new icms_db_criteria_Item("mid", (int)$mid['mid']));
			$criteria->add(new icms_db_criteria_Item("iid", $object->getVar("article_id")));
			$tagObjects = $sprockets_taglink_handler->getObjects($criteria, TRUE);
			$tags = array();
			foreach ($tagObjects as $key => &$tagObj) {
				$tags = $tagObj->getVar("tid", "e");
			}
			$object->setVar("article_tags", $tags);
			$article_article_handler->insert($object, TRUE);
		}
		echo '<code><b>Sprockets taglinks table successfully imported.</b></code><br />';
	} else {
		echo '<code><b>Sprockets not found.</b></code><br />';
	}
}

include_once 'admin_header.php';

$valid_op = array ('1', '2', '3', '4', '5', '6', '7', '8', '9', '');

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
			
		case '5':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			
			// import topics
			article_import_news_topics();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
		
		case '6':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			
			// import stories
			article_import_news_stories();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		case '7':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			
			// import files
			article_import_news_files();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		case '8':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			
			// import news view permissions
			import_news_view_permissions();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		case '9':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			
			// import news submit permissions
			import_news_submit_permissions();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		case '10':
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			
			// import news submit permissions
			article_import_linked_news_tags();
			
			echo '<br /><br /><a class="formButton" href="javascript:history.go(-1)">Go Back</a>';
			break;
			
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(0);
			echo ' <div style="margin: 2em 0em; color: red; font-weight: bold;"><p>' . _AM_ARTICLE_IMPORT_SMARTSECTION_WARNING . '</p></div>';
			
			 //ask what to do
	        $form = new icms_form_Theme('Importing',"form", $_SERVER['REQUEST_URI']);
	        // for article table
	        $sql = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('smartsection_items');
			$result = icms::$xoopsDB->query($sql);
			list($count) = icms::$xoopsDB->fetchRow($result);
	        if ($result > 0) {
	            $button = new icms_form_elements_Button("Import " . $count . " items from smartsection_items", "button", "Import", "submit");
	            $button->setExtra("onclick='document.forms.form.op.value=\"1\"'");
	            $form->addElement($button);
	        } else {
	            $label = new icms_form_elements_Label("Import data from smartsection_items", "smartsection_items tables not found on this site.");
	            $form->addElement($label);
	        }
			
			//for category table
			$sql2 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('smartsection_categories');
			$result2 = icms::$xoopsDB->query($sql2);
			list($count2) = icms::$xoopsDB->fetchRow($result2);
	        if ($result2 > 0) {
	            $button2 = new icms_form_elements_Button("Import " . $count2 . " categories from smartsection_categories", "cat_button", "Import", "submit");
	            $button2->setExtra("onclick='document.forms.form.op.value=\"2\"'");
	            $form->addElement($button2);
	        } else {
	            $label2 = new icms_form_elements_Label("Import data from smartsection_categories", "smartsection_categories tables not found on this site.");
	            $form->addElement($label2);
	        }
			
			// for files
			$sql3 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('smartsection_files');
			$result3 = icms::$xoopsDB->query($sql3);
			list($count3) = icms::$xoopsDB->fetchRow($result3);
	        if ($result3 > 0) {
	            $button3 = new icms_form_elements_Button("Import " . $count3 . " files from smartsection_files", "files_button", "Import", "submit");
	            $button3->setExtra("onclick='document.forms.form.op.value=\"3\"'");
	            $form->addElement($button3);
	        } else {
	            $label3 = new icms_form_elements_Label("Import data from smartsection_files", "smartsection_categories tables not found on this site.");
	            $form->addElement($label3);
	        }
			
			// for tags
			$sql4 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('sprockets_taglink');
			$result4 = icms::$xoopsDB->query($sql4);
	        if ($result4 > 0) {
	            $button4 = new icms_form_elements_Button("Import tags from sprockets taglinks", "tags_button", "Import", "submit");
	            $button4->setExtra("onclick='document.forms.form.op.value=\"4\"'");
	            $form->addElement($button4);
	        } else {
	            $label4 = new icms_form_elements_Label("Import data from sprockets taglinks", "sprockets_taglink tables not found on this site.");
	            $form->addElement($label4);
	        }
			
			// for news topics
			$sql5 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('topics');
			$result5 = icms::$xoopsDB->query($sql5);
			list($count5) = icms::$xoopsDB->fetchRow($result5);
	        if ($result5 > 0) {
	            $button5 = new icms_form_elements_Button("Import " . $count5 .  " topics from old News Module", "topics_button", "Import", "submit");
	            $button5->setExtra("onclick='document.forms.form.op.value=\"5\"'");
	            $form->addElement($button5);
	        } else {
	            $label5 = new icms_form_elements_Label("Import data from old News Module", "topics tables not found on this site.");
	            $form->addElement($label5);
	        }
	        
			// for news stories
			$sql6 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('stories');
			$result6 = icms::$xoopsDB->query($sql6);
			list($count6) = icms::$xoopsDB->fetchRow($result6);
	        if ($result6 > 0) {
	            $button6 = new icms_form_elements_Button("Import "  . $count6 . " stories from old news module", "stories_button", "Import", "submit");
	            $button6->setExtra("onclick='document.forms.form.op.value=\"6\"'");
	            $form->addElement($button6);
	        } else {
	            $label6 = new icms_form_elements_Label("Import data from news stories", "stories tables not found on this site.");
	            $form->addElement($label6);
	        }
			
			// for news stories files
			$sql7 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('stories_files');
			$result7 = icms::$xoopsDB->query($sql7);
			list($count7) = icms::$xoopsDB->fetchRow($result7);
	        if ($result7 > 0) {
	            $button7 = new icms_form_elements_Button("Import "  . $count7 . " stories files from old news module", "stories_files_button", "Import", "submit");
	            $button7->setExtra("onclick='document.forms.form.op.value=\"7\"'");
	            $form->addElement($button7);
	        } else {
	            $label7 = new icms_form_elements_Label("Import data from news stories files", "stories_files tables not found on this site.");
	            $form->addElement($label7);
	        }
			
			// for news stories view perm
			$sql8 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('group_permissions') . " WHERE gperm_name = 'news_view'";
			$result8 = icms::$xoopsDB->query($sql8);
	        if ($result8 > 0) {
	            $button8 = new icms_form_elements_Button("Import stories view permissions from old news module", "view_stories_button", "Import", "submit");
	            $button8->setExtra("onclick='document.forms.form.op.value=\"8\"'");
	            $form->addElement($button8);
	        } else {
	            $label8 = new icms_form_elements_Label("Import stories view permissions from old news module", "news_view not found on this site.");
	            $form->addElement($label8);
	        }
			
			// for news stories submit perm
			$sql9 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('group_permissions') . " WHERE gperm_name = 'news_submit'";
			$result9 = icms::$xoopsDB->query($sql7);
	        if ($result9 > 0) {
	            $button9 = new icms_form_elements_Button("Import stories submit permission from old news module", "stories_files_button", "Import", "submit");
	            $button9->setExtra("onclick='document.forms.form.op.value=\"9\"'");
	            $form->addElement($button9);
	        } else {
	            $label9 = new icms_form_elements_Label("Import stories submit permission from old news module", "news_submit tables not found on this site.");
	            $form->addElement($label9);
	        }
			
			// for news taglinks
			$sql10 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('sprockets_taglink');
			$result10 = icms::$xoopsDB->query($sql10);
	        if ($result10 > 0) {
	            $button10 = new icms_form_elements_Button("Import tags from sprockets taglinks", "tags_button", "Import", "submit");
	            $button10->setExtra("onclick='document.forms.form.op.value=\"10\"'");
	            $form->addElement($button10);
	        } else {
	            $label10 = new icms_form_elements_Label("Import data from sprockets taglinks", "sprockets_taglink tables not found on this site.");
	            $form->addElement($label10);
	        }
			
			$form->addElement(new icms_form_elements_Hidden('op', 0));
        	$form->display();

			break;
	}
	icms_cp_footer();
}