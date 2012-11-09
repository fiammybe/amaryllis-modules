<?php
/**
 * 'Portfolio' is an portfolio management module for ImpressCMS
 *
 * File: /include/common.php
 * 
 * contains install/update informations
 * 
 * @copyright	Copyright QM-B (Steffen Flohrer) 2012
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * ----------------------------------------------------------------------------------------------------------
 * 				Portfolio
 * @since		1.00
 * @author		QM-B <qm-b@hotmail.de>
 * @version		$Id$
 * @package		portfolio
 *
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");
if(!defined("PORTFOLIO_DIRNAME")) define("PORTFOLIO_DIRNAME",basename(dirname(dirname(__FILE__))));

icms_loadLanguageFile('portfolio', 'common');
// this needs to be the latest db version
define('PORTFOLIO_DB_VERSION', 2);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SOME NEEDED FUNCTIONS ////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function portfolio_upload_paths() {
	//Create folders and set permissions
	$path = ICMS_ROOT_PATH . '/uploads/' . PORTFOLIO_DIRNAME;
	if(!is_dir($path . '/category')) mkdir($path . '/category', 0777, TRUE);
	$categoryimages = array();
	$categoryimages = icms_core_Filesystem::getFileList(ICMS_ROOT_PATH . '/modules/' . PORTFOLIO_DIRNAME .'/images/folders/', '', array('gif', 'jpg', 'png'));
	foreach($categoryimages as $image) {
		icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH . '/modules/' . PORTFOLIO_DIRNAME . '/images/folders/' . $image, $path . '/category/' . $image);
	}
	if(!is_dir($path . '/indexpage')) mkdir($path . '/indexpage', 0777, TRUE);
	$image2 = 'portfolio_indeximage.png';
	icms_core_Filesystem::copyRecursive(ICMS_ROOT_PATH.'/modules/'.PORTFOLIO_DIRNAME.'/images/'.$image2, $path.'/indexpage/'.$image2);
}

function copySitemapPlugin() {
	$dir = ICMS_ROOT_PATH . '/modules/portfolio/extras/modules/sitemap/';
	$file = 'portfolio.php';
	$plugin_folder = ICMS_ROOT_PATH . '/modules/sitemap/plugins/';
	if(is_dir($plugin_folder)) {
		icms_core_Filesystem::copyRecursive($dir . $file, $plugin_folder . $file);
	}
	return TRUE;
}

function portfolio_indexpage() {
	$portfolio_indexpage_handler = icms_getModuleHandler( 'indexpage', basename( dirname( dirname( __FILE__ ) ) ), 'portfolio' );
	$indexpageObj = $portfolio_indexpage_handler -> create(TRUE);
	echo '<code>';
	$indexpageObj->setVar('index_header', 'My Portfolio');
	$indexpageObj->setVar('index_heading', '<p>Lorem ipsum dolor sit amet, ratio iuvenis. Praesta enim ad suis ut diem obiecti invidunt cum suam ut a lenoni vero cum. Habes qui enim me in modo genito in fuerat se in rei sensibilium iussit hoc puella. Quique non coepit amatrix tolle auri. Neque revertisset meam celebrabantur Apollonius non coepit cognitionis omnium ascende ad suis. Peractoque convocatis secessit civitatis ne civitatis intelligitur sicut gaudio. Filiae tibi cum obiectum est cum magna anima Apollonium sit audivit mihi. Sadipscing fac mea Christianis aedificatur ergo quod non dum. Atqui plurium venenosamque serpentium ne videret quaeritur sed eu fugiens laudo in lucem in modo ad nomine Maria non solutionem inveni. Qui dicens mea vero diam omni magnis dotem ad suis alteri formam! Indulgentia pedes Dianae feminis introeunte instat manu certas parturiens a lenoni vidit pater ostendit qui auri in! Inquisivi ecce adhibitis amor ea complacuit leno est in, scola somnis angelorum haec puella est Apollonius eius.</p>
<p>Iusto opes mihi Tyrum reverteretur ad nomine Stranguillio sit dolor Jesus Circumdat flante vestibus regni. Gaudeo in modo genito in modo ad te princeps coniungitur vestra felicitatem suam non solutionem invenerunt. Horum tolle auri eos vero diam nostra praedicabilium subsannio oculos capillos apto. Fecisti huc corpore aliquis virginis provolutus volo erat in. Quique non dum miror diligere quem suis. Inter tua cupididate flebili Miserere puellam flentem praemio litore consiliata quis casus turbata minim venisse. Consuetudo aut atque album Apolloni ex hic non coepit contingere vasculo ab eos. Apertius ingens ferro dolor Jesus Circumdat. Agimus nolo me testatur in modo compungi mulierem ubi confudit huc apud senex lacrimis colligantes. Opto cum magna aliter diligo alii paupertas quantitas devenit regi alius est Apollonius in fuerat accidens quam dicentes quod non solutionem innocentem vis. Tamen sed haec vidit tam, habet clementiae venit est in.</p>');
	$indexpageObj->setVar('index_footer', '&copy; 2012 | Portfolio module footer');
	$indexpageObj->setVar('index_image', 'portfolio_indeximage.png');
	$indexpageObj->setVar('index_skills_1', 'My Skill 1|5');
	$indexpageObj->setVar('index_skills_2', 'My Skill 2|4');
	$indexpageObj->setVar('index_skills_3', 'My Skill 3|3');
	$indexpageObj->setVar('index_skills_4', 'My Skill 4|2');
	$indexpageObj->setVar('index_skills_5', 'My Skill 5|1');
	$indexpageObj->setVar('index_skills_6', 'My Skill 6|2');
	$indexpageObj->setVar('index_skills_7', 'My Skill 7|3');
	$indexpageObj->setVar('index_skills_8', 'My Skill 8|4');
	$indexpageObj->setVar('index_skills_9', 'My Skill 9|5');
	$indexpageObj->setVar('index_skills_10', 'My Skill 10|5');
	$indexpageObj->setVar('dohtml', 1);
	$indexpageObj->setVar('dobr', 1);
	$indexpageObj->setVar('doimage', 1);
	$indexpageObj->setVar('dosmiley', 1);
	$indexpageObj->setVar('doxcode', 1);
	$portfolio_indexpage_handler->insert($indexpageObj, TRUE);
	echo '&nbsp;&nbsp;-- <b> Indexpage </b> successfully imported!<br />';
	echo '</code>';
}

function deleteFiles() {
	$path = ICMS_UPLOAD_PATH.'/'.PORTFOLIO_DIRNAME;
	icms_core_Filesystem::deleteRecursive($path);
	return TRUE;
}

function upgrade_v1_1() {
	$portfolio_handler = icms_getModuleHandler("portfolio", PORTFOLIO_DIRNAME, "portfolio");
	$portfolios = $portfolio_handler->getObjects(FALSE, TRUE);
	if($portfolios) {
		foreach (array_keys($portfolios) as $key) {
			if($portfolios[$key]->short_url() == "") {
				$seo = icms_ipf_Metagen::generateSeoTitle(trim($portfolios[$key]->title()), FALSE);
				$portfolios[$key]->setVar("short_url", $seo);
				$portfolios[$key]->_updating = TRUE;
				$portfolio_handler->insert($portfolios[$key]);
			}
		}
	}
	unset($portfolio_handler, $portfolios);
	$category_handler = icms_getModuleHandler("category", PORTFOLIO_DIRNAME, "portfolio");
	$cats = $category_handler->getObjects(FALSE, TRUE);
	if($cats) {
		foreach (array_keys($cats) as $key) {
			if($cats[$key]->short_url() == "") {
				$seo = icms_ipf_Metagen::generateSeoTitle(trim($cats[$key]->title()), FALSE);
				$cats[$key]->setVar("short_url", $seo);
				$cats[$key]->_updating = TRUE;
				$category_handler->insert($cats[$key]);
			}
		}
	}
	unset($category_handler, $cats);
	$img_path = ICMS_ROOT_PATH.'/modules/'.PORTFOLIO_DIRNAME.'/images/';
	$icon_big = "portfolio_icon.png";
	$icon_small = "portfolio_icon_small.png";
	if(file_exists($img_path.$icon_big)) icms_core_Filesystem::deleteFile($img_path.$icon_big);
	if(file_exists($img_path.$icon_small)) icms_core_Filesystem::deleteFile($img_path.$icon_small);
	return TRUE;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// UPDATE PORTFOLIO MODULE //////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

function icms_module_update_portfolio(&$module) {
	upgrade_v1_1();
	$icmsDatabaseUpdater = icms_db_legacy_Factory::getDatabaseUpdater();
	$icmsDatabaseUpdater -> moduleUpgrade($module);
    return TRUE;
}

function icms_module_install_portfolio(&$module) {
	// check if upload directories exist and make them if not
	portfolio_upload_paths();
	
	//prepare indexpage
	portfolio_indexpage();
	
	copySitemapPlugin();

	return TRUE;
}

function icms_module_uninstall_portfolio($module) {
	deleteFiles();
}