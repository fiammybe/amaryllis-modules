<?php
/**
 * 'Article' is an article management module for ImpressCMS
 *
 * File: /admin/index.php
 * 
 * index view of Article module
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

include_once "admin_header.php";

$article_handler = icms_getModuleHandler('article', basename(dirname(dirname(__FILE__))), 'article');

icms_cp_header();
icms::$module->displayAdminMenu(0, _MI_ARTICLE_MENU_INDEX);
global $articleConfig;
//check broken article
$criteria = '';
$criteria = new icms_db_criteria_Compo();
$criteria->add(new icms_db_criteria_Item('article_broken_file', TRUE));
$broken = $article_handler->getCount($criteria, TRUE, FALSE);

$link_handler = icms_getModuleHandler("link", INDEX_DIRNAME, "index");
$crit = new icms_db_criteria_Compo();
$crit->add(new icms_db_criteria_Item("link_case", 1));
$crit->add(new icms_db_criteria_Item("link_item", $article_handler->_itemname));
$sql = "SELECT DISTINCT (link_cid) FROM " . icms::$xoopsDB->prefix("index_link") . " " . $crit->renderWhere();
$result = icms::$xoopsDB->query($sql);
list($count) = count(icms::$xoopsDB->fetchRow($result));

// get all files count
$totalfiles = $article_handler->getCount();

// check files to approve
if ($articleConfig['article_needs_approval'] == 1) {
	$criteria2 = '';
	$criteria2 = new icms_db_criteria_Compo();
	$criteria2 -> add(new icms_db_criteria_Item('article_approve', 0));
	$article_approve = $article_handler->getCount($criteria2, TRUE, FALSE);
}


//$mimetypes = $article_handler->checkMimeType();
echo ' <div style="margin: 2em 0em;"><p>' . _AM_ARTICLE_INDEX_WARNING . '</p></div>'; 

echo '	<fieldset style="border: #E8E8E8 1px solid; width: 450px;">
			<legend style="display: inline; font-weight: bold; color: #0A3760;">' . _AM_ARTICLE_INDEX . '</legend>
			
			<div style="display: table; padding: 8px;">
				
				
				<div style="display: table-row;">
					<div style="display: table-cell; width: 55%;">'
						. _AM_ARTICLE_INDEX_TOTAL .
					'</div>
					<div style="display: table-cell;">'
						. $totalfiles . _AM_ARTICLE_FILES_IN . $count . _AM_ARTICLE_CATEGORIES .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ARTICLE_INDEX_BROKEN_FILES .
					'</div>
					<div style="display: table-cell">'
						. $broken .
					'</div>
				</div>
				
				<div style="display: table-row;">
					<div style="display: table-cell;">'
						. _AM_ARTICLE_INDEX_NEED_APPROVAL_FILES .
					'</div>
					<div style="display: table-cell;">'
						. $article_approve .
					'</div>
				</div>
				
			</div>
		</fieldset>
		<br />';

icms_cp_footer();