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

icms::$module->displayAdminMenu(4, _MI_ARTICLE_MENU_PERMISSIONS);
$op = isset($_REQUEST['op']) ? trim($_REQUEST['op']) : 'viewarticle';
switch ($op) {
	case 'viewarticle':
		$title_of_form = _AM_ARTICLE_PREMISSION_ARTICLE_VIEW;
		$perm_name = "article_grpperm";
		$restriction = "article_grpperm";
		$anonymous = TRUE;
		break;
		
	case 'viewcategory':
		$title_of_form = _AM_ARTICLE_PREMISSION_CATEGORY_VIEW;
		$perm_name = "category_grpperm";
		$restriction = "category_grpperm";
		$anonymous = TRUE;
		break;
		
	case 'submitarticle':
		$title_of_form = _AM_ARTICLE_PREMISSION_CATEGORY_SUBMIT;
		$perm_name = "submit_article";
		$restriction = "";
		$anonymous = TRUE;
		break;
		
	case 'addarticle':
		
		break;

}

$opform = new icms_form_Simple('', 'opform', 'permissions.php', "get");
$op_select = new icms_form_elements_Select("", 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOption('viewarticle', _AM_ARTICLE_PREMISSION_ARTICLE_VIEW);
$op_select->addOption('viewcategory', _AM_ARTICLE_PREMISSION_CATEGORY_VIEW);
$op_select->addOption('submitarticle', _AM_ARTICLE_PREMISSION_CATEGORY_SUBMIT);
$opform->addElement($op_select);
$opform->display();

$form = new icms_form_Groupperm($title_of_form, icms::$module->getVar('mid'), $perm_name, '', 'admin/permissions.php', $anonymous);



if($op == 'viewarticle') {
	$article_article_handler = icms_getmodulehandler("article", ARTICLE_DIRNAME, "article");
	$articles = $article_article_handler->getObjects(FALSE, TRUE);
	foreach (array_keys($articles) as $i) {
		if ($restriction == "" || $articles[$i]->getVar($restriction)) {
			$form->addItem($articles[$i]->getVar('article_id'),
			$articles[$i]->getVar('article_title'));
		}
	}
} elseif ($op == 'viewcategory') {
	$article_category_handler = icms_getmodulehandler("category", ARTICLE_DIRNAME, "article");
	$categories = $article_category_handler->getObjects(FALSE, TRUE);
	foreach (array_keys($categories) as $i) {
		if ($restriction == "" || $categories[$i]->getVar($restriction)) {
			$form->addItem($categories[$i]->getVar('category_id'),
			$categories[$i]->getVar('category_title'));
		}
	}
} else {
	$article_category_handler = icms_getmodulehandler("category", ARTICLE_DIRNAME, "article");
	$categories = $article_category_handler->getObjects(FALSE, TRUE);
	foreach (array_keys($categories) as $i) {
		if ($restriction == "" || $categories[$i]->getVar($restriction)) {
			$form->addItem($categories[$i]->getVar('category_id'),
			$categories[$i]->getVar('category_title'));
		}
	}
}
$form->display();
icms_cp_footer();