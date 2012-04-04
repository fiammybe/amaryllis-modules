<?php
/**
 * 'Downloads' is a light weight download handling module for ImpressCMS
 *
 * File: /admin/import.php
 * 
 * Import Script for WFD
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Downloads
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		downloads
 *
 */
ini_set('max_execution_time', 0);

ini_set('memory_limit', '256M');

/**
 * import categories
 */
function store_wfdownloads_cat($row) {
	global $downloads_category_handler;
	
	$obj = $downloads_category_handler->create(TRUE);
	$obj->setVar("category_id", $row['cid']);
	$obj->setVar("category_title", $row['title']);
	$obj->setVar("category_pid", $row['pid']);
	$obj->setVar("category_img", $row['imgurl']);
	$obj->setVar("category_description", $row['description']);
	$obj->setVar("weight", $row['weight']);
	
	$obj->setVar("dohtml", $row['dohtml']);
	$obj->setVar("dosmiley", $row['dosmiley']);
	$obj->setVar("doxcode", $row['doxcode']);
	$obj->setVar("doimage", $row['doimage']);
	$obj->setVar("dobr", $row['dobr']);
	$obj->setVar("category_approve", 1);
	$obj->setVar("category_published_date", time());
	$obj->setVar("category_publisher", 1);
	$obj->setVar("category_submitter", 1);
	$obj->setVar("category_notification_sent", 1);

	$downloads_category_handler->insert($obj, TRUE);
	unset($row);
}

function downloads_import_categories() {
	$table = new icms_db_legacy_updater_Table('wfdownloads_cat');
	if ($table->exists()) {
		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('wfdownloads_cat');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			store_wfdownloads_cat($row);
		}
		mysql_free_result($result);
		echo '</code>';
	}
	echo '<code><b>Categories from wfdownloads_cat succesfully imported.</b><br />';
	echo '<b>wfdownloads_cat table successfully dropped.</b></code><br />';
	$table->dropTable ();
	unset($table);
}

/**
 * import downloads
 */
function store_wfdownloads_downloads($row) {
	global $downloads_download_handler;
	
	$obj = $downloads_download_handler->create(TRUE);
	$obj->setVar("download_id", $row['lid']);
	$obj->setVar("download_title", $row['title']);
	$obj->setVar("download_cid", explode(",", $row['cid']));
	
	$obj->setVar('download_file', "");
	$obj->setVar('download_file_alt', "");
	
	$obj->setVar('download_teaser', $row['summary']);
	$obj->setVar('download_description', $row['description']);
	$obj->setVar('download_keyfeatures', $row['features']);
	$obj->setVar('download_requirements', $row['requirements']);
	$obj->setVar('download_version', $row['version']);
	$obj->setVar('download_version_status', $row['versiontypes']);
	$obj->setVar('download_version_link', "");
	$obj->setVar('download_history', $row['dhistory']);
	$obj->setVar('download_limitations', $row['limitations']);
	$obj->setVar('download_license', explode(",", $row['license']));
	$obj->setVar('download_platform', explode(",", $row['platform']));
	$obj->setVar("download_language", "");
	$obj->setVar('download_related', "");
	
	$obj->setVar('download_img',$row['screenshot']);
	$obj->setVar('download_screen_1',$row['screenshot2']);
	$obj->setVar('download_screen_2',$row['screenshot3']);
	$obj->setVar('download_screen_3',$row['screenshot4']);
	$obj->setVar('download_screen_4',"");
	$obj->setVar('download_album', 0);
	$obj->setVar('catalogue_item', 0);
	
	$obj->setVar('download_mirror_url',"");
	$obj->setVar('download_mirror_approve', 1);
	$obj->setVar('download_has_mirror', 0);
	
	$obj->setVar("download_dev", "");
	$obj->setVar("download_dev_hp", $row['homepage']);
	$obj->setVar("download_demo", "");
	
	$obj->setVar('download_submitter', $row['submitter']);
	if($row['publisher'] != "" && $row['publisher'] != 0) {
		$obj->setVar('download_publisher', $row['publisher']);
	} else {
		$obj->setVar('download_publisher', $row['submitter']);
	}
	$obj->setVar('download_published_date', (int)$row['date']);
	$obj->setVar('download_updated_date', (int)$row['updated']);
	$obj->setVar("download_tags", '');
	
	if($row['expired'] > 0) {
		$obj->setVar('download_approve', 0);
	} else {
		$obj->setVar('download_approve', 1);
	}
	$obj->setVar('download_inblocks', 1);
	$obj->setVar('download_active', 1);
	$obj->setVar('download_updated', 0);
	$obj->setVar('download_broken', 0);
	
	$obj->setVar('download_comments', $row['comments']);
	$obj->setVar('download_notification_sent', $row['notifypub']);
	$obj->setVar('download_status_set', 0);
	$obj->setVar('download_like', 0);
	$obj->setVar('download_dislike', 0);
	$obj->setVar('download_downcounter', 0);
	$obj->setVar('weight');
	$obj->setVar('counter', $row['hits']);
	$obj->setVar('dohtml', 1);
	$obj->setVar('dobr', 1);
	$obj->setVar('doimage', 1);
	$obj->setVar('dosmiley', 1);
	$obj->setVar('docxode', 1);

	$downloads_download_handler->insert($obj, TRUE);
	unset($row);
}

function downloads_import_downloads() {
	$table = new icms_db_legacy_updater_Table('wfdownloads_downloads');
	if ($table->exists()) {
		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('wfdownloads_downloads');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			store_wfdownloads_downloads($row);
		}
		mysql_free_result($result);
		echo '</code>';
	}
	echo '<code><b>downloads from wfdownloads_downloads succesfully imported.</b><br /></code>';
	unset($table);
}
/**
 * import wfdownloads files
 */
function store_wfdownloads_files($row) {
	global $downloads_download_handler;
	
	$file_handler = icms::handler("icms_data_file");
	$obj = $file_handler->create(TRUE);
	$obj->setVar("mid", icms::$module->getVar("mid"));
	if($row['filename'] != "") {
		$url = ICMS_URL . '/uploads/downloads/download/' . $row['filename'];
		$obj->setVar("url", $url);
	} else {
		$obj->setVar("url", $row['url']);
	}
	$file_handler->insert($obj, TRUE);
	$id = mysql_insert_id();
	$downloadObj = $downloads_download_handler->get($row['lid']);
	if ($downloadObj->isNew()) return FALSE;
	$downloadObj->setVar("download_file", $id);
	$downloadObj->store(TRUE);
	unset($row);
}
function downloads_import_files() {
	$table = new icms_db_legacy_updater_Table('wfdownloads_downloads');
	if($table->exists()) {
	$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('wfdownloads_downloads');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			store_wfdownloads_files($row);
		}
		mysql_free_result($result);
		echo '</code>';
	}
	echo '<code><b>Files from wfdownloads_downloads succesfully imported.</b><br /></code>';
	echo '<code><b>wfdownloads_cat table successfully dropped.</b></code><br />';
	$table->dropTable ();
	unset($table);
}

/**
 * import reviews
 */
function store_wfdownloads_reviews($row) {
	global $downloads_review_handler;
	
	$obj = $downloads_review_handler->create(TRUE);
	$obj->setVar("review_id", $row['review_id']);
	$obj->setVar("review_item_id", $row['lid']);
	$obj->setVar("review_uid", $row['uid']);
	$obj->setVar("review_case", 1);
	$obj->setVar("review_name", "");
	$obj->setVar("review_email", "");
	$obj->setVar("review_message", $row['review']);
	$obj->setVar("review_ip", "");
	$obj->setVar("review_date",(int)$row['date']);
	$obj->setVar('dohtml', 1);
		
	$downloads_review_handler->insert($obj, TRUE);
	unset($row);
}

function downloads_import_reviews() {
	$table = new icms_db_legacy_updater_Table('wfdownloads_reviews');
	if ($table->exists()) {
		$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('wfdownloads_reviews');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			store_wfdownloads_reviews($row);
		}
		mysql_free_result($result);
		echo '</code>';
	}
	echo '<code><b>reviews from wfdownloads_reviews succesfully imported.</b><br />';
	echo '<b>wfdownloads_reviews table successfully dropped.</b></code><br />';
	$table->dropTable ();
	unset($table);
}

/**
 * import wfdownloads mirrors
 */
function store_wfdownloads_mirrors($row) {
	global $downloads_download_handler;
	
	$urllink_handler = icms::handler("icms_data_urllink");
	$obj = $urllink_handler->create(TRUE);
	$obj->setVar("mid", icms::$module->getVar("mid"));
	$obj->setVar("caption", $row['title']);
	$obj->setVar("description", $row['title']);
	
	$obj->setVar("url", $row['downurl']);
	$obj->setVar("target", "_blank");
	$urllink_handler->insert($obj, TRUE);
	$id = mysql_insert_id();
	$downloadObj = $downloads_download_handler->get($row['lid']);
	if ($downloadObj->isNew()) return FALSE;
	$downloadObj->setVar("download_mirror_url", $id);
	$downloadObj->store(TRUE);
	unset($row);
}
function downloads_import_mirrors() {
	$table = new icms_db_legacy_updater_Table('wfdownloads_mirrors');
	if($table->exists()) {
	$sql = "SELECT * FROM " . icms::$xoopsDB->prefix('wfdownloads_mirrors');
		$result = icms::$xoopsDB->query($sql);
		echo '<code>';
		while ($row = icms::$xoopsDB->fetchArray($result)) {
			store_wfdownloads_mirrors($row);
		}
		mysql_free_result($result);
		echo '</code>';
	}
	echo '<code><b>Mirrors from wfdownloads_mirrors succesfully imported.</b><br />';
	echo '<b>wfdownloads_mirrors table successfully dropped.</b></code><br />';
	$table->dropTable ();
	unset($table);
}

include_once 'admin_header.php';

$valid_op = array ('1', '2', '3', '4', '5', '');

$clean_op = isset($_GET['op']) ? filter_input(INPUT_GET, 'op' ) : '';
if (isset($_POST['op'])) $clean_op = filter_input(INPUT_POST, 'op');

if(in_array($clean_op, $valid_op, TRUE)) {
	$downloads_category_handler = icms_getModuleHandler("category", DOWNLOADS_DIRNAME, "downloads");
	$downloads_download_handler = icms_getModuleHandler("download", DOWNLOADS_DIRNAME, "downloads");
	$downloads_review_handler = icms_getModuleHandler("review", DOWNLOADS_DIRNAME, "downloads");
	switch ($clean_op) {
		/**
		 * import category table
		 */
		case '1':
			icms_cp_header();
			icms::$module->displayAdminMenu(10);
			downloads_import_categories();
			
			echo '<br /><br /><a class="formButton" href="' . DOWNLOADS_ADMIN_URL . 'import.php">Go Back</a>';
			break;
		/**
		 * import download table
		 */
		case '2':
			icms_cp_header();
			icms::$module->displayAdminMenu(10);
			downloads_import_downloads();
			
			echo '<br /><br /><a class="formButton" href="' . DOWNLOADS_ADMIN_URL . 'import.php">Go Back</a>';
			break;
		/**
		 * import download files
		 */
		case '3':
			icms_cp_header();
			icms::$module->displayAdminMenu(10);
			downloads_import_files();
			
			echo '<br /><br /><a class="formButton" href="' . DOWNLOADS_ADMIN_URL . 'import.php">Go Back</a>';
			break;
		/**
		 * import review table
		 */
		case '4':
			icms_cp_header();
			icms::$module->displayAdminMenu(10);
			downloads_import_reviews();
			
			echo '<br /><br /><a class="formButton" href="' . DOWNLOADS_ADMIN_URL . 'import.php">Go Back</a>';
			break;
		/**
		 * import wfdownloads mirrors
		 */
		case '5':
			icms_cp_header();
			icms::$module->displayAdminMenu(10);
			downloads_import_mirrors();
			
			echo '<br /><br /><a class="formButton" href="' . DOWNLOADS_ADMIN_URL . 'import.php">Go Back</a>';
			break;
			
		default:
			icms_cp_header();
			icms::$module->displayAdminMenu(10);
			
			 //ask what to do
	        $form = new icms_form_Theme('Importing from wfdownloads',"form", $_SERVER['REQUEST_URI']);
			
			// for category table
	        $sql = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('wfdownloads_cat');
			$result = icms::$xoopsDB->query($sql);
			list($count) = icms::$xoopsDB->fetchRow($result);
	        if ($result > 0) {
	            $button = new icms_form_elements_Button("Import " . $count . " categories from wfdownloads_cat", "button", "Import", "submit");
	            $button->setExtra("onclick='document.forms.form.op.value=\"1\"'");
	            $form->addElement($button);
	        } else {
	            $label = new icms_form_elements_Label("Import data from wfdownloads_cat", "wfdownloads_cat table not found on this site.");
	            $form->addElement($label);
	        }
			// for downloads table
	        $sql2 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('wfdownloads_downloads');
			$result2 = icms::$xoopsDB->query($sql2);
			list($count2) = icms::$xoopsDB->fetchRow($result2);
	        if ($result2 > 0) {
	            $button2 = new icms_form_elements_Button("Import " . $count2 . " downloads from wfdownloads_downloads", "button", "Import", "submit");
	            $button2->setExtra("onclick='document.forms.form.op.value=\"2\"'");
	            $form->addElement($button2);
	        } else {
	            $label2 = new icms_form_elements_Label("Import data from wfdownloads_downloads", "wfdownloads_downloads table not found on this site.");
	            $form->addElement($label2);
	        }
			// for downloads files
	        $sql3 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('wfdownloads_downloads');
			$result3 = icms::$xoopsDB->query($sql3);
			list($count3) = icms::$xoopsDB->fetchRow($result3);
	        if ($result3 > 0) {
	            $button3 = new icms_form_elements_Button("Import " . $count3 . " files from wfdownloads_downloads", "button", "Import", "submit");
	            $button3->setExtra("onclick='document.forms.form.op.value=\"3\"'");
	            $form->addElement($button3);
	        } else {
	            $label3 = new icms_form_elements_Label("Import data from wfdownloads_downloads", "wfdownloads_downloads table not found on this site.");
	            $form->addElement($label3);
	        }
			// for mirrors
			$sql5 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('wfdownloads_mirrors');
			$result5 = icms::$xoopsDB->query($sql5);
			list($count5) = icms::$xoopsDB->fetchRow($result5);
	        if ($result5 > 0) {
	            $button5 = new icms_form_elements_Button("Import " . $count5 . " mirrors from wfdownloads_mirrors", "button", "Import", "submit");
	            $button5->setExtra("onclick='document.forms.form.op.value=\"5\"'");
	            $form->addElement($button5);
	        } else {
	            $label5 = new icms_form_elements_Label("Import data from wfdownloads_mirrors", "wfdownloads_mirrors table not found on this site.");
	            $form->addElement($label5);
	        }
			// for review table
	        $sql4 = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('wfdownloads_reviews');
			$result4 = icms::$xoopsDB->query($sql4);
			list($count4) = icms::$xoopsDB->fetchRow($result4);
	        if ($result4 > 0) {
	            $button4 = new icms_form_elements_Button("Import " . $count4 . " reviews from wfdownloads_reviews", "button", "Import", "submit");
	            $button4->setExtra("onclick='document.forms.form.op.value=\"4\"'");
	            $form->addElement($button4);
	        } else {
	            $label4 = new icms_form_elements_Label("Import data from wfdownloads_reviews", "wfdownloads_reviews table not found on this site.");
	            $form->addElement($label4);
	        }
			
			/**
			// for indexpage
	        $sql = "SELECT COUNT(*) FROM " . icms::$xoopsDB->prefix('wfdownloads_reviews');
			$result = icms::$xoopsDB->query($sql);
			list($count) = icms::$xoopsDB->fetchRow($result);
	        if ($result > 0) {
	            $button = new icms_form_elements_Button("Import " . $count . " downloads from wfdownloads_reviews", "button", "Import", "submit");
	            $button->setExtra("onclick='document.forms.form.op.value=\"5\"'");
	            $form->addElement($button);
	        } else {
	            $label = new icms_form_elements_Label("Import data from wfdownloads_reviews", "wfdownloads_reviews table not found on this site.");
	            $form->addElement($label);
	        }
			 * 
			 */
			$form->addElement(new icms_form_elements_Hidden('op', 0));
        	$form->display();
			break;
	}
	icms_cp_footer();
}